<?php
namespace App\Repository;

use App\Models\Kecamatan;
use App\Models\PengajuanDagulir;
use App\Models\PengajuanModel;
use App\Models\PlafonUsulan;
use App\Models\User;
use App\Models\PengajuanDagulirTemp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PengajuanDagulirRepository
{

    function get($search, $limit = 10, $page = 1, $role, $id_user, array $filter, $from_apps = 'pincetar')
    {
        $data = null;
        $cabang = null;
        if (isset($filter['cbg'])) {
            $cabang = DB::table('cabang')
                ->where('kode_cabang', $filter['cbg'])
                ->first();
        } else {
            $cabang = null;
        }
        if ($role == 'Staf Analis Kredit') {
            $data = PengajuanDagulir::with([
                'pengajuan' => function ($query) {
                    $query->with('komentar');
                }
            ])
            ->whereHas('pengajuan', function ($query) use ($id_user, $filter, $cabang) {
            $query->where('pengajuan.id_staf', $id_user)
                ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                    return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
                })
                ->when(isset($filter['pss']), function ($query) use ($filter) {
                    return $query->where('pengajuan.posisi', $filter['pss']);
                })
                ->when(isset($filter['score']), function ($query) use ($filter) {
                    return $query->where(function ($query2) use ($filter) {
                        $query2->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                            ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
                    });
                })
                ->when(isset($filter['sts']), function ($query) use ($filter) {
                    if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                        return $query->where('pengajuan.posisi', $filter['sts']);
                    } else {
                        return $query->where('pengajuan.posisi', '<>', 'Selesai')
                            ->where('pengajuan.posisi', '<>', 'Ditolak');
                    }
                });
            })
            ->where('pengajuan_dagulir.from_apps', $from_apps)
            ->when($search, function ($query, $search) use ($from_apps) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_pendaftaran', 'like', "%$search%")
                        ->orWhere('nama', 'like', "%$search%");
                })
                ->where('pengajuan_dagulir.from_apps', $from_apps);
            })
            ->latest()
            ->select('pengajuan_dagulir.*')
            ->paginate($limit);
        } else if ($role == 'Penyelia Kredit') {
            $data = PengajuanDagulir::with([
                'pengajuan' => function ($query) {
                    $query->with('komentar');
                }
            ])
                ->whereHas('pengajuan', function ($query) use ($id_user, $filter, $cabang) {
                    $query->where('pengajuan.id_penyelia', $id_user)
                        ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                            return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
                        })
                        ->when(isset($filter['pss']), function ($query) use ($filter) {
                            return $query->where('pengajuan.posisi', $filter['pss']);
                        })
                        ->when(isset($filter['score']), function ($query) use ($filter) {
                            return $query->where(function ($query2) use ($filter) {
                                $query2->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                                    ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
                            });
                        })
                        ->when(isset($filter['sts']), function ($query) use ($filter) {
                            if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                                return $query->where('pengajuan.posisi', $filter['sts']);
                            } else {
                                return $query->where('pengajuan.posisi', '<>', 'Selesai')
                                    ->where('pengajuan.posisi', '<>', 'Ditolak');
                            }
                        });
                })
                ->when($search, function ($query, $search) {
                    $query->where('kode_pendaftaran', 'like', "%$search%")
                        ->orWhere('nama', 'like', "%$search%");
                })
                ->where('pengajuan_dagulir.from_apps', $from_apps)
                ->select('pengajuan_dagulir.*')
                ->latest()
                ->paginate($limit);
        } else if ($role == 'Pincab') {
            $data = PengajuanDagulir::with([
                'pengajuan' => function ($query) {
                    $query->with('komentar');
                }
            ])->when($search, function ($query, $search) {
                $query->where('kode_pendaftaran', 'like', "%$search%")
                    ->orWhere('nama', 'like', "%$search%");
            })
                ->whereHas('pengajuan', function ($query) use ($id_user, $filter, $cabang) {
                    $query->where('pengajuan.id_pincab', $id_user)
                        ->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                            return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
                        })
                        ->when(isset($filter['pss']), function ($query) use ($filter) {
                            return $query->where('pengajuan.posisi', $filter['pss']);
                        })
                        ->when(isset($filter['score']), function ($query) use ($filter) {
                            return $query->where(function ($query2) use ($filter) {
                                $query2->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                                    ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
                            });
                        })
                        ->when(isset($filter['sts']), function ($query) use ($filter) {
                            if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                                return $query->where('pengajuan.posisi', $filter['sts']);
                            } else {
                                return $query->where('pengajuan.posisi', '<>', 'Selesai')
                                    ->where('pengajuan.posisi', '<>', 'Ditolak');
                            }
                        });
                })
                ->where('pengajuan_dagulir.from_apps', $from_apps)
                ->when($search, function ($query, $search) use ($from_apps) {
                    $query->where(function ($query) use ($search) {
                        $query->where('kode_pendaftaran', 'like', "%$search%")
                            ->orWhere('nama', 'like', "%$search%");
                    })
                    ->where('pengajuan_dagulir.from_apps', $from_apps);
                })
                ->latest()
                ->select('pengajuan_dagulir.*')
                // ->where('pengajuan.id_staf', $id_user)
                ->where('pengajuan_dagulir.from_apps', $from_apps)
                ->paginate($limit);
        } else {
            $data = PengajuanDagulir::with([
                'pengajuan' => function ($query) {
                    $query->with('komentar');
                }
            ])
            ->whereHas('pengajuan', function ($query) use ($id_user, $filter, $cabang) {
                $query->when(isset($filter['tAwal']) && isset($filter['tAkhir']), function ($query) use ($filter) {
                    return $query->whereBetween('pengajuan.tanggal', [$filter['tAwal'], $filter['tAkhir']]);
                })
                ->when(isset($filter['pss']), function ($query) use ($filter) {
                    return $query->where('pengajuan.posisi', $filter['pss']);
                })
                ->when(isset($filter['score']), function ($query) use ($filter) {
                    return $query->where(function ($query2) use ($filter) {
                        $query2->whereRaw('FLOOR(pengajuan.average_by_sistem) = ?', $filter['score'])
                            ->orWhereRaw('FLOOR(pengajuan.average_by_penyelia) = ?', $filter['score']);
                    });
                })
                ->when(isset($filter['sts']), function ($query) use ($filter) {
                    if ($filter['sts'] == 'Selesai' || $filter['sts'] == 'Ditolak') {
                        return $query->where('pengajuan.posisi', $filter['sts']);
                    } else {
                        return $query->where('pengajuan.posisi', '<>', 'Selesai')
                            ->where('pengajuan.posisi', '<>', 'Ditolak');
                    }
                });
            })
            ->where('pengajuan_dagulir.from_apps', $from_apps)
            ->when($search, function ($query, $search) use ($from_apps) {
                $query->where(function ($query) use ($search) {
                    $query->where('kode_pendaftaran', 'like', "%$search%")
                        ->orWhere('nama', 'like', "%$search%");
                })
                ->where('pengajuan_dagulir.from_apps', $from_apps);
            })
            ->latest()
            ->select('pengajuan_dagulir.*')
            ->paginate($limit);
                // ->when($search, function ($query, $search) {
                //     $query->where('kode_pendaftaran', 'like', "%$search%")
                //         ->orWhere('nama', 'like', "%$search%");
                // })
        }


        foreach ($data as $key => $item) {
            // dd($item->pengajuan);
            $nama_pemroses = 'undifined';
            $user = User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            if ($item->pengajuan->posisi == 'Proses Input Data') {
                $user = User::select('nip')->where('id', $item->pengajuan->id_staf)->first();
            } else if ($item->pengajuan->posisi == 'Review Penyelia') {
                $user = User::select('nip')->where('id', $item->pengajuan->id_penyelia)->first();
            } else if ($item->pengajuan->posisi == 'PBO') {
                $user = User::select('nip')->where('id', $item->pengajuan->id_pbo)->first();
            } else if ($item->pengajuan->posisi == 'PBP') {
                $user = User::select('nip')->where('id', $item->pengajuan->id_pbp)->first();
            } else if ($item->pengajuan->posisi == 'Pincab' || $item->pengajuan->posisi == 'Selesai' || $item->pengajuan->posisi == 'Ditolak') {
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
            $item->plafon = PlafonUsulan::where('id_pengajuan', $item->pengajuan->id)->first()->plafon_usulan_pincab ?? 0;
            $item->tenor = PlafonUsulan::where('id_pengajuan', $item->pengajuan->id)->first()->jangka_waktu_usulan_pincab ?? 0;
        }
        return $data;
    }

    function detail($id)
    {
        $data = PengajuanDagulir::with('pengajuan',
            'kec_ktp:id,kecamatan',
            'kotakab_ktp:id,kabupaten',
            'kec_dom:id,kecamatan',
            'kotakab_dom:id,kabupaten',
            'kec_usaha:id,kecamatan',
            'kotakab_usaha:id,kabupaten')
            ->where('id', $id)->first();
        return $data;
    }

    public function getDataPemroses($model)
    {
        $roles = [];
        $idRoles = [];

        $pengajuan = PengajuanModel::select('id_staf', 'id_penyelia', 'id_pbo', 'id_pbp', 'id_pincab')->where('id', $model->id)->first();

        if ($pengajuan->id_pbo != null && $pengajuan->id_pbp != null) {
            $roles = [
                'Staf Analis Kredit',
                'Penyelia Kredit',
                'PBO',
                'PBP',
                'Pincab',
            ];
            $idRoles = [
                'id_staf',
                'id_penyelia',
                'id_pbo',
                'id_pbp',
                'id_pincab'
            ];
        } else if ($pengajuan->id_pbo != null && $pengajuan->id_pbp == null) {
            $roles = [
                'Staf Analis Kredit',
                'Penyelia Kredit',
                'PBO',
                'Pincab',
            ];
            $idRoles = [
                'id_staf',
                'id_penyelia',
                'id_pbo',
                'id_pincab'
            ];
        } else if ($pengajuan->id_pbo == null < 1 && $pengajuan->id_pbp != null) {
            $roles = [
                'Staf Analis Kredit',
                'Penyelia Kredit',
                'PBP',
                'Pincab',
            ];
            $idRoles = [
                'id_staf',
                'id_penyelia',
                'id_pbp',
                'id_pincab'
            ];
        } else {
            $roles = [
                'Staf Analis Kredit',
                'Penyelia Kredit',
                'Pincab',
            ];
            $idRoles = [
                'id_staf',
                'id_penyelia',
                'id_pincab'
            ];
        }

        return [
            'roles' => $roles,
            'idRoles' => $idRoles
        ];
    }

    public function getDraftData($search, $limit = 10, $page = 1, $id_user)
    {
        $data = null;
        $data = PengajuanDagulirTemp::where('user_id', $id_user)
            ->where(function($query) use ($search) {
                $query->orWhere('nama','like', "%$search%");
            })
            ->paginate($limit);

        return $data;
    }
}
