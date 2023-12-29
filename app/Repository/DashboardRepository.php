<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class DashboardRepository
{
    public function getDetailPosisi(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;

        $data = DB::table('pengajuan')
        ->whereNull('deleted_at')
        ->select(
            'id_staf',
            'id_penyelia',
            'id_pbo',
            'id_pbp',
            'id_pincab',
            'posisi'
        );

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
        }else{
            $data;
        }

        $processedData = [
            'staf' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'penyelia' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pbo' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pbp' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pincab' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
        ];

        foreach ($data->get() as $value) {
            $staffRole = '';

            if (!empty($value->id_staf) && !empty($value->id_penyelia) && !empty($value->id_pincab) ) {
                $processedData['staf']['total_pengajuan'] += 1;
                $processedData['staf']['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData['staf']['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData['staf']['diproses'] += $value->posisi == 'Proses Input Data' ? 1 : 0;

                $processedData['penyelia']['total_pengajuan'] += 1;
                $processedData['penyelia']['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData['penyelia']['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData['penyelia']['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;

                $processedData['pincab']['total_pengajuan'] += 1;
                $processedData['pincab']['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData['pincab']['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData['pincab']['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;
            } else {
                if (!empty($value->id_staf)) {
                    $staffRole = 'staf';
                } elseif (!empty($value->id_penyelia)) {
                    $staffRole = 'penyelia';
                } elseif (!empty($value->id_pbo)) {
                    $staffRole = 'pbo';
                } elseif (!empty($value->id_pbp)) {
                    $staffRole = 'pbp';
                } elseif (!empty($value->id_pincab)) {
                    $staffRole = 'pincab';
                }

                if ($staffRole) {
                    $processedData[$staffRole]['total_pengajuan'] += 1;
                    $processedData[$staffRole]['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                    $processedData[$staffRole]['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                    $processedData[$staffRole]['diproses'] += ($value->posisi == 'Proses Input Data') ? 1 : 0;
                }
            }
        }

        return $processedData;
    }

    public function getDetailSkema(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;

        $data = DB::table('pengajuan')
        ->select(
            'id_staf',
            'id_penyelia',
            'id_pbo',
            'id_pbp',
            'id_pincab',
            'posisi',
            'skema_kredit'
        );
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
        }else{
            $data;
        }

        $processedData = [
            'PKPJ' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'KKB' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'Talangan' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'Prokesra' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'Kusuma' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'Dagulir' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
        ];

        foreach ($data->get() as $value) {
            $paramSkema = '';

            if($value->skema_kredit == "PKPJ") {
                $paramSkema = "PKPJ";
            }elseif($value->skema_kredit == "KKB"){
                $paramSkema = "KKB";
            }elseif($value->skema_kredit == "Talangan Umroh"){
                $paramSkema = "Talangan";
            }elseif($value->skema_kredit == "Prokesra"){
                $paramSkema = "Prokesra";
            }elseif($value->skema_kredit == "Kusuma"){
                $paramSkema = "Kusuma";
            }elseif($value->skema_kredit == "Dagulir"){
                $paramSkema = "Dagulir";
            }

            if (!empty($value->id_staf) && !empty($value->id_penyelia) && !empty($value->id_pincab) ) {
                $processedData[$paramSkema]['total_pengajuan'] += 1;
                $processedData[$paramSkema]['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData[$paramSkema]['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData[$paramSkema]['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;
            }else{
                $processedData[$paramSkema]['total_pengajuan'] += 1;
                $processedData[$paramSkema]['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData[$paramSkema]['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData[$paramSkema]['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;
            }

        }

        return $processedData;
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
