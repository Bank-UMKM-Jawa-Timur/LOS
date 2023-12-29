<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class DashboardRepository
{
    public function getDetailSkemaTotal(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.skema_kredit = 'PKPJ', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(p.skema_kredit = 'KKB', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(p.skema_kredit = 'Talangan Umroh', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(p.skema_kredit = 'Prokesra', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(p.skema_kredit = 'Dagulir', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(p.skema_kredit = 'Kusuma', 1, 0)) AS kusuma"),
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }

    public function getDetailCabangTotal(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.posisi IN ('Proses Input Data', 'Review Penyelia', 'PBO', 'PBP', 'Pincab'), 1, 0)) AS diproses"),
            DB::raw("SUM(IF(p.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(p.posisi = 'Ditolak', 1, 0)) AS ditolak"),
            DB::raw("SUM(IF(p.id_cabang = c.id, 1, 0)) AS total")
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }

    public function getDetailCabangDisetujui(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.skema_kredit = 'PKPJ' AND p.posisi = 'Selesai', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(p.skema_kredit = 'KKB' AND p.posisi = 'Selesai', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(p.skema_kredit = 'Talangan Umroh' AND p.posisi = 'Selesai', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(p.skema_kredit = 'Prokesra' AND p.posisi = 'Selesai', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(p.skema_kredit = 'Dagulir' AND p.posisi = 'Selesai', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(p.skema_kredit = 'Kusuma' AND p.posisi = 'Selesai', 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailCabangDitolak(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.skema_kredit = 'PKPJ' AND p.posisi = 'Ditolak', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(p.skema_kredit = 'KKB' AND p.posisi = 'Ditolak', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(p.skema_kredit = 'Talangan Umroh' AND p.posisi = 'Ditolak', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(p.skema_kredit = 'Prokesra' AND p.posisi = 'Ditolak', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(p.skema_kredit = 'Dagulir' AND p.posisi = 'Ditolak', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(p.skema_kredit = 'Kusuma' AND p.posisi = 'Ditolak', 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailCabangDiproses(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.posisi = 'Proses Input Data', 1, 0)) AS proses_input_data"),
            DB::raw("SUM(IF(p.posisi = 'Review Penyelia', 1, 0)) AS review_penyelia"),
            DB::raw("SUM(IF(p.posisi = 'PBO', 1, 0)) AS pbo"),
            DB::raw("SUM(IF(p.posisi = 'PBP', 1, 0)) AS pbp"),
            DB::raw("SUM(IF(p.posisi = 'Pincab', 1, 0)) AS pincab"),
            DB::raw("SUM(IF(p.posisi IN ('Proses Input Data', 'Review Penyelia', 'PBO', 'PBP', 'Pincab'), 1, 0)) AS total"),
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailSkemaDiproses(Request $request){
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(p.skema_kredit = 'PKPJ' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(p.skema_kredit = 'KKB' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS kkb"),
            DB::raw("SUM(IF(p.skema_kredit = 'Talangan Umroh' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS umroh"),
            DB::raw("SUM(IF(p.skema_kredit = 'Prokesra' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(p.skema_kredit = 'Dagulir' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(p.skema_kredit = 'Kusuma' AND p.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan AS p', 'c.id', 'p.id_cabang')
        ->where('c.kode_cabang', '!=', 000)
        ->whereNull('p.deleted_at')
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailRankCabang(Request $request){
        $data = DB::table('cabang')
        ->leftJoin('pengajuan', 'cabang.id', '=', 'pengajuan.id_cabang')
        ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
        ->where('cabang.kode_cabang', '!=', '000')
        ->groupBy('cabang.kode_cabang', 'cabang.cabang')
        ->orderByRaw('total DESC, cabang.kode_cabang ASC')
        ->get();

        return $data;
    }

    public function getCount(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;
        $skema = $request->skema ?? null;
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $cabang = $request->cbg;

        $data = DB::table('pengajuan')
            ->whereNull('deleted_at')
            ->when($cabang, function ($query, $cabang) {
                return $query->where('id_cabang', $cabang);
            })
            ->when($tanggalAwal, function($query) use ($tanggalAwal){
                return $query->where('tanggal', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                return $query->where('tanggal', '<=', $tanggalAkhir);
            })
            ->when($skema, function($query) use ($skema){
                return $query->where('skema_kredit', $skema);
            })
            ->when($request->pss, function ($query, $pss) {
                return $query->where('pengajuan.posisi', $pss);
            })
            ->when($request->sts, function ($query, $sts) {
                if ($sts == 'Selesai' || $sts == 'Ditolak') {
                    return $query->where('pengajuan.posisi', $sts);
                } else {
                    return $query->where('pengajuan.posisi', '<>', 'Selesai')
                    ->where('pengajuan.posisi', '<>', 'Ditolak');
                }
            });

        if($role == 'Staf Analis Kredit'){
            $data->where('id_staf', $idUser);
        } else if($role == 'Penyelia Kredit'){
            $data->where('id_penyelia', $idUser);
        } else if($role == 'PBO'){
            $data->where('id_pbo', $idUser);
        } else if($role == 'PBP'){
            $data->where('id_pbp', $idUser);
        } else if($role == 'Pincab'){
            $data->where('id_pincab', $idUser);
        }

        $total_proses = 0;
        $total_selesai = 0;
        $total_ditolak = 0;
        $total_keseluruhan = 0;
        $total_belum_ditindak_lanjuti = 0;
        $total_sudah_ditindak_lanjuti = 0;
        foreach($data->get() as $item){
            if($role == 'Staf Analis Kredit'){
                if($item->posisi == 'Proses Input Data'){
                    $total_belum_ditindak_lanjuti++;
                }else if($item->posisi == 'Selesai'){
                }else if($item->posisi == 'Ditolak'){
                }else{
                    $total_sudah_ditindak_lanjuti++;
                }
            } else if($role == 'Penyelia Kredit'){
                if($item->posisi == 'Review Penyelia'){
                    $total_belum_ditindak_lanjuti++;
                }else if($item->posisi == 'Selesai'){
                }else if($item->posisi == 'Ditolak'){
                }else{
                    $total_sudah_ditindak_lanjuti++;
                }
            } else if($role == 'PBO'){
                if($item->posisi == 'PBO'){
                    $total_belum_ditindak_lanjuti++;
                }else if($item->posisi == 'Selesai'){
                }else if($item->posisi == 'Ditolak'){
                }else{
                    $total_sudah_ditindak_lanjuti++;
                }
            } else if($role == 'PBP'){
                if($item->posisi == 'PBP'){
                    $total_belum_ditindak_lanjuti++;
                }else if($item->posisi == 'Selesai'){
                }else if($item->posisi == 'Ditolak'){
                }else{
                    $total_sudah_ditindak_lanjuti++;
                }
            } else if($role == 'Pincab'){
                if($item->posisi == 'Pincab'){
                    $total_belum_ditindak_lanjuti++;
                }else if($item->posisi == 'Selesai'){
                }else if($item->posisi == 'Ditolak'){
                }else{
                    $total_sudah_ditindak_lanjuti++;
                }
            }

            if($item->posisi == 'Proses Input Data' || $item->posisi == 'Review Penyelia' || $item->posisi == 'PBO' || $item->posisi == 'PBP' || $item->posisi == 'Pincab'){
                $total_proses++;
            } else if($item->posisi == 'Selesai'){
                $total_selesai++;
            } else if($item->posisi == 'Ditolak'){
                $total_ditolak++;
            }
            $total_keseluruhan++;
        }

        return [
            'proses' => $total_proses,
            'selesai' => $total_selesai,
            'ditolak' => $total_ditolak,
            'total' => $total_keseluruhan,
            'belum_ditindak_lanjuti' => $total_belum_ditindak_lanjuti,
            'sudah_ditindak_lanjuti' => $total_sudah_ditindak_lanjuti,
        ];
    }

    public function getDataYear(){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;
        $tAwal = now()->subYear();
        $tAkhir = now();

        if (request()->has('tAwal')) {
            $tAwal = Carbon::parse(request('tAwal'))->startOfYear();
        }

        if (request()->has('tAkhir')) {
            $tAkhir = Carbon::parse(request('tAkhir'))->endOfYear();
        }

        $total_disetujui_perbulan = DB::table('pengajuan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tAwal, $tAkhir])
            ->where('posisi', 'Selesai')
            ->whereNull('pengajuan.deleted_at')
            ->groupBy(DB::raw('MONTH(tanggal)'));

        $total_ditolak_perbulan = DB::table('pengajuan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tAwal, $tAkhir])
            ->where('posisi', 'Ditolak')
            ->whereNull('pengajuan.deleted_at')
            ->groupBy(DB::raw('MONTH(tanggal)'));

        $total_diproses_perbulan = DB::table('pengajuan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tAwal, $tAkhir])
            ->whereIn('posisi', ['Pincab','PBP','PBO','Review Penyelia','Proses Input Data'])
            ->whereNull('pengajuan.deleted_at')
            ->groupBy(DB::raw('MONTH(tanggal)'));

        $dataDisetujui = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];
        $dataDitolak = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];
        $dataDiproses = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];
        $dataKeseluruhan = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        if($role == 'Staf Analis Kredit'){
            $total_diproses_perbulan->where('id_staf', $idUser)->get();
            $total_disetujui_perbulan->where('id_staf', $idUser)->get();
            $total_disetujui_perbulan->where('id_staf', $idUser)->get();
        } else if($role == 'Penyelia Kredit'){
            $total_diproses_perbulan->where('id_penyelia', $idUser)->get();
            $total_disetujui_perbulan->where('id_penyelia', $idUser)->get();
            $total_disetujui_perbulan->where('id_penyelia', $idUser)->get();
        } else if($role == 'PBO'){
            $total_diproses_perbulan->where('id_pbo', $idUser)->get();
            $total_disetujui_perbulan->where('id_pbo', $idUser)->get();
            $total_disetujui_perbulan->where('id_pbo', $idUser)->get();
        } else if($role == 'PBP'){
            $total_diproses_perbulan->where('id_pbp', $idUser)->get();
            $total_disetujui_perbulan->where('id_pbp', $idUser)->get();
            $total_disetujui_perbulan->where('id_pbp', $idUser)->get();
        } else if($role == 'Pincab'){
            $total_diproses_perbulan->where('id_pincab', $idUser)->get();
            $total_disetujui_perbulan->where('id_pincab', $idUser)->get();
            $total_disetujui_perbulan->where('id_pincab', $idUser)->get();
        }

        foreach ($total_disetujui_perbulan->get() as $item) {
            $dataDisetujui[date('F', mktime(0, 0, 0, $item?->bulan, 1))] = $item->total;
        }
        foreach ($total_ditolak_perbulan->get() as $item) {
            $dataDitolak[date('F', mktime(0, 0, 0, $item?->bulan, 1))] = $item->total;
        }
        foreach ($total_diproses_perbulan->get() as $item) {
            $dataDiproses[date('F', mktime(0, 0, 0, $item?->bulan, 1))] = $item->total;
        }
        foreach ($dataKeseluruhan as $key=> $item) {
            $disetujui = $dataDisetujui[$key];
            $ditolak = $dataDitolak[$key];
            $diproses = $dataDiproses[$key];
            $dataKeseluruhan[$key] = intval($disetujui + $ditolak + $diproses);
        }

        return [
            'data_disetujui' => $dataDisetujui,
            'data_ditolak' => $dataDitolak,
            'data_diproses' => $dataDiproses,
            'data_keseluruhan' => $dataKeseluruhan,
        ];
    }

    public function getDataPosisi(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;
        $skema = $request->skema ?? null;
        $tanggalAwal = $request->tAwal ?? null;
        $tanggalAkhir = $request->tAkhir ?? null;
        $cabang = $request->cbg;

        $data = DB::table('pengajuan')
            ->selectRaw("CAST(sum(posisi='pincab') AS UNSIGNED) as pincab,
                CAST(sum(posisi='PBP') AS UNSIGNED) as pbp,
                CAST(sum(posisi='PBO') AS UNSIGNED) as pbo,
                CAST(sum(posisi='Review Penyelia') AS UNSIGNED) as penyelia,
                CAST(sum(posisi='Proses Input Data') AS UNSIGNED) as staf,
                CAST(sum(posisi='Selesai') AS UNSIGNED) as disetujui,
                CAST(sum(posisi='ditolak') AS UNSIGNED) as ditolak")
                ->when($cabang, function ($query, $cabang) {
                    return $query->where('id_cabang', $cabang);
                })
                ->when($tanggalAwal, function($query) use ($tanggalAwal){
                    return $query->where('tanggal', '>=', $tanggalAwal);
                })
                ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                    return $query->where('tanggal', '<=', $tanggalAkhir);
                })
                ->when($skema, function($query) use ($skema){
                    return $query->where('skema_kredit', $skema);
                })
                ->when($request->pss, function ($query, $pss) {
                    return $query->where('pengajuan.posisi', $pss);
                })
                ->when($request->sts, function ($query, $sts) {
                    if ($sts == 'Selesai' || $sts == 'Ditolak') {
                        return $query->where('pengajuan.posisi', $sts);
                    } else {
                        return $query->where('pengajuan.posisi', '<>', 'Selesai')
                        ->where('pengajuan.posisi', '<>', 'Ditolak');
                    }
                });
        if($role == 'Staf Analis Kredit'){
            $data->where('id_staf', $idUser);
        } else if($role == 'Penyelia Kredit'){
            $data->where('id_penyelia', $idUser);
        } else if($role == 'PBO'){
            $data->where('id_pbo', $idUser);
        } else if($role == 'PBP'){
            $data->where('id_pbp', $idUser);
        } else if($role == 'Pincab'){
            $data->where('id_pincab', $idUser);
        }

        return $data->first();
    }

    public function getDataSkema(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;
        $skema = $request->skema;
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $cabang = $request->cbg;
        $data = DB::table('pengajuan')
            ->selectRaw("sum(skema_kredit='PKPJ') as PKPJ,sum(skema_kredit='KKB') as KKB,sum(skema_kredit='Talangan Umroh') as Umroh,sum(skema_kredit='Prokesra') as Prokesra,sum(skema_kredit='Kusuma') as Kusuma, sum(skema_kredit='Dagulir') as Dagulir")
            ->when($cabang, function ($query, $cabang) {
                return $query->where('id_cabang', $cabang);
            })
            ->when($tanggalAwal, function($query) use ($tanggalAwal){
                return $query->where('tanggal', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                return $query->where('tanggal', '<=', $tanggalAkhir);
            })
            ->when($skema, function($query) use ($skema){
                return $query->where('skema_kredit', $skema);
            })
            ->when($request->pss, function ($query, $pss) {
                return $query->where('posisi', $pss);
            })
            ->when($request->sts, function ($query, $sts) {
                if ($sts == 'Selesai' || $sts == 'Ditolak') {
                    return $query->where('posisi', $sts);
                } else {
                    return $query->where('pengajuan.posisi', '<>', 'Selesai')
                    ->where('posisi', '<>', 'Ditolak');
                }
            });

        if($role == 'Staf Analis Kredit'){
            $data->where('id_staf', $idUser);
        } else if($role == 'Penyelia Kredit'){
            $data->where('id_penyelia', $idUser);
        } else if($role == 'PBO'){
            $data->where('id_pbo', $idUser);
        } else if($role == 'PBP'){
            $data->where('id_pbp', $idUser);
        } else if($role == 'Pincab'){
            $data->where('id_pincab', $idUser);
        }

        return $data->first();
    }

    public function getRangking(Request $request){
        $total_cabang = DB::table('cabang')->where('kode_cabang', '!=', '000')->count();
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;

        $dataTertinggi = DB::table('cabang')
            ->leftJoin('pengajuan', function ($join) use ($tanggalAwal,$tanggalAkhir) {
                $join->on('cabang.id', '=', 'pengajuan.id_cabang')
                    ->when($tanggalAwal, function($query) use ($tanggalAwal){
                        return $query->where('tanggal', '>=', $tanggalAwal);
                    })
                    ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                        return $query->where('tanggal', '<=', $tanggalAkhir);
                    });
            })
            ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
            ->where('cabang.kode_cabang', '!=', '000')
            ->groupBy('cabang.kode_cabang', 'cabang.cabang')
            ->orderByRaw('total DESC, cabang.kode_cabang ASC')
            ->limit(5)
            ->get();

        $dataTerendah = DB::table('cabang')
            ->leftJoin('pengajuan', function ($join) use ($tanggalAwal,$tanggalAkhir) {
                $join->on('cabang.id', '=', 'pengajuan.id_cabang')
                    ->when($tanggalAwal, function($query) use ($tanggalAwal){
                        return $query->where('tanggal', '>=', $tanggalAwal);
                    })
                    ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                        return $query->where('tanggal', '<=', $tanggalAkhir);
                    });
            })
            ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
            ->where('cabang.kode_cabang', '!=', '000')
            // ->where('pengajuan.posisi', 'Selesai')
            ->whereNull('pengajuan.deleted_at')
            ->groupBy('cabang.kode_cabang', 'cabang.cabang')
            ->orderByRaw('total ASC, cabang.kode_cabang ASC') // Ubah ke ASC untuk mengambil data terendah
            ->limit(5)
            ->get();
        return [
            'data_tertinggi' => $dataTertinggi,
            'data_terendah' => $dataTerendah
        ];
    }

}
