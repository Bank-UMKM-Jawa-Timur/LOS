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
        $cabangIds = cabang::get();

        // kategori custom
        // Jenis cabang di pilih semua
        $all_data = [];
        foreach ($cabangIds as $rows) {
            $dat = DB::table('pengajuan')
            ->selectRaw('kode_cabang as kodeC,
                                 cabang,
                                 sum(posisi = "selesai") as disetujui,
                                 sum(posisi = "Ditolak") as ditolak,
                                 sum(posisi = "pincab") as pincab,
                                 sum(posisi = "PBB") as PBB,
                                 sum(posisi = "PBO") as PBO,
                                 sum(posisi = "Review Penyelia") as penyelia,
                                 sum(posisi = "Proses Input Data") as staff,
                                 count(*) as total')
            ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
            ->where('cabang.id', $rows->id)
                ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
                ->groupBy('id_cabang')
                ->orderBy('total', 'DESC')
                ->get();
            if (count($dat) == 0) {
                $cbgs = [
                    'kodeC' => $rows->kode_cabang,
                    'cabang' => $rows->cabang,
                    'disetujui' => 0,
                    'ditolak' => 0,
                    'pincab' => 0,
                    'PBB' => 0,
                    'PBO' => 0,
                    'penyelia' => 0,
                    'staff' => 0,
                    'total' => 0,
                ];
            } else {
                $cbgs = [
                    'kodeC' => $dat[0]->kodeC,
                    'cabang' => $dat[0]->cabang,
                    'disetujui' => $dat[0]->disetujui,
                    'ditolak' => $dat[0]->ditolak,
                    'pincab' => $dat[0]->pincab,
                    'PBB' => $dat[0]->PBB,
                    'PBO' => $dat[0]->PBO,
                    'penyelia' => $dat[0]->penyelia,
                    'staff' => $dat[0]->staff,
                    'total' => $dat[0]->total,
                ];
            }
            array_push($all_data, $cbgs);
        }

        // kategori custom
        // jenis cabang pilih 1
        $data = DB::table('pengajuan')
        ->selectRaw('kode_cabang as kodeC,
                                 cabang,
                                 sum(posisi = "selesai") as disetujui,
                                 sum(posisi = "Ditolak") as ditolak,
                                 sum(posisi = "pincab") as pincab,
                                 sum(posisi = "PBB") as PBB,
                                 sum(posisi = "PBO") as PBO,
                                 sum(posisi = "Review Penyelia") as penyelia,
                                 sum(posisi = "Proses Input Data") as staff,
                                 count(*) as total')
        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
        ->where('cabang.id', $pilCabang)
            ->whereBetween('tanggal', [$tAwal, ($tAkhir ?? date('Y-m-d'))])
            ->groupBy('id_cabang')
            ->orderBy('total')
            ->get();

        $arr = $data->map(function ($d) {
            return get_object_vars($d);
        });



        // kategori seluruh
        // jenis semua
        $seluruh_data = [];
        foreach ($cabangIds as $row) {
            $dataS = DB::table('pengajuan')
            ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Ditolak") as ditolak,
                                    sum(posisi = "pincab") as pincab,
                                    sum(posisi = "PBB") as PBB,
                                    sum(posisi = "PBO") as PBO,
                                    sum(posisi = "Review Penyelia") as penyelia,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
            ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
            ->where('cabang.id', $row->id)
                ->orderBy('KodeC')
                ->get();

            $c = [
                'kodeC' => $dataS[0]->kodeC,
                'cabang' => $dataS[0]->cabang,
                'disetujui' => $dataS[0]->disetujui | 0,
                'ditolak' => $dataS[0]->ditolak | 0,
                'pincab' => $dataS[0]->pincab | 0,
                'PBB' => $dataS[0]->PBB | 0,
                'PBO' => $dataS[0]->PBO | 0,
                'penyelia' => $dataS[0]->penyelia | 0,
                'staff' => $dataS[0]->staff | 0,
                'total' => $dataS[0]->total | 0,
            ];
            // dd($dataS);

            array_push($seluruh_data, $c);
        }

        // kategori seluruh
        // jenis pilih 1
        $data = DB::table('pengajuan')
        ->selectRaw('kode_cabang as kodeC,
                                 cabang,
                                 sum(posisi = "selesai") as disetujui,
                                 sum(posisi = "Ditolak") as ditolak,
                                 sum(posisi = "pincab") as pincab,
                                 sum(posisi = "PBB") as PBB,
                                 sum(posisi = "PBO") as PBO,
                                 sum(posisi = "Review Penyelia") as penyelia,
                                 sum(posisi = "Proses Input Data") as staff,
                                 count(*) as total')
        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
        ->where('cabang.id', $pilCabang)
            ->orderBy('total')
            ->get();

        $arr2 = $data->map(function ($d) {
            return get_object_vars($d);
        });


        if ($type == 'kustom') {
            if ($pilCabang == 'semua') {
                $param['data'] =  $all_data;
            } else {
                $param['data'] = $arr->toArray();
            }
        } else {
            if ($pilCabang == 'semua') {
                $param['data'] = $seluruh_data;
            } else {
                $param['data'] = $arr2->toArray();
            }
        }




        $semua_cabang = [];
        foreach ($cabangIds as $c) {
            $dataC = DB::table('pengajuan')
            ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
            ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
            ->where('cabang.id', $c->id)
                ->orderBy('KodeC')
                ->get();
            $c = [
                'kodeC' => $dataC[0]->kodeC,
                'cabang' => $dataC[0]->cabang,
                'disetujui' => $dataC[0]->disetujui | 0,
                'staff' => $dataC[0]->staff | 0,
                'total' => $dataC[0]->total | 0,
            ];
            // }
            array_push($semua_cabang, $c);
        }

        // cabang di pilih 1
        $dataC = DB::table('pengajuan')
        ->selectRaw('kode_cabang as kodeC,
                                    cabang,
                                    sum(posisi = "selesai") as disetujui,
                                    sum(posisi = "Proses Input Data") as staff,
                                    count(*) as total')
        ->join('cabang', 'pengajuan.id_cabang', '=', 'cabang.id')
        ->where('cabang.id', $pilCabang)
            ->orderBy('KodeC')
            ->get();

        $jarr2 = $dataC->map(function ($d) {
            return get_object_vars($d);
        });




        if ($pilCabang == 'semua') {
            $param['dataC'] =  $semua_cabang;
        } else {
            $param['dataC'] = $jarr2->toArray();
        }

        return view('modal.DataNominatif-excel', $param);
    }
}
