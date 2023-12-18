<?php
namespace App\Repository;

use App\Models\Kecamatan;
use App\Models\PengajuanDagulir;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PengajuanDagulirRepository
{
    function get($search, $limit=10, $page=1, $role, $id_user) {
        $data = null;
        if ($role == 'Staf Analis Kredit') {
            $data = PengajuanDagulir::with('pengajuan')->where(function($query) use ($search) {
                $query->where('kode_pendaftaran','like', "%$search%")
                        ->orWhere('nama','like', "%$search%")
                        ->orWhere('kode_pendaftaran','like', "%$search%");
            })
            ->latest()
            ->join('pengajuan', 'pengajuan.dagulir_id', 'pengajuan_dagulir.id')
            ->select('pengajuan_dagulir.*')
            ->where('pengajuan.id_staf', $id_user)
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
            ->latest()
            ->paginate($limit);
        }

        foreach ($data as $key => $item) {
            $nama_pemroses = 'undifined';
            $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            if($item->posisi == 'Proses Input Data'){
                $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            } else if($item->posisi == 'Review Penyelia'){
                $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_penyelia)->first();
            } else if($item->posisi == 'PBO'){
                $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_pbo)->first();
            } else if($item->posisi == 'PBP'){
                $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_pbp)->first();
            } else if($item->posisi == 'Pincab' || $item->posisi == 'Selesai' || $item->posisi == 'Ditolak'){
                $user = \App\Models\User::select('nip')->where('id', $item->pengajuan->id_pincab)->first();
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
