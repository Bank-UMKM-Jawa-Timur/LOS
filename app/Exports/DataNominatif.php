<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Cabang;
use Illuminate\Support\Facades\DB;


class DataNominatif implements FromView
{
    public function view(): View
    {
        $param['tAwal'] = Request()->tAwal;
        $param['tAkhir'] = Request()->tAkhir;
        $pilCabang = Request()->cabang;
        $tAkhir = Request()->tAkhir;
        $tAwal = Request()->tAwal;
        $jExport = Request()->export;
        $type = Request()->k_tanggal;

        // New code
        $seluruh_data = DB::table('pengajuan AS p')
                            ->select(
                                'c.kode_cabang AS kodeC',
                                'c.cabang',
                                \DB::raw("SUM(IF(p.posisi = 'Selesai', 1,0)) AS disetujui"),
                                \DB::raw("SUM(IF(p.posisi = 'Ditolak', 1,0)) AS ditolak"),
                                \DB::raw("SUM(IF(p.posisi = 'Pincab', 1,0)) AS pincab"),
                                \DB::raw("SUM(IF(p.posisi = 'PBP', 1,0)) AS PBP"),
                                \DB::raw("SUM(IF(p.posisi = 'PBO', 1,0)) AS PBO"),
                                \DB::raw("SUM(IF(p.posisi = 'Review Penyelia', 1,0)) AS penyelia"),
                                \DB::raw("SUM(IF(p.posisi = 'Proses Input Data', 1,0)) AS staff"),
                                \DB::raw("(SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                        SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                        SUM(IF(p.posisi = 'PBO', 1,0))+
                                        SUM(IF(p.posisi = 'PBP', 1,0))+
                                        SUM(IF(p.posisi = 'Pincab', 1,0))+
                                        SUM(IF(p.posisi = 'Selesai', 1,0))) AS diproses"),
                                \DB::raw("SUM(1) AS total"),
                            )
                            ->join('cabang AS c', 'c.id', 'p.id_cabang')
                            ->groupBy('kodeC')
                            ->orderBy('total', 'desc');

        $seluruh_data_proses = DB::table('pengajuan AS p')
                            ->select(
                                'c.kode_cabang AS kodeC',
                                'c.cabang',
                                \DB::raw("SUM(IF(p.posisi = 'Selesai', 1,0)) AS disetujui"),
                                \DB::raw("SUM(IF(p.posisi = 'Ditolak', 1,0)) AS ditolak"),
                                \DB::raw("(SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                        SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                        SUM(IF(p.posisi = 'PBO', 1,0))+
                                        SUM(IF(p.posisi = 'PBP', 1,0))+
                                        SUM(IF(p.posisi = 'Pincab', 1,0))) AS diproses"),
                                \DB::raw("(SUM(IF(p.posisi = 'Selesai', 1,0))+
                                        SUM(IF(p.posisi = 'Ditolak', 1,0))+
                                        (
                                            SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                            SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                            SUM(IF(p.posisi = 'PBO', 1,0))+
                                            SUM(IF(p.posisi = 'PBP', 1,0))+
                                            SUM(IF(p.posisi = 'Pincab', 1,0))
                                        )) AS total"),
                            )
                            ->join('cabang AS c', 'c.id', 'p.id_cabang')
                            ->groupBy('kodeC')
                            ->orderBy('total', 'desc');
        if ($pilCabang != 'semua') {
            $seluruh_data = $seluruh_data->where('c.id', $pilCabang);
            $seluruh_data_proses = $seluruh_data_proses->where('c.id', $pilCabang);
        }
        
        if ($tAwal && $tAkhir) {
            $seluruh_data = $seluruh_data->whereBetween('p.tanggal', [$tAwal, $tAkhir]);
            $seluruh_data_proses = $seluruh_data_proses->whereBetween('p.tanggal', [$tAwal, $tAkhir]);
        }

        if ($type == 'kustom') {
            $seluruh_data = $seluruh_data->whereBetween('p.tanggal', [$tAwal, $tAkhir]);
            $seluruh_data_proses = $seluruh_data_proses->whereBetween('p.tanggal', [$tAwal, $tAkhir]);
        }

        $seluruh_data = $seluruh_data->get();
        $seluruh_data_proses = $seluruh_data_proses->get();

        $param['data'] = $seluruh_data;
        $param['data2'] = $seluruh_data_proses;

        return view('modal.DataNominatif-excel', $param);
    }
}
