<style>
    .jrk {
        width: 200px;
    }

    .conten-timeline td {
        padding-top: 10px;
        border-bottom: 1px solid #eeeeee;
    }

    .title-log {
        font-size: 20px;
        font-weight: bold;
    }
</style>
@php
    $userPBO = \App\Models\User::select('id')
        ->where('id_cabang', $dataUmum->id_cabang)
        ->where('role', 'PBO')
        ->first();
    
    $userPBP = \App\Models\User::select('id')
        ->where('id_cabang', $dataUmum->id_cabang)
        ->where('role', 'PBP')
        ->whereNotNull('nip')
        ->first();
@endphp
<div class="card mb-3">
    <div class="card-header bg-info color-white font-weight-bold" data-toggle="collapse" href="#logPengajuan">
        @if (Auth::user()->role == 'Pincab')
            Pemroses Data
        @else
            Log Pengajuan
        @endif
    </div>
    <div class="card-body collapse multi-collapse show" id="logPengajuan">
        <div class="">
            @foreach ($roles as $key => $itemRole)
                @if ($itemRole == 'PBO')
                    @if ($userPBO)
                        <div class="form-group row d-flex align-items-center">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemRole }}</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                @php
                                    $log = DB::table('log_pengajuan')
                                        ->select('id')
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->first();
                                    if (!$log) {
                                        $user = DB::table('pengajuan')
                                            ->join('users', 'users.id', 'pengajuan.' . $idRoles[$key])
                                            ->select('users.role', 'users.nip', 'users.email', 'users.nip as nip_users')
                                            ->first();
                                    } else {
                                        $user = DB::table('log_pengajuan')
                                            ->join('users', 'users.id', 'log_pengajuan.user_id')
                                            ->select('users.role', 'users.nip', 'users.email', 'log_pengajuan.nip as nip_users')
                                            ->where('log_pengajuan.id_pengajuan', $dataUmum->id)
                                            ->where('users.role', $itemRole)
                                            ->first();
                                    }
                                    
                                    if ($dataUmum->average_by_pbo > 0 && $dataUmum->average_by_pbo <= 2) {
                                        $status = 'merah';
                                    } elseif ($dataUmum->average_by_pbo > 2 && $dataUmum->average_by_pbo <= 3) {
                                        $status = 'kuning';
                                    } elseif ($dataUmum->average_by_pbo > 3) {
                                        $status = 'hijau';
                                    } else {
                                        $status = 'merah';
                                    }
                                @endphp
                                <div class="col-sm-12">
                                    <span
                                        class="text-dark">{{ $user ? $user->nip_users . ' - ' . getKaryawan($user->nip) . ' ' . '(' . $user->email . ')' : '-' }}</span>
                                    @if ($status == 'hijau')
                                        <span class="text-success">Skor {{ $dataUmum->average_by_pbo }}</span>
                                    @elseif ($status == 'kuning')
                                        <span class="text-warning">Skor {{ $dataUmum->average_by_pbo }}</span>
                                    @elseif ($status == 'merah')
                                        <span class="text-danger">
                                            {{ $dataUmum->average_by_pbo }}
                                        </span>
                                    @else
                                        <span class="text-secondary">
                                            {{ $dataUmum->average_by_pbo }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @elseif ($itemRole == 'PBP')
                    @if ($userPBP)
                        <div class="form-group row d-flex align-items-center">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemRole }}</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                @php
                                    $log = DB::table('log_pengajuan')
                                        ->select('id')
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->first();
                                    if (!$log) {
                                        $user = DB::table('pengajuan')
                                            ->join('users', 'users.id', 'pengajuan.' . $idRoles[$key])
                                            ->select('users.role', 'users.nip', 'users.email', 'users.nip as nip_users')
                                            ->first();
                                    } else {
                                        $user = DB::table('log_pengajuan')
                                            ->join('users', 'users.id', 'log_pengajuan.user_id')
                                            ->select('users.role', 'users.nip', 'users.email', 'log_pengajuan.nip as nip_users')
                                            ->where('log_pengajuan.id_pengajuan', $dataUmum->id)
                                            ->where('users.role', $itemRole)
                                            ->first();
                                    }
                                    
                                    if ($dataUmum->average_by_pbp > 0 && $dataUmum->average_by_pbp <= 2) {
                                        $status = 'merah';
                                    } elseif ($dataUmum->average_by_pbp > 2 && $dataUmum->average_by_pbo <= 3) {
                                        $status = 'kuning';
                                    } elseif ($dataUmum->average_by_pbp > 3) {
                                        $status = 'hijau';
                                    } else {
                                        $status = 'merah';
                                    }
                                @endphp
                                <div class="col-sm-12">
                                    <span
                                        class="text-dark">{{ $user ? $user->nip_users . ' - ' . getKaryawan($user->nip) . ' ' . '(' . $user->email . ')' : '-' }}</span>
                                    @if ($status == 'hijau')
                                        <span class="text-success">Skor {{ $dataUmum->average_by_pbp }}</span>
                                    @elseif ($status == 'kuning')
                                        <span class="text-warning">Skor {{ $dataUmum->average_by_pbp }}</span>
                                    @elseif ($status == 'merah')
                                        <span class="text-danger">
                                            {{ $dataUmum->average_by_pbp }}
                                        </span>
                                    @else
                                        <span class="text-secondary">
                                            {{ $dataUmum->average_by_pbp }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="form-group row d-flex align-items-center">
                        <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemRole }}</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            @php
                                $log = DB::table('log_pengajuan')
                                    ->select('id')
                                    ->where('id_pengajuan', $dataUmum->id)
                                    ->first();
                                $avg = 0;
                                if ($itemRole == 'Staf Analis Kredit') {
                                    $avg = $dataUmum->average_by_sistem;
                                } elseif ($itemRole == 'Penyelia Kredit') {
                                    $avg = $dataUmum->average_by_penyelia;
                                }
                                
                                if ($avg > 0 && $avg <= 2) {
                                    $status = 'merah';
                                } elseif ($avg > 2 && $avg <= 3) {
                                    $status = 'kuning';
                                } elseif ($avg > 3) {
                                    $status = 'hijau';
                                } else {
                                    $status = 'merah';
                                }
                                
                                if (!$log) {
                                    $user = DB::table('pengajuan')
                                        ->join('users', 'users.id', 'pengajuan.' . $idRoles[$key])
                                        ->select('users.role', 'users.nip', 'users.email', 'users.nip as nip_users')
                                        ->first();
                                } else {
                                    $user = DB::table('log_pengajuan')
                                        ->join('users', 'users.id', 'log_pengajuan.user_id')
                                        ->select('users.role', 'users.nip', 'users.email', 'log_pengajuan.nip as nip_users')
                                        ->where('log_pengajuan.id_pengajuan', $dataUmum->id)
                                        ->where('users.role', $itemRole)
                                        ->first();
                                }
                            @endphp
                            <div class="col-sm-12">
                                @if ($itemRole == 'Pincab')
                                    <span
                                        class="text-dark">{{ $user ? $user->nip_users . ' - ' . getKaryawan($user->nip) . ' ' . '(' . $user->email . ')' : '-' }}</span>
                                @else
                                    <span
                                        class="text-dark">{{ $user ? $user->nip_users . ' - ' . getKaryawan($user->nip) . ' ' . '(' . $user->email . ')' : '-' }}</span>
                                    @if ($status == 'hijau')
                                        <span class="text-success">Skor {{ $avg }}</span>
                                    @elseif ($status == 'kuning')
                                        <span class="text-warning">Skor {{ $avg }}</span>
                                    @elseif ($status == 'merah')
                                        <font class="text-danger">
                                            {{ $avg }}
                                        </font>
                                    @else
                                        <font class="text-secondary">
                                            {{ $avg }}
                                        </font>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <hr>
        <div class="timeline">
            <div class="conten-timeline right">
                @if (Auth::user()->role != 'Pincab')
                    @if (!$log)
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Tidak ada log pengajuan pada data ini, dikarenakan data dikategorikan data lama pada
                                    domain <a href="https://los.bankumkm.id">los.bankumkm.id</a>.</p>
                            </div>
                        </div>
                    @else
                        @foreach ($logPengajuan as $item)
                            <div class="content">
                                @php
                                    $itemLog = DB::table('log_pengajuan')
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->whereDate('created_at', $item->tgl)
                                        ->get();
                                @endphp
                                <h2 class="title-log">{{ date('d F Y', strtotime($item->tgl)) }}</h2>
                                <table>
                                    @foreach ($itemLog as $itemLog)
                                        <tr>
                                            <td class="jrk"><span class="fa fa-clock mr-1"></span>
                                                {{ date('H:i:s', strtotime($itemLog->created_at)) }}</td>
                                            <td><span class="fa fa-check mr-1"></span> {{ $itemLog->activity }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                <hr>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
