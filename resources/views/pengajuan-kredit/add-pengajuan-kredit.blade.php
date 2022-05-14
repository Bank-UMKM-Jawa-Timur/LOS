@extends('layouts.template')
@section('content')
    @include('components.notification')
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

    </style>
    <form id="pengajuan_kredit" action="{{ route('pengajuan-kredit.store') }}" method="post">
        @csrf
        <input type="hidden" name="progress" class="progress">
        <div class="form-wizard active" data-index='0' data-done='true'>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nama sesuai dengan KTP">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Kabupaten</label>
                    <select name="kabupaten" class="form-control @error('name') is-invalid @enderror select2" id="kabupaten">
                        <option value="">---Pilih Kabupaten----</option>
                        @foreach ($dataKabupaten as $item)
                            <option value="{{ old('id', $item->id) }}">{{ $item->kabupaten }}</option>
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
                    <textarea name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror" id="" cols="30" rows="4"
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
                    <textarea name="alamat_usaha" class="form-control @error('alamat_usaha') is-invalid @enderror" id="" cols="30" rows="4"
                        placeholder="Alamat Usaha disesuaikan dengan KTP"></textarea>
                    @error('alamat_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">No. KTP</label>
                    <input type="text" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" id=""
                        placeholder="Masukkan 16 digit No. KTP">
                    @error('no_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Tempat</label>
                    <input type="text" name="tempat_lahir" id=""
                        class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Tempat Lahir">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id=""
                        class="form-control @error('tanggal_lahir') is-invalid @enderror" placeholder="Tempat Lahir">
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
                        <option value="menikah">Menikah</option>
                        <option value="belum menikah">Belum Menikah</option>
                        <option value="duda">Duda</option>
                        <option value="janda">Janda</option>
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
                        <option value="perdagangan">Perdagangan</option>
                        <option value="perindustrian">Perindustrian</option>
                        <option value="dll">dll</option>
                    </select>
                    @error('sektor_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jenis Usaha</label>
                    <textarea name="jenis_usaha" class="form-control @error('jenis_usaha') is-invalid @enderror" id="" cols="30" rows="4"
                        placeholder="Jenis Usaha secara spesifik"></textarea>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jumlah Kredit yang diminta</label>
                    <textarea name="jumlah_kredit" class="form-control @error('jumlah_kredit') is-invalid @enderror" id="" cols="30"
                        rows="4" placeholder="Jumlah Kredit"></textarea>
                    @error('jumlah_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Tujuan Kredit</label>
                    <textarea name="tujuan_kredit" class="form-control @error('tujuan_kredit') is-invalid @enderror" id="" cols="30"
                        rows="4" placeholder="Tujuan Kredit"></textarea>
                    @error('tujuan_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Jaminan yang disediakan</label>
                    <textarea name="jaminan" class="form-control @error('jaminan') is-invalid @enderror" id="" cols="30" rows="4"
                        placeholder="Jaminan yang disediakan"></textarea>
                    @error('jaminan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hubungan Bank</label>
                    <textarea name="hubungan_bank" class="form-control @error('hubungan_bank') is-invalid @enderror" id="" cols="30"
                        rows="4" placeholder="Hubungan dengan Bank"></textarea>
                    @error('hubungan_bank')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for="">Hasil Verifikasi</label>
                    <textarea name="hasil_verifikasi" class="form-control @error('hasil_verifikasi') is-invalid @enderror" id="" cols="30"
                        rows="4" placeholder="Hasil Verifikasi Karakter Umum"></textarea>
                    @error('hasil_verifikasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <input type="text" id="jumlahData" name="jumlahData" hidden value="{{ count($dataAspek) }}">
        @foreach ($dataAspek as $key => $value)
            @php
                $key += 1;
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
                        @if ($item->opsi_jawaban == 'input text')
                            <div class="form-group col-md-6">
                                <label for="">{{ $item->nama }}</label>
                                <input type="hidden" name="opsi_jawaban[]" value="{{ $item->opsi_jawaban }}" id="">
                                <input type="hidden" name="id_level[]" value="{{ $item->id }}" id="">
                                <input type="text" name="informasi[]" id="" placeholder="Masukkan informasi"
                                    class="form-control">
                            </div>
                        @else
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
                            <div class="form-group col-md-6">
                                <label for="">{{ $item->nama }}</label>
                                <select name="dataLevelDua[]" id="dataLevelDua" class="form-control">
                                    <option value=""> --Pilih Data -- </option>
                                    @foreach ($dataJawaban as $itemJawaban)
                                        <option value="{{ $itemJawaban->skor . '-' . $itemJawaban->id }}">
                                            {{ $itemJawaban->option }}</option>
                                    @endforeach
                                </select>
                                @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('dataLevelDua.' . $key) }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                            @if ($itemTiga->opsi_jawaban == 'input text')
                                <div class="form-group col-md-6">
                                    <label for="">{{ $itemTiga->nama }}</label>
                                    <input type="hidden" name="id_level[]" value="{{ $itemTiga->id }}" id="">
                                    <input type="hidden" name="opsi_jawaban[]" value="{{ $itemTiga->opsi_jawaban }}"
                                        id="">
                                    <input type="text" name="informasi[]" id="" placeholder="Masukkan informasi"
                                        class="form-control">
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
                                <div class="form-group col-md-6">
                                    <label for="">{{ $itemTiga->nama }}</label>
                                    <select name="dataLevelTiga[]" id="" class="form-control">
                                        <option value=""> --Pilih Opsi-- </option>
                                        @foreach ($dataJawabanLevelTiga as $itemJawabanTiga)
                                            <option value="{{ $itemJawabanTiga->skor . '-' . $itemJawabanTiga->id }}">
                                                {{ $itemJawabanTiga->option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                @if ($itemEmpat->opsi_jawaban == 'input text')
                                    <div class="form-group col-md-6">
                                        <label for="">{{ $itemEmpat->nama }}</label>
                                        <input type="hidden" name="id_level[]" value="{{ $itemEmpat->id }}" id="">
                                        <input type="hidden" name="opsi_jawaban[]" value="{{ $itemEmpat->opsi_jawaban }}"
                                            id="">
                                        <input type="text" name="informasi[]" id="" placeholder="Masukkan informasi"
                                            class="form-control">
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
                                        <select name="dataLevelEmpat[]" id="" class="form-control">
                                            <option value=""> --Pilih Opsi -- </option>
                                            @foreach ($dataJawabanLevelEmpat as $itemJawabanEmpat)
                                                <option value="{{ $itemJawabanEmpat->skor . '-' . $itemJawabanEmpat->id }}">
                                                    {{ $itemJawabanEmpat->option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </div>
                {{-- @php
                echo "<pre>";
                print_r($dataLevelSatu);
                echo "</pre>";
            @endphp --}}
            </div>
        @endforeach
        {{-- pendapat dan usulan --}}
        <div class="form-wizard" data-index='{{count($dataAspek) + 1}}' data-done='true'>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Pendapat dan Usulan</label>
                    <textarea name="komentar_staff" class="form-control @error('komentar_staff') is-invalid @enderror" id="" cols="30" rows="4"
                        placeholder="Pendapat dan Usulan Staf/Analis Kredit" required></textarea>
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
                                $("#kecamatan").append('<option value="' + kode + '">' + nama +
                                    '</option>');
                            });
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
                                $("#desa").append('<option value="' + kode + '">' + nama +
                                    '</option>');
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
    </script>
    <script src="{{ asset('') }}js/custom.js"></script>
@endpush
