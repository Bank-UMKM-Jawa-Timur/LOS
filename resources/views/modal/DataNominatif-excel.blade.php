<table>
    <tr>
        <td align="center" style="font-weight:bold;vertical-align: center;text-align:center;" colspan="10" rowspan="3">
            <h2>DATA NOMINATIF</h2>
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
            <th rowspan="2" colspan="10" align="center"
                style="background-color: #dc3545; color: white; font-weight: bold; vertical-align: center;">Data
                Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }}</th>
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
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Disetujui</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Ditolak</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Pincab</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">PBP</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">PBO</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Penyelia</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Staff</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Total</th>
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
        @for ($i = 0; $i < count($data); $i++)
            <tr>
                <td style="border:1px solid #000;">{{ $data[$i]['kodeC'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['cabang'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['disetujui'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['ditolak'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['pincab'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['PBP'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['PBO'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['penyelia'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['staff'] }}</td>
                <td style="border:1px solid #000;">{{ $data[$i]['total'] }}</td>
            </tr>

            @php
                $disetujui += $data[$i]['disetujui'];
                $ditolak += $data[$i]['ditolak'];
                $pincab += $data[$i]['pincab'];
                $pbp += $data[$i]['PBP'];
                $pbo += $data[$i]['PBO'];
                $penyelia += $data[$i]['penyelia'];
                $staff += $data[$i]['staff'];
                $total += $data[$i]['total'];
            @endphp
        @endfor
        {{-- @foreach ($data as $row)
                <tr>
                    <td>{{ $row->kodeC }}</td>
                    <td>{{ $row->cabang }}</td>
                    <td>{{ $row->disetujui }}</td>
                    <td>{{ $row->ditolak }}</td>
                    <td>{{ $row->pincab }}</td>
                    <td>{{ $row->PBP }}</td>
                    <td>{{ $row->PBO }}</td>
                    <td>{{ $row->penyelia }}</td>
                    <td>{{ $row->staff }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
                @endforeach --}}
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
            <th rowspan="2" colspan="5" align="center"
                style="vertical-align: center; background-color: #dc3545; color: white; font-weight: bold;">Total
                Pengajuan Selesai Dan Proses</th>
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
            <th>Kode</th>
            <th style="background-color: rgb(17, 32, 66);width: 300px; border:1px solid #000;">Cabang</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Disetujui</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Proses</th>
            <th style="background-color: rgb(17, 32, 66);border:1px solid #000;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $disetujui = 0;
            $ditolak = 0;
            $total = 0;
        @endphp
        @for ($i = 0; $i < count($dataC); $i++)
            <tr>
                <td style="border:1px solid #000;">{{ $dataC[$i]['kodeC'] }}</td>
                <td style="border:1px solid #000;">{{ $dataC[$i]['cabang'] }}</td>
                <td style="border:1px solid #000;">{{ $dataC[$i]['disetujui'] }}</td>
                <td style="border:1px solid #000;">{{ $dataC[$i]['staff'] }}</td>
                <td style="border:1px solid #000;">{{ $dataC[$i]['total'] }}</td>
            </tr>

            @php
                $disetujui += $dataC[$i]['disetujui'];
                $staff += $dataC[$i]['staff'];
                $total += $dataC[$i]['total'];
            @endphp
        @endfor
        {{-- @foreach ($data as $row)
                <tr>
                    <td>{{ $row->kodeC }}</td>
                    <td>{{ $row->cabang }}</td>
                    <td>{{ $row->disetujui }}</td>
                    <td>{{ $row->proses }}</td>
                    <td>{{ $row->pincab }}</td>
                    <td>{{ $row->PBP }}</td>
                    <td>{{ $row->PBO }}</td>
                    <td>{{ $row->penyelia }}</td>
                    <td>{{ $row->staff }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
                @endforeach --}}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="center" style="font-weight: bold; border:1px solid #000;">Grand Total</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $disetujui }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $staff }}</td>
            <td style="font-weight: bold; border:1px solid #000;">{{ $total }}</td>
        </tr>
    </tfoot>
</table>
