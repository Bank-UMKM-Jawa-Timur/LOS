<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\DanaCabang;
use App\Models\MasterDDAngsuran;
use App\Models\MasterDDLoan;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PembayaranController extends Controller
{
    public function index() {
        return view('pembayaran.upload',['data' => null]);
    }

    public function upload(Request $request) {
        // Process file_txt
        if ($request->hasFile('file_txt')) {
            $file = $request->file('file_txt');
            $filename_txt = 'LHLONINC'.'.'.$file->extension();
            $file->storeAs('file',$filename_txt);
        }
        // Process file_dic
        if ($request->has('file_dic')) {
            $file = $request->file('file_dic');
            $filename = 'dictionary'.'.'.$file->extension();
            $file->storeAs('dictionary/',$filename);
        }
        //start file_nomi
        if ($request->has('file_nomi')) {
            $file_nomi = $request->file('file_nomi');
            $filename = 'nomi'.'.'.$file_nomi->extension();
            $file_nomi->storeAs('file_nomi/',$filename);
        }

        return response()->json(['success' => true]);


    }

    public function store(Request $request) {
        ini_set('max_execution_time', 120);
        ini_set('memory_limit', '-1');
        DB::beginTransaction();
        try {
            // Process file_txt
            $filename_txt = 'LHLONINC.txt';
            // Ganti pembacaan file_txt dengan fungsi file
            $txt_data = array_map('utf8_encode', file(storage_path('app/file/'.$filename_txt), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            // Process file_dic
            $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
            // end process file_dic
            //start file_nomi
            $filename = 'nomi.xlsx';
            $theArrayNomi = Excel::toCollection([],storage_path('app/file_nomi/').$filename);
            // proses array
            $fieldPositions = [];
            $fieldPositionsNomi = [];
            for ($i=0; $i < count($theArrayNomi[0]); $i++) {
                if ($i > 0) {
                    array_push($fieldPositionsNomi,[
                        'norek' => $theArrayNomi[0][$i][1],
                        'kolek' => $theArrayNomi[0][$i][10],
                    ]);
                }
            }
            // //end file_nomi
            for ($i=0; $i < count($theArray[0]); $i++) {
                // Sequence(HLSEQN) | No. Loan(HLLNNO) | Tanggal Pembayaran(HLDTVL) | Nominal(HLOPMT)
                if ($i > 4) {
                    array_push($fieldPositions,[
                        'field' => $theArray[0][$i][0],
                        'from' => $theArray[0][$i][1],
                        'to' => $theArray[0][$i][2],
                    ]);
                }

            }

            $result = array_map(function ($val) use ($fieldPositions) {
                $objects = [];
                foreach ($fieldPositions as $j) {
                    $value = substr($val, $j['from']-1, $j['to']-$j['from']+1);
                    $value = trim($value);
                    $objects[$j['field']] = $value;
                    $objects['kolek'] = '';
                }
                return $objects;
            }, $txt_data);

            // Gunakan array_filter untuk menyaring result
            $result = array_filter($result, function ($value) {
                return $value['HLACKY'] == 'PYSPI' || $value['HLACKY'] == 'PDYPI' || $value['HLACKY'] == "MRYPI+";
            });

            $result_data = [];
            foreach ($result as $value) {
                if (array_key_exists('HLLNNO', $value)) {
                    $HLLNNO_value = $value['HLLNNO'];
                    $array1Obj = collect($fieldPositionsNomi)->firstWhere('norek', $HLLNNO_value);

                    $result_data[] = [
                        'HLSEQN' => $value['HLSEQN'],
                        'HLLNNO' => $value['HLLNNO'],
                        'HLDTVL' => $value['HLDTVL'],
                        'HLORMT' => $value['HLORMT'],
                        'HLDESC' => $value['HLDESC'],
                        'kolek' => $array1Obj && $array1Obj['kolek'] !== '-' ? $array1Obj['kolek'] : '-',
                    ];
                }
            }
            // Memperbaiki kode dengan penamaan variabel yang jelas
            $masterLoanNumbers = MasterDDLoan::pluck('no_loan')->toArray();

            // Memastikan $result_data memiliki data sebelum digunakan
            if (!empty($result_data)) {
                // Membuat koleksi dari $result_data
                $collection = collect($result_data);

                // Menggunakan whereIn() dengan nomor pinjaman dari master_loan
                if(!empty($masterLoanNumbers)){
                      $filtered = $collection;
                }else{
                    $filtered = $collection->whereIn('HLLNNO', $masterLoanNumbers);

                }
                if (count($filtered) <= 0) {
                    DB::commit();
                    alert()->error('Kesalahan','Data tidak valid.');
                    return redirect()->route('pembayaran.index');
                }
                return view('pembayaran.upload',['data' => $filtered->all()]);
            } else {
                DB::commit();
                alert()->error('Kesalahan','Data tidak ditemukan.');
                return redirect()->route('pembayaran.index');
            }
            return redirect()->route('pembayaran.index');
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi Kesalahan.');
            return redirect()->route('pembayaran.index');
        } catch (QueryException $th){
            DB::rollBack();
            alert()->error('Error','Terjadi Kesalahan.');
            return redirect()->route('pembayaran.index');
        }
    }

    public function proses_data(Request $request) {
        ini_set('max_execution_time', 120);
        ini_set('memory_limit', '-1');
        DB::beginTransaction();
        try {
            $HLSEQN = [];
            $HLLNNO = [];
            $result_data_loan = json_decode($request->get('data'),true);
            foreach ($result_data_loan as $key => $value) {
                if ($value != null) {
                    if (is_null($value['HLSEQN']) || is_null($value['HLLNNO']) || is_null($value['HLDTVL']) || is_null($value['HLORMT']) || is_null($value['HLDESC'])) {
                        alert()->error('Error', 'Data is incomplete.');
                        return redirect()->route('pembayaran.index');
                    }
                    // current master anggsuran
                    $existing_loan = MasterDDAngsuran::where('squence', $value['HLSEQN'])
                                                    ->where('no_loan', $value['HLLNNO'])
                                                    ->whereDate('tanggal_pembayaran', date('Y-m-d', strtotime($value['HLDTVL'])))
                                                    ->count();

                    // Insert data only if no existing records
                    if ($existing_loan == 0) {
                        array_push($HLSEQN,$value['HLSEQN']);
                        array_push($HLLNNO,$value['HLLNNO']);
                        $pembayaran = new MasterDDAngsuran;
                        $pembayaran->squence = $value['HLSEQN'];
                        $pembayaran->no_loan = $value['HLLNNO'];
                        $pembayaran->tanggal_pembayaran = date('Y-m-d h:i:s', strtotime($value['HLDTVL']));
                        $pembayaran->pokok_pembayaran = (int) $value['HLORMT'] / 100;
                        $pembayaran->kolek = $value['kolek'];
                        $pembayaran->keterangan = $value['HLDESC'];
                        $pembayaran->save();
                    }else{
                        continue;
                    }
                }
            }
            DB::commit();
            $inserted_data = MasterDDAngsuran::
                                            whereIn('no_loan',$HLLNNO)
                                            ->whereIn('squence',$HLSEQN)
                                            ->whereDate('tanggal_pembayaran', date('Y-m-d', strtotime($value['HLDTVL'])))
                                            ->get();
            if (count($inserted_data) <= 0) {
                DB::commit();
                alert()->warning('Perhatian','sudah melakukan pembayaran');
                return redirect()->route('pembayaran.index');
            }else{
                DB::commit();
                foreach ($inserted_data as $key => $value) {
                    if ($value != null) {
                        // current master anggsuran
                        $loan = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                        $total_pembayaran = MasterDDAngsuran::where('no_loan',$value['no_loan'])->sum('pokok_pembayaran');
                        $kode = $loan->kode_pendaftaran;
                        // update sipde
                        if ($value['no_loan'] == $loan->no_loan) {
                            $total_angsuran = $loan->baki_debet - $value['pokok_pembayaran'];
                            if ($total_angsuran <= 0) {
                                $result_total_angsuran = 0;
                            }else{
                                $result_total_angsuran = $total_angsuran;
                            }
                            $update = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                            $update->baki_debet = $result_total_angsuran;
                            $update->update();
                            $response = $this->kumulatif_debitur($kode,$total_pembayaran,$result_total_angsuran,$value['kolek']);
                            if ($response != 200) {
                                DB::rollBack();
                                alert()->error('Error','Terjadi Kesalahan.');
                                return redirect()->route('pembayaran.index');
                            }
                        }
                    }
                }
                alert()->success('Berhasil','Berhasil menambahkan pembayaran');
                return redirect()->route('pembayaran.index');
            }
        } catch (Exception $th) {
            DB::rollBack();
            alert()->error('Error','Terjadi Kesalahan.');
            return redirect()->route('pembayaran.index');
        } catch (QueryException $th){
            DB::rollBack();
            alert()->error('Error','Terjadi Kesalahan.');
            return redirect()->route('pembayaran.index');
        }
    }

    public function upload_data(Request $request) {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            // Process file_txt
            $file = $save->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'txt' && $request->data == 'file_txt') {
                $onlyFileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
                $fileName = 'LHLONINC'.'.' . $extension; // a unique file name
                $file->storeAs('file/',$fileName);
                unlink($file->getPathname());
            }
            if ($extension == 'xlsx' && $request->data == 'file_dic') {
                $fileName = 'dictionary'.'.' . $extension; // a unique file name
                $file->storeAs('dictionary/',$fileName);
                unlink($file->getPathname());

            }
            if ($extension == 'xlsx' && $request->data == 'file_nomi') {
                $fileName = 'nomi'.'.' . $extension; // a unique file name
                $file->storeAs('file_nomi/',$fileName);

                unlink($file->getPathname());
            }

            return response()->json([
                'filename' => $fileName,
                // 'file_path' => $filePath,
                'status' => true
            ]);

        }
        // we are in chunk mode, lets send the current progress
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    public function kumulatif_debitur($kode, $pokok_angsuran, $kolek, $status) {
        DB::beginTransaction();
        try {
            $token = sipde_token()['token'];
            $body = [
                'kode_pendaftaran' => $kode,
                'kumulatif_pokok_angsuran' =>(float)$pokok_angsuran,
                'baki_debet' =>  (float)$kolek,
                'kolektibilitas' => (float)$kolek,
                'status_kolektibilitas' => (int)$status,
            ];
            $pembayaran_kumulatif = Http::withHeaders([
                'Authorization' => 'Bearer ' .$token,
            ])->post(config('dagulir.host').'/kumulatif_dana_debitur.json', $body)->json();
            if (array_key_exists('data', $pembayaran_kumulatif)) {
                $response = $pembayaran_kumulatif['data'];
                if ($response['status_code'] == 200) {
                    DB::commit();
                    return $response['status_code'];
                }else{
                    return array_key_exists('message', $response) ? $response['message'] : 'failed';
                }
            }else{
                DB::commit();
                $message = 'Terjadi kesalahan.';
                if (array_key_exists('error', $pembayaran_kumulatif)) $message .= ' '.$pembayaran_kumulatif['error'];
                return $message;
            }


        } catch (Exception $e) {

            return $e;
        }
    }
}
