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
        td{
            vertical-align: top;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- <table>
        <tr>
            <td style="width: 30%;">
            </td>
            <td style="width: 50%;text-align:center">
                ANALISA KREDIT MODAL KERJA
                <br>
                Sektor . . . . . . . .
            </td>
            <td style="width: 25%;text-align:center" class="title-head">LAMPIRAN 25</td>
        </tr>
    </table> --}}
    <h4 style="text-align:center">ANALISA KREDIT MODAL KERJA {{strtoupper($dataUmum->skema_kredit)}}
        <br>
        Sektor {{$dataUmum->skema_kredit}}
    </h4>
    <br>
    <table>
        <tr>
            <td style="width: 100%;" ><span>I</span><b><u><span style="margin-left:6px">DATA UMUM</span></u></b>
                <br>
                (<span style="font-weight: bold;"><i>nasabah perorangan</i></span>)
            </td>
            <td style="width:5%"></td>
            <td style="width: 70%">
            </td>
        </tr>
    </table>

    <table style="width: 100%">
        <tr>
            <td style="width: 40%;" >
                <label>Nama</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->nama }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Alamat Rumah</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->alamat_rumah }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Alamat Usaha</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->alamat_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>NO. Ktp</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->no_ktp }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Tempat, Tanggal Lahir / Status</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ ucfirst($dataNasabah->tempat_lahir) }}, {{ date_format(date_create($dataNasabah->tanggal_lahir), 'd/m/Y') }} / {{ ucfirst($dataNasabah->status) }}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Sektor Kredit</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{$dataUmum->skema_kredit}}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jenis Usaha</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{$dataNasabah->jenis_usaha}}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jumlah Kredit Yang Diminta</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ "Rp " . number_format($dataNasabah->jumlah_kredit,2,',','.') }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Tujuan Kredit</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->tujuan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jaminan Yang Disediakan</label>
            </td>
            <td>:</td>
            <td style="padding-left: 19px;">
                {{ strtoupper($dataNasabah->jaminan_kredit) }}
            </td>
        </tr>
        <tr>
            <td >
                <label>Hubungan Dengan Bank</label>
            </td>
            <td style="vertical-align: top">:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->hubungan_bank }}
            </td>
        </tr>
        <tr>
            <td>
                <label>Hasil Verifikasi Karakter Umum</label>
            </td>
            <td style="vertical-align: top">:</td>
            <td style="padding-left: 19px;">
                {{ $dataNasabah->verifikasi_umum }}
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
    <table style="width: 100%">
        @foreach ($dataAspek as $itemAspek)
            @if ($itemAspek->nama != 'Data Umum')
                @php
                    // check level 2
                    $dataLevelDua = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',2)->where('id_parent',$itemAspek->id)->get();
                    // check level 4
                    $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemAspek->id)->get();
                @endphp
                <tr>
                    <td style="width: 40%; padding-left: 17px">{{ $loop->iteration }}. <u><strong>{{ $itemAspek->nama }}</strong></u></td>
                </tr>
                <tr></tr>
                @foreach ($dataLevelDua as $item)
                    @if ($item->opsi_jawaban == 'input text' || $item->opsi_jawaban == 'long text' || $item->opsi_jawaban == 'number' || $item->opsi_jawaban == 'persen' || $item->opsi_jawaban == 'input text')
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$item->id)->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextDua)
                            @if ($item->opsi_jawaban == 'number')
                                @if ($item->nama == 'Repayment Capacity')
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                        <td>:</td>
                                        <td>{{ (is_numeric($itemTextDua->opsi_text)) ? round($itemTextDua->opsi_text,2) : $itemTextDua->opsi_text }}</td>
                                    </tr>
                                @endif
                            @elseif ($item->opsi_jawaban == 'persen')
                                <tr>
                                    <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                    <td>:</td>
                                    <td>{{ $itemTextDua->opsi_text }}%</td>
                                </tr>
                            @elseif($item->opsi_jawaban == 'input text' && $item->is_rupiah == 1)
                                @if ($item->nama == 'Omzet Penjualan' || $item->nama == 'Installment')
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px">{{  $item->nama }}(Perbulan) 1</td>
                                        <td>:</td>
                                        <td>
                                            @if (is_numeric($itemTextDua->opsi_text))
                                                {{ "Rp " . number_format($itemTextDua->opsi_text,2,',','.') }}
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @else
                                @if ($item->nama == 'NPWP')
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px"></td>
                                        <td></td>
                                        <td>{{$item->nama}} No. {{ $itemTextDua->opsi_text }}</td>
                                    </tr>
                                @elseif ($item->nama == 'Omzet Penjualan' || $item->nama == 'Installment' )
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px">{{  $item->nama }}(Perbulan)</td>
                                        <td>:</td>
                                        <td>
                                            @if (is_numeric($itemTextDua->opsi_text))
                                                {{ "Rp " . number_format($itemTextDua->opsi_text,2,',','.') }}
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                @elseif ($item->nama == 'Kebutuhan Kredit')
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                        <td>:</td>
                                        <td>
                                            @if (is_numeric($itemTextDua->opsi_text))
                                                {{ "Rp " . number_format($itemTextDua->opsi_text,2,',','.') }}
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                        <td>:</td>
                                        <td>{{ $itemTextDua->opsi_text }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @endif
                    @php
                        $dataJawaban = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$item->id)->get();
                        $dataOption = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$item->id)->get();

                        // check level 3
                        $dataLevelTiga = \App\Models\ItemModel::where('level',3)->whereNotIn('nama', ['Modal (awal) Sendiri','Modal Pinjaman'])->where('id_parent',$item->id)->get();
                    @endphp
                    @if (count($dataJawaban) != 0)
                        @if ($item->nama == 'Badan Usaha')
                            <tr>
                                <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                <td>:</td>
                            @foreach ($dataJawaban as $key => $itemJawaban)
                                @php
                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->get();
                                    $count = count($dataDetailJawaban);
                                    for ($i=0; $i < $count; $i++) {
                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                    }
                                @endphp
                                @if (in_array($itemJawaban->id,$data))
                                    @if (isset($data))
                                        <td style="padding-left: 4px">{{ $itemJawaban->option }}</td>
                                    @endif
                                @endif
                            @endforeach
                            </tr>
                            <tr>
                                <td style="width: 40%; padding-left: 33px;vertical-align:top">Permodalan Dipenuhi dari</td>
                                <td style="vertical-align:top">:</td>
                                <td style="vertical-align: top">
                                    @php
                                        $dataDetailJawabanModal = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                                ->join('item','jawaban_text.id_jawaban','item.id')->where('nama', 'like', '%Modal%')
                                                                                                ->where('jawaban_text.id_pengajuan',$dataUmum->id)->get();
                                    @endphp
                                    <table style="width: 100%">
                                        @foreach ($dataDetailJawabanModal as $itemModal)
                                            <tr>
                                                <td style="width: 40%; vertical-align: top">{{$itemModal->nama}}</td>
                                                <td>:</td>
                                                <td>
                                                    @if (is_numeric($itemModal->opsi_text))
                                                        {{ "Rp " . number_format($itemModal->opsi_text,2,',','.') }}
                                                    @else
                                                        Rp 0
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @else
                            @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi' || $item->nama == 'Repayment Capacity Opsi')
                            @else
                                <tr>
                                    <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                    <td>:</td>
                                @foreach ($dataJawaban as $key => $itemJawaban)
                                    @php
                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->get();
                                        $count = count($dataDetailJawaban);
                                        for ($i=0; $i < $count; $i++) {
                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                        }
                                    @endphp
                                    @if (in_array($itemJawaban->id,$data))
                                        @if (isset($data))
                                            <td>{{ $itemJawaban->option }}</td>
                                        @endif
                                    @endif
                                @endforeach
                                </tr>
                            @endif
                        @endif
                    @endif
                    @if ($item->nama == 'Jaminan Utama')
                        <tr>
                            <td style="width: 40%; padding-left: 33px">{{ $item->nama }}</td>
                        </tr>
                        @php
                            $checkJawabanKelayakan = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->whereIn('id_jawaban', ['183','184'])->first();
                        @endphp
                        @if (isset($checkJawabanKelayakan))
                            <tr>
                                <td style="width: 40%; padding-left: 50px">Kelayakan Usaha</td>
                                <td style="width: 5%; padding-top: 1px">:</td>
                                @php
                                    $jawabanKelayakan = \App\Models\OptionModel::where('id', $checkJawabanKelayakan->id_jawaban)->first();
                                @endphp
                                <td>{{$jawabanKelayakan->option}}</td>
                            </tr>
                        @else
                            @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                @php
                                    $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
                                @endphp
                                @if ($itemTiga->nama == 'Kategori Jaminan Utama')
                                    <tr>
                                        <td style="width: 40%; padding-left: 50px">Barang Jaminan</td>
                                        <td style="width: 5%; padding-top: 1px">:</td>
                                        <td>
                                            <table style="width: 100%">
                                                @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                    @if ($itemEmpat->opsi_jawaban == 'option')
                                                        @php
                                                            $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemEmpat->id)->get();
                                                            $dataOptionEmpat = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemEmpat->id)->get();
                                                        @endphp
                                                        @if (count($dataJawabanLevelEmpat) != 0)
                                                            @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                                @php
                                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                                    $count = count($dataDetailJawaban);
                                                                    for ($i=0; $i < $count; $i++) {
                                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                    }
                                                                @endphp
                                                                @if (in_array($itemJawabanLevelEmpat->id,$data))
                                                                        @if (isset($data))
                                                                        <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                                        <td style="width: 3%; padding-top: 1px">:</td>
                                                                        <td style="padding-top: 1px">{{ $itemJawabanLevelEmpat->option }}</td>
                                                                        @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @php
                                                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                                        @endphp
                                                        @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                            <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                            <td style="width: 3%; padding-top: 1px">:</td>
                                                            <td style="padding-top: 1px">{{ $itemTextEmpat->opsi_text }}</td>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Utama')
                                    <tr>
                                        <td style="width: 40%; padding-left: 50px; vertical-align: top">Bukti Pemilikan</td>
                                        <td style="width: 5%; padding-top: 1px; vertical-align: top">:</td>
                                        <td>
                                            <table style="width: 100%">
                                                @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                    @if ($itemEmpat->opsi_jawaban == 'input text')
                                                        @php
                                                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                                        @endphp
                                                        @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                            <tr>
                                                                <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                                <td style="width: 3%; padding-top: 1px">:</td>
                                                                <td style="padding-top: 1px">{{ $itemTextEmpat->opsi_text }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @elseif($itemTiga->nama == 'Pengikatan Jaminan Utama')
                                    <tr>
                                        <td style="width: 40%; padding-left: 50px; vertical-align: top">Pengikatan</td>
                                        <td style="width: 5%; padding-top: 1px; vertical-align: top">:</td>
                                        @php
                                            $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                                            $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                                        @endphp
                                        @if (count($dataJawabanLevelTiga) != 0)
                                            @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                                @php
                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                    $count = count($dataDetailJawaban);
                                                    for ($i=0; $i < $count; $i++) {
                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                    }
                                                @endphp
                                                @if (in_array($itemJawabanLevelTiga->id,$data))
                                                    @if (isset($data))
                                                        <td style="padding-left: 3px">{{ $itemJawabanLevelTiga->option }}</td>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @elseif ($item->nama == 'Jaminan Tambahan')
                        <tr>
                            <td style="width: 40%; padding-left: 33px">{{ $item->nama }}</td>
                        </tr>
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @php
                                $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
                            @endphp
                            @if ($itemTiga->nama == 'Kategori Jaminan Tambahan')
                                <tr>
                                    <td style="width: 40%; padding-left: 50px">Barang Jaminan</td>
                                    <td style="width: 5%; padding-top: 1px">:</td>
                                    <td>
                                        <table style="width: 100%">
                                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                @if ($itemEmpat->opsi_jawaban == 'option')
                                                    @php
                                                        $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemEmpat->id)->get();
                                                        $dataOptionEmpat = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemEmpat->id)->get();
                                                    @endphp
                                                    @if (count($dataJawabanLevelEmpat) != 0)
                                                        @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                            @php
                                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                                $count = count($dataDetailJawaban);
                                                                for ($i=0; $i < $count; $i++) {
                                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                }
                                                            @endphp
                                                            @if (in_array($itemJawabanLevelEmpat->id,$data))
                                                                    @if (isset($data))
                                                                    <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                                    <td style="width: 3%; padding-top: 1px">:</td>
                                                                    <td style="padding-top: 1px">{{ $itemJawabanLevelEmpat->option }}</td>
                                                                    @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                                    @endphp
                                                    @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                        <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                        <td style="width: 3%; padding-top: 1px">:</td>
                                                        <td style="padding-top: 1px">{{ $itemTextEmpat->opsi_text }}</td>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Tambahan')
                                <tr>
                                    <td style="width: 40%; padding-left: 50px; vertical-align: top">Bukti Pemilikan</td>
                                    <td style="width: 5%; padding-top: 1px; vertical-align: top">:</td>
                                    <td>
                                        <table style="width: 100%">
                                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                @if ($itemEmpat->opsi_jawaban == 'input text')
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                                    @endphp
                                                    @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                        <tr>
                                                            <td style="width: 40%; padding-top: 1px">{{ $itemEmpat->nama }}</td>
                                                            <td style="width: 3%; padding-top: 1px">:</td>
                                                            <td style="padding-top: 1px">{{ $itemTextEmpat->opsi_text }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            @elseif($itemTiga->nama == 'Pengikatan Jaminan Tambahan')
                                <tr>
                                    <td style="width: 40%; padding-left: 50px; vertical-align: top">Pengikatan</td>
                                    <td style="width: 5%; padding-top: 1px; vertical-align: top">:</td>
                                    @php
                                        $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                                        $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                                    @endphp
                                    @if (count($dataJawabanLevelTiga) != 0)
                                        @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                            @php
                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                $count = count($dataDetailJawaban);
                                                for ($i=0; $i < $count; $i++) {
                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                }
                                            @endphp
                                            @if (in_array($itemJawabanLevelTiga->id,$data))
                                                @if (isset($data))
                                                    <td style="padding-left: 3px">{{ $itemJawabanLevelTiga->option }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                            @elseif ($itemTiga->nama == 'Taksiran Harga')
                                <tr>
                                    <td style="width: 40%; padding-left: 50px; vertical-align: top">Taksiran Harga</td>
                                    <td style="width: 5%; padding-top: 1px; vertical-align: top">:</td>
                                    <td>
                                        <table style="width: 100%">
                                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                @if ($itemEmpat->opsi_jawaban == 'number')
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                                    @endphp
                                                    @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                        <tr>
                                                            <td style="width: 40%; padding-top: 1px">{{ $itemTextEmpat->nama }}</td>
                                                            <td style="width: 5%; padding-top: 1px;">:</td>
                                                            <td style="padding-top: 1px;">
                                                                @if (is_numeric($itemTextEmpat->opsi_text))
                                                                    {{ "Rp " . number_format($itemTextEmpat->opsi_text,2,',','.') }}
                                                                @else
                                                                    0
                                                                @endif
                                                            </td>
                                                            {{-- <td style="width: 5%; padding-top: 1px">{{ $itemTextEmpat->nama }}</td>
                                                            <td style="width: 3%; padding-top: 1px">:</td>
                                                            <td style="width: 3%; padding-top: 1px">
                                                                @if (is_numeric($itemTextEmpat->opsi_text))
                                                                    {{ "Rp " . number_format($itemTextEmpat->opsi_text,2,',','.') }}
                                                                @else
                                                                    Rp 0
                                                                @endif
                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @elseif ($item->nama == 'Lokasi Usaha')
                        <tr>
                            <td style="width: 40%; padding-left: 33px">{{ $item->nama }}</td>
                        </tr>
                            @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                @if ($itemTiga->opsi_jawaban == 'input text')
                                    @php
                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                                    @endphp
                                    @foreach ($dataDetailJawabanText as $itemTextTiga)
                                        <tr>
                                            <td style="width: 40%; padding-left: 50px">{{ $itemTiga->nama }}</td>
                                            <td style="width: 5%; padding-top: 1px">:</td>
                                            <td style="padding-left: 3px">{{ $itemTextTiga->opsi_text }}</td>
                                        </tr>
                                    @endforeach
                                @elseif ($itemTiga->opsi_jawaban == 'option')
                                    @php
                                        $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                                        $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                                    @endphp
                                    @if (count($dataJawabanLevelTiga) != 0)
                                        @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                            @php
                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                $count = count($dataDetailJawaban);
                                                for ($i=0; $i < $count; $i++) {
                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                }
                                            @endphp
                                            @if (in_array($itemJawabanLevelTiga->id,$data))
                                                @if (isset($data))
                                                    <tr>
                                                        <td style="width: 40%; padding-left: 50px">{{$itemTiga->nama}}</td>
                                                        <td style="width: 5%; padding-top: 1px">:</td>
                                                        <td style="padding-left: 3px">{{ $itemJawabanLevelTiga->option }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                    @elseif ($item->nama == 'Sarana Penunjang')
                        <tr>
                            <td style="width: 40%; padding-left: 33px">{{ $item->nama }}</td>
                        </tr>
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @php
                                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                            @endphp
                            @foreach ($dataDetailJawabanText as $itemTextTiga)
                                <tr>
                                    <td style="width: 40%; padding-left: 50px">{{ $itemTiga->nama }}</td>
                                    <td style="width: 5%; padding-top: 1px">:</td>
                                    <td style="padding-left: 3px">{{ $itemTextTiga->opsi_text }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @elseif ($item->nama == 'Barang Dagangan')
                        <tr>
                            <td style="width: 40%; padding-left: 33px">{{ $item->nama }}</td>
                        </tr>
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @if ($itemTiga->opsi_jawaban == 'input text')
                                @php
                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                                @endphp
                                @foreach ($dataDetailJawabanText as $itemTextTiga)
                                    <tr>
                                        <td style="width: 40%; padding-left: 50px">{{ $itemTiga->nama }}</td>
                                        <td style="width: 5%; padding-top: 1px">:</td>
                                        <td style="padding-left: 3px">{{ $itemTextTiga->opsi_text }}</td>
                                    </tr>
                                @endforeach
                            @elseif ($itemTiga->opsi_jawaban == 'option')
                                @php
                                    $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                                    $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                                @endphp
                                @if (count($dataJawabanLevelTiga) != 0)
                                    @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                        @if (in_array($itemJawabanLevelTiga->id,$data))
                                            @if (isset($data))
                                                <tr>
                                                    <td style="width: 40%; padding-left: 50px">{{$itemTiga->nama}}</td>
                                                    <td style="width: 5%; padding-top: 1px">:</td>
                                                    <td style="padding-left: 3px">{{ $itemJawabanLevelTiga->option }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach

                    @else
                    @php
                        $noTiga = 0;
                    @endphp
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @if ($itemTiga->opsi_jawaban == 'input text')
                                @php
                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                            ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                            ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                                @endphp
                                @if(count($dataDetailJawabanText) != 0)
                                    @foreach ($dataDetailJawabanText as $itemTextTiga)
                                        @if ($itemTiga->nama == 'NIB' || $itemTiga->nama == 'Surat Keterangan Usaha')
                                            <tr>
                                                <td style="width: 40%; padding-left: 33px">Ijin Usaha</td>
                                                <td>: </td>
                                                <td>{{ $itemTiga->nama }} No. {{ $itemTextTiga->opsi_text }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td style="width: 40%; padding-left: 33px">{{ $itemTiga->nama }}</td>
                                                <td>: </td>
                                                <td>{{ $itemTiga->is_rupiah ? number_format($itemTextTiga->opsi_text, 0 , ',', '.') : $itemTextTiga->opsi_text }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    @if ($noTiga++ == 0)
                                        <tr>
                                            <td style="width: 40%; padding-left: 33px">Tidak ada legalitas usaha</td>
                                        </tr>
                                    @endif
                                @endif
                            @endif
                            @php
                                // check  jawaban level tiga
                                $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                                $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                                // check level empat
                                $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
                            @endphp
                            @if (count($dataJawabanLevelTiga) != 0)
                                <tr>
                                    <td style="width: 40%; padding-left: 33px">{{  $itemTiga->nama }}</td>
                                    <td>:</td>
                                    @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                        @if (in_array($itemJawabanLevelTiga->id,$data))
                                            @if (isset($data))
                                                <td>{{ $itemJawabanLevelTiga->option }}</td>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            @endif
                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                @if ($itemEmpat->nama != 'Tanah' || $itemEmpat->nama != 'Kendaraan Bermotor' || $itemEmpat->nama != 'Tanah dan Bangunan')
                                    @php
                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                    @endphp
                                    @if ($itemEmpat->opsi_jawaban == 'input text')
                                        @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                            <tr>
                                                <td style="width: 40%; padding-left: 33px">{{ $itemEmpat->nama }}</td>
                                                <td>:</td>
                                                <td>{{ $itemTextEmpat->opsi_text }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @php
                                        // check level empat
                                        $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemEmpat->id)->get();
                                        $dataOptionEmpat = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemEmpat->id)->get();
                                    @endphp
                                    {{-- Data jawaban Level Empat --}}
                                    @if (count($dataJawabanLevelEmpat) != 0)
                                            <tr>
                                                @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                    @php
                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                                        $count = count($dataDetailJawaban);
                                                        for ($i=0; $i < $count; $i++) {
                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                        }
                                                    @endphp
                                                    @if (in_array($itemJawabanLevelEmpat->id,$data))
                                                        @if (isset($data))
                                                            <td style="width: 40%; padding-left: 33px">{{ $itemEmpat->id_parent }}{{ $itemEmpat->nama }}</td>
                                                            <td >:</td>
                                                            <td>{{ $itemJawabanLevelEmpat->option }}</td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            @endforeach
                        @endif
                @endforeach
                @php
                    $pendapatperaspek = \App\Models\PendapatPerAspek::select('*')->where('id_pengajuan', $dataUmum->id)->where('id_aspek', $itemAspek->id)->get();
                @endphp
                @foreach ($pendapatperaspek as $pendapatuser)
                    {{-- @if()
                    @else --}}
                        @if ($pendapatuser->id_staf != null)
                            <tr>
                                <td style="width: 40%; padding: 20px 0px 10px 33px; vertical-align: top">KESIMPULAN STAFF</td>
                                <td style="padding: 20px 0px 10px 0px; vertical-align: top">:</td>
                                <td style="padding: 20px 0px 10px 0px; vertical-align: top">{{$pendapatuser->pendapat_per_aspek}}</td>
                            </tr>
                        @elseif ($pendapatuser->id_penyelia != null)
                            <tr>
                                <td style="width: 40%; padding: 0px 0px 10px 33px; vertical-align: top">KESIMPULAN PENYELIA</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">:</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">{{$pendapatuser->pendapat_per_aspek}}</td>
                            </tr>
                        @elseif ($pendapatuser->id_pbo != null)
                            <tr>
                                <td style="width: 40%; padding: 0px 0px 10px 33px; vertical-align: top">KESIMPULAN PBO</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">:</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">{{$pendapatuser->pendapat_per_aspek}}</td>
                            </tr>
                        @elseif ($pendapatuser->id_pbp != null)
                            <tr>
                                <td style="width: 40%; padding: 0px 0px 10px 33px; vertical-align: top">KESIMPULAN PBP</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">:</td>
                                <td style="padding: 0px 0px 10px 0px; vertical-align: top">{{$pendapatuser->pendapat_per_aspek}}</td>
                            </tr>
                        @elseif ($pendapatuser->id_pincab != null)
                            <tr>
                                <td style="width: 40%; padding: 20px 0px 20px 33px; vertical-align: top">KESIMPULAN PINCAB</td>
                                <td style="padding: 20px 0px 20px 0px; vertical-align: top">:</td>
                                <td style="padding: 20px 0px 20px 0px; vertical-align: top">{{$pendapatuser->pendapat_per_aspek}}</td>
                            </tr>
                        @endif
                @endforeach
            @else
                {{-- Data Umum tidak ditampilkan --}}
            @endif
        @endforeach
    </table>
    <br>
    <table style="border-spacing:10px;">
        <tr>
            <td colspan="3"><b><u><span>PENDAPAT dan USULAN STAF KREDIT</span></u></b></td>
        </tr>
            <tr>
                <td>{{$komentar->komentar_staff}}</td>
            </tr>
        @if ($komentar->id_penyelia != null)
         <tr>
            <td colspan="3"><b><u><span>PENDAPAT dan USULAN PENYELIA</span></u></b></td>
        </tr>
            <tr>
                <td>{{$komentar->komentar_penyelia}}</td>
            </tr>
        @endif
        @if ($komentar->id_pbo != null)
         <tr>
            <td colspan="3"><b><u><span>PENDAPAT dan USULAN STAF PBO</span></u></b></td>
        </tr>
            <tr>
                <td>{{$komentar->komentar_pbo}}</td>
            </tr>
        @endif
        @if ($komentar->id_pbp != null)
         <tr>
            <td colspan="3"><b><u><span>PENDAPAT dan USULAN STAF PBP</span></u></b></td>
        </tr>
            <tr>
                <td>{{$komentar->komentar_pbp}}</td>
            </tr>
            {{-- <tr>
                <td style="width: 40%; padding: 0px 20px 20px; vertical-align: top">PENDAPAT DAN USULAN PBP</td>
                <td style="padding: 0px 0px 10px 0px; vertical-align: top">:</td>
                <td style="padding: 0px 0px 10px 0px; vertical-align: top">{{$komentar->komentar_pbp}}</td>
            </tr --}}
        @endif
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td style="width: 100%;" ><span>III</span><b><u><span style="margin-left:6px">KEPUTUSAN KREDIT</span></u></b>
            </td>
        </tr>
    </table>
    <table style="border-spacing:10px;">
        <tr>
            <td style="width: 100%;" ><b><u><span>PENDAPAT PEMIMPIN CABANG</span></u></b>
            </td>
        </tr>
        <tr>
            <td>{{$komentar->komentar_pincab}}</td>
        </tr>
    </table>
    <br>
    @if ($dataUmum->posisi == 'Selesai')
    <table style="border-spacing:10px;">
        <tr>
            <td>
                Berdasarkan analisa aspek II 1), 2), 3), 4), 5), 6) selanjutnya agar segera dilakukan pembahasan dalam komite kredi
            </td>
        </tr>
    </table>
    @endif
    @php
        $dataKtpNasabah = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
            ->where('level', 2)
            ->where('id_parent', $itemSP->id)
            ->where('nama', 'Foto KTP Nasabah')
            ->get();
        $dataFotoNasabah = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
            ->where('level', 2)
            ->where('id_parent', $itemSP->id)
            ->where('nama', 'Foto KTP Suami')
            ->get();

        $dataLS = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
            ->where('level', 2)
            ->where('id_parent', $itemSP->id)
            ->where('nama', 'Laporan SLIK')
            ->get();
    @endphp

    <div class="page-break"></div>
        <table style="border-spacing:10px;">
            @foreach ($dataFotoNasabah as $item)
                @if ($item->opsi_jawaban == 'file')
                    @php
                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                            ->where('jawaban_text.id_jawaban', $item->id)
                            ->get();
                    @endphp
                    @foreach ($dataDetailJawabanText as $itemTextDua)
                        @php
                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                        @endphp
                            <tr>
                                <td style="width: 100%;" ><span>{{$item->nama}}</span></td>
                                {{-- <td style="width: 40%; padding: 20px 0px 20px 33px; vertical-align: top">{{$item->nama}}</td> --}}
                            </tr>
                            <tr>
                                <td style="vertical-align: top">
                                    <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="">
                                </td>
                            </tr>
                        </div>
                    @endforeach
                @endif
            @endforeach
            @foreach ($dataKtpNasabah as $item)
                @if ($item->opsi_jawaban == 'file')
                    @php
                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                            ->where('jawaban_text.id_jawaban', $item->id)
                            ->get();
                    @endphp
                    @foreach ($dataDetailJawabanText as $itemTextDua)
                        @php
                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                        @endphp
                                <p>{{$item->nama}}</p>
                                <img style="width: 100%;" src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="">
                        </div>
                    @endforeach
                @endif
            @endforeach
        </table>
    <div class="page-break"></div>
    @php
        // check level 2
    @endphp
    @foreach ($dataLS as $item)
        @if ($item->opsi_jawaban == 'file')
            @php
                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                    ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                    ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                    ->where('jawaban_text.id_jawaban', $item->id)
                    ->get();
            @endphp
            @foreach ($dataDetailJawabanText as $itemTextDua)
                @php
                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                @endphp

                            <p>{{$item->nama}}</p>
                            <iframe
                                id="dynamicIframe"
                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}#toolbar=0&navpanes=0"
                                width="100%"
                                style="border: none; overflow: hidden;"
                                onload="adjustIframeHeight(this);"
                            ></iframe>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
</body>
</html>
<script>
    function adjustIframeHeight(iframe) {
        var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
        iframe.style.height = (innerDoc.body.scrollHeight + 23000) + 'px';
    }
</script>
@if (isset($_GET['pdf']))
    @php
        $name = 'Laporan Kas ' . date('d-m-Y', strtotime($_GET['start'])).' s/d '.date('d-m-Y', strtotime($_GET['end'])).'.pdf';
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=$name");
    @endphp
@else
    <script>
        window.print()
    </script>
@endif
