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

        h2, p {
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

    <h2><b>DATA NOMINATIF</b></h2>\
    @if (request()->k_tanggal != "kesuluruhan")
        @if (Request()->cabang == "semua")
            <p>Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Semua Cabang</p>
        @else
            <p>Data Pengajuan, Tanggal: {{ date($tAwal) }} sampai {{ date($tAkhir) }} Cabang {{ \App\Models\cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}</p>
        @endif
    @else
        @if (Request()->cabang == "semua")
            <p>Data Pengajuan Kesuluruhan Data Semua Cabang</p>
        @else
            <p>Data Pengajuan Kesuluruhan Data Cabang {{ \App\Models\cabang::select('cabang')->where('id', Request()->cabang)->first()->cabang }}</p>
        @endif
    @endif

    <table>

        <thead>
            <tr>
                <th colspan="10">
                    Posisi Pengajuan
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

            @if ($dataC[$i]['kodeC'] != 000)

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

            @endif

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
            {{-- @php
                $disetujui = 0;
                $proses = 0;
                $GtotalC = 0;
                @endphp --}}
            @php

                $totalC = 0;
                $disetujui = 0;
                $proses = 0;

            @endphp
            @for ($i = 0; $i < count($dataC); $i++)

            @if ($dataC[$i]['kodeC'] != 000)


            <tr>

                <td>{{ $dataC[$i]['kodeC'] }}</td>
                <td>{{ $dataC[$i]['cabang'] }}</td>
                <td>{{ $dataC[$i]['disetujui'] }}</td>
                <td>{{ $dataC[$i]['proses'] }}</td>
                <td>{{$dataC[$i]['disetujui']+$dataC[$i]['proses']   }}</td>
                @php
                    $totalC += $dataC[$i]['disetujui']+$dataC[$i]['proses']  ;
                    $disetujui +=  $dataC[$i]['disetujui'];
                    $proses +=  $dataC[$i]['proses'];
                    @endphp
            </tr>


            @endif


                @endfor
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight:bold ;" colspan="2">Grand Total</td>
                <td style="font-weight:bold ;">{{ $disetujui }}</td>
                <td style="font-weight:bold ;">{{ $proses }}</td>
                <td style="font-weight:bold ;">{{ $totalC }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html
