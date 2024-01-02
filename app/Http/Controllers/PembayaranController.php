<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class PembayaranController extends Controller
{
    function index() {
        return view('pembayaran.upload');
    }

    function store(Request $request) {
        try {
            // Process file_txt
            if ($request->hasFile('file_txt')) {
                $file = $request->file('file_txt');
                $filename_txt = 'file'.'.'.$file->extension();
                $file->storeAs('file',$filename_txt);
            }
            $data_txt = \File::get(storage_path('app/file/'.$filename_txt));
            // Process file_dic
            $file = $request->file('file_dic');
            $filename = 'dictionary'.'.'.$file->extension();
            $file->storeAs('dictionary/',$filename);
            $theArray = Excel::toCollection([], storage_path('app/dictionary/').'dictionary.xlsx');
            for ($i=0; $i < count($theArray[0]); $i++) {
                // Sequence(HLSEQN) | No. Loan(HLLNNO) | Tanggal Pembayaran(HLDTVL) | Nominal(HLOPMT)
                switch ($theArray[0][$i][0]) {
                    case 'HLSEQN':
                        return $theArray[0][$i][0];
                        break;
                    case 'HLLNNO':
                        # code...
                        break;
                    case 'HLDTVL':
                        # code...
                        break;
                    case 'HLOPMT':
                        # code...
                        break;
                    default:
                        # code...
                        break;
                }
            }
        } catch (\Exception $e) {
            return $e;
            // return redirect(route('users.index'));
        }
    }
}
