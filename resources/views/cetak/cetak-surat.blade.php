<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Surat</title>
    <style>
        .title-head{
            border: 1px solid;
        }

    </style>
</head>
<body>
    <table>
        <tr>
            <td style="width: 25%;" class="title-head">ANALISA
                    (KREDIT DIATAS RP 50 JUTA
                    SAMPAI < RP 350 JUTA)
            </td>
            <td style="width: 50%;text-align:center">
                ANALISA KREDIT MODAL KERJA
                <br>
                Sektor . . . . . . . .
            </td>
            <td style="width: 25%;text-align:center" class="title-head">LAMPIRAN 25</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td style="width: 25%;" ><b><u><span>DATA UMUM</span></u></b> <br><span><b><i>(nasabah perorangan)</i></b></span>
            </td>
            <td style="width:5%"></td>
            <td style="width: 70%">
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="width: 25%;" >
                <label>Nama</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->nama }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Alamat Rumah</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->alamat_rumah }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Alamat Usaha</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->alamat_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>No KTP</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->no_ktp }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Tempat, Tanggal Lahir / Status</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->tempat_lahir }}, {{ date_format(date_create($nasabah->tanggal_lahir), 'd/m/Y') }} <span style="margin-left:20px">Status : {{ $nasabah->status }}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Sector Kredit</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->sektor_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jenis Usaha</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->jenis_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jumlah Kredit Yang Diminta</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ "Rp " . number_format($nasabah->jumlah_kredit,2,',','.') }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Tujuan Kredit</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->tujuan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jaminan Yang Disediakan</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->jaminan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Hubungan Dengan Bank</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->hubungan_bank }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Hasil Verifikasi Karakter Umum</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $nasabah->verifikasi_umum }}
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td style="width: 100%;" ><span>II</span><b><u><span style="margin-left:6px">PEMBAHASAN PER ASPEK</span></u></b>
            </td>
        </tr>
    </table>
    <table>
         @php
              $no = 1
          @endphp
        @foreach ($aspek as $item)
            <tr>
                <td style="width: 25%;" >
                    <span>{{ $no++ }}</span>
                    <span>
                        {{ $item->nama }}
                    </span>
                </td>
                @php
                    $dataLevelDua = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',2)->where('id_parent',$item->id)->get();
                    $dataLevelDuaCount = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',2)->where('id_parent',$item->id)->count();
                    $dataLeveTiga = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',3)->where('id_parent',$item->id)->get();
                    $dataLeveEmpat = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',4)->where('id_parent',$item->id)->get();
                    echo "<pre>'$dataLevelDua'</pre>";
                @endphp
                @foreach ($dataLeveTiga as $keyTiga => $itemTiga)
                        @php
                            // check  jawaban level tiga
                            $dataJawabanLevelTiga = \App\Models\ItemModel::where('id_item',$itemTiga->id)->get();
                            echo "<pre>'$dataJawabanLevelTiga'</pre>";
                            // check level empat
                            $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
                        @endphp
                @endforeach
                <td style="width:5%">:</td>
                <td style="width: 70%">
                    @foreach ($dataLevelDua as $item)
                        <tr>
                            <td style="width: 25%;" >
                                <label>{{ $item->nama }}</label>
                            </td>
                            <td style="width:25%;text-align:center;">:</td>
                            <td style="width: 50%">
                                @if ($dataLevelDuaCount != null || $dataLeveDuaCount != 0)
                                    @foreach ($dataLeveTiga as $itemTiga)
                                        <tr>
                                            <td style="width: 25%;" >
                                                <label>{{ $itemTiga->nama }}</label>
                                            </td>
                                            <td style="width:25%;text-align:center;">:</td>
                                            <td style="width: 50%">
                                                asdasdasdasdasd
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    adsasdasd
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
