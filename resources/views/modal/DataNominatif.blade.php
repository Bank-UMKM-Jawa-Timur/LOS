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

    <h2><b>DATA NOMINATIF</b></h2>
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
            @foreach ($data as $key => $item)
                @if ($item->kodeC != 000)
                    <tr>
                        <td>{{ $item->kodeC }}</td>
                        <td>{{ $item->cabang }}</td>
                        <td>{{ $item->disetujui }}</td>
                        <td>{{ $item->ditolak }}</td>
                        <td>{{ $item->pincab }}</td>
                        <td>{{ $item->PBP }}</td>
                        <td>{{ $item->PBO }}</td>
                        <td>{{ $item->penyelia }}</td>
                        <td>{{ $item->staff }}</td>
                        <td>{{ $item->total }}</td>
                    </tr>

                    @php
                        $disetujui += $item->disetujui;
                        $ditolak += $item->ditolak;
                        $pincab += $item->pincab;
                        $pbp += $item->PBP;
                        $pbo += $item->PBO;
                        $penyelia += $item->penyelia;
                        $staff += $item->staff;
                        $total += $item->total;
                    @endphp
                @endif
            @endforeach
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
                <th colspan="6">Total Pengajuan Selesai Dan Proses</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Cabang</th>
                <th>Disetujui</th>
                <th>Ditolak</th>
                <th>Proses</th>
                <th>Total</th>
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
                    <td>{{ $item->kodeC }}</td>
                    <td>{{ $item->cabang }}</td>
                    <td>{{ $item->disetujui }}</td>
                    <td>{{ $item->ditolak }}</td>
                    <td>{{ $item->diproses }}</td>
                    <td>{{ $item->total }}</td>
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
                <td style="font-weight:bold ;" colspan="2">Grand Total</td>
                <td style="font-weight:bold ;">{{ $disetujui }}</td>
                <td style="font-weight:bold ;">{{ $ditolak }}</td>
                <td style="font-weight:bold ;">{{ $proses }}</td>
                <td style="font-weight:bold ;">{{ $totalC }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html
