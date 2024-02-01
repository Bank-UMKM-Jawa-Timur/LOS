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
    function getKaryawan($nip){
        $host = env('HCS_HOST','https://hcs.bankumkm.id');
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $host . '/api/v1/karyawan/' . $nip,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($response);

        if ($json) {
            if ($json->data)
                return $json->data->nama_karyawan;
        }
    }
@endphp

@foreach ($data_pengajuan as $item)
@php
    $alasanPengembalian = \App\Models\AlasanPengembalianData::where('id_pengajuan', $item->id)
                ->join('users', 'users.id', 'alasan_pengembalian_data.id_user')
                ->select('users.nip', 'alasan_pengembalian_data.*')
                ->get();
@endphp
<div class="modal fade " id="modalRiwayatPengembalian-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Riwayat Pengembalian Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row mb-3">
                <div class="col-12 p-0">
                    <div class="table-responsive">
                        <table style="width: 100%" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Alasan Pengembalian</th>
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Tanggal</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alasanPengembalian as $key => $itemPengembalian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $itemPengembalian->alasan }}</td>
                                        <td>{{ $itemPengembalian->dari }}</td>
                                        <td>{{ $itemPengembalian->ke }}</td>
                                        <td>{{ date_format($itemPengembalian->created_at, 'd M Y') }}</td>
                                        <td>{{ getKaryawan($itemPengembalian->nip) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Riwayat Pengembalian Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
