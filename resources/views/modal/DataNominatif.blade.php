<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            text-align: center;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        th,
        td {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2><b>DATA NOMINATIF</b></h2>

    <table>

        <thead>
            <tr>
                <th colspan="10">Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }}</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Cabang</th>
                <th>Disetujui</th>
                <th>Ditolak</th>
                <th>Pincab</th>
                <th>PBP</th>
                <th>PBO</th>
                <th>Penyelia</th>
                <th>Staff</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $disetujui = 0;
                $ditolak = 0;
                $pincab = 0;
                $pbb = 0;
                $pbo = 0;
                $penyelia = 0;
                $staff = 0;
                $total = 0;
            @endphp
            @for ($i = 0; $i < count($data); $i++)
                <tr>
                    <td>{{ $data[$i]['kodeC'] }}</td>
                    <td>{{ $data[$i]['cabang'] }}</td>
                    <td>{{ $data[$i]['disetujui'] }}</td>
                    <td>{{ $data[$i]['ditolak'] }}</td>
                    <td>{{ $data[$i]['pincab'] }}</td>
                    <td>{{ $data[$i]['PBB'] }}</td>
                    <td>{{ $data[$i]['PBO'] }}</td>
                    <td>{{ $data[$i]['penyelia'] }}</td>
                    <td>{{ $data[$i]['staff'] }}</td>
                    <td>{{ $data[$i]['total'] }}</td>
                </tr>

                @php
                    $disetujui += $data[$i]['disetujui'];
                    $ditolak += $data[$i]['ditolak'];
                    $pincab += $data[$i]['pincab'];
                    $pbb += $data[$i]['PBB'];
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
                    <td>{{ $row->PBB }}</td>
                    <td>{{ $row->PBO }}</td>
                    <td>{{ $row->penyelia }}</td>
                    <td>{{ $row->staff }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>{{ $disetujui }}</td>
                <td>{{ $ditolak }}</td>
                <td>{{ $pincab }}</td>
                <td>{{ $pbb }}</td>
                <td>{{ $pbo }}</td>
                <td>{{ $penyelia }}</td>
                <td>{{ $staff }}</td>
                <td>{{ $total }}</td>
            </tr>
        </tfoot>
    </table>

    <br><br><br><br>
    {{-- seluruh data --}}
    <table>

        <thead>
            <tr>
                <th colspan="10">Suluruh Data Pengajuan</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Cabang</th>
                <th>Disetujui</th>
                <th>Ditolak</th>
                <th>Pincab</th>
                <th>PBP</th>
                <th>PBO</th>
                <th>Penyelia</th>
                <th>Staff</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $disetujui = 0;
                $ditolak = 0;
                $pincab = 0;
                $pbb = 0;
                $pbo = 0;
                $penyelia = 0;
                $staff = 0;
                $total = 0;
            @endphp
            @for ($i = 0; $i < count($dataS); $i++)
                <tr>
                    <td>{{ $dataS[$i]['kodeC'] }}</td>
                    <td>{{ $dataS[$i]['cabang'] }}</td>
                    <td>{{ $dataS[$i]['disetujui'] }}</td>
                    <td>{{ $dataS[$i]['ditolak'] }}</td>
                    <td>{{ $dataS[$i]['pincab'] }}</td>
                    <td>{{ $dataS[$i]['PBB'] }}</td>
                    <td>{{ $dataS[$i]['PBO'] }}</td>
                    <td>{{ $dataS[$i]['penyelia'] }}</td>
                    <td>{{ $dataS[$i]['staff'] }}</td>
                    <td>{{ $dataS[$i]['total'] }}</td>
                </tr>

                @php
                    $disetujui += $dataS[$i]['disetujui'];
                    $ditolak += $dataS[$i]['ditolak'];
                    $pincab += $dataS[$i]['pincab'];
                    $pbb += $dataS[$i]['PBB'];
                    $pbo += $dataS[$i]['PBO'];
                    $penyelia += $dataS[$i]['penyelia'];
                    $staff += $dataS[$i]['staff'];
                    $total += $dataS[$i]['total'];
                @endphp
            @endfor
            {{-- @foreach ($data as $row)
                <tr>
                    <td>{{ $row->kodeC }}</td>
                    <td>{{ $row->cabang }}</td>
                    <td>{{ $row->disetujui }}</td>
                    <td>{{ $row->ditolak }}</td>
                    <td>{{ $row->pincab }}</td>
                    <td>{{ $row->PBB }}</td>
                    <td>{{ $row->PBO }}</td>
                    <td>{{ $row->penyelia }}</td>
                    <td>{{ $row->staff }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>{{ $disetujui }}</td>
                <td>{{ $ditolak }}</td>
                <td>{{ $pincab }}</td>
                <td>{{ $pbb }}</td>
                <td>{{ $pbo }}</td>
                <td>{{ $penyelia }}</td>
                <td>{{ $staff }}</td>
                <td>{{ $total }}</td>
            </tr>
        </tfoot>
    </table>

    <br><br><br><br>
    {{-- seluruh data Cabang --}}
    <table>

        <thead>
            <tr>
                <th colspan="5">Total Pengajuan Selesai Dan Proses</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Cabang</th>
                <th>Disetujui</th>
                <th>Proses</th>
                <th>Total</th>
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
                    <td>{{ $dataC[$i]['kodeC'] }}</td>
                    <td>{{ $dataC[$i]['cabang'] }}</td>
                    <td>{{ $dataC[$i]['disetujui'] }}</td>
                    <td>{{ $dataC[$i]['staff'] }}</td>
                    <td>{{ $dataC[$i]['total'] }}</td>
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
                    <td>{{ $row->PBB }}</td>
                    <td>{{ $row->PBO }}</td>
                    <td>{{ $row->penyelia }}</td>
                    <td>{{ $row->staff }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @endforeach --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>{{ $disetujui }}</td>
                <td>{{ $staff }}</td>
                <td>{{ $total }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html
