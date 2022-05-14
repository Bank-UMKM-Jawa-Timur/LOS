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
    <h4 style="text-align:center">ANALISA KREDIT MODAL KERJA
        <br>
        Sektor . . . . . . . .
    </h4>
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
                {{ $dataNasabah->nama }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Alamat Rumah</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->alamat_rumah }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Alamat Usaha</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->alamat_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>No KTP</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->no_ktp }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Tempat, Tanggal Lahir / Status</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->tempat_lahir }}, {{ date_format(date_create($dataNasabah->tanggal_lahir), 'd/m/Y') }} <span style="margin-left:20px">Status : {{ $dataNasabah->status }}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Sector Kredit</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->sektor_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jenis Usaha</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->jenis_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jumlah Kredit Yang Diminta</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ "Rp " . number_format($dataNasabah->jumlah_kredit,2,',','.') }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Tujuan Kredit</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->tujuan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Jaminan Yang Disediakan</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->jaminan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Hubungan Dengan Bank</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
                {{ $dataNasabah->hubungan_bank }}
            </td>
        </tr>
        <tr>
            <td style="width: 25%;" >
                <label>Hasil Verifikasi Karakter Umum</label>
            </td>
            <td style="width:25%;text-align:center;">:</td>
            <td style="width: 50%">
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
    <table>
        @foreach ($dataAspek as $itemAspek)
            @php
                // check level 2
                $dataLevelDua = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',2)->where('id_parent',$itemAspek->id)->get();
                // check level 4
                $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemAspek->id)->get();
            @endphp
            <tr>
                <td><strong>{{ $itemAspek->nama }}</strong></td>
            </tr>
            @foreach ($dataLevelDua as $item)
                @if ($item->opsi_jawaban == 'input text')
                    @php
                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$item->id)->get();
                    @endphp
                    @foreach ($dataDetailJawabanText as $itemTextDua)
                    <tr>
                        <td>{{  $item->nama }}</td>
                        <td>:</td>
                        <td>{{ $itemTextDua->opsi_text }}</td>
                    </tr>
                        {{-- <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextDua->skor_penyelia }}">
                            </div>
                        </div> --}}
                    @endforeach
                @endif
                @php
                    $dataJawaban = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$item->id)->get();
                    $dataOption = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$item->id)->get();

                    // check level 3
                    $dataLevelTiga = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',3)->where('id_parent',$item->id)->get();
                @endphp
                @if (count($dataJawaban) != 0)
                    <tr>
                        <td>{{  $item->nama }}</td>
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

                    {{-- <div class="row form-group sub">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
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
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->where('id_jawaban',$itemJawaban->id)->get();
                                        @endphp
                                        @foreach ($dataDetailJawaban as $item)
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div> --}}
                @endif
                @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                    @if ($itemTiga->opsi_jawaban == 'input text')
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                    ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                    ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextTiga)
                        <tr>
                            <td>{{  $itemTiga->nama }}</td>
                            <td>: </td>
                            <td>{{ $itemTextTiga->opsi_text }}</td>
                        </tr>
                            {{-- <div class="row form-group sub">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextTiga->skor_penyelia }}">

                                </div>
                            </div> --}}
                        @endforeach
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
                        <td>{{  $itemTiga->nama }}</td>
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
                        {{-- <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                @foreach ($dataJawabanLevelTiga as $key => $itemJawabanTiga)
                                    @php
                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->get();
                                        $count = count($dataDetailJawaban);
                                        for ($i=0; $i < $count; $i++) {
                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                        }
                                    @endphp
                                    @if (in_array($itemJawabanTiga->id,$data))
                                        @if (isset($data))
                                            @php
                                                $dataDetailJawabanTiga = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->where('id_jawaban',$itemJawabanTiga->id)->get();
                                            @endphp
                                            @foreach ($dataDetailJawabanTiga as $item)
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <hr> --}}
                    @endif
                    @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                        @if ($itemEmpat->opsi_jawaban == 'input text')
                            @php
                                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                        ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                        ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                            @endphp
                            @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                <tr>
                                    <td>{{ $itemEmpat->nama }}</td>
                                    <td>:</td>
                                    <td>{{ $itemTextEmpat->opsi_text }}</td>
                                </tr>
                                {{-- <div class="row form-group sub">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextEmpat->skor_penyelia }}">
                                    </div>
                                </div>
                                <hr> --}}
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
                            <td>{{ $itemEmpat->nama }}</td>
                            <td >:</td>
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
                                        <td>{{ $itemJawabanLevelEmpat->option }}</td>
                                            {{-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemJawabanLevelEmpat->option }}"> --}}
                                    @endif
                                @endif
                            @endforeach
                        </tr>

                            {{-- <div class="row form-group sub">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Skor Penyelia</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanEmpat)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                        @if (in_array($itemJawabanEmpat->id,$data))
                                            @if (isset($data))
                                                @php
                                                    $dataDetailJawabanEmpat = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor','skor_penyelia')->where('id_pengajuan',$dataUmum->id)->where('id_jawaban',$itemJawabanEmpat->id)->get();
                                                @endphp
                                                @foreach ($dataDetailJawabanEmpat as $item)
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <hr> --}}
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </table>
    <br>
    <table style="border-spacing:10px;">
        <tr>
            <td style="width: 100%;" ><b><u><span>PENDAPAT dan USULAN STAF KREDIT</span></u></b>
            </td>
        </tr>
        <tr>
            <td>{{$komentar->komentar_staff}}</td>
        </tr>
    </table>
    <br>
    <table style="border-spacing:10px;">
        <tr>
            <td style="width: 100%;" ><b><u><span>PENDAPAT dan USULAN PENYELIA KREDIT</span></u></b>
            </td>
        </tr>
        <tr>
            <td>{{$komentar->komentar_penyelia}}</td>
        </tr>
    </table>
    <br>
    <table style="border-spacing:10px;">
        <tr>
            <td style="width: 100%;" ><b><u><span>PENDAPAT PEMIMPIN CABANG</span></u></b>
            </td>
        </tr>
        <tr>
            <td>{{$komentar->komentar_pincab}}</td>
        </tr>
    </table>
    {{-- <table>
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
    </table> --}}
</body>
</html>
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
