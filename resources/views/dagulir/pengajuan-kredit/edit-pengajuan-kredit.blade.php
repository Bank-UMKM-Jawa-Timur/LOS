@include('components.new.modal.loading')
@extends('layouts.tailwind-template')
@section('modal')
@include('dagulir.modal.file-preview')
@endsection
@php
$status = ['belum menikah', 'menikah', 'duda', 'janda'];

$sectors = ['perdagangan', 'perindustrian', 'dll'];

function rupiah($angka)
{
if ($angka != null || $angka != '') {
    $hasil_rupiah = number_format($angka, 0, ',', '.');
return $hasil_rupiah;
}
}
$skema = 'Dagulir';
$dataIndex = match ($skema) {
    'PKPJ' => 1,
    'KKB' => 2,
    'Talangan Umroh' => 1,
    'Prokesra' => 1,
    'Kusuma' => 1,
    'Dagulir' => 1,
    null => 1,
};
@endphp

@section('content')

<section class="">
    <nav class="w-full bg-white p-3  top-[4rem] border sticky">
        <div class="owl-carousel owl-theme tab-wrapper">
            <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold">
                <span class="percentage">0%</span> Data Umum
            </button>
            @foreach ($dataAspek as $item)
                @php
                    $title = str_replace('&', 'dan', strtolower($item->nama));
                    $title = str_replace(' ', '-', strtolower($title));
                @endphp
                <button data-toggle="tab" data-tab="{{$title}}" class="btn btn-tab font-semibold"><span class="percentage">0%</span> {{$item->nama}}</button>
            @endforeach
            <button data-toggle="tab" data-tab="pendapat-dan-usulan" class="btn btn-tab font-semibold">Pendapat dan Usulan</button>
        </div>
    </nav>
    <div class="p-3">
        <div class="body-pages">
            <form action="{{ route('dagulir.pengajuan.update', $dataPengajuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @foreach ($dataDetailJawaban as $itemId)
                    <input type="hidden" name="id[]" value="{{ $itemId->id }}">
                @endforeach
                <div class="mt-3 container mx-auto">
                    <div id="dagulir-tab" class="is-tab-content active">
                        @include('dagulir.pengajuan.edit-dagulir', [
                            'id_pengajuan' => $dataPengajuan->id,
                            'data' => $dataPengajuan->dagulir,
                            'jawabanSlik' => $jawabanSlik,
                            'jawabanLaporanSlik' => $jawabanLaporanSlik
                        ])
                    </div>
                    @foreach ($dataAspek as $key => $value)
                        @php
                            $title_id = str_replace('&', 'dan', strtolower($value->nama));
                            $title_id = str_replace(' ', '-', strtolower($title_id));
                            $title_tab = "$title_id-tab";
                            $key += $dataIndex;
                        @endphp

                        <div id="{{ $title_tab }}" class="is-tab-content">
                            <div class="pb-10 space-y-3">
                                <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">{{$value->nama}}</h2>
                            </div>
                            <div class="self-start bg-white w-full border">
                                <div
                                    class="p-5 w-full space-y-5"
                                    id="{{$title_id}}">
                                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                    @foreach ($value->dataLevelDua as $item)
                                        @php
                                            $idLevelDua = str_replace(' ', '_', strtolower($item->nama));
                                        @endphp
                                        {{-- item ijin usaha --}}

                                        @if ($item->nama == 'Ijin Usaha')
                                            <div class="input-box">
                                                <label for="">{{ $item->nama }}</label>
                                                <select name="ijin_usaha" id="ijin_usaha" class="form-input">
                                                    <option value="" {{old('ijin_usaha', $item->jawaban ? $item->jawaban->opsi_text : '') == '' ? 'selected' : ''}}>-- Pilih Ijin Usaha --</option>
                                                    <option value="nib" {{old('ijin_usaha', $item->jawaban ? $item->jawaban->opsi_text : '') == 'nib' ? 'selected' : ''}}>NIB</option>
                                                    <option value="surat_keterangan_usaha" {{old('ijin_usaha', $item->jawaban ? $item->jawaban->opsi_text : '') == 'surat_keterangan_usaha' ? 'selected' : ''}}>Surat Keterangan Usaha</option>
                                                    <option value="tidak_ada_legalitas_usaha" {{old('ijin_usaha', $item->jawaban ? $item->jawaban->opsi_text : '') == 'tidak_ada_legalitas_usaha' ? 'selected' : ''}}>Tidak Ada Legalitas Usaha</option>
                                                </select>
                                            </div>
                                            <div>
                                                <div class="input-box" id="npwpsku" @if ($item->jawaban->opsi_text != 'nib') style="display:none;" @endif>
                                                    <label for="">NPWP</label>
                                                    <br>
                                                    <div class="flex gap-2 rounded p-2 w-full">
                                                        <input
                                                            type="checkbox"
                                                            name="form-input"
                                                            class="form-check cursor-pointer"
                                                            id="isNpwp"
                                                            @if($itemNPWP->jawaban) checked @endif
                                                        />
                                                        <label
                                                            for="isNpwp"
                                                            class="font-semibold cursor-pointer text-theme-text"
                                                            >Memiliki NPWP</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-box" id="nib">
                                                <label for="">NIB</label>
                                                <input type="hidden" name="id_level[77]" value="77" id="nib_id">
                                                <input type="hidden" name="opsi_jawaban[77]" value="input text" id="nib_opsi_jawaban">
                                                <input type="text" maxlength="255" name="informasi[77]" id="nib_text"
                                                    placeholder="Masukkan informasi" class="form-input" value="{{old('informasi[77]', $itemNIBTeks?->jawaban ? $itemNIBTeks?->jawaban->opsi_text : '')}}" @if($item->jawaban->opsi_text != 'nib') disabled @endif>
                                                <input type="hidden"name="id_text[]" id="id_nib_text" value="77">
                                                <input type="hidden" name="skor_penyelia_text[]"
                                                    value="{{ $itemNIBTeks?->jawaban ? $itemNIBTeks?->jawaban->skor_penyelia : '' }}">
                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemNIBTeks?->jawaban ? $itemNIBTeks?->jawaban->id_jawaban : '' }}">
                                                <input type="hidden" name="id_jawaban_text[]" id="id_jawaban_nib"
                                                    value="{{ $itemNIBTeks?->jawaban ? $itemNIBTeks?->jawaban->id_jawaban : '' }}">
                                            </div>
                                            <div class="input-box" id="docNIB">
                                                <label for="">{{ $itemNIB?->nama }}</label>
                                                @if ($itemNIB)
                                                    @if ($itemNIB->jawaban)
                                                        <a class="text-theme-primary underline underline-offset-4 cursor-pointer btn-file-preview"
                                                            data-title="Foto Nasabah" data-filepath="{{asset('../upload')}}/{{$dataPengajuan->id}}/{{$itemNIB?->id}}/{{$itemNIB?->jawaban->opsi_text}}">Preview</a>
                                                    @endif
                                                @endif
                                                <input type="hidden" name="id_item_file[{{ $itemNIB?->id }}]" value="{{ $itemNIB?->id }}"
                                                    id="docNIB_id">
                                                @php
                                                    $nib_jawaban = '';
                                                    if ($itemNIB != null) {
                                                        if ($itemNIB->jawaban != null) {
                                                            $nib_jawaban = $itemNIB->jawaban->opsi_text;
                                                        }
                                                    }
                                                @endphp
                                                <input type="file" name="upload_file[{{ $itemNIB?->id }}]" data-id=""
                                                    placeholder="Masukkan informasi {{ $itemNIB?->nama }}" class="form-input limit-size"
                                                    id="file_nib" value="{{old('upload_file['.$itemNIB?->id.']', $nib_jawaban)}}" @if($item->jawaban->opsi_text != 'nib') disabled @endif>
                                                <span class="text-red-500 m-0" style="display: none" id="docNIB_text">Besaran file
                                                    tidak boleh lebih dari 5 MB</span>
                                                @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('dataLevelTiga.' . $key) }}
                                                    </div>
                                                @endif
                                                <span class="filename" style="display: inline;"></span>
                                            </div>
                                            <div class="form-group" id="surat_keterangan_usaha">
                                                <div class="input-box">
                                                    <label for="">Surat Keterangan Usaha</label>
                                                    <input type="hidden" name="id_level[78]" value="78" id="surat_keterangan_usaha_id">
                                                    <input type="hidden" name="opsi_jawaban[78]" value="input text"
                                                        id="surat_keterangan_usaha_opsi_jawaban">
                                                    <input type="text" maxlength="255" name="informasi[78]" id="surat_keterangan_usaha_text"
                                                        placeholder="Masukkan informasi" class="form-input" value="{{old('informasi[78]', $itemSKUTeks?->jawaban ? $itemSKUTeks?->jawaban->opsi_text : '')}}">
                                                    <input type="hidden" name="skor_penyelia_text[]" id="surat_keterangan_usaha_text"
                                                        value="{{ $itemSKUTeks?->jawaban ? $itemSKUTeks?->jawaban->skor_penyelia : null }}">
                                                    <input type="hidden" name="id_text[]" id="id_surat_keterangan_usaha_text"
                                                        value="78">
                                                    <input type="hidden" name="id_jawaban_text[]" id="id_jawaban_sku"
                                                        value="{{ $itemSKUTeks?->jawaban ? $itemSKUTeks?->jawaban->id_jawaban : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group" id="docSKU">
                                                <div class="input-box">
                                                    <label for="">{{ $itemSKU?->nama }}</label>
                                                    @if ($itemSKU)
                                                        @if ($itemSKU->jawaban)
                                                            <a class="text-theme-primary underline underline-offset-4 cursor-pointer btn-file-preview"
                                                                data-title="Foto Nasabah" data-filepath="{{asset('../upload')}}/{{$dataPengajuan->id}}/{{$itemSKU?->id}}/{{$itemSKU?->jawaban->opsi_text}}">Preview</a>
                                                        @endif
                                                    @endif
                                                    <input type="hidden" name="id_item_file[{{ $itemSKU?->id }}]" value="{{ $itemSKU?->id }}"
                                                        id="docSKU_id">
                                                    @php
                                                        $sku_jawaban = '';
                                                        if ($itemSKU != null) {
                                                            if ($itemSKU->jawaban != null) {
                                                                $sku_jawaban = $itemSKU->jawaban->opsi_text;
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="file" name="upload_file[{{ $itemSKU?->id }}]" id="surat_keterangan_usaha_file"
                                                        data-id="" placeholder="Masukkan informasi {{ $itemSKU?->nama }}"
                                                        class="form-input limit-size" value="{{old('upload_file['.$itemSKU?->id.']', $sku_jawaban)}}">
                                                    <span class="text-red-500 m-0" style="display: none" id="docSKU_text">Besaran file
                                                        tidak boleh lebih dari 5 MB</span>
                                                    @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('dataLevelTiga.' . $key) }}
                                                        </div>
                                                    @endif
                                                    <span class="filename" style="display: inline;"></span>
                                                    <input type="hidden" id="id_update_sku" id="id_update_sku" name="id_update_file[]"
                                                        value="{{ $itemSKU?->jawaban ? $itemSKU?->jawaban->id : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group" id="npwp">
                                                <div class="input-box" @if($item?->jawaban->opsi_text == 'surat_keterangan_usaha' && !$itemNPWP->jawaban) style="display: none;" @endif>
                                                    <input type="hidden" name="id_text[]" value="79" id="npwp_id">
                                                    <input type="hidden" name="skor_penyelia_text[]" id="npwp_text"
                                                        value="{{ $itemNPWPTeks?->jawaban ? $itemNPWPTeks?->jawaban->skor_penyelia : '' }}">
                                                    <input type="hidden" name="id_jawaban_text[]" id="id_jawaban_npwp"
                                                        value="{{ $itemNPWPTeks?->jawaban != null ? $itemNPWPTeks?->jawaban->id_jawaban : null }}">
                                                    <label for="">NPWP</label>
                                                    <input type="hidden" name="id_level[79]" value="79" id="npwp_id">
                                                    <input type="hidden" name="opsi_jawaban[79]" value="input text" id="npwp_opsi_jawaban">
                                                    <input type="text" maxlength="20" name="informasi[79]" id="npwp_text"
                                                        placeholder="Masukkan informasi" class="form-input" value="{{old('informasi[79]', $itemNPWPTeks?->jawaban ? $itemNPWPTeks?->jawaban->opsi_text : '')}}">
                                                </div>
                                            </div>
                                            <div class="form-group" id="docNPWP">
                                                <div class="input-box" @if($item?->jawaban->opsi_text == 'surat_keterangan_usaha' && !$itemNPWP->jawaban) style="display: none;" @endif>
                                                    <label for="">{{ $itemNPWP?->nama }}</label>
                                                    <input type="hidden" name="id_file_text[]" value="153" id="docNPWP_id">
                                                    <input type="hidden" name="id_item_file[{{ $itemNPWP?->id }}]" value="{{ $itemNPWP?->id }}"
                                                        id="docNPWP_id">
                                                    @php
                                                        $npwp_jawaban = '';
                                                        if($item->jawaban->opsi_text == 'surat_keterangan_usaha') {
                                                            if ($itemNPWP) {
                                                                if ($itemNPWP->jawaban != null) {
                                                                    $npwp_jawaban = $itemNPWP->jawaban->opsi_text;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    <input type="file" name="upload_file[{{ $itemNPWP?->id }}]" id="npwp_file" data-id=""
                                                        placeholder="Masukkan informasi {{ $itemNPWP?->nama }}" class="form-input limit-size"
                                                        value="{{old('upload_file['.$itemNPWP?->id.']', $npwp_jawaban)}}">
                                                    <span class="text-red-500 m-0" style="display: none" id="docNPWP_text">Besaran file
                                                        tidak boleh lebih dari 5 MB</span>
                                                    @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('dataLevelTiga.' . $key) }}
                                                        </div>
                                                    @endif
                                                    <span class="filename" style="display: inline;"></span>
                                                </div>
                                            </div>
                                        @elseif ($item->id == 79)
                                        @else
                                            @if ($item->opsi_jawaban == 'input text')
                                                <div class="form-group">
                                                    <div class="input-box">
                                                        <label for="">{{ $item->nama }}</label>
                                                        <div class="flex items-center">
                                                            <div class="flex-1">
                                                                <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                                    value="{{ $item->opsi_jawaban }}" id="">
                                                                <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                                    id="">
                                                                <input type="text" maxlength="255" name="informasi[{{ $item->id }}]"
                                                                    id="{{ $idLevelDua }}" placeholder="Masukkan informasi {{ $item->nama }}"
                                                                    value="{{old('informasi['.$item->id.']', $item->jawaban ? $item->jawaban->opsi_text : '')}}"
                                                                    class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}" >
                                                                <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                                <input type="hidden" name="skor_penyelia_text[]"
                                                                    value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                            </div>
                                                            @if ($item->suffix)
                                                                <div class="flex-shrink-0  mt-2.5rem">
                                                                    <span class="form-input bg-gray-100">{{$item->suffix}}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->opsi_jawaban == 'number')
                                                @if ($item->nama == 'Repayment Capacity')
                                                    <div class="form-group">
                                                        <div class="input-box">
                                                            <label for="">{{ $item->nama }}</label>
                                                            <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                                value="{{ $item->opsi_jawaban }}" id="">
                                                            <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                                id="">
                                                            <input type="text" maxlength="255" name="informasi[{{ $item->id }}]"
                                                                id="{{ $idLevelDua }}" placeholder="Masukkan informasi {{ $item->nama }}"
                                                                class="form-input" value="{{old('informasi['.$item->id.']', $item->jawaban->opsi_text)}}">
                                                            <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                            <input type="hidden" name="skor_penyelia_text[]"
                                                                value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                            <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                        </div>
                                                    </div>
                                                @else
                                                    @if ($item->nama == 'Omzet Penjualan' || $item->nama == 'Installment')
                                                        <div class="form-group">
                                                            <div class="input-box">
                                                                <label for="">{{ $item->nama }}(Perbulan)</label>
                                                                <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                                    value="{{ $item->opsi_jawaban }}" id="">
                                                                <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                                    id="">
                                                                <input type="text" maxlength="255" step="any"
                                                                    name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                                    placeholder="Masukkan informasi {{ $item->nama }}" class="form-input rupiah"
                                                                    value="{{old('informasi['.$item->id.']', $item->jawaban->opsi_text)}}">
                                                                <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                                <input type="hidden" name="skor_penyelia_text[]"
                                                                    value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <div class="input-box">
                                                                <label for="">{{ $item->nama }}</label>
                                                                <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                                    value="{{ $item->opsi_jawaban }}" id="">
                                                                <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                                    id="">
                                                                <input type="text" maxlength="255" step="any"
                                                                    name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                                    placeholder="Masukkan informasi {{ $item->nama }}" class="form-input rupiah"
                                                                    value="{{old('informasi['.$item->id.']', $item->jawaban->opsi_text)}}">
                                                                <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                                <input type="hidden" name="skor_penyelia_text[]"
                                                                    value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @elseif ($item->opsi_jawaban == 'persen')
                                                <div class="form-group">
                                                    <div class="input-box">
                                                        <label for="">{{ $item->nama }}</label>
                                                        <div class="flex items-center">
                                                            <div class="flex-1">
                                                                <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                                    value="{{ $item->opsi_jawaban }}" id="">
                                                                <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                                    id="">
                                                                <input type="number" step="any" name="informasi[{{ $item->id }}]"
                                                                    id="{{ $idLevelDua }}" placeholder="Masukkan informasi {{ $item->nama }}"
                                                                    class="form-input" aria-label="Recipient's username" aria-describedby="basic-addon2"
                                                                    value="{{old('informasi['.$item->id.']', $item->jawaban->opsi_text)}}" onkeydown="return event.keyCode !== 69">
                                                                <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                                <input type="hidden" name="skor_penyelia_text[]"
                                                                    value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                            </div>
                                                            @if ($item->suffix)
                                                                <div class="flex-shrink-0  mt-2.5rem">
                                                                    <span class="form-input bg-gray-100">{{$item->suffix}}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($item->opsi_jawaban == 'file')
                                                <div class="form-group">
                                                    <div class="input-box">
                                                        <label for="">
                                                            {{ $item->nama }}
                                                        </label>
                                                        <input type="hidden" name="id_file_text[]"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="skor_penyelia_text[]"
                                                            value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                        <input type="hidden" name="id_update_file[]"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="id_item_file[{{ $item->id }}]" value="{{ $item->id }}"
                                                            id="">
                                                        <input type="file" name="upload_file[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                            data-id="" placeholder="Masukkan informasi {{ $item->nama }}"
                                                            class="form-input limit-size" value="{{old('upload_file['.$item->id.']', $item->jawaban->opsi_text)}}">
                                                            {{-- class="form-input limit-size" value=""> --}}
                                                        <span class="text-red-500 m-0" style="display: none">Maximum upload file size is 15
                                                            MB</span>
                                                        <span class="filename" style="display: inline;"></span>
                                                    </div>
                                                </div>
                                            @elseif ($item->opsi_jawaban == 'long text')
                                                <div class="form-group">
                                                    <div class="input-box">
                                                        <label for="">{{ $item->nama }}</label>
                                                        <input type="hidden" name="id_text[]" value="{{ $item->id }}">
                                                        <input type="hidden" name="skor_penyelia_text[]"
                                                            value="{{ $item->jawaban ? $item->jawaban->skor_penyelia : '' }}">
                                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $item->jawaban ? $item->jawaban->id_jawaban : '' }}">
                                                        <input type="hidden" name="opsi_jawaban[{{ $item->id }}]"
                                                            value="{{ $item->opsi_jawaban }}" id="">
                                                        <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}"
                                                            id="">
                                                        <textarea name="informasi[{{ $item->id }}]" rows="4" id="{{ $idLevelDua }}" maxlength="255"
                                                            class="form-input" placeholder="Masukkan informasi {{ $item->nama }}">{{old('informasi['.$item->id.']', $item->jawaban->opsi_text)}}</textarea>
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($item->dataOption as $itemOption)
                                                @if ($itemOption->option == '-')
                                                    <div class="form-group-1 col-span-2">
                                                        <div>
                                                            <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                                                                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                                                    {{$item->nama}} :
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            @if (count($item->dataJawaban) != 0)
                                                <div
                                                    class="{{ $idLevelDua == 'persentase_kebutuhan_kredit_opsi' || $idLevelDua == 'repayment_capacity_opsi' ? 'hidden' : 'form-group' }}">
                                                    <div class="input-box">
                                                        <label for="" id="{{ $idLevelDua . '_label' }}">{{ $item->nama }}</label>

                                                        <select name="dataLevelDua[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                            class="form-select cek-sub-column" data-id_item={{ $item->id }}>
                                                            <option value=""> --Pilih Opsi-- </option>
                                                            @foreach ($item->dataJawaban as $key => $itemJawaban)
                                                                <option id="{{ $idLevelDua . '_' . $key }}"
                                                                    value="{{ ($itemJawaban->skor == null ? 'kosong' : $itemJawaban->skor) . '-' . $itemJawaban->id }}"
                                                                    {{$itemJawaban->jawaban ? 'selected' : ''}}>
                                                                    {{ $itemJawaban->option }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="item{{ $item->id }}">

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($item->dataLevelTiga as $keyTiga => $itemTiga)
                                                @php
                                                    $idLevelTiga = str_replace(' ', '_', strtolower($itemTiga->nama));
                                                @endphp
                                                @if ($itemTiga->nama == 'Kategori Jaminan Utama')
                                                @elseif ($itemTiga->nama == 'Kategori Jaminan Tambahan')
                                                    <div class="form-group ">
                                                        <div class="input-box">
                                                            <label for="">{{ $itemTiga->nama }}</label>
                                                            @php
                                                                $kategori_jawaban = ucwords(str_replace('_', ' ', $itemTiga->jawaban->opsi_text));
                                                            @endphp
                                                            <input type="hidden" name="id_kategori_jaminan_tambahan"
                                                                value="{{ $itemTiga?->id ?? null }}">
                                                            <select name="kategori_jaminan_tambahan" id="kategori_jaminan_tambahan" class="form-input">
                                                                <option value="" {{old('kategori_jaminan_tambahan') == '' ? 'selected' : ''}}>-- Pilih Kategori Jaminan Tambahan --</option>
                                                                <option value="Tidak Memiliki Jaminan Tambahan" {{old('kategori_jaminan_tambahan', $itemTiga->jawaban ? $kategori_jawaban : '') == 'Tidak Memiliki Jaminan Tambahan' ? 'selected' : ''}}>Tidak Memiliki Jaminan Tambahan
                                                                </option>
                                                                <option value="Tanah" {{old('kategori_jaminan_tambahan', $itemTiga->jawaban ? $kategori_jawaban : '') == 'Tanah' ? 'selected' : ''}}>Tanah</option>
                                                                <option value="Kendaraan Bermotor" {{old('kategori_jaminan_tambahan', $itemTiga->jawaban ? $kategori_jawaban : '') == 'Kendaraan Bermotor' ? 'selected' : ''}}>Kendaraan Bermotor</option>
                                                                <option value="Tanah dan Bangunan" {{old('kategori_jaminan_tambahan', $itemTiga->jawaban ? $kategori_jawaban : '') == 'Tanah dan Bangunan' ? 'selected' : ''}}>Tanah dan Bangunan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="select_kategori_jaminan_tambahan"></div>
                                                @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Utama')
                                                @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Tambahan')
                                                    <div class="form-group-1 col-span-2" id="jaminan_tambahan">
                                                        <div>
                                                            <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                                                                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                                                    {{$itemTiga->nama}} :
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="bukti_pemilikan_jaminan_tambahan" class="form-group-1 row col-span-2 grid grid-cols-2">

                                                    </div>
                                                @else
                                                    @if ($itemTiga->opsi_jawaban == 'input text')
                                                        <div class="form-group">
                                                            <div class="input-box">
                                                                <label for="">{{ $itemTiga->nama }}</label>
                                                                <div class="flex items-center">
                                                                    <div class="flex-1">
                                                                        <input type="hidden" name="id_text[]" value="{{ $itemTiga->id }}">
                                                                        <input type="hidden" name="skor_penyelia_text[]"
                                                                            value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->skor_penyelia : '' }}">
                                                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->id_jawaban : '' }}">
                                                                        <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}"
                                                                            id="">
                                                                        <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                                            value="{{ $itemTiga->opsi_jawaban }}" id="">
                                                                        <input type="text" maxlength="255" name="informasi[{{ $itemTiga->id }}]"
                                                                            placeholder="Masukkan informasi" id="{{ $idLevelTiga }}"
                                                                            value="{{old('informasi['.$itemTiga->id.']', $itemTiga->jawaban->opsi_text)}}" class="form-input {{$itemTiga->is_rupiah ? 'rupiah' : ''}}">
                                                                    </div>
                                                                    @if ($itemTiga->suffix)
                                                                        <div class="flex-shrink-0 mt-2.5rem">
                                                                            <span class="form-input bg-gray-100">{{$itemTiga->suffix}}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif ($itemTiga->opsi_jawaban == 'number')
                                                        <div class="form-group">
                                                            <div class="input-box">
                                                                <label for="">{{ $itemTiga->nama }}</label>
                                                                <div class="flex items-center">
                                                                    <div class="flex-1">
                                                                        <input type="hidden" name="id_text[]" value="{{ $itemTiga->id }}">
                                                                        <input type="hidden" name="skor_penyelia_text[]"
                                                                            value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->skor_penyelia : '' }}">
                                                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->id_jawaban : '' }}">
                                                                        <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                                            value="{{ $itemTiga->opsi_jawaban }}" id="">
                                                                        <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}"
                                                                            id="">
                                                                        <input type="text" step="any" name="informasi[{{ $itemTiga->id }}]"
                                                                            id="{{ $idLevelTiga }}" placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                                            class="form-input {{$itemTiga->is_rupiah ? 'rupiah' : ''}}" value="{{old('informasi['.$itemTiga->id.']', $itemTiga->jawaban->opsi_text)}}">
                                                                    </div>
                                                                    @if ($itemTiga->suffix)
                                                                        <div class="flex-shrink-0 mt-2.5rem">
                                                                            <span class="form-input bg-gray-100">{{$itemTiga->suffix}}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif ($itemTiga->opsi_jawaban == 'persen')
                                                        <div class="form-group">
                                                            @if ($itemTiga->nama == 'Ratio Tenor Asuransi')
                                                            @else
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemTiga->nama }}</label>
                                                                    <div class="flex items-center">
                                                                        <div class="flex-1">
                                                                            <input type="hidden" name="id_text[]" value="{{ $itemTiga->id }}">
                                                                            <input type="hidden" name="skor_penyelia_text[]"
                                                                                value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->skor_penyelia : '' }}">
                                                                            <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->id_jawaban : '' }}">
                                                                            <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                                                value="{{ $itemTiga->opsi_jawaban }}" id="">
                                                                            <input type="hidden" name="id_level[{{ $itemTiga->id }}]"
                                                                                value="{{ $itemTiga->id }}" id="">
                                                                                <input type="number" step="any" name="informasi[{{ $itemTiga->id }}]"
                                                                                    id="{{ $idLevelTiga }}"
                                                                                    placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                                                    class="form-input {{$itemTiga->readonly ? 'bg-gray-100' : ''}}"
                                                                                    value="{{old('informasi['.$itemTiga->id.']', $itemTiga->jawaban->opsi_text)}}">
                                                                        </div>
                                                                        @if ($itemTiga->suffix)
                                                                            <div class="flex-shrink-0 mt-2.5rem">
                                                                                <span class="form-input bg-gray-100">{{$itemTiga->suffix}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @elseif ($itemTiga->opsi_jawaban == 'file')
                                                        <div class="form-group file-wrapper item-{{ $itemTiga->id }}">
                                                            <div class="input-box">
                                                                <label for="">{{ $itemTiga->nama }}</label>
                                                                <div class="input-box mb-4">
                                                                    <div class="flex gap-4">
                                                                        <input type="hidden" name="id_file_text[]"
                                                                            value="{{ $itemTiga->id }}">
                                                                        <input type="hidden" name="skor_penyelia_text[]"
                                                                            value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->skor_penyelia : '' }}">
                                                                        <input type="hidden" name="id_item_file[{{ $itemTiga->id }}][]"
                                                                            value="{{ $itemTiga->id }}" id="">
                                                                        <input type="file" name="upload_file[{{ $itemTiga->id }}][]"
                                                                            id="{{ $idLevelTiga }}" data-id=""
                                                                            placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                                            class="form-input limit-size file-usaha" accept="image/*"
                                                                            value="{{old('upload_file['.$itemTiga->id.']', $itemTiga->jawaban->opsi_text)}}">
                                                                            {{-- value=""> --}}
                                                                        <span class="text-red-500 m-0" style="display: none">Maximum upload
                                                                            file size is 15 MB</span>
                                                                        <span class="filename" style="display: inline;"></span>
                                                                        @if ($itemTiga->is_multiple)
                                                                            <div class="flex gap-2 multiple-action">
                                                                                <button type="button" class="btn-add" data-item-id="{{$itemTiga->id}}-{{strtolower(str_replace(' ', '_', $itemTiga->nama))}}">
                                                                                    <iconify-icon icon="fluent:add-16-filled" class="mt-2"></iconify-icon>
                                                                                </button>
                                                                                <button type="button" class="btn-minus hidden" data-item-id="{{$itemTiga->id}}-{{strtolower(str_replace(' ', '_', $itemTiga->nama))}}">
                                                                                    <iconify-icon icon="lucide:minus" class="mt-2"></iconify-icon>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @elseif ($itemTiga->opsi_jawaban == 'long text')
                                                        <div class="form-group">
                                                            <div class="input-box">
                                                                <label for="">{{ $itemTiga->nama }}</label>
                                                                <input type="hidden" name="id_text[]" value="{{ $itemTiga->id }}">
                                                                <input type="hidden" name="skor_penyelia_text[]"
                                                                    value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->skor_penyelia : '' }}">
                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTiga->jawaban ? $itemTiga->jawaban->id_jawaban : '' }}">
                                                                <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                                    value="{{ $itemTiga->opsi_jawaban }}" id="">
                                                                <input type="hidden" name="id_level[{{ $itemTiga->id }}]"
                                                                    value="{{ $itemTiga->id }}" id="">
                                                                <textarea name="informasi[{{ $itemTiga->id }}]" rows="4" id="{{ $idLevelTiga }}" maxlength="255"
                                                                    class="form-input" placeholder="Masukkan informasi {{ $itemTiga->nama }}">{{old('informasi['.$itemTiga->id.']', $itemTiga->jawaban->opsi_text)}}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @foreach ($itemTiga->dataOptionTiga as $itemOptionTiga)
                                                        @if ($itemOptionTiga->option == '-')
                                                            <div class="form-group-1 col-span-2">
                                                                <div>
                                                                    <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                                                                        <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                                                            {{$itemTiga->nama}} :
                                                                        </h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if (count($itemTiga->dataJawabanLevelTiga) != 0)
                                                        @if ($itemTiga->nama != 'Pengikatan Jaminan Utama')
                                                            <div
                                                                class="{{ $idLevelTiga == 'ratio_tenor_asuransi_opsi' || $idLevelTiga == 'ratio_coverage_opsi' ? '' : 'form-group' }}">
                                                                <div class="input-box">
                                                                    <label for=""
                                                                        id="{{ $idLevelTiga . '_label' }}">{{ $itemTiga->nama }}</label>

                                                                    <select name="dataLevelTiga[{{ $itemTiga->id }}]" id="{{ $idLevelTiga }}"
                                                                        class="form-input cek-sub-column" data-id_item={{ $itemTiga->id }}>
                                                                        <option value=""> --Pilih Opsi-- </option>
                                                                        @foreach ($itemTiga->dataJawabanLevelTiga as $key => $itemJawabanTiga)
                                                                            <option id="{{ $idLevelTiga . '_' . $key }}"
                                                                                value="{{ ($itemJawabanTiga->skor == null ? 'kosong' : $itemJawabanTiga->skor) . '-' . $itemJawabanTiga->id }}"
                                                                                {{old('informasi['.$itemTiga->id.']', $itemJawabanTiga->jawaban ? $itemJawabanTiga->jawaban->skor : '') == $itemJawabanTiga->skor ? 'selected' : ''}}>
                                                                                {{ $itemJawabanTiga->option }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="item{{ $itemTiga->id }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif

                                                    @foreach ($itemTiga->dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                        @php
                                                            $idLevelEmpat = str_replace(' ', '_', strtolower($itemEmpat->nama));
                                                        @endphp

                                                        @if ($itemEmpat->opsi_jawaban == 'input text')
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <input type="hidden" name="id_text[]" value="{{ $itemEmpat->id }}">
                                                                    <input type="hidden" name="skor_penyelia_text[]"
                                                                        value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->skor_penyelia : '' }}">
                                                                    <input type="hidden" name="id_jawaban_text[]" value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->id_jawaban : '' }}">
                                                                    <input type="hidden" name="id_level[{{ $itemEmpat->id }}]"
                                                                        value="{{ $itemEmpat->id }}" id="">
                                                                    <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                                        value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                                    @if ($itemEmpat->nama == 'Masa Berlaku Asuransi Penjaminan')
                                                                        <div class="input-group">
                                                                            <input type="text" maxlength="255"
                                                                                name="informasi[{{ $itemEmpat->id }}]"
                                                                                id="{{ $idLevelEmpat == 'nilai_asuransi_penjaminan_/_ht' ? '' : $idLevelEmpat }}"
                                                                                placeholder="Masukkan informasi"
                                                                                class="form-input only-number"
                                                                                value="{{old('informasi['.$itemEmpat->id.']', $itemEmpat->jawaban->opsi_text)}}">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text" id="addon_tenor_yang_diminta">
                                                                                    Bulan</div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        @php
                                                                            $jawaban = '';
                                                                            if ($itemEmpat) {
                                                                                if ($itemEmpat->jawaban) {
                                                                                    $jawaban = $itemEmpat->jawaban->opsi_text;
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <input type="text" maxlength="255" name="informasi[{{ $itemEmpat->id }}]"
                                                                            id="{{ $idLevelEmpat == 'nilai_asuransi_penjaminan_/_ht' ? '' : $idLevelEmpat }}"
                                                                            placeholder="Masukkan informasi" value="{{old('informasi['.$itemEmpat->id.']', $jawaban)}}"
                                                                            class="form-input  {{$itemEmpat->is_rupiah ? 'rupiah' : ''}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @elseif ($itemEmpat->opsi_jawaban == 'number')
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <div class="flex items-center">
                                                                        <div class="flex-1">
                                                                            <input type="hidden" name="id_text[]" value="{{ $itemEmpat->id }}">
                                                                            <input type="hidden" name="skor_penyelia_text[]"
                                                                                value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->skor_penyelia : '' }}">
                                                                            <input type="hidden" name="id_jawaban_text[]" value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->id_jawaban : '' }}">
                                                                            <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                                                value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                                            <input type="hidden" name="id_level[{{ $itemEmpat->id }}]"
                                                                                value="{{ $itemEmpat->id }}" id="">
                                                                            @php
                                                                                $jawaban = '';
                                                                                if ($itemEmpat) {
                                                                                    if ($itemEmpat->jawaban) {
                                                                                        $jawaban = $itemEmpat->jawaban->opsi_text;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="text" step="any" name="informasi[{{ $itemEmpat->id }}]"
                                                                                id="{{ $idLevelEmpat == 'nilai_asuransi_penjaminan_/_ht' ? 'nilai_asuransi_penjaminan' : $idLevelEmpat }}"
                                                                                placeholder="Masukkan informasi {{ $itemEmpat->nama }}"
                                                                                class="form-input only-number" value="{{old('informasi['.$itemEmpat->id.']', $jawaban)}}">
                                                                        </div>
                                                                        @if ($itemEmpat->suffix)
                                                                            <div class="flex-shrink-0 mt-2.5rem">
                                                                                <span class="form-input bg-gray-100">{{$itemEmpat->suffix}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif ($itemEmpat->opsi_jawaban == 'persen')
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <div class="flex items-center">
                                                                        <div class="flex-1">
                                                                            <input type="hidden" name="id_text[]" value="{{ $itemEmpat->id }}">
                                                                            <input type="hidden" name="skor_penyelia_text[]"
                                                                                value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->skor_penyelia : '' }}">
                                                                            <input type="hidden" name="id_jawaban_text[]" value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->id_jawaban : '' }}">
                                                                            <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                                                value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                                            <input type="hidden" name="id_level[{{ $itemEmpat->id }}]"
                                                                                value="{{ $itemEmpat->id }}" id="">
                                                                            <input type="number" step="any" name="informasi[{{ $itemEmpat->id }}]"
                                                                                id="{{ $idLevelEmpat }}"
                                                                                placeholder="Masukkan informasi {{ $itemEmpat->nama }}" class="form-input"
                                                                                aria-label="Recipient's username" aria-describedby="basic-addon2"
                                                                                value="{{old('informasi['.$itemEmpat->id.']', $itemEmpat->jawaban->opsi_text)}}">
                                                                        </div>
                                                                        @if ($itemEmpat->suffix)
                                                                            <div class="flex-shrink-0 mt-2.5rem">
                                                                                <span class="form-input bg-gray-100">{{$itemEmpat->suffix}}</span>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif ($itemEmpat->opsi_jawaban == 'file')
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <input type="hidden" name="id_file_text[]" value="{{ $itemEmpat->id }}">
                                                                    <input type="hidden" name="skor_penyelia_text[]"
                                                                        value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->skor_penyelia : '' }}">
                                                                    <input type="hidden" name="id_update_file[]"
                                                                        value="{{ $itemTextTiga->id }}">
                                                                    <input type="hidden" name="id_item_file[{{ $itemEmpat->id }}]"
                                                                        value="{{ $itemEmpat->id }}" id="">
                                                                    <input type="file" id="{{ $idLevelEmpat }}"
                                                                        name="upload_file[{{ $itemEmpat->id }}]" data-id=""
                                                                        placeholder="Masukkan informasi {{ $itemEmpat->nama }}"
                                                                        class="form-input limit-size"
                                                                        value="{{old('upload_file['.$itemEmpat->id.']', $itemEmpat->jawaban->opsi_text)}}">
                                                                    <span class="text-red-500 m-0" style="display: none">Maximum upload file
                                                                        size is 5 MB</span>
                                                                    <span class="filename" style="display: inline;"></span>
                                                                </div>
                                                            </div>
                                                        @elseif ($itemEmpat->opsi_jawaban == 'long text')
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <input type="hidden" name="id_text[]" value="{{ $itemEmpat->id }}">
                                                                    <input type="hidden" name="skor_penyelia_text[]"
                                                                        value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->skor_penyelia : '' }}">
                                                                    <input type="hidden" name="id_jawaban_text[]" value="{{ $itemEmpat->jawaban ? $itemEmpat->jawaban->id_jawaban : '' }}">
                                                                    <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                                        value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                                    <input type="hidden" name="id_level[{{ $itemEmpat->id }}]"
                                                                        value="{{ $itemEmpat->id }}" id="">
                                                                    <textarea name="informasi[{{ $itemEmpat->id }}]" rows="4" id="{{ $idLevelEmpat }}" maxlength="255"
                                                                        class="form-input" placeholder="Masukkan informasi {{ $itemEmpat->nama }}">{{old('informasi['.$itemEmpat->id.']', $itemEmpat->jawaban->opsi_text)}}</textarea>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($itemEmpat)
                                                            @if ($itemEmpat->dataOptionEmpat)
                                                                @foreach ($itemEmpat->dataOptionEmpat as $itemOptionEmpat)
                                                                    @if ($itemOptionEmpat->option == '-')
                                                                        <div class="form-group-1">
                                                                            <h6>{{ $itemEmpat->nama }}</h6>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif

                                                        @if (count($itemEmpat->dataJawabanLevelEmpat) != 0)
                                                            <div class="form-group">
                                                                <div class="input-box">
                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                    <select name="dataLevelEmpat[{{ $itemEmpat->id }}]" id="{{ $idLevelEmpat }}"
                                                                        class="form-input cek-sub-column" data-id_item={{ $itemEmpat->id }}>
                                                                        <option value=""> --Pilih Opsi -- </option>
                                                                        @foreach ($itemEmpat->dataJawabanLevelEmpat as $itemJawabanEmpat)
                                                                            <option id="{{ $idLevelEmpat . '_' . $key }}"
                                                                                value="{{ ($itemJawabanEmpat->skor == null ? 'kosong' : $itemJawabanEmpat->skor) . '-' . $itemJawabanEmpat->id }}"
                                                                                {{$itemJawabanEmpat->jawaban ? 'selected' : ''}}>
                                                                                {{ $itemJawabanEmpat->option }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="item{{ $itemEmpat->id }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </div>

                                    <div class="form-group-1">
                                        <hr style="border: 0.2px solid #E3E6EA;">
                                        <label for="">Pendapat dan Usulan {{ $value->nama }}</label>
                                        <input type="hidden" name="id_aspek[{{ $value->id }}]" value="{{ $value->id }}">
                                        <input type="hidden" name="id_jawaban_aspek[]" value="{{ $value->pendapat->id }}">
                                        <textarea name="pendapat_per_aspek[{{ $value->id }}]"
                                            class="form-input @error('pendapat_per_aspek') is-invalid @enderror" id="" maxlength="255"
                                            cols="30" rows="4" placeholder="Pendapat Per Aspek">{{old('pendapat_per_aspek['.$value->id.']', $value->pendapat->pendapat_per_aspek)}}</textarea>
                                        @error('pendapat_per_aspek')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="flex justify-between">
                                        <a href="{{route('dagulir.pengajuan.index')}}">
                                            <button type="button"
                                              class="px-5 py-2 border rounded bg-white text-gray-500">
                                              Kembali
                                            </button>
                                        </a>
                                        <div>
                                          <button type="button"
                                          class="px-5 prev-tab py-2 border rounded bg-theme-secondary text-white"
                                        >
                                          Sebelumnya
                                        </button>
                                        <button type="button"
                                          class="px-5 next-tab py-2 border rounded bg-theme-primary text-white"
                                        >
                                          Selanjutnya
                                        </button>
                                        <button type="submit" class="px-5 py-2 border rounded bg-green-600 text-white btn-simpan hidden" id="submit">Simpan </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="pendapat-dan-usulan-tab" class="is-tab-content">
                        <div class="pb-10 space-y-3">
                            <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Pendapat dan Usulan</h2>
                        </div>
                        <div class="self-start bg-white w-full border">
                            <div class="p-5 border-b">
                                <h2 class="font-bold text-lg tracking-tighter">
                                    Pendapat dan Usulan
                                </h2>
                            </div>
                            <!-- pendapat-dan-usulan -->
                            <div class="p-5 space-y-5">
                                <div class="form-group-1">
                                    <div class="input-box">
                                        <label for="">Pendapat dan Usulan</label>
                                        <input type="hidden" name="id_komentar_staff_text" value="{{ $pendapat?->id }}">
                                        <textarea name="komentar_staff" class="form-textarea"
                                            placeholder="Pendapat dan Usulan" id="">{{$pendapat?->komentar_staff ?? null}}</textarea>
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <a href="{{route('dagulir.pengajuan.index')}}">
                                        <button class="px-5 py-2 border rounded bg-white text-gray-500">
                                            Kembali
                                        </button>
                                    </a>
                                    <div>
                                        <button type="button" class="px-5 py-2 border rounded bg-theme-secondary text-white">
                                            Sebelumnya
                                        </button>
                                        <button class="px-5 py-2 border rounded bg-theme-primary text-white" type="submit">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('script-inject')
@include('dagulir.pengajuan-kredit.scripts.edit')
@endpush
