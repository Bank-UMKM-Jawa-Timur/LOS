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
    <div class="card-header bg-info color-white font-weight-bold collapsed" data-toggle="collapse" href="#logPengajuan">
        Log Pengajuan
    </div>
    <div class="card-body collapse multi-collapse show" id="logPengajuan">
        <div class="timeline">
            <div class="conten-timeline right">
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
            </div>
        </div>
    </div>
</div>