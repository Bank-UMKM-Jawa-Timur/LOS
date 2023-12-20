<?php
namespace App\Repository;

use App\Models\Kecamatan;
use App\Models\PengajuanDagulir;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PengajuanDagulirRepository
{
    function get($search, $limit=10, $page=1, $role, $id_user, array $filter) {
        $data = null;
        $cabang = null;
        if (isset($filter['cbg'])) {
            $cabang = DB::table('cabang')
            ->where('kode_cabang', $filter['cbg'])
            ->first();
        }else{
            $cabang = null;
        }

        if ($role == 'Staf Analis Kredit') {
            $data = PengajuanDagulir::with('pengajuan')
            ->where('pengajuan.id_staf', $id_user)
            ->when($search, function ($query, $search) {
                $query->where('kode_pendaftaran','like', "%$search%")
                        ->orWhere('nama','like', "%$search%")
                        ->orWhere('kode_pendaftaran','like', "%$search%");
            })
            ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
            })
            ->when($cabang, function ($query, $cabang) {
                return $query->where('pengajuan.id_cabang', $cabang->id);
            })
            ->when(isset($filter['pss']), function ($query) use ($filter) {
                return $query->where('pengajuan.posisi', $filter['pss']);
            })
            ->when(isset($filter['sts']), function ($query) use ($filter) {
                if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                    return $query->where('pengajuan.posisi', $filter['sts']);
                } else {
                    return $query->where('pengajuan.posisi', '<>', 'Selesai')
                        ->where('pengajuan.posisi', '<>', 'Ditolak');
                }
            })
            ->when(isset($filter['score']), function ($query) use ($filter) {
                return $query->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                    ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
            })
            ->latest()
            ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
            ->select('pengajuan_dagulir.*')
            ->paginate($limit);
        }else if ($role == 'Penyelia Kredit') {
            $data = PengajuanDagulir::whereHas('pengajuan', function (Builder $query) {
                        $query->where('pengajuan.id_penyelia', auth()->user()->id);
               })
                ->where(function($query) use ($search) {
                    $query->where('kode_pendaftaran','like', "%$search%")
                            ->orWhere('nama','like', "%$search%")
                            ->orWhere('kode_pendaftaran','like', "%$search%");
                })
            ->with('pengajuan')
            ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
            ->select('pengajuan_dagulir.*')
            ->where('pengajuan.id_penyelia', $id_user)
            ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
            })
            ->when($cabang, function ($query, $cabang) {
                return $query->where('pengajuan.id_cabang', $cabang->id);
            })
            ->when(isset($filter['pss']), function ($query) use ($filter) {
                return $query->where('pengajuan.posisi', $filter['pss']);
            })
            ->when(isset($filter['sts']), function ($query) use ($filter) {
                if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                    return $query->where('pengajuan.posisi', $filter['sts']);
                } else {
                    return $query->where('pengajuan.posisi', '<>', 'Selesai')
                        ->where('pengajuan.posisi', '<>', 'Ditolak');
                }
            })
            ->when(isset($filter['score']), function ($query) use ($filter) {
                return $query->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                    ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
            })
            ->latest()
            ->paginate($limit);
        }else if ($role == 'Pincab') {
            $data = PengajuanDagulir::whereHas('pengajuan', function (Builder $query) {
                        $query->where('pengajuan.id_pincab', auth()->user()->id);
               })
                ->where(function($query) use ($search) {
                    $query->where('kode_pendaftaran','like', "%$search%")
                            ->orWhere('nama','like', "%$search%")
                            ->orWhere('kode_pendaftaran','like', "%$search%");
                })
            ->with('pengajuan')
            ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
            ->select('pengajuan_dagulir.*')
            ->where('pengajuan.id_pincab', $id_user)
            ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
            })
            ->when($cabang, function ($query, $cabang) {
                return $query->where('pengajuan.id_cabang', $cabang->id);
            })
            ->when(isset($filter['pss']), function ($query) use ($filter) {
                return $query->where('pengajuan.posisi', $filter['pss']);
            })
            ->when(isset($filter['sts']), function ($query) use ($filter) {
                if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                    return $query->where('pengajuan.posisi', $filter['sts']);
                } else {
                    return $query->where('pengajuan.posisi', '<>', 'Selesai')
                        ->where('pengajuan.posisi', '<>', 'Ditolak');
                }
            })
            ->when(isset($filter['score']), function ($query) use ($filter) {
                return $query->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                    ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
            })
            ->latest()
            ->paginate($limit);
        }

        foreach ($data as $key => $item) {
            // dd($item->pengajuan);
            $nama_pemroses = 'undifined';
            $user = User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            if($item->posisi == 'Proses Input Data'){
                $user = User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            } else if($item->posisi == 'Review Penyelia'){
                $user = User::select('nip')->where('id', $item->pengajuan->id_penyelia)->first();
            } else if($item->posisi == 'PBO'){
                $user = User::select('nip')->where('id', $item->pengajuan->id_pbo)->first();
            } else if($item->posisi == 'PBP'){
                $user = User::select('nip')->where('id', $item->pengajuan->id_pbp)->first();
            } else if($item->posisi == 'Pincab' || $item->posisi == 'Selesai' || $item->posisi == 'Ditolak'){
                $user = User::select('nip')->where('id', $item->pengajuan->id_pincab)->first();
            }
            if ($user)
                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
            else {
                $check_log = \DB::table('log_pengajuan')
                                ->select('nip')
                                ->where('id_pengajuan', $item->pengajuan->id)
                                ->where('activity', 'LIKE', 'Staf%')
                                ->orderBy('id', 'DESC')
                                ->first();
                if ($check_log)
                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
            }
            $item->nama_pemroses = $nama_pemroses;
        }
        return $data;
    }

    function detail($id) {
        $data = PengajuanDagulir::with('pengajuan',
                                'kec_ktp:id,kecamatan',
                                'kotakab_ktp:id,kabupaten',
                                'kec_dom:id,kecamatan',
                                'kotakab_dom:id,kabupaten',
                                'kec_usaha:id,kecamatan',
                                'kotakab_usaha:id,kabupaten')
                ->where('id',$id)->first();
        return $data;
    }
}
