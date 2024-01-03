<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class PembayaranController extends Controller
{
    function index() {
        return view('pembayaran.upload',['data' => null]);
    }

    function store(Request $request) {
        try{
            ini_set('memory_limit', '44M');
            // Define field positions and lengths
            $fieldPositions = [[
                'field' => 'HLSTAT',
                'from' => 1,
                'to' => 1],];

            // Process file_txt
            $filename_txt = 'file.txt';
            if ($request->hasFile('file_txt')) {
                $file = $request->file('file_txt');
                $filename_txt = 'file'.'.'.$file->extension();
                $file->storeAs('file',$filename_txt);
            }
            $fp = fopen(storage_path('app/file/'.$filename_txt), "r");
            $txt_data = [];
            while(!feof($fp)){
                $line = fgets($fp);
                if (!str_contains($line, "")) {
                    array_push($txt_data, utf8_encode($line));
                }
            }
            // Process file_dic
            if ($request->has('file_dic')) {
                $file = $request->file('file_dic');
                $filename = 'dictionary'.'.'.$file->extension();
                $file->storeAs('dictionary/',$filename);
            }
            $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
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
                }
                $result[] = $objects;
            }

            foreach ($result as $key => $value) {
                if ($value['HLACKY'] == 'PYSPI' || $value['HLACKY'] == 'PDYPI' || $value['HLACKY'] == "MRYPI+") {
                    $result[$key];
                }else{
                    unset($result[$key]);
                }

            }

            // $body = [
            //     'file_json' => $txt_data,
            //     'dictionary' => $fieldPositions
            // ];
            // $pembayaran = Http::post('http://127.0.0.1:5001'.'/pembayaran', $body)->json();

            // return view('pembayaran.upload',['data' => $pembayaran['data']]);
            return view('pembayaran.upload',['data' => $result]);
        } catch (\Exception $e) {
            return $e;
            // return redirect(route('users.index'));
        } catch ( QueryException $e){
            return $e;
        }
    }

    function filter(Request $request) {
        $fp = fopen(storage_path('app/file/'.'file.txt'), "r");

        $txt_data = [];
        while(!feof($fp)){
            $line = fgets($fp);
            if (!str_contains($line, "")) {
                array_push($txt_data, utf8_encode($line));
            }
        }
        // Process file_dic
        $fieldPositions = [[
            'field' => 'HLSTAT',
            'from' => 1,
            'to' => 1],];

        $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
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

        // $body = [
        //     'file_json' => $txt_data,
        //     'dictionary' => $fieldPositions
        // ];
        // $pembayaran = Http::post(env('EXTRA_HOST').'/pembayaran', $body)->json();
        // $result = $pembayaran['data'];
        $result = array();
        for ($i = 0; $i < count($txt_data); $i++) {
            $val = trim($txt_data[$i]);
            $objects = array();
            foreach ($fieldPositions as $j) {
                $value = substr($val, $j['from']-1, $j['to']-$j['from']+1);
                $value = ltrim(rtrim($value));
                $objects[$j['field']] = $value;
            }
            $result[] = $objects;
        }

        foreach ($result as $key => $value) {
            if ($request->get('filter') != '0') {
                if ($value['HLACKY'] != $request->get('filter')) {
                    unset($result[$key]);
                }
            }

        }
        return view('pembayaran.upload',['data' => $result]);
        // return view('pembayaran.upload',['data' => $pembayaran['data']]);


    }
}
