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
    function index() {
        return view('pembayaran.upload',['data' => null]);
    }

    function upload(Request $request) {


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
            $file_nomi->storeAs('file-nomi/',$filename);
        }

        return response()->json(['success' => true]);


    }

    function store(Request $request) {
        // Process file_txt
        $filename_txt = 'LHLONINC.txt';
        // Ganti pembacaan file_txt dengan fungsi file
        $txt_data = array_map('utf8_encode', file(storage_path('app/file/'.$filename_txt), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        // Process file_dic
        $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
        // end process file_dic
        //start file_nomi
        $filename = 'nomi.xlsx';
        $theArrayNomi = Excel::toCollection([],storage_path('app/file-nomi/').$filename);
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
        $master_loan = MasterDDLoan::get()->toArray();
        $result_data_loan = [];
        foreach ($master_loan as $item) {
            if (array_key_exists('no_loan', $item)) {
                $no_loan = $item['no_loan'];
                $array1Obj = collect($result_data)->firstWhere('HLLNNO', $no_loan);
                $result_data_loan [] = $array1Obj;
            }
        }
        foreach ($result_data_loan as $key => $value) {
            if (is_null($value['HLSEQN']) || is_null($value['HLLNNO']) || is_null($value['HLDTVL']) || is_null($value['HLORMT']) || is_null($value['HLDESC'])) {
                alert()->error('Error', 'Data is incomplete.');
                return redirect()->route('pembayaran.index');
            }

            // current master anggsuran
            $current_loan = MasterDDAngsuran::where('squence', $value['HLSEQN'])
                ->where('no_loan', $value['HLLNNO'])
                ->get();

            // Check if there are existing records with the same squence and no_loan
            if (count($current_loan) > 0) {
                alert()->error('Error', 'Data Pembayaran telah di proses.');
                return redirect()->route('pembayaran.index');
            }
            // Create a new instance only if the count is not greater than 0
            $pembayaran = new MasterDDAngsuran;
            $pembayaran->squence = $value['HLSEQN'];
            $pembayaran->no_loan = $value['HLLNNO'];
            $pembayaran->tanggal_pembayaran = date('Y-m-d h:i:s', strtotime($value['HLDTVL']));
            $pembayaran->pokok_pembayaran = (int) $value['HLORMT'] / 100;
            $pembayaran->kolek = $value['kolek'];
            $pembayaran->keterangan = $value['HLDESC'];
            $pembayaran->save();
            // Fetch the inserted data
            $inserted_data = MasterDDAngsuran::where('squence', $value['HLSEQN'])
                            ->where('no_loan', $value['HLLNNO'])
                            ->get();
            return view('pembayaran.upload',['data' => $inserted_data]);
        }

         // Check if any required value is null

        // return view('pembayaran.upload',['data' => $pembayaran['data']]);
    // } catch (\Exception $e) {
    //     return $e;
    //     // return redirect(route('users.index'));
    // } catch ( QueryException $e){
    //     return $e;
    // }
    }

    function upload_data(Request $request) {
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
            // return $this->saveFile($save->getFile());
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

    function proses_data(Request $request) {
        DB::beginTransaction();
        try {
            DB::commit();
            $data = json_decode($request->get('data'),true);
            foreach ($data as $key => $value) {
                if ($value != null) {
                    // current master anggsuran
                    $loan = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                    $kode = $loan->kode_pendaftaran;
                    // update sipde
                    if ($value['no_loan'] == $loan->no_loan) {
                        $total_angsuran = $loan->baki_debet - $value['pokok_pembayaran'];
                        $update = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                        $update->baki_debet = $total_angsuran;
                        $update->update();
                        $response = $this->kumulatif_debitur($kode,$value['pokok_pembayaran'],$total_angsuran,$value['kolek']);
                        if ($response != 200) {
                            DB::rollBack();
                            alert()->error('Error','Terjadi Kesalahan.');
                            return redirect()->route('pembayaran.index');
                        }
                    }
                }
            }
            alert()->success('Sukses','Pembayaran Berhasil dilakukan');
            return redirect()->route('pembayaran.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    function checkPembayaran() {
        DB::beginTransaction();
        try {
            DB::commit();
            $date_yesterday = Carbon::yesterday()->setTime(05, 00, 00)->toDateTimeString();
            $data_yesterday = MasterDDLoan::whereDate('created_at', '>=',$date_yesterday)->get();
            return $data_yesterday;
            return $data_yesterday;
            if ($data_yesterday) {
                return 'qw';
            }
            return 'asd';
            $data = MasterDDAngsuran::whereDate('created_at',Carbon::now())->get();
            if ($data) {
                foreach ($data as $key => $value) {
                    if ($value != null) {
                        // current master anggsuran
                        $loan = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                        $kode = $loan->kode_pendaftaran;
                        // update sipde
                        if ($value['no_loan'] == $loan->no_loan) {
                            $total_angsuran = $loan->baki_debet - $value['pokok_pembayaran'];
                            $update = MasterDDLoan::where('no_loan',$value['no_loan'])->first();
                            $update->baki_debet = $total_angsuran;
                            $update->update();
                            $response = $this->kumulatif_debitur($kode,$value['pokok_pembayaran'],$total_angsuran,$value['kolek']);
                            if ($response != 200) {
                                DB::rollBack();
                                alert()->error('Error','Terjadi Kesalahan.');
                                return redirect()->route('pembayaran.index');
                            }
                        }
                    }
                }
            }
            return 'berhasil';
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    function kumulatif_debitur($kode, $pokok_angsuran, $kolek, $status) {
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
