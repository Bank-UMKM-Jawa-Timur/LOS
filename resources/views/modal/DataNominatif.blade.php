<!DOCTYPE html>
<html>

<head>
    <title>
        {{-- @if (request()->k_tanggal == "Keseluruhan")
            Laporan Data Pengajuan Cabang {{ request()->get('cabang') }}, Keseluruhan
        @endif --}}
    </title>
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
                <th colspan="10">
                    @if (request()->k_tanggal != "kesuluruhan")
                        @if (Request()->cabang == "semua")
                            Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Semua Cabang
                            @else
                            Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Cabang {{ \App\Models\cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}
                        @endif
                    @else
                        @if (Request()->cabang == "semua")
                            Kategori keseluruhan Semua Cabang
                        @else
                            Kategori keseluruhan Cabang {{ \App\Models\cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}
                        @endif
                    @endif
                </th>
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
                $pbp = 0;
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
                    <td>{{ $data[$i]['PBP'] }}</td>
                    <td>{{ $data[$i]['PBO'] }}</td>
                    <td>{{ $data[$i]['penyelia'] }}</td>
                    <td>{{ $data[$i]['staff'] }}</td>
                    <td>{{ $data[$i]['total'] }}</td>
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
                <td style="font-weight:bold ;" colspan="2">Grand Total</td>
                <td style="font-weight:bold ;">{{ $disetujui }}</td>
                <td style="font-weight:bold ;">{{ $ditolak }}</td>
                <td style="font-weight:bold ;">{{ $pincab }}</td>
                <td style="font-weight:bold ;">{{ $pbp }}</td>
                <td style="font-weight:bold ;">{{ $pbo }}</td>
                <td style="font-weight:bold ;">{{ $penyelia }}</td>
                <td style="font-weight:bold ;">{{ $staff }}</td>
                <td style="font-weight:bold ;">{{ $total }}</td>
            </tr>
        </tfoot>
    </table>

    <br><br><br><br>
    {{-- seluruh data --}}
    

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
                <td style="font-weight:bold ;" colspan="2">Grand Total</td>
                <td style="font-weight:bold ;">{{ $disetujui }}</td>
                <td style="font-weight:bold ;">{{ $staff }}</td>
                <td style="font-weight:bold ;">{{ $total }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html
