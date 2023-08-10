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
        $seluruh_data = DB::table('cabang AS c')
                            ->select(
                                'c.kode_cabang AS kodeC',
                                'c.cabang',
                                $type == 'kustom' ?
                                \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Selesai' GROUP BY id_cabang), 0) AS disetujui") : \DB::raw("SUM(IF(p.posisi = 'Selesai', 1,0)) AS disetujui"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Ditolak' GROUP BY id_cabang), 0) AS ditolak") : \DB::raw("SUM(IF(p.posisi = 'Ditolak', 1,0)) AS ditolak"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Pincab' GROUP BY id_cabang), 0) AS pincab") : \DB::raw("SUM(IF(p.posisi = 'Pincab', 1,0)) AS pincab"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBP' GROUP BY id_cabang), 0) AS pbp") : \DB::raw("SUM(IF(p.posisi = 'PBP', 1,0)) AS pbp"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'PBO' GROUP BY id_cabang), 0) AS pbo") : \DB::raw("SUM(IF(p.posisi = 'PBO', 1,0)) AS pbo"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Review Penyelia' GROUP BY id_cabang), 0) AS penyelia") : \DB::raw("SUM(IF(p.posisi = 'Review Penyelia', 1,0)) AS penyelia"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Proses Input Data' GROUP BY id_cabang), 0) AS staff") : \DB::raw("SUM(IF(p.posisi = 'Proses Input Data', 1,0)) AS staff"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi != 'Ditolak' GROUP BY id_cabang), 0) AS diproses") : \DB::raw("(SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                        SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                        SUM(IF(p.posisi = 'PBO', 1,0))+
                                        SUM(IF(p.posisi = 'PBP', 1,0))+
                                        SUM(IF(p.posisi = 'Pincab', 1,0))+
                                        SUM(IF(p.posisi = 'Selesai', 1,0))) AS diproses"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' GROUP BY id_cabang), 0) AS total") : \DB::raw("SUM(IF(p.id_cabang = c.id, 1, 0)) AS total"),
                            )
                            ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
                            ->where('c.kode_cabang', '!=', 000)
                            ->groupBy('kodeC')
                            ->orderBy('total', 'desc');

        $seluruh_data_proses = DB::table('cabang AS c')
                            ->select(
                                'c.kode_cabang AS kodeC',
                                'c.cabang',
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Selesai' GROUP BY id_cabang), 0) AS disetujui") : \DB::raw("SUM(IF(p.posisi = 'Selesai', 1,0)) AS disetujui"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi = 'Ditolak' GROUP BY id_cabang), 0) AS ditolak") : \DB::raw("SUM(IF(p.posisi = 'Ditolak', 1,0)) AS ditolak"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' AND posisi != 'Ditolak' GROUP BY id_cabang), 0) AS diproses") : \DB::raw("(SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                        SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                        SUM(IF(p.posisi = 'PBO', 1,0))+
                                        SUM(IF(p.posisi = 'PBP', 1,0))+
                                        SUM(IF(p.posisi = 'Pincab', 1,0))) AS diproses"),
                                $type == 'kustom' ? \DB::raw("IFNULL((SELECT count(id) FROM pengajuan WHERE id_cabang = c.id AND tanggal >= '$tAwal' AND tanggal <= '$tAkhir' GROUP BY id_cabang), 0) AS total") : \DB::raw("(SUM(IF(p.posisi = 'Selesai', 1,0))+
                                        SUM(IF(p.posisi = 'Ditolak', 1,0))+
                                        (
                                            SUM(IF(p.posisi = 'Proses Input Data', 1,0))+
                                            SUM(IF(p.posisi = 'Review Penyelia', 1,0))+
                                            SUM(IF(p.posisi = 'PBO', 1,0))+
                                            SUM(IF(p.posisi = 'PBP', 1,0))+
                                            SUM(IF(p.posisi = 'Pincab', 1,0))
                                        )) AS total"),
                            )
                            ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
                            ->where('c.kode_cabang', '!=', 000)
                            ->groupBy('kodeC')
                            ->orderBy('total', 'desc');
        if ($pilCabang != 'semua') {
            $seluruh_data = $seluruh_data->where('c.id', $pilCabang);
            $seluruh_data_proses = $seluruh_data_proses->where('c.id', $pilCabang);
        }

        $seluruh_data = $seluruh_data->get();
        $seluruh_data_proses = $seluruh_data_proses->get();

        $param['data'] = $seluruh_data;
        $param['data2'] = $seluruh_data_proses;

        return view('modal.DataNominatif-excel', $param);
    }
}
