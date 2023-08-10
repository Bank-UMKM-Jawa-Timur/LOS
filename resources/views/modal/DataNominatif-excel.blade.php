<table>
    <tr>
        <td align="center" style="font-weight:bold;vertical-align: center;text-align:center;" colspan="10" rowspan="3">
            <h2>DATA NOMINATIF</h2>
            @if (request()->k_tanggal != "kesuluruhan")
                @if (Request()->cabang == "semua")
                    <p>Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Semua Cabang</p>
                @else
                    <p>Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Cabang {{ \App\Models\Cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}</p>
                @endif
            @else
                @if (Request()->cabang == "semua")
                    <p>Data Pengajuan Kesuluruhan Data Semua Cabang</p>
                @else
                    <p>Data Pengajuan Kesuluruhan Data Cabang {{ \App\Models\Cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}</p>
                @endif
            @endif
        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
</table>

<table>

    <thead>
        <tr>
            <th colspan="10" rowspan="2" align="center" style="font-weight: bold; vertical-align: center; background-color: #dc3545; color: white;">
                Posisi Pengajuan
            </th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Kode</th>
            <th style="background-color: rgb(17, 32, 66);width: 300px; border:1px solid #000;">Cabang</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Disetujui</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Ditolak</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Pincab</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">PBP</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">PBO</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Penyelia</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Staff</th>
            <th style="background-color: rgb(17, 32, 66); border:1px solid #000;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $disetujui = 0;
            $ditolak = 0;
            $pincab = 0;
            $pbp = 0;
            $pbo = 0;
            $penyelia = 0;
            $staff = 0;
            $total = 0;
        @endphp
        @foreach ($data as $key => $item)
            @if ($item->kodeC != 000)
                <tr>
                    <td style="border:1px solid #000;">{{ $item->kodeC }}</td>
                    <td style="border:1px solid #000;">{{ $item->cabang }}</td>
                    <td style="border:1px solid #000;">{{ $item->disetujui }}</td>
                    <td style="border:1px solid #000;">{{ $item->ditolak }}</td>
                    <td style="border:1px solid #000;">{{ $item->pincab }}</td>
                    <td style="border:1px solid #000;">{{ $item->pbp }}</td>
                    <td style="border:1px solid #000;">{{ $item->pbo }}</td>
                    <td style="border:1px solid #000;">{{ $item->penyelia }}</td>
                    <td style="border:1px solid #000;">{{ $item->staff }}</td>
                    <td style="border:1px solid #000;">{{ $item->total }}</td>
                </tr>

                @php
                    $disetujui += $item->disetujui;
                    $ditolak += $item->ditolak;
                    $pincab += $item->pincab;
                    $pbp += $item->pbp;
                    $pbo += $item->pbo;
                    $penyelia += $item->penyelia;
                    $staff += $item->staff;
                    $total += $item->total;
                @endphp
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="font-weight: bold; border:1px solid #000;" colspan="2" align="center">Grand Total</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $disetujui }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $ditolak }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $pincab }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $pbp }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $pbo }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $penyelia }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $staff }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $total }}</td>
        </tr>
    </tfoot>
</table>


<br><br><br><br>
{{-- seluruh data Cabang --}}
<table>

    <thead>
        <tr>
            <th rowspan="2" colspan="6" align="center" style="vertical-align: center; background-color: #dc3545; color: white; font-weight: bold;">
                Total Pengajuan Selesai Dan Proses
            </th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th style="background-color: rgb(17, 32, 66);width: 300px; border:1px solid #000;">Kode</th>
            <th style="background-color: rgb(17, 32, 66);width: 300px; border:1px solid #000;">Cabang</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Disetujui</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Ditolak</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Proses</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalC = 0;
            $disetujui = 0;
            $ditolak = 0;
            $proses = 0;
        @endphp
        @foreach ($data2 as $key => $item)
            @if ($item->kodeC != 000)
            <tr>
                <td style="border:1px solid #000;">{{ $item->kodeC }}</td>
                <td style="border:1px solid #000;">{{ $item->cabang }}</td>
                <td style="border:1px solid #000;">{{ $item->disetujui }}</td>
                <td style="border:1px solid #000;">{{ $item->ditolak }}</td>
                <td style="border:1px solid #000;">{{ $item->diproses }}</td>
                <td style="border:1px solid #000;">{{ $item->total }}</td>
                @php
                    $totalC += $item->total;
                    $disetujui +=  $item->disetujui;
                    $ditolak +=  $item->ditolak;
                    $proses +=  $item->diproses;
                @endphp
            </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="center" style="font-weight: bold; border:1px solid #000;">Grand Total</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $disetujui }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $ditolak }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $proses }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $totalC }}</td>
        </tr>
    </tfoot>
</table>
