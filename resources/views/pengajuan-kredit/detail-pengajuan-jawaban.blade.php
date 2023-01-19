@extends('layouts.template')
@section('content')
    @include('components.notification')

    <style>
        .sub label:not(.info) {
            font-weight: 400;
        }

        h4 {
            color: #1f1d62;
            font-weight: 600 !important;
            font-size: 20px;
            /* border-bottom: 1px solid #dc3545; */
        }

        h5 {
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

    </style>
    <form id="pengajuan_kredit" action="{{ route('pengajuan.insertkomentar') }}" method="post">
        @csrf
        <div class="form-wizard active" data-index='0' data-done='true'>
            <div class="row">
                    @php
                        $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                            ->where('level', 2)
                            ->where('id_parent', $itemSP->id)
                            ->where('nama', 'Surat Permohonan')
                            ->get();
                    @endphp
                    @foreach ($dataLevelDua as $item)
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
                                <div class="form-group col-md-12">
                                <label for="">{{ $item->nama }}</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <b>Jawaban:</b>
                                    <div class="mt-2 pl-3">
                                        @if ($file_parts['extension'] == 'pdf')
                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="800px"></iframe>
                                        @else
                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="800px">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                <div class="form-group col-md-12">
                    <label for="">Nama Lengkap</label>
                    <input type="text" disabled name="name" id="nama"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $dataUmumNasabah->nama) }}" placeholder="Nama sesuai dengan KTP">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Kabupaten</label>
                    <select name="kabupaten" disabled class="form-control @error('name') is-invalid @enderror select2"
                        id="kabupaten">
                        <option value="">---Pilih Kabupaten----</option>
                        @foreach ($allKab as $item)
                            <option value="{{ old('id', $item->id) }}"
                                {{ old('id', $item->id) == $dataUmumNasabah->id_kabupaten ? 'selected' : '' }}>
                                {{ $item->kabupaten }}</option>
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
                    <select name="kec" disabled id="kecamatan"
                        class="form-control @error('kec') is-invalid @enderror  select2">
                        <option value="">---Pilih Kecamatan----</option>
                        @foreach ($allKec as $kec)
                            <option value="{{ $kec->id }}"
                                {{ $kec->id == $dataUmumNasabah->id_kecamatan ? 'selected' : '' }}>{{ $kec->kecamatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('kec')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Desa</label>
                    <select disabled name="desa" id="desa" class="form-control @error('desa') is-invalid @enderror select2">
                        <option value="">---Pilih Desa----</option>
                        @foreach ($allDesa as $desa)
                            <option value="{{ $desa->id }}"
                                {{ $desa->id == $dataUmumNasabah->id_desa ? 'selected' : '' }}>{{ $desa->desa }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Alamat Rumah</label>
                    <textarea disabled name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror" id="" cols="30"
                        rows="4"
                        placeholder="Alamat Rumah disesuaikan dengan KTP">{{ old('alamat_rumah', $dataUmumNasabah->alamat_rumah) }}</textarea>
                    @error('alamat_rumah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <hr>
                </div>
                <div class="form-group col-md-12">
                    <label for="">Alamat Usaha</label>
                    <textarea disabled name="alamat_usaha" class="form-control @error('alamat_usaha') is-invalid @enderror" id="" cols="30"
                        rows="4"
                        placeholder="Alamat Usaha disesuaikan dengan KTP">{{ old('alamat_usaha', $dataUmumNasabah->alamat_usaha) }}</textarea>
                    @error('alamat_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">No. KTP</label>
                    <input disabled type="text" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror"
                        id="" value="{{ old('no_ktp', $dataUmumNasabah->no_ktp) }}"
                        placeholder="Masukkan 16 digit No. KTP">
                    @error('no_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @php
                    $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemKTPSu->id)
                        ->where('nama', 'Foto KTP Suami')
                        ->get();
                @endphp
                @foreach ($dataLevelDua as $item)
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
                            <div class="form-group col-md-6">
                                <label for="">{{ $item->nama }}</label>
                                <div class="col-md-6 form-group">
                                    <b>Jawaban:</b>
                                    <div class="mt-2">
                                        @if ($file_parts['extension'] == 'pdf')
                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="400px"></iframe>
                                        @else
                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="400px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                @php
                    $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemKTPSu->id)
                        ->where('nama', 'Foto KTP Istri')
                        ->get();
                @endphp
                @foreach ($dataLevelDua as $item)
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
                            <div class="form-group col-md-6">
                                <label for="">{{ $item->nama }}</label>
                                <div class="col-md-6 form-group">
                                    <b>Jawaban:</b>
                                    <div class="mt-2">
                                        @if ($file_parts['extension'] == 'pdf')
                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="400px"></iframe>
                                        @else
                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="400px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                <div class="form-group col-md-4">
                    <label for="">Tempat</label>
                    <input disabled type="text" name="tempat_lahir" id=""
                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir', $dataUmumNasabah->tempat_lahir) }}" placeholder="Tempat Lahir">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Tanggal Lahir</label>
                    <input disabled type="date" name="tanggal_lahir" id=""
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $dataUmumNasabah->tanggal_lahir) }}" placeholder="Tempat Lahir">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Status</label>
                    <select disabled name="status" id="" class="form-control @error('status') is-invalid @enderror select2">
                        <option value=""> --Pilih Status --</option>
                        <option value="menikah"
                            {{ old('status', $dataUmumNasabah->status) == 'menikah' ? 'selected' : '' }}>
                            Menikah</option>
                        <option value="belum menikah"
                            {{ old('status', $dataUmumNasabah->status) == 'belum menikah' ? 'selected' : '' }}>Belum
                            Menikah
                        </option>
                        <option value="duda" {{ old('status', $dataUmumNasabah->status) == 'duda' ? 'selected' : '' }}>
                            Duda
                        </option>
                        <option value="janda" {{ old('status', $dataUmumNasabah->status) == 'janda' ? 'selected' : '' }}>
                            Janda
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Sektor Kredit</label>
                    <select disabled name="sektor_kredit" id=""
                        class="form-control @error('sektor_kredit') is-invalid @enderror select2">
                        <option value=""> --Pilih Sektor Kredit -- </option>
                        <option value="perdagangan"
                            {{ old('sektor_kredit', $dataUmumNasabah->sektor_kredit) == 'perdagangan' ? 'selected' : '' }}>
                            Perdagangan</option>
                        <option value="perindustrian"
                            {{ old('sektor_kredit', $dataUmumNasabah->sektor_kredit) == 'perindustrian' ? 'selected' : '' }}>
                            Perindustrian</option>
                        <option value="dll"
                            {{ old('sektor_kredit', $dataUmumNasabah->sektor_kredit) == 'dll' ? 'selected' : '' }}>dll
                        </option>
                    </select>
                    @error('sektor_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">{{ $itemSlik->nama }}</label>
                    <br>
                    <b>Jawaban : </b>
                    <div class="mt-2 pl-2">
                        <p class="badge badge-info text-lg">
                            <b>{{ $itemSlik->option }}</b>
                        </p>
                    </div>
                    @php
                        $komentarSlik = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                            ->where('id_pengajuan', $dataUmum->id)
                            ->where('id_item', $itemSlik->id_item)
                            ->first();
                    @endphp
                    <div class="input-group input-b-bottom">
                        <input type="hidden" name="id_item[]" value="{{ $itemSlik->id_item }}">
                        <input type="hidden" name="id_option[]" value="{{ $itemSlik->id_jawaban }}">
                        <input type="text" class="form-control komentar" name="komentar_penyelia[]"
                            placeholder="Masukkan Komentar"
                            value="{{ isset($komentarSlik->komentar) ? $komentarSlik->komentar : '' }}">
                        <div class="input-skor">
                            <input type="number" class="form-control" placeholder="" name="skor_penyelia[]" onKeyUp="if(this.value>4){this.value='4';}else if(this.value<0){this.value='0';}"
                                {{ $itemSlik->status_skor == 0 ? 'readonly' : '' }}
                                value="{{ $itemSlik->skor_penyelia != null ? $itemSlik->skor_penyelia : $itemSlik->skor }}">
                        </div>
                    </div>
                </div>
                @php
                    // $key += 1;
                    // check level 2
                    $dataLS = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemSP->id)
                        ->where('nama', 'Laporan SLIK')
                        ->get();
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
                            <div class="form-group col-md-12">
                            <label for="">{{ $item->nama }}</label>
                            </div>
                            <div class="col-md-12 form-group">
                                <b>Jawaban:</b>
                                <div class="mt-2 pl-3">
                                    @if ($file_parts['extension'] == 'pdf')
                                        <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="800px"></iframe>
                                    @else
                                        <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="800px">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                <div class="form-group col-md-12">
                    <label for="">Jenis Usaha</label>
                    <textarea disabled name="jenis_usaha" class="form-control @error('jenis_usaha') is-invalid @enderror" id="" cols="30"
                        rows="4"
                        placeholder="Jenis Usaha secara spesifik">{{ old('jenis_usaha', $dataUmumNasabah->jenis_usaha) }}</textarea>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">Jumlah Kredit yang diminta</label>
                    <input type="number" disabled name="jumlah_kredit"
                        class="form-control @error('jumlah_kredit') is-invalid @enderror" placeholder="Jumlah Kredit"
                        value="{{ old('jumlah_kredit', $dataUmumNasabah->jumlah_kredit) }}">
                    @error('jumlah_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="">Tenor Yang Diminta</label>
                    <input type="text" disabled name="tenor_yang_diminta"
                        class="form-control @error('tenor_yang_diminta') is-invalid @enderror"
                        placeholder="Tenor Yang Diminta"
                        value="{{ old('tenor_yang_diminta', $dataUmumNasabah->tenor_yang_diminta) }} Tahun">
                    @error('tenor_yang_diminta')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Tujuan Kredit</label>
                    <textarea disabled name="tujuan_kredit" class="form-control @error('tujuan_kredit') is-invalid @enderror" id=""
                        cols="30" rows="4"
                        placeholder="Tujuan Kredit">{{ old('tujuan_kredit', $dataUmumNasabah->tujuan_kredit) }}</textarea>
                    @error('tujuan_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jaminan yang disediakan</label>
                    <textarea disabled name="jaminan" class="form-control @error('jaminan') is-invalid @enderror" id="" cols="30" rows="4"
                        placeholder="Jaminan yang disediakan">{{ old('jaminan', $dataUmumNasabah->jaminan_kredit) }}</textarea>
                    @error('jaminan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hubungan Bank</label>
                    <textarea disabled name="hubungan_bank" class="form-control @error('hubungan_bank') is-invalid @enderror" id=""
                        cols="30" rows="4"
                        placeholder="Hubungan dengan Bank">{{ old('hubungan_bank', $dataUmumNasabah->hubungan_bank) }}</textarea>
                    @error('hubungan_bank')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hasil Verifikasi</label>
                    <textarea disabled name="hasil_verifikasi" class="form-control @error('hasil_verifikasi') is-invalid @enderror" id=""
                        cols="30" rows="4"
                        placeholder="Hasil Verifikasi Karakter Umum">{{ old('hasil_verifikasi', $dataUmumNasabah->verifikasi_umum) }}</textarea>
                    @error('hasil_verifikasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <input type="hidden" id="jumlahData" name="jumlahData" hidden value="{{ count($dataAspek) + 1 }}">
        <input type="hidden" id="id_pengajuan" name="id_pengajuan" value="{{ $dataUmum->id }}">
        @php
            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                ->where('id_pengajuan', $dataUmum->id)
                ->get();
        @endphp
        @foreach ($dataDetailJawaban as $itemJawabanDetail)
            <input type="hidden" name="id_jawaban[]" value="{{ $itemJawabanDetail->id }}" id="">
        @endforeach
        @foreach ($dataAspek as $key => $value)
            @php
                $key += 1;
                // check level 2
                $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                    ->where('level', 2)
                    ->where('id_parent', $value->id)
                    ->get();

                // check level 4
                $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                    ->where('level', 4)
                    ->where('id_parent', $value->id)
                    ->get();
                $pendapatStafPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                    ->whereNotNull('id_staf')
                    ->where('id_aspek', $value->id)
                    ->first();
                $pendapatPenyeliaPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                    ->whereNotNull('id_penyelia')
                    ->where('id_aspek', $value->id)
                    ->first();
            @endphp
            {{-- level level 2 --}}

            <div class="form-wizard $key" data-index='{{ $key }}' data-done='true'>
                <div class="">
                    @foreach ($dataLevelDua as $item)
                        @if ($item->opsi_jawaban != 'option')
                            @php
                                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                    ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                    ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                    ->where('jawaban_text.id_jawaban', $item->id)
                                    ->get();
                            @endphp
                            @foreach ($dataDetailJawabanText as $itemTextDua)
                                <div class="row">
                                    <div class="form-group col-md-12 mb-0">
                                        <label for="">{{ $item->nama }}</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <b>Jawaban: </b>
                                        <div class="mt-2 pl-3">
                                            @if ($item->opsi_jawaban == 'file')
                                                @php
                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                @endphp
                                                @if ($file_parts['extension'] == 'pdf')
                                                    <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="800px"></iframe>
                                                @else
                                                    <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="800px">
                                                @endif
                                            @else
                                                <p class="badge badge-info text-lg"><b> {{ $itemTextDua->opsi_text }}
                                                        {{ $item->opsi_jawaban == 'persen' ? '%' : '' }}</b></p>
                                                @if ($itemTextDua->is_commentable)
                                                    <div class="input-k-bottom">
                                                        <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                        <input type="text" class="form-control komentar"
                                                            name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <input type="text" hidden class="form-control mb-3" placeholder="Masukkan komentar"
                                    name="komentar_penyelia" value="{{ $itemTextDua->nama }}" disabled>
                                <input type="text" hidden class="form-control mb-3" placeholder="Masukkan komentar"
                                    name="komentar_penyelia" value="{{ $itemTextDua->opsi_text }}" disabled>
                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextDua->id }}">
                                <input type="hidden" name="id[]" value="{{ $itemTextDua->id_item }}">
                            @endforeach
                        @endif
                        @php
                            $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                ->where('id_item', $item->id)
                                ->get();
                            $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                ->where('id_item', $item->id)
                                ->get();

                            $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                ->where('id_pengajuan', $dataUmum->id)
                                ->where('id_item', $item->id)
                                ->where('id_user', Auth::user()->id)
                                ->first();

                            // check level 3
                            $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                                ->where('level', 3)
                                ->where('id_parent', $item->id)
                                ->get();
                        @endphp
                        @foreach ($dataOption as $itemOption)
                            @if ($itemOption->option == '-')
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h4>{{ $item->nama }}</h4>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if (count($dataJawaban) != 0)
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">{{ $item->nama }}</label>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($dataJawaban as $key => $itemJawaban)
                                    @php
                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                            ->where('id_pengajuan', $dataUmum->id)
                                            ->get();
                                        $count = count($dataDetailJawaban);
                                        for ($i = 0; $i < $count; $i++) {
                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                        }
                                        $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                            ->where('id_pengajuan', $dataUmum->id)
                                            ->where('id_jawaban', $itemJawaban->id)
                                            ->first();
                                    @endphp
                                    @if (in_array($itemJawaban->id, $data))
                                        @if (isset($data))
                                            <div class="col-md-12 form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <b>Jawaban : </b>
                                                        <div class="mt-2 pl-2">
                                                            <p class="badge badge-info text-lg">
                                                                <b>{{ $itemJawaban->option }}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group input-b-bottom">
                                                    @if ($item->is_commentable == 'Ya')
                                                        <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                        <input type="hidden" name="id_option[]"
                                                            value="{{ $itemJawaban->id }}">
                                                        <input type="text" class="form-control komentar"
                                                            name="komentar_penyelia[]" placeholder="Masukkan Komentar"
                                                            value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                        <div class="input-skor">
                                                            <input type="number" class="form-control" placeholder=""
                                                                name="skor_penyelia[]"  onKeyUp="if(this.value>4){this.value='4';}else if(this.value<0){this.value='0';}"
                                                                {{ $item->status_skor == 0 ? 'readonly' : '' }}
                                                                value="{{ $getSkorPenyelia->skor_penyelia != null ? $getSkorPenyelia->skor_penyelia : $itemJawaban->skor }}">

                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="text" hidden class="form-control mb-3"
                                                placeholder="Masukkan komentar" name="komentar_penyelia"
                                                value="{{ $itemJawaban->option }}" disabled>
                                            <input type="text" hidden class="form-control mb-3"
                                                placeholder="Masukkan komentar" name="komentar_penyelia"
                                                value="{{ $itemJawaban->skor }}" disabled>
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @if ($itemTiga->opsi_jawaban != 'option')
                                @php
                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                        ->where('jawaban_text.id_jawaban', $itemTiga->id)
                                        ->get();
                                @endphp
                                @foreach ($dataDetailJawabanText as $itemTextTiga)
                                    @if ($itemTextTiga->nama != 'Ratio Tenor Asuransi')    
                                        <div class="row col-md-6">
                                            <div class="form-group col-md-12 mb-0">
                                                <label for="">{{ $itemTextTiga->nama }}</label>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <b>Jawaban: A</b>
                                                <div class="mt-2 pl-3">
                                                    <p class="badge badge-info text-lg"><b>
                                                            {{ $itemTextTiga->opsi_text }}
                                                            {{ $itemTiga->opsi_jawaban == 'persen' ? '%' : '' }}</b></p>
                                                    @if ($item->is_commentable == 'Ya')
                                                        <div class="input-k-bottom">
                                                            <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                            <input type="text" class="form-control komentar"
                                                                name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control mb-3" placeholder="Masukkan komentar"
                                            name="komentar_penyelia" value="{{ $itemTextTiga->nama }}" disabled>
                                        <input type="hidden" class="form-control mb-3" placeholder="Masukkan komentar"
                                            name="komentar_penyelia" value="{{ $itemTextTiga->opsi_text }}" disabled>

                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextTiga->id }}">
                                        <input type="hidden" name="id[]" value="{{ $itemTextTiga->id_item }}">
                                    @elseif ($itemTextTiga->nama == 'Dokumen NIB') 
                                        @php
                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text);
                                        @endphp
                                        @if ($file_parts['extension'] == 'pdf')
                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}" width="100%" height="800px"></iframe>
                                        @else
                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}" alt="" width="800px">
                                    @endif
                                @endforeach
                            @endif
                            @php
                                // check  jawaban level tiga
                                $dataJawabanLevelTiga = \App\Models\OptionModel::where('option', '!=', '-')
                                    ->where('id_item', $itemTiga->id)
                                    ->get();
                                $dataOptionTiga = \App\Models\OptionModel::where('option', '=', '-')
                                    ->where('id_item', $itemTiga->id)
                                    ->get();
                                $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                    ->where('id_pengajuan', $dataUmum->id)
                                    ->where('id_item', $itemTiga->id)
                                    ->first();
                                // check level empat
                                $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                                    ->where('level', 4)
                                    ->where('id_parent', $itemTiga->id)
                                    ->get();
                                // check jawaban kelayakan
                                $checkJawabanKelayakan = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan', $dataUmum->id)->whereIn('id_jawaban', ['183','184'])->first();
                            @endphp

                            @foreach ($dataOptionTiga as $itemOptionTiga)
                                @if ($itemOptionTiga->option == '-')
                                    @if (isset($checkJawabanKelayakan))
                                        
                                    @else    
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <h5> {{ $itemTiga->nama }}</h5>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach

                            @if (count($dataJawabanLevelTiga) != 0)
                                @if ($itemTiga->nama == 'Ratio Tenor Asuransi Opsi')
                                    
                                @else
                                    @if (isset($checkJawabanKelayakan))
                                        @if ($itemTiga->nama != 'Kelayakan Usaha')
                                            
                                        @else    
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">{{ $itemTiga->nama }}</label>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        @if ($itemTiga->nama != 'Kelayakan Usaha')    
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">{{ $itemTiga->nama }}</label>
                                                </div>
                                            </div>
                                        @else
                                            
                                        @endif
                                    @endif
                                    <div class="row">
                                        @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                            @php
                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->get();

                                                $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->where('id_jawaban', $itemJawabanLevelTiga->id)
                                                    ->first();
                                                $count = count($dataDetailJawaban);
                                                for ($i = 0; $i < $count; $i++) {
                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                }
                                            @endphp
                                            @if (in_array($itemJawabanLevelTiga->id, $data))
                                                @if (isset($data))
                                                    <div class="col-md-12 form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <b>Jawaban : </b>
                                                                <div class="mt-2 pl-2">
                                                                    <p class="badge badge-info text-lg">
                                                                        <b>{{ $itemJawabanLevelTiga->option }}</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group input-b-bottom">
                                                            @if ($itemTiga->is_commentable == 'Ya')
                                                                <input type="hidden" name="id_item[]"
                                                                    value="{{ $itemTiga->id }}">
                                                                <input type="hidden" name="id_option[]"
                                                                    value="{{ $itemJawabanLevelTiga->id }}">
                                                                <input type="text" class="form-control komentar"
                                                                    name="komentar_penyelia[]" placeholder="Masukkan Komentar"
                                                                    value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                <div class="input-skor">
                                                                    <input type="number" class="form-control" placeholder=""
                                                                        name="skor_penyelia[]" onKeyUp="if(this.value>4){this.value='4';}else if(this.value<0){this.value='0';}"
                                                                        {{ $itemTiga->status_skor == 0 ? 'readonly' : '' }}
                                                                        value="{{ $getSkorPenyelia->skor_penyelia != null ? $getSkorPenyelia->skor_penyelia : $itemJawabanLevelTiga->skor }}">

                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <input type="text" hidden class="form-control mb-3"
                                                        placeholder="Masukkan komentar" name="komentar_penyelia"
                                                        value="{{ $itemJawabanLevelTiga->option }}" disabled>
                                                    <input type="text" hidden class="form-control mb-3"
                                                        placeholder="Masukkan komentar" name="skor_penyelia"
                                                        value="{{ $itemJawabanLevelTiga->skor }}" disabled>
                                                    <input type="hidden" name="id[]" value="{{ $itemTiga->id }}">
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                {{-- @php
                                echo "<pre>";
                                    print($itemEmpat);
                                echo "</pre>";
                            @endphp --}}

                                @if ($itemEmpat->opsi_jawaban != 'option')
                                    @php
                                        $dataDetailJawabanTextEmpat = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                            ->where('jawaban_text.id_jawaban', $itemEmpat->id)
                                            ->get();
                                    @endphp
                                    {{-- @php
                                    echo "<pre>";
                                        print($dataDetailJawabanTextEmpat);
                                    echo "</pre>";
                                @endphp --}}
                                    @foreach ($dataDetailJawabanTextEmpat as $keyEmpat => $itemTextEmpat)
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-0">
                                                @if ($itemTextEmpat->id_jawaban == 148)
                                                    <label for="">{{ $itemTextEmpat->nama .' '. $keyEmpat + 1 }}</label>
                                                @else
                                                    <label for="">{{ $itemTextEmpat->nama }}</label>
                                                @endif
                                                <div class="col-md-6 form-group">
                                                    <b>Jawaban:</b>
                                                    <div class="mt-2">
                                                        @if ($itemEmpat->opsi_jawaban == 'file')
                                                            @php
                                                                $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                            @endphp
                                                            @if ($file_parts['extension']=='pdf')
                                                                <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}" width="100%" height="500px"></iframe>
                                                            @else
                                                                <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}" alt="" width="500px">
                                                            @endif
                                                        @else
                                                            <p class="badge badge-info text-lg"><b>
                                                                    {{ $itemTextEmpat->opsi_text }}
                                                                    {{ $itemEmpat->opsi_jawaban == 'persen' ? '%' : '' }}</b>
                                                            </p>
                                                            @if ($itemTextEmpat->is_commentable == 'Ya')
                                                                <div class="input-k-bottom">
                                                                    <input type="hidden" name="id_item[]"
                                                                        value="{{ $item->id }}">
                                                                    <input type="text" class="form-control komentar"
                                                                        name="komentar_penyelia[]"
                                                                        placeholder="Masukkan Komentar">
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control mb-3" placeholder="Masukkan komentar"
                                            name="komentar_penyelia" value="{{ $itemTextEmpat->nama }}" disabled>
                                        <input type="hidden" class="form-control mb-3" placeholder="Masukkan komentar"
                                            name="komentar_penyelia" value="{{ $itemTextEmpat->opsi_text }}" disabled>
                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextEmpat->id }}">
                                        <input type="hidden" name="id[]" value="{{ $itemTextEmpat->id_item }}">
                                    @endforeach
                                @endif
                                @php
                                    // check level empat
                                    $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option', '!=', '-')
                                        ->where('id_item', $itemEmpat->id)
                                        ->get();
                                    $dataOptionEmpat = \App\Models\OptionModel::where('option', '=', '-')
                                        ->where('id_item', $itemEmpat->id)
                                        ->get();
                                    $isJawabanExist = \App\Models\OptionModel::join('jawaban', 'jawaban.id_jawaban', 'option.id')
                                        ->where('jawaban.id_pengajuan', $dataUmum->id)
                                        ->where('id_item', $itemEmpat->id)
                                        ->count();

                                    $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->where('id_item', $itemEmpat->id)
                                        ->first();
                                    // echo "<pre>";
                                    // print_r ($dataOptionEmpat);
                                    // echo "</pre>";
                                    // ;
                                @endphp
                                @if ($itemEmpat->opsi_jawaban == 'option' && $isJawabanExist > 0)
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-0">
                                            <label for="">{{ $itemEmpat->nama }}</label>
                                        </div>
                                    </div>
                                @endif

                                {{-- Data jawaban Level Empat --}}
                                @if (count($dataJawabanLevelEmpat) != 0)
                                    <div class="row">
                                        @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                            @php
                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->get();
                                                $count = count($dataDetailJawaban);
                                                for ($i = 0; $i < $count; $i++) {
                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                }
                                                $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->where('id_jawaban', $itemJawabanLevelEmpat->id)
                                                    ->first();
                                            @endphp
                                            @if (in_array($itemJawabanLevelEmpat->id, $data))
                                                @if (isset($data))
                                                    <div class="col-md-12 form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <b>Jawaban : </b>
                                                                <div class="mt-2 pl-2">
                                                                    <p class="badge badge-info text-lg">
                                                                        <b>{{ $itemJawabanLevelEmpat->option }}</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="input-group input-b-bottom">
                                                            @if ($itemEmpat->is_commentable == 'Ya')
                                                                <input type="hidden" name="id_item[]"
                                                                    value="{{ $itemEmpat->id }}">
                                                                <input type="hidden" name="id_option[]"
                                                                    value="{{ $itemJawabanLevelEmpat->id }}">
                                                                <input type="text" class="form-control komentar"
                                                                    name="komentar_penyelia[]"
                                                                    placeholder="Masukkan Komentar"
                                                                    value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                <div class="input-skor">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="skor_penyelia[]" onKeyUp="if(this.value>4){this.value='4';}else if(this.value<0){this.value='0';}"
                                                                        {{ $itemEmpat->status_skor == 0 ? 'readonly' : '' }}
                                                                        value="{{ $getSkorPenyelia->skor_penyelia != null ? $getSkorPenyelia->skor_penyelia : $itemJawabanLevelEmpat->skor }}">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control mb-3"
                                                        placeholder="Masukkan komentar" name="komentar_penyelia"
                                                        value="{{ $itemJawabanLevelEmpat->option }}" disabled>
                                                    <input type="hidden" name="id[]" value="{{ $itemEmpat->id }}">
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                    @if (Auth::user()->role == 'PBP')    
                    @php
                        $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                            ->where('id_aspek', $value->id)
                            ->where('id_pbp', Auth::user()->id)
                            ->first();
                    @endphp
                        <div class="form-group col-md-12">
                            <label for="">Pendapat dan Usulan {{ $value->nama }}</label>
                            <input type="hidden" name="id_aspek[]" value="{{ $value->id }}">
                            <textarea name="pendapat_per_aspek[]" class="form-control @error('pendapat_per_aspek') is-invalid @enderror" id=""
                                cols="30" rows="4"
                                placeholder="Pendapat Per Aspek">{{ isset($getPendapatPerAspek->pendapat_per_aspek) ? $getPendapatPerAspek->pendapat_per_aspek : '' }}</textarea>
                            @error('pendapat_per_aspek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <hr>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Penyelia Kredit</label>
                        <p>{{ $pendapatPenyeliaPerAspek->pendapat_per_aspek }}</p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Staf Kredit</label>
                        <p>{{ $pendapatStafPerAspek->pendapat_per_aspek }}</p>
                    </div>
                    @else
                    @php
                        $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                            ->where('id_aspek', $value->id)
                            ->where('id_penyelia', Auth::user()->id)
                            ->first();
                    @endphp
                        <div class="form-group col-md-12">
                            <label for="">Pendapat dan Usulan {{ $value->nama }}</label>
                            <input type="hidden" name="id_aspek[]" value="{{ $value->id }}">
                            <textarea name="pendapat_per_aspek[]" class="form-control @error('pendapat_per_aspek') is-invalid @enderror" id=""
                                cols="30" rows="4"
                                placeholder="Pendapat Per Aspek">{{ isset($getPendapatPerAspek->pendapat_per_aspek) ? $getPendapatPerAspek->pendapat_per_aspek : '' }}</textarea>
                            @error('pendapat_per_aspek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Staf Kredit</label>
                        <p>{{ $pendapatStafPerAspek->pendapat_per_aspek }}</p>
                    </div>
                        
                    @endif
            </div>
        @endforeach
        {{-- pendapat dan usulan --}}
        @if (Auth::user()->role == 'PBP')    
            <div class="form-wizard" data-index='{{ count($dataAspek) + 1 }}' data-done='true'>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Staf Kredit</label>
                        <br>
                        <span>
                            {{ $pendapatDanUsulanStaf->komentar_staff }}
                        </span>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Penyelia Kredit</label>
                        <br>
                        <span>
                            {{ $pendapatDanUsulanPenyelia->komentar_penyelia }}
                        </span>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan PBP</label>
                        <textarea name="komentar_pbp_keseluruhan"
                            class="form-control @error('komentar_pbp_keseluruhan') is-invalid @enderror" id=""
                            cols="30" rows="4" placeholder="Pendapat dan Usulan Penyelia Kredit"
                            required>{{ isset($pendapatDanUsulanPBP->komentar_pbp) ? $pendapatDanUsulanPBP->komentar_pbp : '' }}</textarea>
                        @error('komentar_pbp_keseluruhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <hr>
                    </div>
                </div>
            </div>
        @else    
            <div class="form-wizard" data-index='{{ count($dataAspek) + 1 }}' data-done='true'>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Staf Kredit</label>
                        <br>
                        <span>
                            {{ $pendapatDanUsulanStaf->komentar_staff }}
                        </span>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Pendapat dan Usulan Penyelia</label>
                        <textarea name="komentar_penyelia_keseluruhan"
                            class="form-control @error('komentar_penyelia_keseluruhan') is-invalid @enderror" id=""
                            cols="30" rows="4" placeholder="Pendapat dan Usulan Penyelia"
                            required>{{ isset($pendapatDanUsulanPenyelia->komentar_penyelia) ? $pendapatDanUsulanPenyelia->komentar_penyelia : '' }}</textarea>
                        @error('komentar_penyelia_keseluruhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <hr>
                    </div>
                </div>
            </div>
        @endif
        {{-- end pendapat dan usulan --}}
        <div class="row form-group">
            <div class="col text-right">
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
    <script>
        var jumlahData = $('#jumlahData').val();
        for (let index = 0; index <= jumlahData; index++) {
            for (let index = 0; index <= parseInt(jumlahData); index++) {
                var selected = index == parseInt(jumlahData) ? ' selected' : ''
                $(".side-wizard li[data-index='" + index + "']").addClass('active' + selected)
                $(".side-wizard li[data-index='" + index + "'] a span i").removeClass('fa fa-ban')
                if ($(".side-wizard li[data-index='" + index + "'] a span i").html() == '' || $(
                        ".side-wizard li[data-index='" + index + "'] a span i").html() == '0%') {
                    $(".side-wizard li[data-index='" + index + "'] a span i").html('0%')
                }
            }

            var form = ".form-wizard[data-index='" + index + "']"

            var input = $(form + " input:disabled");
            var select = $(form + " select")
            var textarea = $(form + " textarea")

            var ttlInput = 0;
            var ttlInputFilled = 0;
            $.each(input, function(i, v) {
                ttlInput++
                if (v.value != '') {
                    ttlInputFilled++
                }
            })
            var ttlSelect = 0;
            var ttlSelectFilled = 0;
            $.each(select, function(i, v) {
                ttlSelect++
                if (v.value != '') {
                    ttlSelectFilled++
                }
            })

            var ttlTextarea = 0;
            var ttlTextareaFilled = 0;
            $.each(textarea, function(i, v) {
                ttlTextarea++
                if (v.value != '') {
                    ttlTextareaFilled++
                }
            })

            var ttlInput = 0;
            var ttlInputFilled = 0;
            $.each(input, function(i, v) {
                ttlInput++
                if (v.value != '') {
                    ttlInputFilled++
                }
            })
            if (index == 1) {
                var allInput = ttlInput - 1
                var allInputFilled = ttlInputFilled
            }
            else if (index == 3 || index == 5) {
                var allInput = ttlInput - 2
                var allInputFilled = ttlInputFilled
            }
            else{
                var allInput = ttlInput
                var allInputFilled = ttlInputFilled
            }
            console.log(ttlInput);
            console.log(ttlInputFilled);

            var percentage = parseInt(allInputFilled / allInput * 100);
            if (index == 7) {
                if ($("textarea[name=komentar_penyelia_keseluruhan]").val() == '') {
                    $(".side-wizard li[data-index='" + index + "'] a span i").html("0%")
                } else {
                    $(".side-wizard li[data-index='" + index + "'] a span i").html("100%")
                }
            }
            else{
                $(".side-wizard li[data-index='" + index + "'] a span i").html(isNaN(percentage) ? 0 + "%" : percentage + "%")
            }
            // $(".side-wizard li[data-index='"+index+"'] input.answer").val(allInput);
            // $(".side-wizard li[data-index='"+index+"'] input.answerFilled").val(allInputFilled);
        }

        function cekBtn() {
            var indexNow = $(".form-wizard.active").data('index')
            var prev = parseInt(indexNow) - 1
            var next = parseInt(indexNow) + 1

            $(".btn-prev").hide()
            $(".btn-simpan").hide()
            $(".progress").prop('disabled', true);

            if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
                $(".btn-prev").show()
            }
            if (parseInt(indexNow) == parseInt(jumlahData)) {
                // $(".btn-next").click(function(e) {
                //     if (parseInt(indexNow) != parseInt(jumlahData)) {
                //         $(".btn-next").show()

                //     }
                $(".btn-simpan").show()
                $(".progress").prop('disabled', false);
                $(".btn-next").hide()
                // });
                // $(".btn-next").show()

            } else {
                $(".btn-next").show()
                $(".btn-simpan").hide()

            }
        }

        function cekWizard(isNext = false) {
            var indexNow = $(".form-wizard.active").data('index')
            // console.log(indexNow);
            if (isNext) {
                $(".side-wizard li").removeClass('active')
            }

            $(".side-wizard li").removeClass('selected')

            for (let index = 0; index <= parseInt(indexNow); index++) {
                var selected = index == parseInt(indexNow) ? ' selected' : ''
                $(".side-wizard li[data-index='" + index + "']").addClass('active' + selected)
                // $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa fa-ban')
                if ($(".side-wizard li[data-index='" + index + "'] a span i").html() == '' || $(
                        ".side-wizard li[data-index='" + index + "'] a span i").html() == '0%') {
                    $(".side-wizard li[data-index='" + index + "'] a span i").html('0%')
                }
            }

        }
        cekBtn()
        cekWizard()

        $(".side-wizard li a").click(function() {
            var dataIndex = $(this).closest('li').data('index')
            if ($(this).closest('li').hasClass('active')) {
                $(".form-wizard").removeClass('active')
                $(".form-wizard[data-index='" + dataIndex + "']").addClass('active')
                cekWizard()
                cekBtn(true)
            }
        })

        function setPercentage(formIndex) {
            var form = ".form-wizard[data-index='" + formIndex + "']"
        }

        $(".btn-next").click(function(e) {
            e.preventDefault();
            var indexNow = $(".form-wizard.active").data('index')
            var next = parseInt(indexNow) + 1
            // \($(".form-wizard[data-index='"+next+"']").length==1);
            // console.log($(".form-wizard[data-index='"+  +"']"));
            if ($(".form-wizard[data-index='" + next + "']").length == 1) {
                // console.log(indexNow);
                $(".form-wizard").removeClass('active')
                $(".form-wizard[data-index='" + next + "']").addClass('active')
                $(".form-wizard[data-index='" + indexNow + "']").attr('data-done', 'true')
            }


            cekWizard()
            cekBtn(true)
            setPercentage(indexNow)
        })
        setPercentage(0)

        $(".btn-prev").click(function(e) {
            event.preventDefault(e);
            var indexNow = $(".form-wizard.active").data('index')
            var prev = parseInt(indexNow) - 1
            if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
                $(".form-wizard").removeClass('active')
                $(".form-wizard[data-index='" + prev + "']").addClass('active')
            }
            cekWizard()
            cekBtn()
            e.preventDefault();
        })
    </script>
@endpush
