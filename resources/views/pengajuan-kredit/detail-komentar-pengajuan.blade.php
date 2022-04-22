@extends('layouts.template')
@section('content')
@include('components.notification')

<style>
    .sub label:not(.info){
        font-weight: 400;
    }
    h4{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 20px;
        /* border-bottom: 1px solid #dc3545; */
    }
    h5{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 18px;
        /* border-bottom: 1px solid #dc3545; */
    }
    .form-wizard h6{
        color: #c2c7cf;
        font-weight: 600 !important;
        font-size: 16px;
        /* border-bottom: 1px solid #dc3545; */
    }
</style>
<div class="">
    <form action="{{ route('pengajuan.check.pincab.status.detail.post') }}" method="POST" >
    @csrf

        {{-- calon nasabah --}}
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Lengkap</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataNasabah->nama }}">
            </div>
        </div>
        <div class="form-group row">
            {{-- alamat rumah --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Rumah</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->alamat_rumah }}</textarea>
            </div>

            {{-- alamat usaha --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Usaha</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->alamat_usaha }}</textarea>
            </div>
            {{-- No KTP --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">No. KTP</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataNasabah->no_ktp }}">
            </div>
            {{-- Tempat tanggal lahir --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Tempat, Tanggal lahir/Status</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7 ">
                <div class="d-flex justify-content-start ">
                    <div class="m-0" style="width: 110px">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataNasabah->tempat_lahir.',' }}">
                    </div>
                    <div class="m-0" style="width: 100px">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ date('d-m-Y', strtotime($dataNasabah->tanggal_lahir)) }}">
                    </div>
                    <div class="m-0" style="width: 140px">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ '/ '.$dataNasabah->status }}">
                    </div>
                </div>

            </div>

            <label for="staticEmail" class="col-sm-3 col-form-label">Sektor Kredit</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataNasabah->sektor_kredit }}">
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Usaha</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataNasabah->jenis_usaha }}">
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Jumlah Kredit yang diminta </label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Rp.{{ number_format($dataNasabah->jumlah_kredit, 2, '.', ',') }}">
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Tujuan Kredit</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->tujuan_kredit }}</textarea>
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Jaminan yang disediakan</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->jaminan_kredit }}</textarea>
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Hubungan dengan Bank</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->hubungan_bank }}</textarea>
            </div>
            <label for="staticEmail" class="col-sm-3 col-form-label">Hasil Verifikasi Karakter Umum</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataNasabah->verifikasi_umum }}</textarea>
            </div>



        </div>
        {{-- aspek management --}}
        <hr>
        @foreach ($dataAspek as $itemAspek)
            @php
                // check level 2
                $dataLevelDua = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',2)->where('id_parent',$itemAspek->id)->get();
                // check level 4
                $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemAspek->id)->get();
            @endphp
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemAspek->nama }}</label>
            </div>
            @foreach ($dataLevelDua as $item)
                @if ($item->opsi_jawaban == 'input text')
                    @php
                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$item->id)->get();
                    @endphp
                    @foreach ($dataDetailJawabanText as $itemTextDua)
                        @php
                            $getKomentar = \App\Models\DetailKomentarModel::select('*')
                                // ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                ->where('id_item', $itemTextDua->id_item)
                                ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                ->get();
                        @endphp
                        @foreach ($getKomentar as $itemKomentar)
                        <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{  $item->nama }}</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextDua->opsi_text }}">
                                <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                            </div>
                        </div>
                        <div class="row form-group sub">
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
                        </div>
                        <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar->komentar }}">
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    @endforeach
                @endif
                @php
                    $dataJawaban = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$item->id)->get();
                    $dataOption = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$item->id)->get();

                    // check level 3
                    $dataLevelTiga = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',3)->where('id_parent',$item->id)->get();
                @endphp
                @if (count($dataJawaban) != 0)
                    <div class="row form-group sub">
                        <label for="staticEmail" class="col-sm-3 col-form-label">{{  $item->nama }}</label>
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
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemJawaban->option }}">
                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row form-group sub">
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
                                            $getKomentar2 = \App\Models\DetailKomentarModel::select('detail_komentar.*')
                                                                                        ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                                        ->where('detail_komentar.id_item', $itemJawaban->id_item)
                                                                                        ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                                                                        ->get();
                                        @endphp
                                        @foreach ($dataDetailJawaban as $item)
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @foreach ($getKomentar2 as $itemKomentar2)
                        <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar2->komentar }}">
                            </div>
                        </div>
                    @endforeach
                    <hr>
                @endif
                @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                    @if ($itemTiga->opsi_jawaban == 'input text')
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                    ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                    ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                            $getKomentar2 = \App\Models\DetailKomentarModel::select('*')
                                // ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                ->where('id_item', $item->id)
                                ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                ->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextTiga)
                            @foreach ($getKomentar2 as $itemKomentar2)
                                <div class="row form-group sub">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{  $item->nama }}</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextTiga->opsi_text }}">
                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                    </div>
                                </div>
                                <div class="row form-group sub">
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
                                </div>
                                <div class="row form-group sub">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar2->komentar }}">
                                    </div>
                                </div>
                            @endforeach
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
                        <div class="row form-group sub">
                            <label for="staticEmail" class="col-sm-3 col-form-label">{{  $itemTiga->nama }}</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
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
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemJawabanLevelTiga->option }}">
                                                <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="row form-group sub">
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
                                                $getKomentar3 = \App\Models\DetailKomentarModel::select('*')
                                                                                                // ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                                                ->where('id_item', $itemJawabanTiga->id_item)
                                                                                                ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                                                                                ->get();
                                            @endphp
                                            @foreach ($dataDetailJawabanTiga as $item)
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @foreach ($getKomentar3 as $itemKomentar3)
                            <div class="row form-group sub">
                                <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar3->komentar }}">
                                </div>
                            </div>
                        @endforeach
                        <hr>
                    @endif
                    @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                        @if ($itemEmpat->opsi_jawaban == 'input text')
                            @php
                                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','jawaban_text.skor_penyelia','item.id as id_item','item.nama')
                                                                                        ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                        ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                            @endphp
                            @foreach ($dataDetailJawabanText as $itemTextEmpat)
                            @php
                                $getKomentar4 = \App\Models\DetailKomentarModel::select('*')
                                                                            // ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                            ->where('id_item', $itemTextEmpat->id_item)
                                                                            ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                                                            ->get();
                            @endphp
                                <div class="row form-group sub">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{  $itemEmpat->nama }}</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemTextEmpat->opsi_text }}">
                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                    </div>
                                </div>
                                <div class="row form-group sub">
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
                                @foreach ($getKomentar4 as $itemKomentar4)
                                    <div class="row form-group sub">
                                        <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemKomentar4->komentar }}">
                                        </div>
                                    </div>
                                @endforeach
                                <hr>
                            @endforeach
                        @endif
                        @php
                            // check level empat
                            $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemEmpat->id)->get();
                            $dataOptionEmpat = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemEmpat->id)->get();
                        @endphp
                        {{-- Data jawaban Level Empat --}}
                        @if (count($dataJawabanLevelEmpat) != 0)
                            <div class="row form-group sub">
                                <label for="staticEmail" class="col-sm-3 col-form-label">{{  $itemEmpat->nama }}</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
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
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemJawabanLevelEmpat->option }}">
                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row form-group sub">
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
                                                    $getKomentar5 = \App\Models\DetailKomentarModel::select('*')
                                                                            // ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                            ->where('id_item', $itemJawabanEmpat->id_item)
                                                                            ->where('detail_komentar.id_komentar', $comment->id_pengajuan)
                                                                            ->get();
                                                @endphp
                                                @foreach ($dataDetailJawabanEmpat as $item)
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $item->skor_penyelia }}">
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($getKomentar5 as $itemKomentar5)
                                <div class="row form-group sub">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar5->komentar }}">
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
        <hr>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">Komentar</label>
            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                <div class="d-flex justify-content-end">
                    <div style="width: 20px">
                        :
                    </div>
                </div>
            </label>
            <div class="col-sm-7">
                <input type="hidden" name="id_pengajuan" id="" value="{{ $dataUmum->id }}">
                <textarea name="komentar" class="form-control" id="" cols="5" rows="3" placeholder="Masukkan Komentar"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
    </form>
</div>


@endsection
