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
        )
        ->get();

        $processedData = [
            'staf' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'penyelia' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pbo' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pbp' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
            'pincab' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0],
        ];

        foreach ($data as $value) {
            $staffRole = '';


    if (!empty($value->id_staf) && !empty($value->id_penyelia) && !empty($value->id_pincab) ) {
        $processedData['staf']['total_pengajuan'] += 1;
        $processedData['staf']['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
        $processedData['staf']['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
        $processedData['staf']['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;

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
            $processedData[$staffRole]['diproses'] += ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') ? 1 : 0;
        }
    }
        }

    return $processedData;
// $data = DB::table('pengajuan')
//         ->whereNull('deleted_at')
//         ->select(DB::raw('sum(case when posisi is not null then 1 else 0 end) as total_by_position'),
//                  DB::raw('sum(case when id_staf is not null then 1 else 0 end) as total_by_staff_id_staf'),
//                  DB::raw('sum(case when id_penyelia is not null then 1 else 0 end) as total_by_staff_id_penyelia'),
//                  DB::raw('sum(case when id_pbo is not null then 1 else 0 end) as total_by_staff_id_pbo'),
//                  DB::raw('sum(case when id_pincab is not null then 1 else 0 end) as total_by_staff_id_pincab'),
//                   'posisi')
//         ->groupBy('posisi')
//         ->get();
//         // $data->transform(function ($value) {
//         //     $total_proses = 0;
//         //     if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
//         //         $total_proses += $value->total_by_staff_id_staf;
//         //         $value->total = $total_proses;
//         //     } elseif ($value->posisi == 'Selesai') {
//         //         $value += $value->count_posisi;
//         //     } elseif ($value->posisi == 'Ditolak') {
//         //         $value += $value->count_posisi;
//         //     }
//         //     return $value;
//         // });
//         $processedData = [
//             'total_pengajuan' => 0,
//             'total_selesai' => 0,
//             'total_ditolak' => 0,
//         ];

//         foreach ($data as $value) {
//             if (in_array($value->posisi, ['Proses Input Data', 'Review Penyelia', 'PBO', 'PBP', 'Pincab'])) {
//                 $processedData['total_pengajuan'] += $value->total_by_position;
//             } elseif ($value->posisi == 'Selesai') {
//                 $processedData['total_selesai'] += $value->total_by_position;
//             } elseif ($value->posisi == 'Ditolak') {
//                 $processedData['total_ditolak'] += $value->total_by_position;
//             }
//         }

//         return $processedData;
    //     $results = [];

    // foreach ($data as $key => $value) {
    //     // Initialize variables for each iteration
    //     $nama = '';
    //     $total_proses = 0;
    //     $total_selesai = 0;
    //     $total_ditolak = 0;

    //     // Check the role and set variables accordingly
    //     if ($value->id_staf != null) {
    //         $nama = 'Staf';
    //     } elseif ($value->id_penyelia != null) {
    //         $nama = 'Penyelia';
    //     } elseif ($value->id_pbp != null) {
    //         $nama = 'PBP';
    //     } elseif ($value->id_pincab != null) {
    //         $nama = 'Pincab';
    //     }

    //     // Update totals based on posisi
    //     if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
    //         $total_proses += $value->count_posisi;
    //     } elseif ($value->posisi == 'Selesai') {
    //         $total_selesai += $value->count_posisi;
    //     } elseif ($value->posisi == 'Ditolak') {
    //         $total_ditolak += $value->count_posisi;
    //     }

    //     // Create a single data object with total counts
    //     $result = new \stdClass();
    //     $result->nama = $value->id_penyelia;
    //     $result->total_proses = $total_proses;
    //     $result->total_selesai = $total_selesai;
    //     $result->total_ditolak = $total_ditolak;
    //     $results[] = $result;
    // }

    // // Return the array of results as JSON
    // return $results;
    // foreach ($results as $result) {
    //     echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
    // }
    //     $data = DB::table('pengajuan')
    //         ->whereNull('deleted_at')
    //         ->select( DB::raw('count(posisi) as count_posisi, posisi'))
    //         // ->where('posisi','Ditolak')
    //         ->groupBy('posisi')
    //         ->where('id_staf', $idUser)->get();
    //     foreach ($data as $key => $value) {
    //         if ($role != 'Administrator') {
    //             if($role == 'Staf Analis Kredit'){
    //                 $total_proses = 0;
    //                 $total_selesai = 0;
    //                 $total_ditolak = 0;
    //                 if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
    //                     $total_proses += $value->count_posisi;
    //                 } else if($value->posisi == 'Selesai'){
    //                     $total_selesai += $value->count_posisi;
    //                 } else if($value->posisi == 'Ditolak'){
    //                     $total_ditolak += $value->count_posisi;
    //                 }
    //                 $posisiUser = 'Staf';
    //                 $value->nama = $posisiUser;
    //                 $value->total_proses = $total_proses;
    //                 $value->total_selesai = $total_selesai;
    //                 $value->total_ditolak = $total_ditolak;
    //             }else if($role == 'Penyelia Kredit'){
    //                 $posisiUser = "Penyelia";
    //                 $total_proses = 0;
    //                 $total_selesai = 0;
    //                 $total_ditolak = 0;
    //                 if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
    //                     $total_proses += $value->count_posisi;
    //                 } else if($value->posisi == 'Selesai'){
    //                     $total_selesai += $value->count_posisi;
    //                 } else if($value->posisi == 'Ditolak'){
    //                     $total_ditolak += $value->count_posisi;
    //                 }
    //                 $posisiUser = 'Staf';
    //                 $value->nama = $posisiUser;
    //                 $value->total_proses = $total_proses;
    //                 $value->total_selesai = $total_selesai;
    //                 $value->total_ditolak = $total_ditolak;
    //             } else if($role == 'PBO'){
    //                 $posisiUser = "PBO";
    //                 $total_proses = 0;
    //                 $total_selesai = 0;
    //                 $total_ditolak = 0;
    //                 if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
    //                     $total_proses += $value->count_posisi;
    //                 } else if($value->posisi == 'Selesai'){
    //                     $total_selesai += $value->count_posisi;
    //                 } else if($value->posisi == 'Ditolak'){
    //                     $total_ditolak += $value->count_posisi;
    //                 }
    //                 $posisiUser = 'Staf';
    //                 $value->nama = $posisiUser;
    //                 $value->total_proses = $total_proses;
    //                 $value->total_selesai = $total_selesai;
    //                 $value->total_ditolak = $total_ditolak;
    //             } else if($role == 'PBP'){
    //                 $posisiUser = "PBP";
    //                 $total_proses = 0;
    //                 $total_selesai = 0;
    //                 $total_ditolak = 0;
    //                 if ($value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab') {
    //                     $total_proses += $value->count_posisi;
    //                 } else if($value->posisi == 'Selesai'){
    //                     $total_selesai += $value->count_posisi;
    //                 } else if($value->posisi == 'Ditolak'){
    //                     $total_ditolak += $value->count_posisi;
    //                 }
    //                 $posisiUser = 'Staf';
    //                 $value->nama = $posisiUser;
    //                 $value->total_proses = $total_proses;
    //                 $value->total_selesai = $total_selesai;
    //                 $value->total_ditolak = $total_ditolak;
    //             }
    //         }
    //     }
    //     return $data;

    //     // if($role == 'Staf Analis Kredit'){
    //     //     $posisiUser = "Staf";
    //     //     $data->where('id_staf', $idUser);
    //     // } else if($role == 'Penyelia Kredit'){
    //     //     $posisiUser = "Penyelia";
    //     //     $data->where('id_penyelia', $idUser);
    //     //     $data->where('posisi','Review Penyelia');
    //     // } else if($role == 'PBO'){
    //     //     $posisiUser = "PBO";
    //     //     $data->where('id_pbo', $idUser);
    //     //     $data->where('posisi','PBO');
    //     // } else if($role == 'PBP'){
    //     //     $posisiUser = "PBP";
    //     //     $data->where('id_pbp', $idUser);
    //     //     $data->where('posisi','PBP');
    //     // } else if($role == 'Pincab'){
    //     //     $posisiUser = "Pincab";
    //     //     $data->where('id_pincab', $idUser);
    //     //     $data->where('posisi','Pincab');
    //     // }else{

    //     // }
    //     if ($role != 'Admin') {
    //         # code...
    //     } else {
    //         # code...
    //     }

    //     return $data->get();
    //     $total_proses = 0;
    //     $total_selesai = 0;
    //     $total_ditolak = 0;
    //     $total_keseluruhan = 0;
    //     foreach($data->get() as $item){
    //         if($item->posisi == 'Proses Input Data' || $item->posisi == 'Review Penyelia' || $item->posisi == 'PBO' || $item->posisi == 'PBP' || $item->posisi == 'Pincab'){
    //             $total_proses++;
    //         } else if($item->posisi == 'Selesai'){
    //             $total_selesai++;
    //         } else if($item->posisi == 'Ditolak'){
    //             $total_ditolak++;
    //         }
    //         $total_keseluruhan++;
    //     }

    //     return ($role == 'Staf Analis Kredit' || $role == 'Penyelia Kredit' || $role == 'PBO' || $role == 'PBP' || $role == 'Pincab') ?
    //     array(
    //         'user' => $posisiUser,
    //         'proses' => $total_proses,
    //         'selesai' => $total_selesai,
    //         'ditolak' => $total_ditolak,
    //         'total' => $total_keseluruhan
    //     ) :
    //     array(
    //         'user' => "TEESS",
    //         'proses' => $total_proses,
    //         'selesai' => $total_selesai,
    //         'ditolak' => $total_ditolak,
    //         'total' => $total_keseluruhan
    //     );

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
        foreach($data->get() as $item){
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
            'total' => $total_keseluruhan
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
