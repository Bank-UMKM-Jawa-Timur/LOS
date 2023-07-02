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

<div class="card mb-3">
    <div class="card-header bg-info color-white font-weight-bold" data-toggle="collapse" href="#logPengajuan">
        Log Pengajuan
    </div>
    <div class="card-body collapse multi-collapse show" id="logPengajuan">
        <div class="">
            @foreach ($roles as $key => $itemRole)
                <div class="form-group row">
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
                            $log = DB::table('log_pengajuan')->select('id')->where('id_pengajuan', $dataUmum->id)->first();
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
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ ($user) ? $user->nip_users . ' - ' . getKaryawan($user->nip) . ' ' . '('. $user->email .')' : '-' }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        <div class="timeline">
            <div class="conten-timeline right">
                @if (!$log)
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>Tidak ada log pengajuan pada data ini, dikarenakan data dikategorikan data lama pada domain <a href="https://los.bankumkm.id">los.bankumkm.id</a>.</p>
                        </div>
                    </div>
                @else
                    @foreach ($logPengajuan as $item)
                        <div class="content">
                            @php
                                $itemLog = DB::table('log_pengajuan')->where('id_pengajuan', $dataUmum->id)->whereDate('created_at', $item->tgl)->get();
                            @endphp
                            <h2 class="title-log">{{ date("d F Y", strtotime($item->tgl)) }}</h2>
                            <table>
                                @foreach ($itemLog as $itemLog)
                                    <tr>
                                        <td class="jrk"><span class="fa fa-clock mr-1"></span> {{ date('H:i:s', strtotime($itemLog->created_at)) }}</td>
                                        <td><span class="fa fa-check mr-1"></span> {{ $itemLog->activity }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <hr>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
