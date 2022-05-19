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
    <div class="form-wizard active" data-index='0' data-done='true'>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Nama Lengkap</label>
                <input type="text" disabled name="name" id="nama" class="form-control @error('name') is-invalid @enderror"
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
                <select name="kec" disabled id="kecamatan" class="form-control @error('kec') is-invalid @enderror  select2">
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
                            {{ $desa->id == $dataUmumNasabah->id_kecamatan ? 'selected' : '' }}>{{ $desa->desa }}
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
                <input disabled type="text" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" id=""
                    value="{{ old('no_ktp', $dataUmumNasabah->no_ktp) }}" placeholder="Masukkan 16 digit No. KTP">
                @error('no_ktp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
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
                    <option value="menikah" {{ old('status', $dataUmumNasabah->status) == 'menikah' ? 'selected' : '' }}>
                        Menikah</option>
                    <option value="belum menikah"
                        {{ old('status', $dataUmumNasabah->status) == 'belum menikah' ? 'selected' : '' }}>Belum Menikah
                    </option>
                    <option value="duda" {{ old('status', $dataUmumNasabah->status) == 'duda' ? 'selected' : '' }}>Duda
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
                <label for="">{{$itemSlik->nama}}</label>
                <br>
                <b>Jawaban : </b>
                <div class="mt-2 pl-2">
                    <p class="badge badge-info text-lg">
                        <b>{{ $itemSlik->option }}</b>
                    </p>
                </div>
                <b>Skor : </b>
                <div class="mt-2 pl-2">
                    <p class="badge badge-info text-lg">
                        <b>{{ $itemSlik->skor }}</b>
                    </p>
                </div>
            </div>
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
            <div class="form-group col-md-12">
                <label for="">Jumlah Kredit yang diminta</label>
                <input type="number" disabled name="jumlah_kredit"
                    class="form-control @error('jumlah_kredit') is-invalid @enderror" placeholder="Jumlah Kredit"
                    value="{{ old('jumlah_kredit', $dataUmumNasabah->jumlah_kredit) }}">
                {{-- <textarea name="jumlah_kredit" class="form-control @error('jumlah_kredit') is-invalid @enderror"  id="" cols="30" rows="4" placeholder="Jumlah Kredit">{{ old('jumlah_kredit',$dataUmumNasabah->jumlah_kredit) }}</textarea> --}}
                @error('jumlah_kredit')
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
    <form action="{{ route('pengajuan.insertkomentar') }}" method="POST">
        @csrf
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
                $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor')
                    ->where('level', 2)
                    ->where('id_parent', $value->id)
                    ->get();

                // check level 4
                $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor')
                    ->where('level', 4)
                    ->where('id_parent', $value->id)
                    ->get();
                $pendapatStafPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)->whereNotNull('id_staf')->where('id_aspek', $value->id)->first();
            @endphp
            {{-- level level 2 --}}

            <div class="form-wizard $key" data-index='{{ $key }}' data-done='true'>
                <div class="">
                    @foreach ($dataLevelDua as $item)
                        @if ($item->opsi_jawaban == 'input text')
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
                                        <b>Jawaban:</b>
                                        <div class="mt-2 pl-3">
                                            <p class="badge badge-info text-lg"><b> {{ $itemTextDua->opsi_text }}</b></p>
                                            @if ($itemTextDua->is_commentable)
                                                <div class="input-k-bottom">
                                                    <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                    <input type="text" class="form-control komentar"
                                                        name="komentar_penyelia[]" placeholder="Masukkan Komentar">

                                                    {{-- <div class="input-skor">
                                            <input type="number" class="form-control" placeholder="" name="skor_penyelia_text[]" value="">

                                            </div> --}}
                                                </div>
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

                            // check level 3
                            $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor')
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
                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                            ->where('id_pengajuan', $dataUmum->id)
                                            ->get();

                                        $jawabanTurunan = \App\Models\JawabanSubColumnModel::where('id_option', $itemJawaban->id)
                                            ->where('id_pengajuan', $dataUmum->id)
                                            ->first();

                                        $count = count($dataDetailJawaban);
                                        for ($i = 0; $i < $count; $i++) {
                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                        }

                                        // echo "<pre>";
                                        // print_r ($dataDetailJawaban);
                                        // echo "</pre>";

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

                                                    @if ($jawabanTurunan)
                                                        <div class="col-md-6">
                                                            <b>{{ $itemJawaban->sub_column }} :</b>
                                                            <div class="mt-2 pl-2">
                                                                <p class="badge badge-info text-lg">
                                                                    <b>{{ $jawabanTurunan->jawaban_sub_column }}</b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="input-group input-b-bottom">
                                                    @if ($item->is_commentable)
                                                        <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                        <input type="hidden" name="id_option[]" value="{{ $itemJawaban->id }}">
                                                        <input type="text" class="form-control komentar"
                                                            name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                        <div class="input-skor">
                                                            <input type="number" class="form-control" placeholder=""
                                                                name="skor_penyelia[]" {{$item->status_skor == 0 ? 'readonly' : ''}}
                                                                value="{{ $itemJawaban->skor != null ? $itemJawaban->skor : '' }}">

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
                            @if ($itemTiga->opsi_jawaban == 'input text')
                                @php
                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                        ->where('jawaban_text.id_jawaban', $itemTiga->id)
                                        ->get();
                                @endphp
                                @foreach ($dataDetailJawabanText as $itemTextTiga)
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-0">
                                            <label for="">{{ $itemTextTiga->nama }}</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <b>Jawaban:</b>
                                            <div class="mt-2 pl-3">
                                                <p class="badge badge-info text-lg"><b>
                                                        {{ $itemTextTiga->opsi_text }}</b></p>
                                                @if ($itemTextTiga->is_commentable)
                                                    <div class="input-k-bottom">
                                                        <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                        <input type="text" class="form-control komentar"
                                                            name="komentar_penyelia[]" placeholder="Masukkan Komentar">

                                                        {{-- <div class="input-skor">
                                    <input type="number" class="form-control" placeholder="" name="skor_penyelia_text[]" value="">

                                    </div> --}}
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
                                // check level empat
                                $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor')
                                    ->where('level', 4)
                                    ->where('id_parent', $itemTiga->id)
                                    ->get();
                            @endphp

                            @foreach ($dataOptionTiga as $itemOptionTiga)
                                @if ($itemOptionTiga->option == '-')
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <h5> {{ $itemTiga->nama }}</h5>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if (count($dataJawabanLevelTiga) != 0)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">{{ $itemTiga->nama }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                ->where('id_pengajuan', $dataUmum->id)
                                                ->get();

                                            $jawabanTurunan = \App\Models\JawabanSubColumnModel::where('id_option', $itemJawabanLevelTiga->id)
                                                ->where('id_pengajuan', $dataUmum->id)
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
                                                    @if ($jawabanTurunan)
                                                        <div class="col-md-6">
                                                            <b>{{ $itemJawaban->sub_column }} :</b>
                                                            <div class="mt-2 pl-2">
                                                                <p class="badge badge-info text-lg">
                                                                    <b>{{ $jawabanTurunan->jawaban_sub_column }}</b>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    {{-- <div class="input-group input-b-bottom">
                                                        @if ($item->is_commentable)
                                                            <div class="input-group input-b-bottom">

                                                                <input type="hidden" name="id_item[]"
                                                                    value="{{ $item->id }}">
                                                                <input type="text" class="form-control komentar"
                                                                    name="komentar_penyelia[]"
                                                                    placeholder="Masukkan Komentar">
                                                            </div>
                                                        @endif

                                                        <div class="input-skor">
                                                            <input type="number" class="form-control" placeholder=""
                                                                name="skor_penyelia[]"
                                                                value="{{ $itemJawabanLevelTiga->skor != null ? $itemJawabanLevelTiga->skor : '' }}">

                                                        </div>
                                                    </div> --}}
                                                    <div class="input-group input-b-bottom">
                                                        @if ($item->is_commentable)
                                                            <input type="hidden" name="id_item[]"
                                                                value="{{ $item->id }}">
                                                            <input type="text" class="form-control komentar"
                                                                name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                                <div class="input-skor">
                                                                    <input type="number" class="form-control" placeholder=""
                                                                        name="skor_penyelia[]" {{$itemTiga->status_skor == 0 ? 'readonly' : ''}}
                                                                        value="{{ $itemJawabanLevelTiga->skor != null ? $itemJawabanLevelTiga->skor : '' }}">

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
                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                {{-- @php
                                echo "<pre>";
                                    print($itemEmpat);
                                echo "</pre>";
                            @endphp --}}

                                @if ($itemEmpat->opsi_jawaban == 'input text')
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
                                    @foreach ($dataDetailJawabanTextEmpat as $itemTextEmpat)
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-0">
                                                <label for="">{{ $itemTextEmpat->nama }}</label>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <b>Jawaban:</b>
                                                <div class="mt-2 pl-3">
                                                    <p class="badge badge-info text-lg"><b>
                                                            {{ $itemTextEmpat->opsi_text }}</b></p>
                                                    @if ($itemTextEmpat->is_commentable)
                                                        <div class="input-k-bottom">
                                                            <input type="hidden" name="id_item[]"
                                                                value="{{ $item->id }}">
                                                            <input type="text" class="form-control komentar"
                                                                name="komentar_penyelia[]" placeholder="Masukkan Komentar">

                                                            {{-- <div class="input-skor">
                                            <input type="number" class="form-control" placeholder="" name="skor_penyelia_text[]" value="">

                                            </div> --}}
                                                        </div>
                                                    @endif
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
                                    $isJawabanExist = \App\Models\OptionModel::join('jawaban', 'jawaban.id_jawaban','option.id')->where('jawaban.id_pengajuan', $dataUmum->id)->where('id_item', $itemEmpat->id)->count();
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
                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->get();
                                                $count = count($dataDetailJawaban);
                                                for ($i = 0; $i < $count; $i++) {
                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                }
                                                $jawabanTurunan = \App\Models\JawabanSubColumnModel::where('id_option', $itemJawabanLevelEmpat->id)
                                                    ->where('id_pengajuan', $dataUmum->id)
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
                                                        @if ($jawabanTurunan)
                                                            <div class="col-md-6">
                                                                <b>{{ $itemJawaban->sub_column }} :</b>
                                                                <div class="mt-2 pl-2">
                                                                    <p class="badge badge-info text-lg">
                                                                        <b>{{ $jawabanTurunan->jawaban_sub_column }}</b>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="input-group input-b-bottom">
                                                            @if ($item->is_commentable)
                                                                <input type="hidden" name="id_item[]"
                                                                    value="{{ $item->id }}">
                                                                <input type="text" class="form-control komentar"
                                                                    name="komentar_penyelia[]"
                                                                    placeholder="Masukkan Komentar">
                                                                <div class="input-skor">
                                                                    <input type="number" class="form-control" placeholder=""
                                                                        name="skor_penyelia[]" {{$itemEmpat->status_skor == 0 ? 'readonly' : ''}}
                                                                        value="{{ $itemJawabanLevelEmpat->skor != null ? $itemJawabanLevelEmpat->skor : '' }}">
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
                </div>
                <hr>
                <div class="form-group col-md-12">
                    <label for="">Pendapat dan Usulan Staf Kredit</label>
                    <p>{{$pendapatStafPerAspek->pendapat_per_aspek}}</p>
                </div>
            </div>
        @endforeach
        {{-- pendapat dan usulan --}}
        <div class="form-wizard" data-index='{{ count($dataAspek) + 1 }}' data-done='true'>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Pendapat dan Usulan</label>
                    <textarea name="komentar_penyelia_keseluruhan"
                        class="form-control @error('komentar_penyelia_keseluruhan') is-invalid @enderror" id=""
                        cols="30" rows="4" placeholder="Pendapat dan Usulan Penyelia Kredit" required></textarea>
                    @error('komentar_penyelia_keseluruhan')
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
        for (let index = 0; index < jumlahData; index++) {
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
            var allInput = ttlInput
            var allInputFilled = ttlInputFilled

            var percentage = parseInt(allInputFilled / allInput * 100);
            $(".side-wizard li[data-index='" + index + "'] a span i").html(isNaN(percentage) ? 0 + "%" : percentage + "%")
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
            if (next == jumlahData) {

                $(".btn-next").click(function(e) {

                    $(".btn-simpan").show()
                    // $(".progress").prop('disabled', false);
                    $(".btn-next").hide()
                });
                // $(".btn-next").show()

            } else if (indexNow == jumlahData) {
                $(".btn-simpan").show()
                $(".btn-next").hide()
            } else {
                $(".btn-next").show()
                $(".btn-simpan").hide()
            }
            console.log(indexNow)
            console.log(next);
            console.log(jumlahData);
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
