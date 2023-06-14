@extends('layouts.template')

@php
$status = [
    'belum menikah',
    'menikah',
    'duda',
    'janda',
];

$sectors = [
    'perdagangan',
    'perindustrian',
    'dll',
];

function rupiah($angka){
	if ($angka != null || $angka != '') {
        $hasil_rupiah = number_format($angka, 0, ",", ".");
        return $hasil_rupiah;
    }
}

$dataIndex = match ($skema) {
    'PKPJ' => 1,
    'KKB' => 2,
    'Talangan Umroh' => 1,
    'Prokesra' => 1,
    'Kusuma' => 1,
    null => 1
};
// dd($dataIndex);
@endphp

@section('content')
    @include('components.notification')
    @include('layouts.popup')
    <style>
        .form-wizard .sub label:not(.info) {
            font-weight: 400;
        }

        .form-wizard h4 {
            color: #1f1d62;
            font-weight: 600 !important;
            font-size: 20px;
            /* border-bottom: 1px solid #dc3545; */
        }

        .form-wizard h5 {
            color: #1f1d62;
            font-weight: 600 !important;
            font-size: 18px;
            /* border-bottom: 1px solid #dc3545; */
        }

        .form-wizard h6 {
            color: #c2c7cf;
            font-weight: 600 !important;
            font-size: 16px;
            /* border-bottom: 1px solid #dc3545; */
        }

        span.filename {
            position: absolute;
            top: 40px;
            left: 139px;
            background: white;
        }

        .file-wrapper span.filename {
            top: 10px;
        }
    </style>

    <form id="pengajuan_kredit" action="{{ route('tesskor.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_nasabah" value="" id="id_nasabah">
        <input type="hidden" name="progress" class="progress">

        <div class="form-wizard active" data-index='0' data-done='true' id="wizard-data-umum">
            <div class="row">
                {{-- Input hidden for Skema Kredit --}}
                <input type="hidden" name="skema_kredit" id="skema_kredit" @if($skema != null) value="{{ $skema ?? '' }}" @endif>

                <div class="form-group col-md-6">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nama sesuai dengan KTP" value=""  maxlength="255">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">{{ $itemSP->nama }}</label>
                    <input type="hidden" name="id_item_file[{{ $itemSP->id }}]" value="{{ $itemSP->id }}" id="">
                    <input type="file" name="upload_file[{{ $itemSP->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemSP->nama }}" class="form-control limit-size">
                    <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    <span class="filename" style="display: inline;"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Kabupaten</label>
                    <select name="kabupaten" class="form-control @error('name') is-invalid @enderror select2" id="kabupaten">
                        <option value="">---Pilih Kabupaten----</option>
                        @foreach ($dataKabupaten as $item)
                            <option
                                
                                value="{{ $item->id }}"
                            >{{ $item->kabupaten }}</option>
                        @endforeach
                    </select>
                    @error('kabupaten')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Kecamatan</label>
                    <select name="kec" id="kecamatan" class="form-control @error('kec') is-invalid @enderror  select2">
                        <option value="">---Pilih Kecamatan----</option>
                    </select>
                    @error('kec')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Desa</label>
                    <select name="desa" id="desa" class="form-control @error('desa') is-invalid @enderror select2">
                        <option value="">---Pilih Desa----</option>
                    </select>
                    @error('desa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Alamat Rumah</label>
                    <textarea name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror" maxlength="255" id="" cols="30" rows="4"
                        placeholder="Alamat Rumah disesuaikan dengan KTP"></textarea>
                    @error('alamat_rumah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <hr>
                </div>
                <div class="form-group col-md-12">
                    <label for="">Alamat Usaha</label>
                    <textarea name="alamat_usaha" class="form-control @error('alamat_usaha') is-invalid @enderror" maxlength="255" id="" cols="30" rows="4"
                        placeholder="Alamat Usaha"></textarea>
                    @error('alamat_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">No. KTP</label>
                    <input type="number" maxlength="16" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" id=""
                        placeholder="Masukkan 16 digit No. KTP" value="">
                    @error('no_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">{{ $itemKTPSu->nama }}</label>
                    <input type="hidden" name="id_item_file[{{ $itemKTPSu->id }}]" value="{{ $itemKTPSu->id }}" id="">
                    <input type="file" name="upload_file[{{ $itemKTPSu->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemKTPSu->nama }}" class="form-control limit-size">
                    <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    <span class="filename" style="display: inline;"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="">{{ $itemKTPIs->nama }}</label>
                    <input type="hidden" name="id_item_file[{{ $itemKTPIs->id }}]" value="{{ $itemKTPIs->id }}" id="">
                    <input type="file" name="upload_file[{{ $itemKTPIs->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemKTPIs->nama }}" class="form-control limit-size">
                    <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    <span class="filename" style="display: inline;"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Tempat Lahir</label>
                    <input type="text" maxlength="255" name="tempat_lahir" id=""
                        class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id=""
                        class="form-control @error('tanggal_lahir') is-invalid @enderror" placeholder="Tempat Lahir" value="">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Status</label>
                    <select name="status" id="" class="form-control @error('status') is-invalid @enderror select2">
                        <option value=""> --Pilih Status --</option>
                        @foreach ($status as $sts)
                            <option
                                value="{{ $sts }}"
                                
                            >{{ ucfirst($sts) }}</option>
                        @endforeach
                    </select>
                    @error('alamat_rumah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Sektor Kredit</label>
                    <select name="sektor_kredit" id=""
                        class="form-control @error('sektor_kredit') is-invalid @enderror select2">
                        <option value=""> --Pilih Sektor Kredit -- </option>
                        @foreach ($sectors as $sector)
                        <option
                            value="{{ $sector }}"
                            
                        >{{ ucfirst($sector) }}</option>
                        @endforeach
                    </select>
                    @error('sektor_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">{{ $itemSlik->nama }}</label>
                    <select name="dataLevelDua[{{ $itemSlik->id }}]" id="dataLevelDua" class="form-control select2"
                        data-id_item={{ $itemSlik->id }}>
                        <option value=""> --Pilih Data -- </option>
                        @foreach ($itemSlik->option as $itemJawaban)
                            <option value="{{ $itemJawaban->skor . '-' . $itemJawaban->id }}">
                                {{ $itemJawaban->option }}</option>
                        @endforeach
                    </select>
                    <div id="item{{ $itemSlik->id }}">

                    </div>
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="">{{ $itemP->nama }}</label>
                    <input type="hidden" name="id_item_file[{{ $itemP->id }}]" value="{{ $itemP->id }}" id="">
                    <input type="file" name="upload_file[{{ $itemP->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemP->nama }}" class="form-control limit-size">
                    <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    <span class="filename" style="display: inline;"></span>
                    {{-- <span class="alert alert-danger">Maximum file upload is 5 MB</span> --}}
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jenis Usaha</label>
                    <textarea name="jenis_usaha" class="form-control @error('jenis_usaha') is-invalid @enderror" maxlength="255" id="" cols="30" rows="4"
                        placeholder="Jenis Usaha secara spesifik"></textarea>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">Jumlah Kredit yang diminta</label>
                    <input type="text" name="jumlah_kredit" id="jumlah_kredit"
                        class="form-control rupiah" value="">
                    {{-- <textarea name="jumlah_kredit" class="form-control @error('jumlah_kredit') is-invalid @enderror" id="" cols="30"
                        rows="4" placeholder="Jumlah Kredit"></textarea> --}}
                    @error('jumlah_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">Tenor Yang Diminta</label>
                    <select name="tenor_yang_diminta" id="tenor_yang_diminta"
                        class="form-control select2 @error('tenor_yang_diminta') is-invalid @enderror" >
                        <option value="">-- Pilih Tenor --</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option
                                value="{{ $i }}"
                                
                            > {{ $i . ' tahun' }} </option>
                        @endfor
                    </select>
                    @error('tenor_yang_diminta')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Tujuan Kredit</label>
                    <textarea name="tujuan_kredit" class="form-control @error('tujuan_kredit') is-invalid @enderror" maxlength="255" id="" cols="30"
                        rows="4" placeholder="Tujuan Kredit"></textarea>
                    @error('tujuan_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jaminan yang disediakan</label>
                    <textarea name="jaminan" class="form-control @error('jaminan') is-invalid @enderror" maxlength="255" id="" cols="30" rows="4"
                        placeholder="Jaminan yang disediakan"></textarea>
                    @error('jaminan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hubungan Bank</label>
                    <textarea name="hubungan_bank" class="form-control @error('hubungan_bank') is-invalid @enderror" maxlength="255" id="" cols="30"
                        rows="4" placeholder="Hubungan dengan Bank"></textarea>
                    @error('hubungan_bank')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hasil Verifikasi</label>
                    <textarea name="hasil_verifikasi" class="form-control @error('hasil_verifikasi') is-invalid @enderror" maxlength="255" id="" cols="30"
                        rows="4" placeholder="Hasil Verifikasi Karakter Umum"></textarea>
                    @error('hasil_verifikasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        @if ($skema == 'KKB')     
            <div class="form-wizard" data-index='1' data-done='true' id="wizard-data-po">
                <div class="row">
                    <div class="form-group col-md-12">
                        <span style="color: black; font-weight: bold; font-size: 18px;">Jenis Kendaraan Roda 2 :</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Merk Kendaraan</label>
                        <select name="id_merk" id="id_merk" class="select2 form-control" style="width: 100%;" >
                            <option value="">Pilih Merk Kendaraan</option>
                            @foreach ($dataMerk as $item)
                                <option value="{{ $item->id }}">{{ $item->merk }}</option>
                            @endforeach
                        </select>
                        @error('id_merk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tipe Kendaraan</label>
                        <select name="id_tipe" id="id_tipe" class="select2 form-control" style="width: 100%;" >
                            <option value="">Pilih Tipe</option>
                        </select>
                        @error('id_tipe')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror"
                            placeholder="Tahun Kendaraan" value="" min="2000">
                        @error('tahun')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Warna</label>
                        <input type="text" maxlength="255" name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror"
                            placeholder="Warna Kendaraan" value="">
                        @error('warna')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <span style="color: black">Keterangan :</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Pemesanan</label>
                        <input type="text" maxlength="255" name="pemesanan" id="pemesanan" class="form-control @error('pemesanan') is-invalid @enderror"
                            placeholder="Pemesanan Kendaraan" value="">
                        @error('pemesanan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Sejumlah</label>
                        <input type="number" name="sejumlah" id="sejumlah" class="form-control @error('sejumlah') is-invalid @enderror"
                            placeholder="Jumlah Kendaraan" value="">
                        @error('sejumlah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control rupiah @error('harga') is-invalid @enderror"
                            placeholder="Harga Kendaraan" value="">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <input type="text" id="jumlahData" name="jumlahData" hidden value="{{ count($dataAspek) + $dataIndex }}">

        @foreach ($dataAspek as $key => $value)
            @php

                $key += $dataIndex;
                // check level 2
                $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'level', 'opsi_jawaban', 'id_parent')
                    ->where('level', 2)
                    ->where('id_parent', $value->id)
                    ->get();
                // check level 4
                $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'level', 'opsi_jawaban', 'id_parent')
                    ->where('level', 4)
                    ->where('id_parent', $value->id)
                    ->get();
            @endphp
            {{-- level level 2 --}}
            <div class="form-wizard" data-index='{{ $key }}' data-done='true'>

                <div class="row">
                    @foreach ($dataLevelDua as $item)
                        @php
                            $idLevelDua = str_replace(' ', '_', strtolower($item->nama));
                        @endphp
                        {{-- item ijin usaha --}}
                        @if ($item->nama == 'Ijin Usaha')
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    <select name="ijin_usaha" id="ijin_usaha" class="form-control" >
                                        <option value="">-- Pilih Ijin Usaha --</option>
                                        <option value="nib">NIB</option>
                                        <option value="surat_keterangan_usaha">Surat Keterangan Usaha</option>
                                        <option value="tidak_ada_legalitas_usaha">Tidak Ada Legalitas Usaha</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="form-group col-md-6" id="nib">
                                    <label for="">NIB</label>
                                    <input type="hidden" name="id_level[77]" value="77" id="nib_id">
                                    <input type="hidden" name="opsi_jawaban[77]" value="input text" id="nib_opsi_jawaban">
                                    <input type="text" maxlength="255" name="informasi[77]" id="nib_text" placeholder="Masukkan informasi"
                                        class="form-control" value="">
                                </div>

                                <div class="form-group col-md-6" id="docNIB">
                                    <label for="">{{ $itemNIB->nama }}</label>
                                    <input type="hidden" name="id_item_file[{{ $itemNIB->id }}]" value="{{ $itemNIB->id }}" id="docNIB_id">
                                    <input type="file" name="upload_file[{{ $itemNIB->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemNIB->nama }}" class="form-control limit-size">
                                    <span class="invalid-tooltip" style="display: none" id="docNIB_text">Maximum upload file size is 15 MB</span>
                                    @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dataLevelTiga.' . $key) }}
                                        </div>
                                    @endif
                                    <span class="filename" style="display: inline;"></span>
                                </div>

                                <div class="form-group col-md-6" id="surat_keterangan_usaha">
                                    <label for="">Surat Keterangan Usaha</label>
                                    <input type="hidden" name="id_level[78]" value="78" id="surat_keterangan_usaha_id">
                                    <input type="hidden" name="opsi_jawaban[78]" value="input text"
                                        id="surat_keterangan_usaha_opsi_jawaban">
                                    <input type="text" maxlength="255" name="informasi[78]" id="surat_keterangan_usaha_text"
                                        placeholder="Masukkan informasi" class="form-control">
                                </div>

                                <div class="form-group col-md-6" id="docSKU">
                                    <label for="">{{ $itemSKU->nama }}</label>
                                    <input type="hidden" name="id_item_file[{{ $itemSKU->id }}]" value="{{ $itemSKU->id }}" id="docSKU_id">
                                    <input type="file" name="upload_file[{{ $itemSKU->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemSKU->nama }}" class="form-control limit-size">
                                    <span class="invalid-tooltip" style="display: none" id="docSKU_text">Maximum upload file size is 15 MB</span>
                                    @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dataLevelTiga.' . $key) }}
                                        </div>
                                    @endif
                                    <span class="filename" style="display: inline;"></span>
                                </div>
                            </div>

                        @elseif($item->nama == 'NPWP')
                            <div class="row col-md-12">
                                <div class="form-group col-md-6" id="npwp">
                                    <label for="">NPWP</label>
                                    <input type="hidden" name="id_level[79]" value="79" id="npwp_id">
                                    <input type="hidden" name="opsi_jawaban[79]" value="input text" id="npwp_opsi_jawaban">
                                    <input type="text" maxlength="255" name="informasi[79]" id="npwp_text" placeholder="Masukkan informasi"
                                        class="form-control" value="">
                                </div>

                                <div class="form-group col-md-6" id="docNPWP">
                                    <label for="">{{ $itemNPWP->nama }}</label>
                                    <input type="hidden" name="id_item_file[{{ $itemNPWP->id }}]" value="{{ $itemNPWP->id }}" id="docNPWP_id">
                                    <input type="file" name="upload_file[{{ $itemNPWP->id }}]" data-id="" placeholder="Masukkan informasi {{ $itemNPWP->nama }}" class="form-control limit-size">
                                    <span class="invalid-tooltip" style="display: none" id="docNPWP_text">Maximum upload file size is 15 MB</span>
                                    @if (isset($key) && $errors->has('dataLevelTiga.' . $key))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dataLevelTiga.' . $key) }}
                                        </div>
                                    @endif
                                    <span class="filename" style="display: inline;"></span>
                                </div>
                            </div>
                        @else
                            @if ($item->opsi_jawaban == 'input text')
                                <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                    <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                    <input type="text" maxlength="255" name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                        placeholder="Masukkan informasi {{ $item->nama }}" class="form-control" value="">
                                </div>
                            @elseif ($item->opsi_jawaban == 'number')
                                @if ($item->nama == 'Repayment Capacity')
                                    <div class="form-group col-md-6">
                                        <label for="">{{ $item->nama }}</label>
                                        <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                        <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                        <input type="text" maxlength="255" name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                            placeholder="Masukkan informasi {{ $item->nama }}" class="form-control" value="">
                                    </div>
                                @else
                                    @if ($item->nama == 'Omzet Penjualan' || $item->nama == 'Installment')
                                        <div class="form-group col-md-6">
                                            <label for="">{{ $item->nama }}(Perbulan)</label>
                                            <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                            <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                            <input type="text" maxlength="255" step="any" name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                placeholder="Masukkan informasi {{ $item->nama }}" class="form-control rupiah" value="">
                                        </div>
                                    @else
                                        <div class="form-group col-md-6">
                                            <label for="">{{ $item->nama }}</label>
                                            <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                            <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                            <input type="text" maxlength="255" step="any" name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                                placeholder="Masukkan informasi {{ $item->nama }}" class="form-control rupiah" value="">
                                        </div>
                                    @endif
                                @endif
                            @elseif ($item->opsi_jawaban == 'persen')
                                <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                    <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                    <div class="input-group mb-3">
                                        <input type="number" step="any" name="informasi[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                            placeholder="Masukkan informasi {{ $item->nama }}" class="form-control"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2" value="">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($item->opsi_jawaban == 'file')
                                <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    {{-- <input type="hidden" name="opsi_jawaban[]" value="{{ $item->opsi_jawaban }}" --}}
                                        {{-- id="{{ $idLevelDua }}"> --}}
                                    <input type="hidden" name="id_item_file[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                    <input type="file" name="upload_file[{{ $item->id }}]" data-id=""
                                        placeholder="Masukkan informasi {{ $item->nama }}" class="form-control limit-size">
                                        <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                    <span class="filename" style="display: inline;"></span>
                                </div>
                            @elseif ($item->opsi_jawaban == 'long text')
                                <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    <input type="hidden" name="opsi_jawaban[{{ $item->id }}]" value="{{ $item->opsi_jawaban }}" id="">
                                    <input type="hidden" name="id_level[{{ $item->id }}]" value="{{ $item->id }}" id="">
                                    <textarea name="informasi[{{ $item->id }}]" rows="4" id="{{ $idLevelDua }}" maxlength="255" class="form-control"
                                        placeholder="Masukkan informasi {{ $item->nama }}"></textarea>
                                </div>
                            @endif

                            @php
                                $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                    ->where('id_item', $item->id)
                                    ->get();
                                $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                    ->where('id_item', $item->id)
                                    ->get();
                                // check level 3
                                $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent')
                                    ->where('level', 3)
                                    ->where('id_parent', $item->id)
                                    ->get();
                            @endphp

                            @foreach ($dataOption as $itemOption)
                                @if ($itemOption->option == '-')
                                    <div class="form-group col-md-12">
                                        <h4>{{ $item->nama }}</h4>
                                    </div>
                                @endif
                            @endforeach

                            @if (count($dataJawaban) != 0)
                                {{-- <div class="form-group col-md-6">
                                    <label for="">{{ $item->nama }}</label>
                                    <select name="dataLevelDua[]" id="dataLevelDua" class="form-control cek-sub-column"
                                        data-id_item={{ $item->id }}>
                                        <option value=""> --Pilih Data -- </option>
                                        @foreach ($dataJawaban as $itemJawaban)
                                            <option
                                                value="{{ ($itemJawaban->skor == null ? 'kosong' : $itemJawaban->skor) . '-' . $itemJawaban->id }}">
                                                {{ $itemJawaban->option }}</option>
                                        @endforeach
                                    </select>
                                    <div id="item{{ $item->id }}">

                                    </div>
                                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dataLevelDua.' . $key) }}
                                        </div>
                                    @endif
                                </div> --}}

                                <div
                                    class="{{ $idLevelDua == 'persentase_kebutuhan_kredit_opsi' || $idLevelDua == 'repayment_capacity_opsi' ? '' : 'form-group col-md-6' }}">
                                    <label for="" id="{{ $idLevelDua . '_label' }}">{{ $item->nama }}</label>

                                    <select name="dataLevelDua[{{ $item->id }}]" id="{{ $idLevelDua }}"
                                        class="form-control cek-sub-column" data-id_item={{ $item->id }}>
                                        <option value=""> --Pilih Opsi-- </option>
                                        @foreach ($dataJawaban as $key => $itemJawaban)
                                            <option id="{{ $idLevelDua . '_' . $key }}"
                                                value="{{ ($itemJawaban->skor == null ? 'kosong' : $itemJawaban->skor) . '-' . $itemJawaban->id }}">
                                                {{ $itemJawaban->option }}</option>
                                        @endforeach
                                    </select>
                                    <div id="item{{ $item->id }}">

                                    </div>
                                </div>
                            @endif

                            @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                @php
                                    $idLevelTiga = str_replace(' ', '_', strtolower($itemTiga->nama));
                                @endphp
                                @if ($itemTiga->nama == 'Kategori Jaminan Utama')
                                    {{-- <div class="form-group col-md-6">
                                        <label for="">{{ $itemTiga->nama }}</label>
                                        <select name="kategori_jaminan_utama" id="kategori_jaminan_utama"
                                            class="form-control">
                                            <option value="">-- Pilih Kategori Jaminan Utama --</option>
                                            <option value="Tanah">Tanah</option>
                                            <option value="Kendaraan Bermotor">Kendaraan Bermotor</option>
                                            <option value="Tanah dan Bangunan">Tanah dan Bangunan</option>
                                            <option value="Stock">Stock</option>
                                            <option value="Piutang">Piutang</option>
                                        </select>
                                        {{-- <input type="hidden" name="id_level[]" value="{{ $itemTiga->id }}" id="">
                                        <input type="hidden" name="opsi_jawaban[]" value="{{ $itemTiga->opsi_jawaban }}"
                                            id="">
                                        <input type="text" name="informasi[]" id="" placeholder="Masukkan informasi"
                                            class="form-control">
                                    </div>

                                    <div class="form-group col-md-6" id="select_kategori_jaminan_utama">

                                    </div> --}}
                                @elseif ($itemTiga->nama == 'Kategori Jaminan Tambahan')
                                    <div class="form-group col-md-6">
                                        <label for="">{{ $itemTiga->nama }}</label>
                                        <select name="kategori_jaminan_tambahan" id="kategori_jaminan_tambahan"
                                            class="form-control" >
                                            <option value="">-- Pilih Kategori Jaminan Tambahan --</option>
                                            <option value="Tanah">Tanah</option>
                                            <option value="Kendaraan Bermotor">Kendaraan Bermotor</option>
                                            <option value="Tanah dan Bangunan">Tanah dan Bangunan</option>
                                        </select>
                                        {{-- <input type="hidden" name="id_level[]" value="{{ $itemTiga->id }}" id="">
                                        <input type="hidden" name="opsi_jawaban[]" value="{{ $itemTiga->opsi_jawaban }}"
                                            id="">
                                        <input type="text" name="informasi[]" id="" placeholder="Masukkan informasi"
                                            class="form-control"> --}}
                                    </div>
                                    <div class="form-group col-md-6" id="select_kategori_jaminan_tambahan"></div>
                                @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Utama')
                                    {{-- <div class="form-group col-md-12">
                                        <h5>{{ $itemTiga->nama }}</h5>
                                    </div>
                                    <div id="bukti_pemilikan_jaminan_utama" class="form-group col-md-12 row">

                                    </div> --}}
                                @elseif ($itemTiga->nama == 'Bukti Pemilikan Jaminan Tambahan')
                                    <div class="form-group col-md-12">
                                        <h5>{{ $itemTiga->nama }}</h5>
                                    </div>
                                    <div id="bukti_pemilikan_jaminan_tambahan" class="form-group col-md-12 row">

                                    </div>
                                @else
                                    @if ($itemTiga->opsi_jawaban == 'input text')
                                        <div class="form-group col-md-6">
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                            <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                value="{{ $itemTiga->opsi_jawaban }}" id="">
                                            <input type="text" maxlength="255" name="informasi[{{ $itemTiga->id }}]" placeholder="Masukkan informasi"
                                                class="form-control" id="{{ $idLevelTiga }}" value="">
                                        </div>
                                    @elseif ($itemTiga->opsi_jawaban == 'number')
                                        <div class="form-group col-md-6">
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                value="{{ $itemTiga->opsi_jawaban }}" id="">
                                            <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                            <input type="text" step="any" name="informasi[{{ $itemTiga->id }}]" id="{{ $idLevelTiga }}"
                                                placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                class="form-control rupiah" value="">
                                        </div>
                                    @elseif ($itemTiga->opsi_jawaban == 'persen')
                                        <div class="form-group col-md-6">
                                            @if ($itemTiga->nama == 'Ratio Tenor Asuransi')

                                            @else
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                value="{{ $itemTiga->opsi_jawaban }}" id="">
                                            <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="informasi[{{ $itemTiga->id }}]"
                                                    id="{{ $idLevelTiga }}"
                                                    placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                    class="form-control" aria-label="Recipient's username"
                                                    aria-describedby="basic-addon2" value="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">%</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @elseif ($itemTiga->opsi_jawaban == 'file')
                                        <div class="form-group col-md-6 file-wrapper item-{{ $itemTiga->id }}">
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <div class="row file-input">
                                                <div class="col-md-9">
                                                    <input type="hidden" name="id_item_file[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                                    <input type="file" name="upload_file[{{ $itemTiga->id }}]" data-id=""
                                                        placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                        class="form-control limit-size">
                                                        <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                                    <span class="filename" style="display: inline;"></span>
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-sm btn-success btn-add-file" type="button" data-id="{{ $itemTiga->id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-sm btn-danger btn-del-file" type="button" data-id="{{ $itemTiga->id }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-6 file-wrapper item-{{ $itemTiga->id }}">
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <div class="row file-input">
                                                <div class="col-md-9">
                                                    <input type="hidden" name="id_item_file[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                                    <input type="file" name="upload_file[{{ $itemTiga->id }}]" data-id=""
                                                        placeholder="Masukkan informasi {{ $itemTiga->nama }}"
                                                        class="form-control limit-size">
                                                        <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                                    <span class="filename" style="display: inline;"></span>
                                                </div>
                                                @if(in_array(trim($itemTiga->nama), $multipleFiles))
                                                <div class="col-1">
                                                    <button class="btn btn-sm btn-success btn-add-file" type="button" data-id="{{ $itemTiga->id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-sm btn-danger btn-del-file" type="button" data-id="{{ $itemTiga->id }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif ($itemTiga->opsi_jawaban == 'long text')
                                        <div class="form-group col-md-6">
                                            <label for="">{{ $itemTiga->nama }}</label>
                                            <input type="hidden" name="opsi_jawaban[{{ $itemTiga->id }}]"
                                                value="{{ $itemTiga->opsi_jawaban }}" id="">
                                            <input type="hidden" name="id_level[{{ $itemTiga->id }}]" value="{{ $itemTiga->id }}" id="">
                                            <textarea name="informasi[{{ $itemTiga->id }}]" rows="4" id="{{ $idLevelTiga }}" maxlength="255" class="form-control"
                                                placeholder="Masukkan informasi {{ $itemTiga->nama }}"></textarea>
                                        </div>
                                    @endif

                                    @php
                                        // check  jawaban level tiga
                                        $dataJawabanLevelTiga = \App\Models\OptionModel::where('option', '!=', '-')
                                            ->where('id_item', $itemTiga->id)
                                            ->get();
                                        $dataOptionTiga = \App\Models\OptionModel::where('option', '=', '-')
                                            ->where('id_item', $itemTiga->id)
                                            ->get();
                                        // check level empat
                                        $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent')
                                            ->where('level', 4)
                                            ->where('id_parent', $itemTiga->id)
                                            ->get();
                                    @endphp

                                    @foreach ($dataOptionTiga as $itemOptionTiga)
                                        @if ($itemOptionTiga->option == '-')
                                            <div class="form-group col-md-12">
                                                <h5>{{ $itemTiga->nama }}</h5>
                                            </div>
                                        @endif
                                    @endforeach
                                    {{-- @foreach ($dataOptionEmpat as $itemOptionEmpat)
                                    @if ($itemOptionEmpat->option == '-')
                                        <div class="form-group col-md-12">
                                            <h5>{{ $itemTiga->nama }}</h5>
                                        </div>
                                    @endif
                                @endforeach --}}
                                    @if (count($dataJawabanLevelTiga) != 0)
                                        @if ($itemTiga->nama != 'Pengikatan Jaminan Utama')
                                            <div
                                                class="{{ $idLevelTiga == 'ratio_tenor_asuransi_opsi' || $idLevelTiga == 'ratio_coverage_opsi' ? '' : 'form-group col-md-6' }}">
                                                <label for=""
                                                    id="{{ $idLevelTiga . '_label' }}">{{ $itemTiga->nama }}</label>

                                                <select name="dataLevelTiga[{{ $itemTiga->id }}]" id="{{ $idLevelTiga }}"
                                                    class="form-control cek-sub-column" data-id_item={{ $itemTiga->id }}>
                                                    <option value=""> --Pilih Opsi-- </option>
                                                    @foreach ($dataJawabanLevelTiga as $key => $itemJawabanTiga)
                                                        <option id="{{ $idLevelTiga . '_' . $key }}"
                                                            value="{{ ($itemJawabanTiga->skor == null ? 'kosong' : $itemJawabanTiga->skor) . '-' . $itemJawabanTiga->id }}">
                                                            {{ $itemJawabanTiga->option }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="item{{ $itemTiga->id }}">

                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                        @php
                                            $idLevelEmpat = str_replace(' ', '_', strtolower($itemEmpat->nama));
                                        @endphp

                                        @if ($itemEmpat->opsi_jawaban == 'input text')
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                <input type="hidden" name="id_level[{{ $itemEmpat->id }}]" value="{{ $itemEmpat->id }}"
                                                    id="">
                                                <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                    value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                <input type="text" maxlength="255" name="informasi[{{ $itemEmpat->id }}]" id="{{ $idLevelEmpat }}"
                                                    placeholder="Masukkan informasi" class="form-control" value="">
                                            </div>
                                        @elseif ($itemEmpat->opsi_jawaban == 'number')
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                    value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                <input type="hidden" name="id_level[{{ $itemEmpat->id }}]" value="{{ $itemEmpat->id }}"
                                                    id="">
                                                <input type="text" step="any" name="informasi[{{ $itemEmpat->id }}]"
                                                    id="{{ $idLevelEmpat }}"
                                                    placeholder="Masukkan informasi {{ $itemEmpat->nama }}"
                                                    class="form-control rupiah" value="">
                                            </div>
                                        @elseif ($itemEmpat->opsi_jawaban == 'persen')
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                    value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                <input type="hidden" name="id_level[{{ $itemEmpat->id }}]" value="{{ $itemEmpat->id }}"
                                                    id="">
                                                <div class="input-group mb-3">
                                                    <input type="number" step="any" name="informasi[{{ $itemEmpat->id }}]"
                                                        id="{{ $idLevelEmpat }}"
                                                        placeholder="Masukkan informasi {{ $itemEmpat->nama }}"
                                                        class="form-control" aria-label="Recipient's username"
                                                        aria-describedby="basic-addon2" value="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($itemEmpat->opsi_jawaban == 'file')
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                {{-- <input type="hidden" name="opsi_jawaban[]"
                                                    value="{{ $itemEmpat->opsi_jawaban }}" id=""> --}}
                                                <input type="hidden" name="id_item_file[{{ $itemEmpat->id }}]" value="{{ $itemEmpat->id }}"
                                                    id="">
                                                <input type="file" name="upload_file[{{ $itemEmpat->id }}]" data-id=""
                                                    placeholder="Masukkan informasi {{ $itemEmpat->nama }}"
                                                    class="form-control limit-size">
                                                    <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                                <span class="filename" style="display: inline;"></span>
                                            </div>
                                        @elseif ($itemEmpat->opsi_jawaban == 'long text')
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                <input type="hidden" name="opsi_jawaban[{{ $itemEmpat->id }}]"
                                                    value="{{ $itemEmpat->opsi_jawaban }}" id="">
                                                <input type="hidden" name="id_level[{{ $itemEmpat->id }}]" value="{{ $itemEmpat->id }}"
                                                    id="">
                                                <textarea name="informasi[{{ $itemEmpat->id }}]" rows="4" id="{{ $idLevelEmpat }}" maxlength="255" class="form-control"
                                                    placeholder="Masukkan informasi {{ $itemEmpat->nama }}"></textarea>
                                            </div>
                                        @endif
                                        @php
                                            // check level empat
                                            $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option', '!=', '-')
                                                ->where('id_item', $itemEmpat->id)
                                                ->get();
                                            $dataOptionEmpat = \App\Models\OptionModel::where('option', '=', '-')
                                                ->where('id_item', $itemEmpat->id)
                                                ->get();
                                        @endphp

                                        @foreach ($dataOptionEmpat as $itemOptionEmpat)
                                            @if ($itemOptionEmpat->option == '-')
                                                <div class="form-group col-md-12">
                                                    <h6>{{ $itemEmpat->nama }}</h6>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if (count($dataJawabanLevelEmpat) != 0)
                                            <div class="form-group col-md-6">
                                                <label for="">{{ $itemEmpat->nama }}</label>
                                                <select name="dataLevelEmpat[{{ $itemEmpat->id }}]" id="{{ $idLevelEmpat }}"
                                                    class="form-control cek-sub-column"
                                                    data-id_item={{ $itemEmpat->id }}>
                                                    <option value=""> --Pilih Opsi -- </option>
                                                    @foreach ($dataJawabanLevelEmpat as $itemJawabanEmpat)
                                                        <option id="{{ $idLevelEmpat . '_' . $key }}"
                                                            value="{{ ($itemJawabanEmpat->skor == null ? 'kosong' : $itemJawabanEmpat->skor) . '-' . $itemJawabanEmpat->id }}">
                                                            {{ $itemJawabanEmpat->option }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="item{{ $itemEmpat->id }}">

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <div class="form-group col-md-12">
                        <hr style="border: 0.2px solid #E3E6EA;">
                        <label for="">Pendapat dan Usulan {{ $value->nama }}</label>
                        <input type="hidden" name="id_aspek[{{ $value->id }}]" value="{{ $value->id }}">
                        <textarea name="pendapat_per_aspek[{{ $value->id }}]" class="form-control @error('pendapat_per_aspek') is-invalid @enderror" id="" maxlength="255"
                            cols="30" rows="4" placeholder="Pendapat Per Aspek"></textarea>
                        @error('pendapat_per_aspek')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
        @endforeach
        {{-- pendapat dan usulan --}}
        <div class="form-wizard" data-index='{{ count($dataAspek) + $dataIndex }}' data-done='true'>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Pendapat dan Usulan</label>
                    <textarea name="komentar_staff" class="form-control @error('komentar_staff') is-invalid @enderror" maxlength="255" id="" cols="30"
                        rows="4" placeholder="Pendapat dan Usulan Staf/Analis Kredit"></textarea>
                    @error('komentar_staff')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <hr>
                </div>
            </div>
        </div>
        {{-- end pendapat dan usulan --}}
        <div class="row form-group">
            <div class="col text-right">
                <a href="{{ route('pengajuan-kredit-draft') }}">
                    <button class="btn btn-warning" type="button"><span class="fa fa-arrow-left"></span> Kembali</button>
                </a>
                <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
                <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
                <button type="submit" class="btn btn-info btn-simpan" id="submit">Simpan <span
                        class="fa fa-save"></span></button>
                {{-- <button class="btn btn-info ">Simpan <span class="fa fa-chevron-right"></span></button> --}}
            </div>
        </div>
    </form>
@endsection

@push('custom-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let valSkema = $("#skema").val();
            if(valSkema == null || valSkema == ''){
                $('#exampleModal').modal('show');
            }

            $("#exampleModal").on('click', "#btnSkema", function(){
                let valSkema = $("#skema").val();
                console.log(valSkema);

                $("#skema_kredit").val(valSkema);
            });
        });

        $("#id_merk").change(function(){
            let val = $(this).val();
            
            $.ajax({
                type: "get",
                url: "{{ route('get-tipe-kendaraan') }}?id_merk="+val,
                dataType: "json",
                success: (res) => {
                    if(res){
                        $("#id_tipe").empty();
                        $("#id_tipe").append(`<option>Pilih Tipe</option>`)

                        $.each(res.tipe, function(i, value){
                            $("#id_tipe").append(`
                                <option value="${value.id}">${value.tipe}</option>
                            `);
                        })
                    }
                }
            })
        })

        $('#docSKU').hide();
        $('#surat_keterangan_usaha').hide();
        $('#nib').hide();
        $('#docNIB').hide();
        //make input readonly
        $('#ratio_coverage').attr('readonly', true);
        $('#ratio_tenor_asuransi').attr('readonly', true);
        $('#persentase_kebutuhan_kredit').attr('readonly', true);
        $('#repayment_capacity').attr('readonly', true);

        // make select option hidden
        $('#ratio_coverage_opsi_label').hide();
        $('#ratio_tenor_asuransi_opsi_label').hide();
        $('#ratio_coverage_opsi').hide();
        $('#ratio_tenor_asuransi_opsi').hide();
        $('#persentase_kebutuhan_kredit_opsi_label').hide();
        $('#persentase_kebutuhan_kredit_opsi').hide();
        $('#repayment_capacity_opsi_label').hide();
        $('#repayment_capacity_opsi').hide();

        let urlCekSubColumn = "{{ route('cek-sub-column') }}";
        let urlGetItemByKategoriJaminanUtama =
            "{{ route('get-item-jaminan-by-kategori-jaminan-utama') }}"; // jaminan tambahan
        let urlGetItemByKategori = "{{ route('get-item-jaminan-by-kategori') }}"; // jaminan tambahan

        var x = 1;

        $('#kabupaten').change(function() {
            var kabID = $(this).val();
            if (kabID) {
                $.ajax({
                    type: "GET",
                    url: "/getkecamatan?kabID=" + kabID,
                    dataType: 'JSON',
                    success: function(res) {
                        //    console.log(res);
                        if (res) {
                            $("#kecamatan").empty();
                            $("#desa").empty();
                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $("#desa").append('<option>---Pilih Desa---</option>');
                            $.each(res, function(nama, kode) {
                                $('#kecamatan').append(`
                                    <option value="${kode}">${nama}</option>
                                `);
                            });

                            $('#kecamatan').trigger('change');
                        } else {
                            $("#kecamatan").empty();
                            $("#desa").empty();
                        }
                    }
                });
            } else {
                $("#kecamatan").empty();
                $("#desa").empty();
            }
        });

        $('#kecamatan').change(function() {
            var kecID = $(this).val();
            // console.log(kecID);
            if (kecID) {
                $.ajax({
                    type: "GET",
                    url: "/getdesa?kecID=" + kecID,
                    dataType: 'JSON',
                    success: function(res) {
                        //    console.log(res);
                        if (res) {
                            $("#desa").empty();
                            $("#desa").append('<option>---Pilih Desa---</option>');
                            $.each(res, function(nama, kode) {
                                $('#desa').append(`
                                    <option value="${kode}">${nama}</option>
                                `);
                            });
                        } else {
                            $("#desa").empty();
                        }
                    }
                });
            } else {
                $("#desa").empty();
            }
        });

        //cek apakah opsi yg dipilih memiliki sub column
        $('.cek-sub-column').change(function(e) {
            let idOption = $(this).val();
            let idItem = $(this).data('id_item');
            // cek option apakah ada turunan
            $(`#item${idItem}`).empty();
            $.ajax({
                type: "get",
                url: `${urlCekSubColumn}?idOption=${idOption}`,
                dataType: "json",
                success: function(response) {
                    if (response.sub_column != null) {
                        $(`#item${idItem}`).append(`
                        <div class="form-group sub mt-2">
                            <label for="">${response.sub_column}</label>
                            <input type="hidden" name="id_option_sub_column[]" value="${idOption}">
                            <input type="text" name="jawaban_sub_column[]" placeholder="Masukkan informasi tambahan" class="form-control">
                        </div>
                        `);
                    } else {
                        $(`#item${idItem}`).empty();
                    }
                }
            });
        });

        //item kategori jaminan utama cek apakah milih tanah, kendaraan bermotor, atau tanah dan bangunan
        $('#kategori_jaminan_utama').change(function(e) {
            //clear item
            $('#select_kategori_jaminan_utama').empty();

            // clear bukti pemilikan
            $('#bukti_pemilikan_jaminan_utama').empty();

            //get item by kategori
            let kategoriJaminanUtama = $(this).val();

            $.ajax({
                type: "get",
                url: `${urlGetItemByKategoriJaminanUtama}?kategori=${kategoriJaminanUtama}`,
                dataType: "json",
                success: function(response) {
                    // jika kategori bukan stock dan piutang
                    if (kategoriJaminanUtama != 'Stock' && kategoriJaminanUtama != 'Piutang') {
                        // add item by kategori
                        $('#select_kategori_jaminan_utama').append(`
                            <label for="">${response.item.nama}</label>
                            <select name="dataLevelEmpat[]" id="itemByKategoriJaminanUtama" class="form-control cek-sub-column"
                                data-id_item="${response.item.id}">
                                <option value=""> --Pilih Opsi -- </option>
                                </select>

                            <div id="item${response.item.id}">

                            </div>
                        `);
                        // add opsi dari item
                        $.each(response.item.option, function(i, valOption) {
                            // console.log(valOption.skor);
                            $('#itemByKategoriJaminanUtama').append(`
                            <option value="${valOption.skor}-${valOption.id}">
                            ${valOption.option}
                            </option>`);
                        });

                        // add item bukti pemilikan
                        var isCheck = kategoriJaminanUtama != 'Kendaraan Bermotor' &&
                            kategoriJaminanUtama != 'Stock' && kategoriJaminanUtama != 'Piutang' ?
                            "<input type='checkbox' class='checkKategoriJaminanUtama'>" : ""
                        var isDisabled = kategoriJaminanUtama != 'Kendaraan Bermotor' &&
                            kategoriJaminanUtama != 'Stock' && kategoriJaminanUtama != 'Piutang' ?
                            'disabled' : ''
                        $.each(response.itemBuktiPemilikan, function(i, valItem) {
                            if (valItem.nama == 'Atas Nama') {
                                $('#bukti_pemilikan_jaminan_utama').append(`
                                <div class="form-group col-md-6 aspek_jaminan_kategori_jaminan_utama">
                                    <label>${valItem.nama}</label>
                                    <input type="hidden" name="id_level[]" value="${valItem.id}" id="" class="input">
                                    <input type="hidden" name="opsi_jawaban[]"
                                        value="${valItem.opsi_jawaban}" id="" class="input">
                                    <input type="text" name="informasi[]" placeholder="Masukkan informasi"
                                        class="form-control input">
                                </div>
                            `);m
                            } else {
                                if(valItem.nama == 'Foto') {
                                    $('#bukti_pemilikan_jaminan_utama').append(`
                                    <div class="form-group col-md-6 aspek_jaminan_kategori_jaminan_utama">
                                        <label>${valItem.nama}</label>
                                        <input type="hidden" name="id_item_file[${valItem.id}]" value="${valItem.id}" id="" class="input">
                                        <input type="file" name="upload_file[${valItem.id}]" data-id="" class="form-control limit-size">
                                        <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                        <span class="filename" style="display: inline;"></span>
                                    </div>`);
                                }
                                else {
                                    $('#bukti_pemilikan_jaminan_utama').append(`
                                    <div class="form-group col-md-6 aspek_jaminan_kategori_jaminan_utama">
                                        <label>${isCheck} ${valItem.nama}</label>
                                        <input type="hidden" name="id_level[]" value="${valItem.id}" id="" class="input" ${isDisabled}>
                                        <input type="hidden" name="opsi_jawaban[]"
                                            value="${valItem.opsi_jawaban}" id="" class="input" ${isDisabled}>
                                        <input type="text" name="informasi[]" placeholder="Masukkan informasi ${valItem.nama}"
                                            class="form-control input" ${isDisabled}>
                                    </div>`);
                                }
                            }
                        });

                        $(".checkKategoriJaminanUtama").click(function() {
                            var input = $(this).closest('.form-group').find(".input")
                            // var input_id = $(this).closest('.form-group').find("input_id").last()
                            // var input_opsi_jawaban = $(this).closest('.form-group').find("input_opsi_jawaban").last()
                            if ($(this).is(':checked')) {
                                input.prop('disabled', false)
                                // input_id.prop('disabled',false)
                                // input_opsi_jawaban.prop('disabled',false)
                            } else {
                                input.val('')
                                input.prop('disabled', true)
                                // input_id.prop('disabled',true)
                                // input_opsi_jawaban.prop('disabled',true)
                            }
                        })
                    }
                    // jika kategori = stock dan piutang
                    else {
                        $.each(response.itemBuktiPemilikan, function(i, valItem) {
                            if (valItem.nama == 'Atas Nama') {
                                $('#select_kategori_jaminan_utama').append(`
                                <div class="aspek_jaminan_kategori_jaminan_utama">
                                    <label>${valItem.nama}</label>
                                    <input type="hidden" name="id_level[]" value="${valItem.id}" id="" class="input">
                                    <input type="hidden" name="opsi_jawaban[]"
                                        value="${valItem.opsi_jawaban}" id="" class="input">
                                    <input type="text" name="informasi[]" placeholder="Masukkan informasi"
                                        class="form-control input">
                                </div>
                            `);
                            } else {
                                $('#select_kategori_jaminan_utama').append(`
                                <div class="aspek_jaminan_kategori_jaminan_utama">
                                    <label>${valItem.nama}</label>
                                    <input type="hidden" name="id_level[]" value="${valItem.id}" id="" class="input" >
                                    <input type="hidden" name="opsi_jawaban[]"
                                        value="${valItem.opsi_jawaban}" id="" class="input">
                                    <input type="text" name="informasi[]" placeholder="Masukkan informasi ${valItem.nama}"
                                        class="form-control input">
                                </div>
                            `);
                            }
                        });
                    }
                }
            });
        });
        // end item kategori jaminan utama cek apakah milih tanah, kendaraan bermotor, atau tanah dan bangunan

        //item kategori jaminan tambahan cek apakah milih tanah, kendaraan bermotor, atau tanah dan bangunan
        $('#kategori_jaminan_tambahan').change(function(e) {
            //clear item
            $('#select_kategori_jaminan_tambahan').empty();

            // clear bukti pemilikan
            $('#bukti_pemilikan_jaminan_tambahan').empty();

            //get item by kategori
            let kategoriJaminan = $(this).val();

            $.ajax({
                type: "get",
                url: `${urlGetItemByKategori}?kategori=${kategoriJaminan}`,
                dataType: "json",
                success: function(response) {
                    // add item by kategori
                    $('#select_kategori_jaminan_tambahan').append(`
                        <label for="">${response.item.nama}</label>
                        <select name="dataLevelEmpat[${response.item.id}]" id="itemByKategori" class="form-control cek-sub-column"
                            data-id_item="${response.item.id}">
                            <option value=""> --Pilih Opsi -- </option>
                            </select>

                        <div id="item${response.item.id}">

                        </div>
                    `);
                    // add opsi dari item
                    $.each(response.item.option, function(i, valOption) {
                        // console.log(valOption.skor);
                        $('#itemByKategori').append(`
                        <option value="${valOption.skor}-${valOption.id}" ${(response.dataSelect == valOption.id) ? 'selected' : ''}>
                        ${valOption.option}
                        </option>`);
                    });

                    // add item bukti pemilikan
                    var isCheck = kategoriJaminan != 'Kendaraan Bermotor' ?
                        "<input type='checkbox' class='checkKategori'>" : ""
                    var isDisabled = kategoriJaminan != 'Kendaraan Bermotor' ? 'disabled' : ''
                    $.each(response.itemBuktiPemilikan, function(i, valItem) {
                        console.log('test');
                        if (valItem.nama == 'Atas Nama') {
                            $('#bukti_pemilikan_jaminan_tambahan').append(`
                                <div class="form-group col-md-6 aspek_jaminan_kategori">
                                    <label>${valItem.nama}</label>
                                    <input type="hidden" name="id_level[${valItem.id}]" value="${valItem.id}" id="" class="input">
                                    <input type="hidden" name="opsi_jawaban[${valItem.id}]"
                                        value="${valItem.opsi_jawaban}" id="" class="input">
                                    <input type="text" maxlength="255" name="informasi[${valItem.id}]" placeholder="Masukkan informasi"
                                        class="form-control input" value="${response.dataJawaban[i]}">
                                </div>
                            `);
                        } else {
                            if(valItem.nama == 'Foto') {
                                $('#bukti_pemilikan_jaminan_tambahan').append(`
                                <div class="form-group col-md-6 file-wrapper item-${valItem.id}">
                                    <label for="">${valItem.nama}</label>
                                    <div class="row file-input">
                                        <div class="col-md-9">
                                            <input type="hidden" name="id_item_file[${valItem.id}]" value="${valItem.id}" id="">
                                            <input type="file" name="upload_file[${valItem.id}]" data-id=""
                                                placeholder="Masukkan informasi ${valItem.nama}"
                                                class="form-control limit-size">
                                                <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                            <span class="filename" style="display: inline;"></span>
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-success btn-add-file" type="button" data-id="${valItem.id}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-danger btn-del-file" type="button" data-id="${valItem.id}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6 file-wrapper item-${valItem.id}">
                                    <label for="">${valItem.nama}</label>
                                    <div class="row file-input">
                                        <div class="col-md-9">
                                            <input type="hidden" name="id_item_file[${valItem.id}]" value="${valItem.id}" id="">
                                            <input type="file" name="upload_file[${valItem.id}]" data-id=""
                                                placeholder="Masukkan informasi ${valItem.nama}"
                                                class="form-control limit-size">
                                                <span class="invalid-tooltip" style="display: none">Maximum upload file size is 15 MB</span>
                                            <span class="filename" style="display: inline;"></span>
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-success btn-add-file" type="button" data-id="${valItem.id}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-sm btn-danger btn-del-file" type="button" data-id="${valItem.id}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                `);
                            } else {
                                if(response.dataJawaban[i] != null && response.dataJawaban[i] != ""){
                                    if(kategoriJaminan != 'Kendaraan Bermotor'){
                                        isCheck = "<input type='checkbox' class='checkKategori' checked>"
                                        isDisabled = ""
                                    }
                                }
                                $('#bukti_pemilikan_jaminan_tambahan').append(`
                                    <div class="form-group col-md-6 aspek_jaminan_kategori">
                                        <label>${isCheck} ${valItem.nama}</label>
                                        <input type="hidden" name="id_level[${valItem.id}]" value="${valItem.id}" id="" class="input" ${isDisabled}>
                                        <input type="hidden" name="opsi_jawaban[${valItem.id}]"
                                            value="${valItem.opsi_jawaban}" id="" class="input" ${isDisabled}>
                                        <input type="text" maxlength="255" name="informasi[${valItem.id}]" placeholder="Masukkan informasi"
                                            class="form-control input" ${isDisabled} value="${response.dataJawaban[i]}">
                                    </div>
                                `);
                            }
                        }
                    });

                    $(".checkKategori").click(function() {
                        var input = $(this).closest('.form-group').find(".input")
                        // var input_id = $(this).closest('.form-group').find("input_id").last()
                        // var input_opsi_jawaban = $(this).closest('.form-group').find("input_opsi_jawaban").last()
                        if ($(this).is(':checked')) {
                            input.prop('disabled', false)
                            // input_id.prop('disabled',false)
                            // input_opsi_jawaban.prop('disabled',false)
                        } else {
                            input.val('')
                            input.prop('disabled', true)
                            // input_id.prop('disabled',true)
                            // input_opsi_jawaban.prop('disabled',true)
                        }
                    })
                }
            });
        });
        // end item kategori jaminan tambahan cek apakah milih tanah, kendaraan bermotor, atau tanah dan bangunan

        // milih ijin usaha
        $('#ijin_usaha').change(function(e) {
            let ijinUsaha = $(this).val();
            if (ijinUsaha == 'nib') {
                $('#surat_keterangan_usaha').hide();
                $('#surat_keterangan_usaha_id').attr('disabled', true);
                $('#surat_keterangan_usaha_text').attr('disabled', true);
                $('#surat_keterangan_usaha_text').val("");
                $('#surat_keterangan_usaha_opsi_jawaban').attr('disabled', true);

                $('#docSKU').hide();
                $('#docSKU_id').attr('disabled', true);
                $('#docSKU_text').attr('disabled', true);
                $('#docSKU_upload_file').attr('disabled', true);

                $('#nib').show();
                $('#nib_id').removeAttr('disabled');
                $('#nib_text').removeAttr('disabled');
                $('#nib_opsi_jawaban').removeAttr('disabled');

                $('#docNIB').show();
                $('#docNIB_id').removeAttr('disabled');
                $('#docNIB_text').removeAttr('disabled');
                $('#docNIB_upload_file').removeAttr('disabled');

                $('#npwp').show();
                $('#npwp_id').removeAttr('disabled');
                $('#npwp_text').removeAttr('disabled');
                $('#npwp_opsi_jawaban').removeAttr('disabled');

                $('#docNPWP').show();
                $('#docNPWP_id').removeAttr('disabled');
                $('#docNPWP_text').removeAttr('disabled');
                $('#docNPWP_text').val('');
                $('#docNPWP_upload_file').removeAttr('disabled');
            } else if (ijinUsaha == 'surat_keterangan_usaha') {
                $('#nib').hide();
                $('#nib_id').attr('disabled', true);
                $('#nib_text').attr('disabled', true);
                $('#nib_text').val('');
                $('#nib_opsi_jawaban').attr('disabled', true);

                $('#docNIB').hide();
                $('#docNIB_id').attr('disabled', true);
                $('#docNIB_text').attr('disabled', true);
                $('#docNIB_upload_file').attr('disabled', true);

                $('#surat_keterangan_usaha').show();
                $('#surat_keterangan_usaha_id').removeAttr('disabled');
                $('#surat_keterangan_usaha_text').removeAttr('disabled');
                $('#surat_keterangan_usaha_text').val('');
                $('#surat_keterangan_usaha_opsi_jawaban').removeAttr('disabled');

                $('#docSKU').show();
                $('#docSKU_id').removeAttr('disabled');
                $('#docSKU_text').removeAttr('disabled');
                $('#docSKU_upload_file').removeAttr('disabled');

                $('#npwp').show();
                $('#npwp_id').removeAttr('disabled');
                $('#npwp_text').removeAttr('disabled');
                $('#npwp_opsi_jawaban').removeAttr('disabled');

                $('#docNPWP').show();
                $('#docNPWP_id').removeAttr('disabled');
                $('#docNPWP_text').removeAttr('disabled');
                $('#docNPWP_text').val('');
                $('#docNPWP_upload_file').removeAttr('disabled');
            } else if (ijinUsaha == 'tidak_ada_legalitas_usaha') {
                $('#nib').hide();
                $('#nib_id').attr('disabled', true);
                $('#nib_text').attr('disabled', true);
                $('#nib_text').val('');
                $('#nib_opsi_jawaban').attr('disabled', true);

                $('#docNIB').hide();
                $('#docNIB_id').attr('disabled', true);
                $('#docNIB_text').attr('disabled', true);
                $('#docNIB_text').val('');
                $('#docNIB_upload_file').attr('disabled', true);

                $('#surat_keterangan_usaha').hide();
                $('#surat_keterangan_usaha_id').attr('disabled', true);
                $('#surat_keterangan_usaha_text').attr('disabled', true);
                $('#surat_keterangan_usaha_text').val('');
                $('#surat_keterangan_usaha_opsi_jawaban').attr('disabled', true);

                $('#docSKU').hide();
                $('#docSKU_id').attr('disabled', true);
                $('#docSKU_text').attr('disabled', true);
                $('#docSKU_text').val('');
                $('#docSKU_upload_file').attr('disabled', true);

                $('#npwp').hide();
                $('#npwp_id').attr('disabled', true);
                $('#npwp_text').attr('disabled', true);
                $('#npwp_text').val('');
                $('#npwp_opsi_jawaban').attr('disabled', true);

                $('#docNPWP').hide();
                $('#docNPWP_id').attr('disabled', true);
                $('#docNPWP_text').attr('disabled', true);
                $('#docNPWP_text').val('');
                $('#docNPWP_upload_file').attr('disabled', true);
            } else {
                $('#nib').hide();
                $('#nib_id').attr('disabled', true);
                $('#nib_text').attr('disabled', true);
                $('#nib_text').val('');
                $('#nib_opsi_jawaban').attr('disabled', true);

                $('#docNIB').hide();
                $('#docNIB_id').attr('disabled', true);
                $('#docNIB_text').attr('disabled', true);
                $('#docNIB_text').val('');
                $('#docNIB_upload_file').attr('disabled', true);

                $('#surat_keterangan_usaha').hide();
                $('#surat_keterangan_usaha_id').attr('disabled', true);
                $('#surat_keterangan_usaha_text').attr('disabled', true);
                $('#surat_keterangan_usaha_text').val('');
                $('#surat_keterangan_usaha_opsi_jawaban').attr('disabled', true);

                $('#npwp').show();
                $('#npwp_id').removeAttr('disabled');
                $('#npwp_text').removeAttr('disabled');
                $('#npwp_opsi_jawaban').removeAttr('disabled');

                $('#docNPWP').show();
                $('#docNPWP_id').removeAttr('disabled');
                $('#docNPWP_text').removeAttr('disabled');
                $('#docNPWP_text').val('');
                $('#docNPWP_upload_file').removeAttr('disabled');
            }
        });
        // end milih ijin usaha

        //triger hitung ratio coverage
        $('#thls').change(function(e) {
            hitungRatioCoverage();
        });
        //end triger hitung ratio covarege

        //triger hitung ratio coverage
        $('#nilai_asuransi_penjaminan').change(function(e) {
            hitungRatioCoverage();
        });
        //end triger hitung ratio covarege

        //triger hitung ratio coverage
        $('#jumlah_kredit').change(function(e) {
            hitungRatioCoverage();
        });
        //end triger hitung ratio covarege

        // hitung ratio covarege
        function hitungRatioCoverage() {
            let thls = parseInt($('#thls').val().split('.').join(''));
            let nilaiAsuransi = parseInt($('#nilai_asuransi_penjaminan').val().split('.').join(''));
            let kreditYangDiminta = parseInt($('#jumlah_kredit').val().split('.').join(''));

            let ratioCoverage = (thls + nilaiAsuransi) / kreditYangDiminta * 100; //cek rumus nya lagi
            $('#ratio_coverage').val(ratioCoverage);

            if (ratioCoverage >= 150) {
                $('#ratio_coverage_opsi_0').attr('selected', true);
                $('#ratio_coverage_opsi_1').removeAttr('selected');
                $('#ratio_coverage_opsi_2').removeAttr('selected');
                $('#ratio_coverage_opsi_3').removeAttr('selected');
            } else if (ratioCoverage >= 131 && ratioCoverage < 150) {
                $('#ratio_coverage_opsi_0').removeAttr('selected');
                $('#ratio_coverage_opsi_1').attr('selected', true);
                $('#ratio_coverage_opsi_2').removeAttr('selected');
                $('#ratio_coverage_opsi_3').removeAttr('selected');
            } else if (ratioCoverage >= 110 && ratioCoverage <= 130) {
                $('#ratio_coverage_opsi_0').removeAttr('selected');
                $('#ratio_coverage_opsi_1').removeAttr('selected');
                $('#ratio_coverage_opsi_2').attr('selected', true);
                $('#ratio_coverage_opsi_3').removeAttr('selected');
            } else if (ratioCoverage < 110 && !isNaN(ratioCoverage)) {
                $('#ratio_coverage_opsi_0').removeAttr('selected');
                $('#ratio_coverage_opsi_1').removeAttr('selected');
                $('#ratio_coverage_opsi_2').removeAttr('selected');
                $('#ratio_coverage_opsi_3').attr('selected', true);
            } else {
                $('#ratio_coverage_opsi_0').removeAttr('selected');
                $('#ratio_coverage_opsi_1').removeAttr('selected');
                $('#ratio_coverage_opsi_2').removeAttr('selected');
                $('#ratio_coverage_opsi_3').removeAttr('selected');
            }
        }
        //end hitung ratio covarege

        //triger hitung ratio Tenor Asuransi
        $('#masa_berlaku_asuransi_penjaminan').change(function(e) {
            hitungRatioTenorAsuransi();
        });
        //end triger hitung ratio Tenor Asuransi

        //triger hitung ratio Tenor Asuransi
        $('#tenor_yang_diminta').change(function(e) {
            hitungRatioTenorAsuransi();
        });
        //end triger hitung ratio Tenor Asuransi

        // hitung ratio Tenor Asuransi
        function hitungRatioTenorAsuransi() {
            let masaBerlakuAsuransi = parseInt($('#masa_berlaku_asuransi_penjaminan').val());
            let tenorYangDiminta = parseInt($('#tenor_yang_diminta').val());

            let ratioTenorAsuransi = parseInt(masaBerlakuAsuransi / tenorYangDiminta * 100); //cek rumusnya lagi

            $('#ratio_tenor_asuransi').val(ratioTenorAsuransi);

            if (ratioTenorAsuransi >= 200) {
                $('#ratio_tenor_asuransi_opsi_0').attr('selected', true);
                $('#ratio_tenor_asuransi_opsi_1').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_2').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_3').removeAttr('selected');
            } else if (ratioTenorAsuransi >= 150 && ratioTenorAsuransi < 200) {
                $('#ratio_tenor_asuransi_opsi_0').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_1').attr('selected', true);
                $('#ratio_tenor_asuransi_opsi_2').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_3').removeAttr('selected');
            } else if (ratioTenorAsuransi >= 100 && ratioTenorAsuransi < 150) {
                $('#ratio_tenor_asuransi_opsi_0').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_1').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_2').attr('selected', true);
                $('#ratio_tenor_asuransi_opsi_3').removeAttr('selected');
            } else if (ratioTenorAsuransi < 100 && !isNaN(ratioTenorAsuransi)) {
                $('#ratio_tenor_asuransi_opsi_0').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_1').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_2').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_3').attr('selected', true);
            } else {
                $('#ratio_tenor_asuransi_opsi_0').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_1').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_2').removeAttr('selected');
                $('#ratio_tenor_asuransi_opsi_3').removeAttr('selected');
            }
        }
        //end hitung ratio covarege

        // //triger hitung Persentase Kebutuhan Kredit
        // $('#kebutuhan_kredit').change(function(e) {
        //     hitungPersentaseKebutuhanKredit();
        // });
        // //end triger hitung Persentase Kebutuhan Kredit

        // //triger hitung Persentase Kebutuhan Kredit
        // $('#jumlah_kredit').change(function(e) {
        //     hitungPersentaseKebutuhanKredit();
        // });
        //end triger hitung Persentase Kebutuhan Kredit

        // hitung Persentase Kebutuhan Kredit
        // function hitungPersentaseKebutuhanKredit() {
        //     let kebutuhanKredit = parseInt($('#kebutuhan_kredit').val());
        //     let jumlahKredit = parseInt($('#jumlah_kredit').val());

        //     let persentaseKebutuhanKredit = parseInt(jumlahKredit / kebutuhanKredit * 100); //cek rumusnya lagi

        //     $('#persentase_kebutuhan_kredit').val(persentaseKebutuhanKredit);

        //     if (persentaseKebutuhanKredit <= 80 && !isNaN(persentaseKebutuhanKredit)) {
        //         $('#persentase_kebutuhan_kredit_opsi_0').attr('selected', true);
        //         $('#persentase_kebutuhan_kredit_opsi_1').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_2').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_3').removeAttr('selected');
        //     } else if (persentaseKebutuhanKredit >= 81 && persentaseKebutuhanKredit <= 89) {
        //         $('#persentase_kebutuhan_kredit_opsi_0').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_1').attr('selected', true);
        //         $('#persentase_kebutuhan_kredit_opsi_2').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_3').removeAttr('selected');
        //     } else if (persentaseKebutuhanKredit >= 90 && persentaseKebutuhanKredit <= 100) {
        //         $('#persentase_kebutuhan_kredit_opsi_0').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_1').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_2').attr('selected', true);
        //         $('#persentase_kebutuhan_kredit_opsi_3').removeAttr('selected');
        //     } else if (persentaseKebutuhanKredit > 100 && !isNaN(persentaseKebutuhanKredit)) {
        //         $('#persentase_kebutuhan_kredit_opsi_0').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_1').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_2').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_3').attr('selected', true);
        //     } else {
        //         $('#persentase_kebutuhan_kredit_opsi_0').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_1').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_2').removeAttr('selected');
        //         $('#persentase_kebutuhan_kredit_opsi_3').removeAttr('selected');
        //     }
        // }
        //end Persentase Kebutuhan Kredit

        //triger hitung Repayment Capacity
        $('#persentase_net_income').change(function(e) {
            hitungRepaymentCapacity();
        });
        //end triger hitung Repayment Capacity

        //triger hitung Repayment Capacity
        $('#omzet_penjualan').change(function(e) {
            hitungRepaymentCapacity();
        });
        //end triger hitung Repayment Capacity

        //triger hitung Repayment Capacity
        $('#rencana_peningkatan').change(function(e) {
            hitungRepaymentCapacity();
        });
        //end triger hitung Repayment Capacity

        //triger hitung Repayment Capacity
        $('#installment').change(function(e) {
            hitungRepaymentCapacity();
        });
        //end triger hitung Repayment Capacity

        // hitung Repayment Capacity
        function hitungRepaymentCapacity() {
            let omzetPenjualan = parseInt($('#omzet_penjualan').val().split('.').join(''));
            let persentaseNetIncome = parseInt($('#persentase_net_income').val()) / 100;
            let rencanaPeningkatan = parseInt($('#rencana_peningkatan').val()) / 100;
            let installment = parseInt($('#installment').val().split('.').join(''));

            let repaymentCapacity = parseFloat(persentaseNetIncome * omzetPenjualan * (1 + rencanaPeningkatan) /
                installment); //cek rumusnya lagi

            $('#repayment_capacity').val(repaymentCapacity.toFixed(2));

            if (repaymentCapacity > 2) {
                $('#repayment_capacity_opsi_0').attr('selected', true);
                $('#repayment_capacity_opsi_1').removeAttr('selected');
                $('#repayment_capacity_opsi_2').removeAttr('selected');
                $('#repayment_capacity_opsi_3').removeAttr('selected');
            } else if (repaymentCapacity >= 1.5 && repaymentCapacity < 2) {
                $('#repayment_capacity_opsi_0').removeAttr('selected');
                $('#repayment_capacity_opsi_1').attr('selected', true);
                $('#repayment_capacity_opsi_2').removeAttr('selected');
                $('#repayment_capacity_opsi_3').removeAttr('selected');
            } else if (repaymentCapacity >= 1.25 && repaymentCapacity < 1.5) {
                $('#repayment_capacity_opsi_0').removeAttr('selected');
                $('#repayment_capacity_opsi_1').removeAttr('selected');
                $('#repayment_capacity_opsi_2').attr('selected', true);
                $('#repayment_capacity_opsi_3').removeAttr('selected');
            } else if (repaymentCapacity < 1.25 && !isNaN(repaymentCapacity)) {
                $('#repayment_capacity_opsi_0').removeAttr('selected');
                $('#repayment_capacity_opsi_1').removeAttr('selected');
                $('#repayment_capacity_opsi_2').removeAttr('selected');
                $('#repayment_capacity_opsi_3').attr('selected', true);
            } else {
                $('#repayment_capacity_opsi_0').removeAttr('selected');
                $('#repayment_capacity_opsi_1').removeAttr('selected');
                $('#repayment_capacity_opsi_2').removeAttr('selected');
                $('#repayment_capacity_opsi_3').removeAttr('selected');
            }
        }
        //end Repayment Capacity

        $('.rupiah').keyup(function(e){
            var input = $(this).val()
            $(this).val(formatrupiah(input))
        });

        function formatrupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
        // End Format Rupiah

        // Limit Upload
        $('.limit-size').on('change', function() {
            var size = (this.files[0].size / 1024 / 1024).toFixed(2)
            if (size > 15) {
                $(this).next().css({"display": "block"});
                this.value = ''
            } else {
                $(this).next().css({"display": "none"});
            }
        })

        $('body').on('click', '.file-wrapper .btn-add-file', function(e) {
            const wrapper = $(this).parent().parent().parent();
            const $clone = wrapper.clone();

            $clone.find('[type="file"]').attr('data-id', '');
            $clone.find('[type="file"]').val('');
            $clone.find('.filename').html('');
            $clone.insertAfter(wrapper);
        });

        $('body').on('click', '.file-wrapper .btn-del-file', function(e) {
            const inputData = $(this).parent().parent().find('input[type="file"]');
            const wrapperEl = $(this).parent().parent().parent();

            $.ajax({
                url: '{{ route('pengajuan-kredit.temp.file') }}',
                method: 'DELETE',
                data: {
                    answer_id: inputData.data('id'),
                },
                success: (res) => {
                    inputData.parent().find('.filename').text('');
                    inputData.val('');

                    if(wrapperEl.siblings('.file-wrapper').get().length < 1) return;
                    wrapperEl.remove();
                }
            });
        });
        // End Limit Upload

        @if(count($errors->all()))
        Swal.fire({
            icon: 'error',
            title: 'Error Validation',
            html: `
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                @foreach($errors->all() as $error)
                <ul>
                    <li>{{ $error }}</li>
                </ul>
                @endforeach
            </div>
            `
        });
        @endif
    </script>
    @include('pengajuan-kredit.partials.create-save-script')
    <script src="{{ asset('') }}js/custom.js"></script>
@endpush
