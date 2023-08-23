<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Cabang;
use Illuminate\Support\Facades\DB;


class DataNominatif implements FromView
{
    private $data;
    private $data2;

    public function __construct($data, $data2)
    {
        $this->data = $data;
        $this->data2 = $data2;
    }
    public function view(): View
    {
        $param['tAwal'] = Request()->tAwal;
        $param['tAkhir'] = Request()->tAkhir;


        $param['data'] = $this->data;
        $param['data2'] = $this->data2;
        return view('modal.DataNominatif-excel', $param);
    }
}
