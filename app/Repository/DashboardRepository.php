<?php

namespace App\Repository;

use App\Models\PengajuanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class DashboardRepository
{
    public function getDetailSkemaTotal(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'PKPJ', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'KKB', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Talangan Umroh', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Prokesra', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Dagulir', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Kusuma', 1, 0)) AS kusuma"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Ditolak', 1, 0)) AS ditolak")
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }

    public function getDetailCabangTotal(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.posisi IN ('Proses Input Data', 'Review Penyelia', 'PBO', 'PBP', 'Pincab'), 1, 0)) AS diproses"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Proses Input Data', 1, 0)) AS staf"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Review Penyelia', 1, 0)) AS penyelia"),
            DB::raw("SUM(IF(pengajuan.posisi = 'PBO', 1, 0)) AS pbo"),
            DB::raw("SUM(IF(pengajuan.posisi = 'PBP', 1, 0)) AS pbp"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Pincab', 1, 0)) AS pincab"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Ditolak', 1, 0)) AS ditolak"),
            DB::raw("SUM(IF(pengajuan.id_cabang = c.id, 1, 0)) AS total")
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }

    public function getDetailCabangDisetujui(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'PKPJ' AND pengajuan.posisi = 'Selesai', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'KKB' AND pengajuan.posisi = 'Selesai', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Talangan Umroh' AND pengajuan.posisi = 'Selesai', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Prokesra' AND pengajuan.posisi = 'Selesai', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Dagulir' AND pengajuan.posisi = 'Selesai', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Kusuma' AND pengajuan.posisi = 'Selesai', 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailCabangDitolak(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'PKPJ' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'KKB' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS kkb"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Talangan Umroh' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS umroh"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Prokesra' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Dagulir' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Kusuma' AND pengajuan.posisi = 'Ditolak', 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailCabangDiproses(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.posisi = 'Proses Input Data', 1, 0)) AS proses_input_data"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Review Penyelia', 1, 0)) AS review_penyelia"),
            DB::raw("SUM(IF(pengajuan.posisi = 'PBO', 1, 0)) AS pbo"),
            DB::raw("SUM(IF(pengajuan.posisi = 'PBP', 1, 0)) AS pbp"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Pincab', 1, 0)) AS pincab"),
            DB::raw("SUM(IF(pengajuan.posisi IN ('Proses Input Data', 'Review Penyelia', 'PBO', 'PBP', 'Pincab'), 1, 0)) AS total"),
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailSkemaDiproses(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang AS c')
        ->select(
            'c.kode_cabang',
            'c.cabang',
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'PKPJ' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS pkpj"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'KKB' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS kkb"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Talangan Umroh' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS umroh"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Prokesra' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS prokesra"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Dagulir' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS dagulir"),
            DB::raw("SUM(IF(pengajuan.skema_kredit = 'Kusuma' AND pengajuan.posisi NOT IN ('Selesai', 'Ditolak'), 1, 0)) AS kusuma")
        )
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('c.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->where('c.kode_cabang', '!=', 000)
        ->groupBy('c.kode_cabang', 'c.cabang')
        ->orderBy('c.kode_cabang')
        ->get();

        return $data;
    }
    public function getDetailRankCabang(Request $request){
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $data = DB::table('cabang')
        ->leftJoin('pengajuan', function ($join) use ($tanggalAwal, $tanggalAkhir) {
            $join->on('cabang.id', '=', 'pengajuan.id_cabang')
                ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                    return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at');
                })
                ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                    return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at');
                })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                    return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at');
                });
        })
        ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
        ->where('cabang.kode_cabang', '!=', '000')
        ->groupBy('cabang.kode_cabang', 'cabang.cabang')
        ->orderByRaw('total DESC, cabang.kode_cabang ASC')
        ->get();

        return $data;
    }
    public function getDetailChartPosisiStaff($id_user, $role){
        $data = PengajuanModel::select(
            'pengajuan.id',
            'users.name as nama',
            'users.nip',
            DB::raw('IF(pengajuan.posisi = "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS belum'),
            DB::raw('IF(pengajuan.posisi != "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS sudah')
        )
        ->whereNull('pengajuan.deleted_at')
        ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
        ->join('users', 'users.id', 'pengajuan.id_staf')->get();
        if ($role == 'Pincab') {
            $data->where('pengajuan.id_pincab', $id_user);
        } else if ($role == 'Penyelia Kredit') {
            $data->where('pengajuan.id_penyelia', $id_user);
        } else if ($role == 'PBO' || $role = 'PBP') {
            $data->where('pengajuan.id_pbo', $id_user)->orWhere('pengajuan.id_pbp', $id_user);
        }

        return $data;
    }
    public function getDetailChartPosisiPenyelia($id_user, $role){
        $data = PengajuanModel::select(
            'pengajuan.id',
            'users.name as nama',
            'users.nip',
            DB::raw("SUM(IF(pengajuan.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Ditolak', 1, 0)) AS ditolak"),
            DB::raw('IF(pengajuan.posisi = "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS belum'),
            DB::raw('IF(pengajuan.posisi != "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS sudah')
        )
        ->whereNull('pengajuan.deleted_at')
        ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
        ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
        ->join('users', 'users.id', 'pengajuan.id_penyelia')->get();
        if ($role == 'Pincab') {
            $data->where('pengajuan.id_pincab', $id_user);
        } else if ($role == 'PBO' || $role = 'PBP') {
            $data->where('pengajuan.id_pbo', $id_user)->orWhere('pengajuan.id_pbp', $id_user);
        }

        return $data;
    }
    public function getDetailChartPosisiPincab($id_user, $role){
        $data = PengajuanModel::select(
            'pengajuan.id',
            'users.name as nama',
            'users.nip',
            DB::raw('IF(pengajuan.posisi = "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS belum'),
            DB::raw('IF(pengajuan.posisi != "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS sudah'),
            DB::raw("SUM(IF(pengajuan.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Ditolak', 1, 0)) AS ditolak")
        )
        ->whereNull('pengajuan.deleted_at')
        ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
        ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
        ->join('users', 'users.id', 'pengajuan.id_pincab')
        ->get();
        if ($role == 'Pincab') {
            $data->where('pengajuan.id_pincab', $id_user);
        } else if ($role == 'PBO' || $role = 'PBP') {
            $data->where('pengajuan.id_pbo', $id_user)->orWhere('pengajuan.id_pbp', $id_user);
        }

        return $data;
    }
    public function getDetailChartPosisiPBOorPBP($id_user, $role){
        $data = PengajuanModel::select(
            'pengajuan.id',
            'users.name as nama',
            'users.nip',
            DB::raw("SUM(IF(pengajuan.posisi = 'Selesai', 1, 0)) AS disetujui"),
            DB::raw("SUM(IF(pengajuan.posisi = 'Ditolak', 1, 0)) AS ditolak"),
            DB::raw('IF(pengajuan.posisi = "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS belum'),
            DB::raw('IF(pengajuan.posisi != "' . $this->getPosisiPengajuan($role) . '", 1, 0) AS sudah')
        )
        ->whereNull('pengajuan.deleted_at')
        ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
        ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id');
        if ($role == 'Pincab') {
            $data->join('users', 'users.id', 'pengajuan.id_pincab')
                ->where('pengajuan.id_pincab', $id_user);
        }
        else if ($role == 'PBO') {
            $data->join('users', 'users.id', 'pengajuan.id_pbo')
                ->where('pengajuan.id_pbo', $id_user)->orWhere('pengajuan.id_pbp', $id_user);
        }
        else if ($role == 'PBP') {
            $data->join('users', 'users.id', 'pengajuan.id_pbp')
                ->where('pengajuan.id_pbo', $id_user)->orWhere('pengajuan.id_pbp', $id_user);
        }

        $data->get();

        return $data;
    }
    public function getDetailChartSkema($idUser, $role)
    {
        $data = DB::table('pengajuan')
        ->select(
            'id_staf',
            'id_penyelia',
            'id_pbo',
            'id_pbp',
            'id_pincab',
            'posisi',
            'skema_kredit'
        )->whereNull('pengajuan.deleted_at')->where('pengajuan.skema_kredit', '!=', 'Dagulir');
        if ($role == 'Staf Analis Kredit') {
            $data->where('id_staf', $idUser);
        } else if ($role == 'Penyelia Kredit') {
            $data->where('id_penyelia', $idUser);
        } else if ($role == 'PBO') {
            $data->where('id_pbo', $idUser);
        } else if ($role == 'PBP') {
            $data->where('id_pbp', $idUser);
        } else if ($role == 'Pincab') {
            $data->where('id_pincab', $idUser);
        } else {
            $data;
        }

        $processedData = [
            'PKPJ' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
            'KKB' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
            'Talangan' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
            'Prokesra' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
            'Kusuma' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
            'Dagulir' => ['total_pengajuan' => 0, 'total_selesai' => 0, 'total_ditolak' => 0, 'diproses' => 0, 'staf' => 0, 'penyelia'=> 0, 'pbo_pbp' => 0, 'pincab' => 0],
        ];

        foreach ($data->get() as $value) {
            $paramSkema = '';

            if ($value->skema_kredit == "PKPJ") {
                $paramSkema = "PKPJ";
            } elseif ($value->skema_kredit == "KKB") {
                $paramSkema = "KKB";
            } elseif ($value->skema_kredit == "Talangan Umroh") {
                $paramSkema = "Talangan";
            } elseif ($value->skema_kredit == "Prokesra") {
                $paramSkema = "Prokesra";
            } elseif ($value->skema_kredit == "Kusuma") {
                $paramSkema = "Kusuma";
            } elseif ($value->skema_kredit == "Dagulir") {
                $paramSkema = "Dagulir";
            }

            if (!empty($value->id_staf) && !empty($value->id_penyelia) && !empty($value->id_pincab)) {
                $processedData[$paramSkema]['total_pengajuan'] += 1;
                $processedData[$paramSkema]['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData[$paramSkema]['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData[$paramSkema]['staf'] += ($value->posisi == 'Proses Input Data') ? 1 : 0;
                $processedData[$paramSkema]['penyelia'] += ($value->posisi == 'Review Penyelia') ? 1 : 0;
                $processedData[$paramSkema]['pincab'] += ($value->posisi == 'Pincab') ? 1 : 0;
                $processedData[$paramSkema]['pbo_pbp'] += ($value->posisi == 'PBO' || $value->posisi == 'PBP') ? 1 : 0;
                $processedData[$paramSkema]['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;
            } else {
                $processedData[$paramSkema]['total_pengajuan'] += 1;
                $processedData[$paramSkema]['total_selesai'] += ($value->posisi == 'Selesai') ? 1 : 0;
                $processedData[$paramSkema]['total_ditolak'] += ($value->posisi == 'Ditolak') ? 1 : 0;
                $processedData[$paramSkema]['staf'] += ($value->posisi == 'Proses Input Data') ? 1 : 0;
                $processedData[$paramSkema]['penyelia'] += ($value->posisi == 'Review Penyelia') ? 1 : 0;
                $processedData[$paramSkema]['pincab'] += ($value->posisi == 'Pincab') ? 1 : 0;
                $processedData[$paramSkema]['pbo_pbp'] += ($value->posisi == 'PBO' || $value->posisi == 'PBP') ? 1 : 0;
                $processedData[$paramSkema]['diproses'] += $value->posisi == 'Proses Input Data' || $value->posisi == 'Review Penyelia' || $value->posisi == 'PBO' || $value->posisi == 'PBP' || $value->posisi == 'Pincab' ? 1 : 0;
            }
        }

        return $processedData;
    }

    function getPosisiPengajuan($role)
    {
        switch ($role) {
            case 'Penyelia':
                return 'Review Penyelia';
            case 'PBO':
                return 'PBO';
            case 'PBP':
                return 'PBP';
            case 'Pincab':
                return 'Pincab';
            default:
                return 'Proses Input Data';
        }
    }

    public function getCount(Request $request){
        $role = auth()->user()->role;
        $idUser = auth()->user()->id;
        $skema = $request->skema ?? null;
        $tanggalAwal = $request->tAwal;
        $tanggalAkhir = $request->tAkhir;
        $cabang = $request->cbg;
        $bulan_sekarang = date('m');

        $data = DB::table('pengajuan')
            ->whereNull('deleted_at')
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
            ->whereMonth('tanggal', $bulan_sekarang)
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
        $tAwal = date('Y') . '-' . date('m') . '-01';
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
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
            ->groupBy(DB::raw('MONTH(tanggal)'));

        $total_ditolak_perbulan = DB::table('pengajuan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tAwal, $tAkhir])
            ->where('posisi', 'Ditolak')
            ->whereNull('pengajuan.deleted_at')
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
            ->groupBy(DB::raw('MONTH(tanggal)'));

        $total_diproses_perbulan = DB::table('pengajuan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$tAwal, $tAkhir])
            ->whereIn('posisi', ['Pincab','PBP','PBO','Review Penyelia','Proses Input Data'])
            ->whereNull('pengajuan.deleted_at')
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
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
        $bulan_sekarang = date('m');

        $data = DB::table('pengajuan')->whereMonth('tanggal', $bulan_sekarang)
            ->whereNull('pengajuan.deleted_at')
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
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
        $bulan_sekarang = date('m');
        $data = DB::table('pengajuan')->whereMonth('tanggal', $bulan_sekarang)
            ->whereNull('pengajuan.deleted_at')
            ->where('pengajuan.skema_kredit', '!=', 'Dagulir')
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
        $bulan_sekarang = date('m');

        $dataTertinggi = DB::table('cabang')
            ->leftJoin('pengajuan', function ($join) use ($tanggalAwal,$tanggalAkhir) {
                $join->on('cabang.id', '=', 'pengajuan.id_cabang')
                    ->when($tanggalAwal, function($query) use ($tanggalAwal){
                        return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    })
                    ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                        return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                        return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    });
            })
            ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
            ->where('cabang.kode_cabang', '!=', '000')
            ->groupBy('cabang.kode_cabang', 'cabang.cabang')
            // ->whereMonth('tanggal', $bulan_sekarang)
            ->orderByRaw('total DESC, cabang.kode_cabang ASC')
            ->limit(5)
            ->get();

        $dataTerendah = DB::table('cabang')
            ->leftJoin('pengajuan', function ($join) use ($tanggalAwal,$tanggalAkhir) {
                $join->on('cabang.id', '=', 'pengajuan.id_cabang')
                    ->when($tanggalAwal, function($query) use ($tanggalAwal){
                        return $query->where('tanggal', '>=', $tanggalAwal)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    })
                    ->when($tanggalAkhir, function($query) use ($tanggalAkhir){
                        return $query->where('tanggal', '<=', $tanggalAkhir)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    })->when(empty($tanggalAwal) && empty($tanggalAkhir), function ($query) {
                        return $query->whereMonth('tanggal', now()->month)->whereNull('pengajuan.deleted_at')
                        ->where('pengajuan.skema_kredit', '!=', 'Dagulir');
                    });
            })
            ->selectRaw('IFNULL(COUNT(pengajuan.id), 0) AS total, cabang.kode_cabang, cabang.cabang')
            ->where('cabang.kode_cabang', '!=', '000')
            // ->where('pengajuan.posisi', 'Selesai')
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
