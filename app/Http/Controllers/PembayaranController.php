<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
            $filename_txt = 'file'.'.'.$file->extension();
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

            // ini_set('memory_limit', '256M');
            // Define field positions and lengths
            $fieldPositions = [[
                'field' => 'HLSTAT',
                'from' => 1,
                'to' => 1],];

            $fieldPositionsNomi = [[
                'norek' => 'A2001389',
                'kolek' => '-',
            ],];

            // Process file_txt
            $filename_txt = 'file.txt';
            $fp = fopen(storage_path('app/file/'.$filename_txt), "r");
            $txt_data = [];
            while(!feof($fp)){
                $line = fgets($fp);
                if (!str_contains($line, "")) {
                    array_push($txt_data, utf8_encode($line));
                }
            }
            // Process file_dic
            $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
            // end process file_dic

            //start file_nomi
            $filename = 'nomi.xlsx';
            $theArrayNomi = Excel::toCollection([],storage_path('app/file-nomi/').$filename);
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

            $result = array();
            for ($i = 0; $i < count($txt_data); $i++) {
                $val = trim($txt_data[$i]);
                $objects = array();
                foreach ($fieldPositions as $j) {
                    $value = substr($val, $j['from']-1, $j['to']-$j['from']+1);
                    $value = ltrim(rtrim($value));
                    $objects[$j['field']] = $value;
                    $objects['kolek'] = '';
                }
                $result[] = $objects;
            }

            foreach ($result as $key => $value) {
                if ($value['HLACKY'] == 'PYSPI' || $value['HLACKY'] == 'PDYPI' || $value['HLACKY'] == "MRYPI+") {
                }else{
                    unset($result[$key]);
                }
            }
            $result_data = [];
            foreach ($result as $key => $value) {
                if (array_key_exists('HLLNNO', $value)) {
                    $HLLNNO_value = $value['HLLNNO'];
                    $array1Obj = collect($fieldPositionsNomi)->firstWhere('norek',$HLLNNO_value);

                    if ($array1Obj && $array1Obj['kolek'] !== '-') {
                       array_push($result_data,[
                        'HLSEQN' => $value['HLSEQN'],
                        'HLLNNO' => $value['HLLNNO'],
                        'HLDTVL' => $value['HLDTVL'],
                        'HLORMT' => $value['HLORMT'],
                        'HLACKY' => $value['HLACKY'],
                        'kolek' => $array1Obj['kolek'],
                       ]);
                    } else {
                        array_push($result_data,[
                            'HLSEQN' => $value['HLSEQN'],
                            'HLLNNO' => $value['HLLNNO'],
                            'HLDTVL' => $value['HLDTVL'],
                            'HLORMT' => $value['HLORMT'],
                            'HLACKY' => $value['HLACKY'],
                            'kolek' => '-',
                        ]);
                    }

                }

            }
            // return view('pembayaran.upload',['data' => $pembayaran['data']]);
            return view('pembayaran.upload',['data' => $result_data]);
        // } catch (\Exception $e) {
        //     return $e;
        //     // return redirect(route('users.index'));
        // } catch ( QueryException $e){
        //     return $e;
        // }
    }

    function proses_data() {

    }
}
