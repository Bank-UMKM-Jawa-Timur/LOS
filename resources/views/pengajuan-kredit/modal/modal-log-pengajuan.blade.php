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

@foreach ($data_pengajuan as $item)
    @php
        $logPengajuan = DB::table('log_pengajuan')->selectRaw("DISTINCT(date(created_at)) as tgl")->where('id_pengajuan', $item->id)->get();
        $log = array();
        if($logPengajuan){
            foreach($logPengajuan as $itemPengajuan){
                $itemLog = DB::table('log_pengajuan')
                    ->where('id_pengajuan', $item->id)
                    ->whereDate('created_at', $itemPengajuan->tgl)
                    ->get();
                $itemsLog = array();

                foreach($itemLog as $itemLogPengajuan){
                    array_push($itemsLog, $itemLogPengajuan);
                }
                array_push($log, [
                    'tgl' => $itemPengajuan->tgl,
                    'data' => $itemLog
                ]);
            }
        } else {
            $log = [];
        }
    @endphp
    <div class="modal-layout hidden" id="modalLogPengajuan-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal modal-sm bg-white">
            <div class="modal-head">
                <h5 class="title" id="exampleModalLabel">Log Pengajuan</h5>
                <button data-dismiss-id="modalLogPengajuan-{{ $item->id }}" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                @forelse ($log as $items)
                    <div class="content">
                        <h2 class="title-log">{{ date('d F Y', strtotime($items['tgl'])) }}</h2>
                        <table>
                            @foreach ($items['data'] as $itemLog)
                                <tr>
                                    <td class="jrk"><span class="fa fa-clock mr-1"></span>
                                        {{ date('H:i:s', strtotime($itemLog->created_at)) }}</td>
                                    <td><span class="fa fa-check mr-1"></span> {{ $itemLog->activity }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <hr>
                    </div>
                @empty
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Tidak ada log pengajuan pada data ini, dikarenakan data dikategorikan data lama pada
                            domain <a href="https://los.bankumkm.id">los.bankumkm.id</a>.</p>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn-submit" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>
@endforeach
