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
        Sektor {{$dataUmum->skema_kredit}}
    </h4>
    <br>
    <table>
        <tr>
            <td style="width: 25%;" ><b><u><span>DATA UMUM</span></u></b>
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
            <td style="padding-left: 17px">
                {{ $dataNasabah->nama }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Alamat Rumah</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->alamat_rumah }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Alamat Usaha</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->alamat_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>No KTP</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->no_ktp }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Tempat, Tanggal Lahir / Status</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->tempat_lahir }}, {{ date_format(date_create($dataNasabah->tanggal_lahir), 'd/m/Y') }} / {{ $dataNasabah->status }}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Sektor Kredit</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->sektor_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jenis Usaha</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->jenis_usaha }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jumlah Kredit Yang Diminta</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ "Rp " . number_format($dataNasabah->jumlah_kredit,2,',','.') }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Tujuan Kredit</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->tujuan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%" >
                <label>Jaminan Yang Disediakan</label>
            </td>
            <td>:</td>
            <td style="padding-left: 17px">
                {{ $dataNasabah->jaminan_kredit }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%; vertical-align: top" >
                <label>Hubungan Dengan Bank</label>
            </td>
            <td style="vertical-align: top">:</td>
            <td style="padding-left: 17px; vertical-align: top">
                {{ $dataNasabah->hubungan_bank }}
            </td>
        </tr>
        <tr>
            <td style="width: 40%; vertical-align: top" >
                <label>Hasil Verifikasi Karakter Umum</label>
            </td>
            <td style="vertical-align: top">:</td>
            <td style="padding-left: 17px; vertical-align: top">
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
                @php
                $getPeriode = \App\Models\PeriodeAspekKeuangan::join('perhitungan_kredit', 'periode_aspek_keuangan.perhitungan_kredit_id', '=', 'perhitungan_kredit.id')
                                                ->where('perhitungan_kredit.pengajuan_id', $dataNasabah->id_pengajuan)
                                                ->select('periode_aspek_keuangan.*', 'perhitungan_kredit.*') 
                                                ->get();
                @endphp
                @if(!$getPeriode->isEmpty())
                    @foreach ($dataLevelDua as $item)
                        {{-- Aspek Keuangan --}}
                        @if ($item->nama == "Repayment Capacity")
                            @php
                            $lev1 = \App\Models\MstItemPerhitunganKredit::where('skema_kredit_limit_id', 1)->where('level', 1)->get();

                            function formatRupiah($angka){
                                $format_rupiah = number_format($angka, 2, ',', '.');
                                $format_rupiah = rtrim($format_rupiah, '0'); 
                                $format_rupiah = str_replace(',', '', $format_rupiah); 
                                echo $format_rupiah;
                            }

                            function formatBulan($value){
                                if ($value == 1) {
                                    echo "Januari";
                                }else if($value == 2){
                                    echo "Februari";
                                }else if($value == 3){
                                    echo "Maret";
                                }else if($value == 4){
                                    echo "April";
                                }else if($value == 5){
                                    echo "Mei";
                                }else if($value == 6){
                                    echo "Juni";
                                }else if($value == 7){
                                    echo "Juli";
                                }else if($value == 8){
                                    echo "Agustus";
                                }else if($value == 9){
                                    echo "September";
                                }else if($value == 10){
                                    echo "Oktober";
                                }else if($value == 11){
                                    echo "November";
                                }else{
                                    echo "Desember";
                                }
                            }
                            @endphp
                            <div class="form-group col-md-12">
                                    @php
                                    $lev1Count = 0;
                                    $totalAktiva = 0;
                                    $totalPasiva = 0;
                                    @endphp
                                    @foreach ($lev1 as $itemAspekKeuangan)
                                        @php
                                        $lev1Count += 1;
                                        $lev2 = \App\Models\MstItemPerhitunganKredit::where('skema_kredit_limit_id', 1)
                                            ->where('level', 2)
                                            ->where('parent_id', $itemAspekKeuangan->id)
                                            ->get();
                                        @endphp
                                        @if ($lev1Count > 1)
                                            <table style="margin-left: 33px; border-collapse: collapse;">
                                                <tr>
                                                    <th colspan="4" style="padding-top: 10px; padding-bottom: 10px; text-align: center; padding-left: 7px; border-left: 0px solid black; border-right: 0px solid black;">{{ $itemAspekKeuangan->field }} Periode : {{ formatBulan($getPeriode[0]->bulan) - $getPeriode[0]->tahun }} </th>
                                                </tr>
                                                @php $lev2Count = 0; @endphp
                                                @foreach ($lev2 as $itemAspekKeuangan2)
                                                @php
                                                $lev2Count += 1;
                                                $perhitunganKreditLev3 = \App\Models\PerhitunganKredit::rightJoin('mst_item_perhitungan_kredit', 'perhitungan_kredit.item_perhitungan_kredit_id', '=', 'mst_item_perhitungan_kredit.id')
                                                    ->where('mst_item_perhitungan_kredit.skema_kredit_limit_id', 1)
                                                    ->where('mst_item_perhitungan_kredit.level', 3)
                                                    ->where('mst_item_perhitungan_kredit.parent_id', $itemAspekKeuangan2->id)
                                                    ->where('perhitungan_kredit.pengajuan_id', $dataNasabah->id_pengajuan)
                                                    ->get();
                                                $fieldValues = [];
                                                @endphp
                                                <tr>
                                                    <th style="padding-top: 5px; padding-bottom: 5px; text-align: left; padding-left: 7px; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;">{{ $itemAspekKeuangan2->field }}</th>
                                                    <td style="border-top: 1px solid black; border-bottom: 1px solid black;"></td>
                                                    @if ($lev2Count > 1)
                                                        <th colspan="2" style="border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;"></th>
                                                    @else
                                                        <th style="text-align: left; padding-left: 20px; border-top: 1px solid black; border-bottom: 1px solid black;">Sebelum Kredit</th>
                                                        <th style="text-align: left; padding-left: 7px; border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;">Sesudah Kredit</th>
                                                    @endif
                                                </tr>
                                                @foreach ($perhitunganKreditLev3 as $itemAspekKeuangan3)
                                                    @php
                                                    $fieldValue = $itemAspekKeuangan3->field;
                                                    $nominal = $itemAspekKeuangan3->nominal;
                                                    @endphp
                                                    @if (!in_array($fieldValue, $fieldValues))
                                                        @if ($fieldValue == "Sisa Pendapatan Setiap Bulan")
                                                        <tr style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                                        @else
                                                            <tr style="border-left: 1px solid black; border-right: 1px solid black;">
                                                        @endif
                                                            <td width="220px" style="padding-left: 20px">{{ $fieldValue }}</td>
                                                            <td>:</td>
                                                            <td width="150px" style="padding-left: 20px;">Rp {{ formatRupiah($nominal) }}</td>
                                                            <td width="150px" style="padding-left: 7px;">
                                                                @foreach ($perhitunganKreditLev3 as $item)
                                                                    @if ($item->field == $fieldValue)
                                                                        @if ($item->nominal != $nominal)
                                                                            Rp {{ formatRupiah($item->nominal) }}<br>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        @php
                                                        $fieldValues[] = $fieldValue;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            </table>
                                        @else
                                            <table style="margin-left: 33px;
                                            border-collapse: collapse;">
                                                <tr>
                                                    <th colspan="{{ count($lev2) * 2 + 2 }}" style="padding-top: 5px; padding-bottom: 5px; text-align: center; padding-left: 7px">{{ $itemAspekKeuangan->field }} Periode : {{ formatBulan($getPeriode[0]->bulan) - $getPeriode[0]->tahun }} </th>
                                                </tr>
                                                <tr style="border: 1px solid black;">
                                                    @php $lev2Count = 0; @endphp
                                                    @foreach ($lev2 as $itemAspekKeuangan2)
                                                    @php $lev2Count += 1; @endphp
                                                    <th colspan="2" style="border: 0; padding-left: 20px; padding-top: 2px; padding-bottom: 2px; text-align: left">{{ $itemAspekKeuangan2->field }}</th>
                                                    {{-- <th>Rp</th> --}}
                                                        @if ($lev2Count <= 1)
                                                            <td style="border: 1px solid black;"></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                @php
                                                $maxRowCount = 0;
                                                $perhitunganKreditLev3List = [];
                                                foreach ($lev2 as $itemAspekKeuangan2) {
                                                    $perhitunganKreditLev3 = \App\Models\PerhitunganKredit::rightJoin('mst_item_perhitungan_kredit', 'perhitungan_kredit.item_perhitungan_kredit_id', '=', 'mst_item_perhitungan_kredit.id')
                                                        ->where('mst_item_perhitungan_kredit.skema_kredit_limit_id', 1)
                                                        ->where('mst_item_perhitungan_kredit.level', 3)
                                                        ->where('mst_item_perhitungan_kredit.parent_id', $itemAspekKeuangan2->id)
                                                        ->where('perhitungan_kredit.pengajuan_id', $dataNasabah->id_pengajuan)
                                                        ->get();
                                                    $perhitunganKreditLev3List[] = $perhitunganKreditLev3;
                                                    $maxRowCount = max($maxRowCount, count($perhitunganKreditLev3));
                                                }
                                                @endphp
                                                @for ($i = 0; $i < $maxRowCount; $i++)
                                                    <tr style="border: 1px solid black;">
                                                        @php 
                                                        $lev3Count = 0; 
                                                        @endphp
                                                        @foreach ($perhitunganKreditLev3List as $perhitunganKreditLev3)
                                                            @php 
                                                            $lev3Count += 1;
                                                            @endphp
                                                            @if ($i < count($perhitunganKreditLev3))
                                                                @if ($perhitunganKreditLev3[$i]->field != "Total Angsuran")
                                                                <td width="100px" style="padding-left: 20px">{{ $perhitunganKreditLev3[$i]->field }}</td>
                                                                <td width="100px" style=" padding-left: 10px;">Rp {{ formatRupiah($perhitunganKreditLev3[$i]->nominal) }}</td>
                                                                    @if ($lev3Count <= 1)
                                                                    <td width="20px" style="border: 1px solid black;"></td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endfor
                                                {{-- <tr style="border: 1px solid black;">
                                                    <th>Total</th>
                                                    <td style="border: 1px solid black;">{{ $totalAktiva }}</td>
                                                    <td style="border: 1px solid black;"></td>
                                                    <td></td>
                                                    <td style="border: 1px solid black;">{{ $totalPasiva }}</td>
                                                </tr> --}}
                                            </table>
                                        @endif
                                        <br>
                                    @endforeach
                                <div class="row">
                                    @php
                                    $lev2NoParent = \App\Models\MstItemPerhitunganKredit::where('skema_kredit_limit_id', 1)
                                                                                ->where('level', 2)
                                                                                ->whereNull('parent_id')
                                                                                ->get();
                                    @endphp
                                    @foreach ($lev2NoParent as $item2NoParent)
                                    @php
                                    $lev3NoParent = \App\Models\PerhitunganKredit::rightJoin('mst_item_perhitungan_kredit', 'perhitungan_kredit.item_perhitungan_kredit_id', '=', 'mst_item_perhitungan_kredit.id')
                                                                                    ->where('mst_item_perhitungan_kredit.skema_kredit_limit_id', 1)
                                                                                    ->where('mst_item_perhitungan_kredit.level', 3)
                                                                                    ->where('mst_item_perhitungan_kredit.parent_id', $item2NoParent->id)
                                                                                    ->where('perhitungan_kredit.pengajuan_id', $dataNasabah->id_pengajuan)
                                                                                    ->get();
                                    @endphp
                                            <table style="margin-left: 33px; border: 1px solid black">
                                                <tr>
                                                    <th colspan="4" style=" padding-top: 5px; padding-bottom: 5px; text-align: left; padding-left: 7px; border-bottom: 1px solid black">{{ $item2NoParent->field }}</th>
                                                </tr>
                                                @foreach ($lev3NoParent as $item3NoParent)
                                                <tr>
                                                    <td width="220px" style="padding-left: 20px">{{ $item3NoParent->field }}</td>
                                                    <td>:</td>
                                                    <td width="150px" style="padding-left: 20px">Rp {{ formatRupiah($item3NoParent->nominal) }}</td>
                                                    <td width="145px"></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                            <br>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        @php
                                        $dataUmumNasabahId = $dataNasabah->id_pengajuan;
                                        $results = \App\Models\MstItemPerhitunganKredit::leftJoin('perhitungan_kredit', function($join) use ($dataUmumNasabahId) {
                                                        $join->on('mst_item_perhitungan_kredit.id', '=', 'perhitungan_kredit.item_perhitungan_kredit_id')
                                                            ->where('perhitungan_kredit.pengajuan_id', '=', $dataUmumNasabahId);
                                                    })
                                                    ->where('mst_item_perhitungan_kredit.skema_kredit_limit_id', '=', 1)
                                                    ->where('mst_item_perhitungan_kredit.level', '=', 3)
                                                    ->whereNull('mst_item_perhitungan_kredit.parent_id')
                                                    ->get();   
                                        
                                        @endphp
                                        <table style="margin-left: 33px;">
                                            @foreach ($results as $item3NoParent)
                                            <tr>
                                                @if ($item3NoParent->field == "Perputaran Usaha")
                                                @elseif($item3NoParent->field == "Keuntungan Usaha")
                                                @elseif($item3NoParent->field == "Laba Setelah Kredit")
                                                @elseif($item3NoParent->field == "Dibulatkan")
                                                @elseif($item3NoParent->field == "Jangka Waktu Usulan")
                                                    <td width="220px" style="padding-left: 20px">{{ $item3NoParent->field }}</td>
                                                    <td>:</td>
                                                    <td style="padding-left: 20px; border-bottom: 1px solid black">{{ empty($item3NoParent->nominal) ? 0 : $item3NoParent->nominal }}</td>
                                                @elseif($item3NoParent->field == "Jangka Waktu Kredit")
                                                    <td width="220px" style="padding-left: 20px">{{ $item3NoParent->field }}</td>
                                                    <td>:</td>
                                                    <td style="padding-left: 20px; border-top: 1px solid black; border-bottom: 1px solid black">{{ empty($item3NoParent->nominal) ? 0 : $item3NoParent->nominal }}</td>
                                                @elseif($item3NoParent->field == "Repayment")
                                                @else
                                                    <td width="220px" style="">{{ $item3NoParent->field }}</td>
                                                    <td>:</td>
                                                    <td style="padding-left: 20px; border-top: 1px solid black; ">Rp {{ formatRupiah(empty($item3NoParent->nominal) ? 0 : $item3NoParent->nominal) }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </table>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- End Aspek Keuangan --}}
                    @endforeach
                @else
                @endif
                @foreach ($dataLevelDua as $item)
                    @if ($item->opsi_jawaban == 'input text' || $item->opsi_jawaban == 'long text' || $item->opsi_jawaban == 'number' || $item->opsi_jawaban == 'persen')
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')->join('item','jawaban_text.id_jawaban','item.id')->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$item->id)->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextDua)
                            @if ($item->opsi_jawaban == 'number')
                                @if ($item->nama == 'Repayment Capacity')    
                                <table style="margin-left: 33px;">
                                    <tr>
                                        <td width="240px" style="">{{  $item->nama }}</td>
                                        <td>:</td>
                                        <td style="padding-left: 20px">{{ (is_numeric($itemTextDua->opsi_text)) ? round($itemTextDua->opsi_text,2) : $itemTextDua->opsi_text }}</td>
                                    </tr>
                                    <br>
                                </table>
                                @else
                                    @if ($item->nama == 'Omzet Penjualan' || $item->nama == 'Installment')    
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
                                    @else
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
                                    @endif    
                                @endif
                            @elseif ($item->opsi_jawaban == 'persen')
                                <tr>
                                    <td style="width: 40%; padding-left: 33px">{{  $item->nama }}</td>
                                    <td>:</td>
                                    <td>{{ $itemTextDua->opsi_text }}%</td>
                                </tr>
                            @else    
                                @if ($item->nama == 'NPWP')
                                    <tr>
                                        <td style="width: 40%; padding-left: 33px"></td>
                                        <td></td>
                                        <td>{{$item->nama}} No. {{ $itemTextDua->opsi_text }}</td>
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
                        $dataLevelTiga = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',3)->where('id_parent',$item->id)->get();
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
                                                                    Rp 0 
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
                                                <td style="width: 40%; padding-left: 33px">asd</td>
                                                <td>: </td>
                                                <td>{{ $itemTextTiga->opsi_text }}</td>
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
                            <br>
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

                        {{-- @endif --}}
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
    @php
        $userPBO = \App\Models\User::select('id')
                                    ->where('id_cabang', $dataUmum->id_cabang)
                                    ->where('role', 'PBO')
                                    ->first();

        $userPBP = \App\Models\User::select('id')
                                    ->where('id_cabang', $dataUmum->id_cabang)
                                    ->where('role', 'PBP')
                                    ->whereNotNull('nip')
                                    ->first();
    @endphp
    @if ($userPBO)
        <table style="border-spacing:10px;">
            <tr>
                <td style="width: 100%;" ><b><u><span>PENDAPAT dan USULAN PBO</span></u></b>
                </td>
            </tr>
            <tr>
                <td>{{$komentar->komentar_pbo}}</td>
            </tr>
        </table>
    @endif
    @if (Auth::user()->id_cabang == '1')
        @if ($userPBP)
            <table style="border-spacing:10px;">
                <tr>
                    <td style="width: 100%;" ><b><u><span>PENDAPAT dan USULAN PBP</span></u></b>
                    </td>
                </tr>
                <tr>
                    <td>{{$komentar->komentar_pbp}}</td>
                </tr>
            </table>
        @endif
        <br>
    @endif
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
