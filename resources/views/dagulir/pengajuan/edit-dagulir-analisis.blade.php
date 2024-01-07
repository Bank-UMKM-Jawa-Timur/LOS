<div class="pb-10 space-y-3">
    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Pengajuan</h2>
    <p class="font-semibold text-gray-400">Edit Pengajuan</p>
</div>
<div class="self-start bg-white w-full border">

    <div class="p-5 border-b">
        <h2 class="font-bold text-lg tracking-tighter">
            Pengajuan Masuk
        </h2>
    </div>
    <div
        class="p-5 w-full space-y-5"
        id="data-umum"
    >
        <!-- data umum -->
        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Diri :
                    </h2>
                </div>
            </div>
        </div>
        <div class="row space-y-5">
            <div class="form-group-2">
                <input type="hidden" name="id_nasabah" id="id_nasabah" value="{{ $dataUmum->id }}">
                <div class="input-box col-md-6">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" id="nama" maxlength="255"
                        class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $dataUmum->nama) }}"
                        placeholder="Nama sesuai dengan KTP">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-6">
                    <label for="">{{ $itemSP->nama }}</label>
                    @php
                        $jawabanFotoSP = \App\Models\JawabanTextModel::where('id_pengajuan', $dataUmum->id_pengajuan)
                            ->where('id_jawaban', 145)
                            ->first();
                        // dd($pengajuan);
                    @endphp
                    <input type="hidden" name="id_file_text[]" value="{{ $itemSP->id }}">
                    <label for="update_file" style="display: none" id="nama_file">{{ $jawabanFotoSP?->opsi_text }}</label>
                    <a class="text-theme-primary underline underline-offset-4 cursor-pointer open-modal btn-file-preview"
                        data-title="{{ $itemSP->nama }}"
                        data-type="image"
                        data-filepath="{{ asset("../upload/{$pengajuan->id}/{$jawabanFotoSP->id_jawaban}/{$jawabanFotoSP->opsi_text}") }}">
                        Preview
                    </a>
                    <input type="file" name="update_file[]" value="{{ $jawabanFotoSP?->opsi_text }}"
                        id="surat_permohonan" placeholder="Masukkan informasi {{ $itemSP?->nama }}"
                        class="form-input limit-size">
                    <span class="invalid-tooltip" style="display: none">Besaran file tidak boleh lebih dari 5 MB</span>
                    <input type="hidden" name="id_update_file[]" value="{{ $jawabanFotoSP?->id }}">
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    {{-- <span class="filename" style="display: inline;">{{ $jawabanFotoSP?->opsi_text }}</span> --}}
                </div>
            </div>
            <div class="form-group-3">
                <div class="input-box col-md-4">
                    <label for="">Kabupaten</label>
                    <select name="kabupaten" class="form-select @error('kabupaten') is-invalid @enderror select2"
                        id="kabupaten">
                        <option value="0">---Pilih Kabupaten----</option>
                        @foreach ($allKab as $item)
                            <option value="{{ $item->id }}"
                                {{ $item->id == $dataUmum->id_kabupaten ? 'selected' : '' }}>
                                {{ $item->kabupaten }}</option>
                        @endforeach
                    </select>
                    @error('kabupaten')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-4">
                    <label for="">Kecamatan</label>
                    <select name="kec" id="kecamatan" class="form-select @error('kec') is-invalid @enderror  select2">
                        <option value="0">---Pilih Kecamatan----</option>
                        @foreach ($allKec as $kec)
                            <option value="{{ $kec->id }}"
                                {{ $kec->id == $dataUmum->id_kecamatan ? 'selected' : '' }}>
                                {{ $kec->kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('kec')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-4">
                    <label for="">Desa</label>
                    <select name="desa" id="desa" class="form-select @error('desa') is-invalid @enderror select2">
                        <option value="0">---Pilih Desa----</option>
                        @foreach ($allDesa as $desa)
                            <option value="{{ $desa->id }}" {{ $desa->id == $dataUmum->id_desa ? 'selected' : '' }}>
                                {{ $desa->desa }}</option>
                        @endforeach
                    </select>
                    @error('desa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group-1">
                <div class="input-box col-md-12">
                    <label for="">No Telp</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-input @error('no_telp') is-invalid @enderror"
                        placeholder="No Telp" value="{{$dataUmum->telp}}" maxlength="255">
                    @error('no_telp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-box col-md-12">
                    <label for="">Alamat Rumah</label>
                    <textarea name="alamat_rumah" class="form-textarea @error('alamat_rumah') is-invalid @enderror" maxlength="255"
                        id="" cols="30" rows="4" placeholder="Alamat Rumah disesuaikan dengan KTP">{{ old('alamat_rumah', $dataUmum->alamat_rumah) }}</textarea>
                    @error('alamat_rumah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <hr>
                </div>

                <div class="input-box col-md-12">
                    <label for="">No. KTP</label>
                    <input type="text" name="no_ktp" maxlength="255"
                        class="form-input @error('no_ktp') is-invalid @enderror" id=""
                        value="{{ old('no_ktp', $dataUmum->no_ktp) }}" placeholder="Masukkan 16 digit No. KTP"  onkeydown="return event.keyCode !== 69" name="no_ktp">
                    @error('no_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            @if ($dataUmum->status == 'menikah')
                <div class="form-group-2">
                    <div class="input-box col-md-6" id="foto-ktp-suami">
                        @php
                            $jawabanFotoKTPSu = \App\Models\JawabanTextModel::where('id_pengajuan', $dataUmum->id)
                                ->where('id_jawaban', 150)
                                ->first();
                        @endphp
                        <label for="">Foto KTP Suami</label>
                        <input type="hidden" name="id_file_text[]" value="150" id="">
                        @if (isset($jawabanFotoKTPSu->opsi_text) != null)
                            <label for="update_file" style="display: none"
                                id="nama_file">{{ $jawabanFotoKTPSu->opsi_text }}</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Suami" class="form-input limit-size"
                                value="{{ $jawabanFotoKTPSu->opsi_text }}">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @else
                            <label for="update_file" style="display: none" id="nama_file">Belum Upload Foto KTP
                                Suami</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Suami" class="form-input limit-size"
                                value="Belum Upload Foto KTP Suami">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @endif
                        <input type="hidden" name="id_update_file[]" value="{{ $jawabanFotoKTPSu->id ?? '' }}">
                        @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                            <div class="invalid-feedback">
                                {{ $errors->first('dataLevelDua.' . $key) }}
                            </div>
                        @endif
                        {{-- <span class="filename" style="display: inline;">{{ $jawabanFotoKTPSu?->opsi_text }}</span> --}}
                        {{-- <span class="alert alert-danger">Maximum file upload is 5 MB</span> --}}
                    </div>
                    <div class="input-box col-md-6" id="foto-ktp-istri">
                        @php
                            $jawabanFotoKTPIs = \App\Models\JawabanTextModel::where('id_pengajuan', $dataUmum->id)
                                ->where('id_jawaban', 151)
                                ->first();
                        @endphp
                        <label for="">Foto KTP Istri</label>
                        <input type="hidden" name="id_file_text[]" value="151" id="">
                        @if (isset($jawabanFotoKTPIs->opsi_text) != null)
                            <label for="update_file" style="display: none"
                                id="nama_file">{{ $jawabanFotoKTPIs->opsi_text }}</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Istri" class="form-input limit-size"
                                value="{{ $jawabanFotoKTPIs->opsi_text }}">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @else
                            <label for="update_file" style="display: none" id="nama_file">Belum Upload Foto KTP
                                Istri</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Istri" class="form-input limit-size"
                                value="Belum Upload Foto KTP Istri">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @endif
                        <input type="hidden" name="id_update_file[]" value="{{ $jawabanFotoKTPIs->id ?? '' }}">
                        @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                            <div class="invalid-feedback">
                                {{ $errors->first('dataLevelDua.' . $key) }}
                            </div>
                        @endif
                        <span class="filename" style="display: inline;">{{ $jawabanFotoKTPIs?->opsi_text }}</span>
                        {{-- <span class="alert alert-danger">Maximum file upload is 5 MB</span> --}}
                    </div>
                </div>
            @else
                <div class="form-group-1 mt-3">
                    <div class="input-box col-md-12" id="foto-ktp-nasabah">
                        @php
                            $jawabanFotoKTPNas = \App\Models\JawabanTextModel::where('id_pengajuan', $dataUmum->id_pengajuan)
                                ->where('id_jawaban', $itemKTPNas->id)
                                ->first();
                        @endphp
                        <label for="">Foto KTP Nasabah</label>
                        @if ($jawabanFotoKTPNas->opsi_text)
                            <a class="text-theme-primary underline underline-offset-4 cursor-pointer open-modal btn-file-preview"
                                data-title="Foto KTP Nasabah"
                                data-type="image"
                                data-filepath="{{asset("../upload/{$jawabanFotoKTPNas->id_pengajuan}/{$jawabanFotoKTPNas->id_jawaban}/{$jawabanFotoKTPNas->opsi_text}")}}"
                                >Preview
                            </a>
                        @endif
                        <input type="hidden" name="id_file_text[]" value="{{ $itemKTPNas->id }}" id="">
                        @if (isset($jawabanFotoKTPNas->opsi_text) != null)
                            <label for="update_file" style="display: none"
                                id="nama_file">{{ $jawabanFotoKTPNas->opsi_text }}</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Nasabah" class="form-select limit-size"
                                value="{{ $jawabanFotoKTPNas->opsi_text }}">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @else
                            <label for="update_file" style="display: none" id="nama_file">Belum Upload Foto KTP
                                Nasabah</label>
                            <input type="file" name="update_file[]" id=""
                                placeholder="Masukkan informasi Foto KTP Nasabah" class="form-select limit-size"
                                value="Belum Upload Foto KTP Suami">
                            <span class="invalid-tooltip" style="display: none">Besaran file tidak
                                boleh lebih dari 5 MB</span>
                        @endif
                        <input type="hidden" name="id_update_file[]" value="{{ $jawabanFotoKTPNas->id ?? '' }}">
                        @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                            <div class="invalid-feedback">
                                {{ $errors->first('dataLevelDua.' . $key) }}
                            </div>
                        @endif
                        {{-- <span class="filename" style="display: inline;">{{ $jawabanFotoKTPNas?->opsi_text }}</span> --}}
                    </div>
                </div>
            @endif
            <div class="input-box" id="foto-ktp-suami">
            </div>
            <div class="input-box" id="foto-ktp-istri">
            </div>
            <div class="input-box" id="foto-ktp-nasabah">
            </div>
            <div class="form-group-3 mt-3">
                <div class="input-box col-md-4">
                    <label for="">Tempat</label>
                    <input type="text" name="tempat_lahir" maxlength="255" id=""
                        class="form-select @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir', $dataUmum->tempat_lahir) }}" placeholder="Tempat Lahir">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-4">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id=""
                        class="form-select @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir', $dataUmum->tanggal_lahir) }}" placeholder="dd-mm-yyyy">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-4">
                    <label for="">Status</label>
                    <select name="status" id=""
                        class="form-select @error('status') is-invalid @enderror select2">
                        <option value=""> --Pilih Status --</option>
                        <option value="menikah" {{ old('status', $dataUmum->status) == 'menikah' ? 'selected' : '' }}>
                            Menikah</option>
                        <option value="belum menikah"
                            {{ old('status', $dataUmum->status) == 'belum menikah' ? 'selected' : '' }}>Belum Menikah
                        </option>
                        <option value="duda" {{ old('status', $dataUmum->status) == 'duda' ? 'selected' : '' }}>Duda
                        </option>
                        <option value="janda" {{ old('status', $dataUmum->status) == 'janda' ? 'selected' : '' }}>Janda
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Slik :
                    </h2>
                </div>
            </div>
            <div class="form-group-1">
                <div class="input-box col-md-12">
                    <label for="">Sektor Kredit</label>
                    <select name="sektor_kredit" id=""
                        class="form-select @error('sektor_kredit') is-invalid @enderror select2">
                        <option value=""> --Pilih Sektor Kredit -- </option>
                        <option value="perdagangan"
                            {{ old('sektor_kredit', $dataUmum->sektor_kredit) == 'perdagangan' ? 'selected' : '' }}>
                            Perdagangan</option>
                        <option value="perindustrian"
                            {{ old('sektor_kredit', $dataUmum->sektor_kredit) == 'perindustrian' ? 'selected' : '' }}>
                            Perindustrian</option>
                        <option value="dll"
                            {{ old('sektor_kredit', $dataUmum->sektor_kredit) == 'dll' ? 'selected' : '' }}>dll</option>
                    </select>
                    @error('sektor_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group-2">
                <div class="input-box col-md-6">
                    <label for="">{{ $itemSlik->nama }}</label>
                    @php
                        $jawabanSlik = \App\Models\JawabanPengajuanModel::whereIn('id_jawaban', [71, 72, 73, 74])
                            ->orderBy('id', 'DESC')
                            ->where('id_pengajuan', $dataUmum->id_pengajuan)
                            ->get();

                        for ($i = 0; $i < count($jawabanSlik); $i++) {
                            $data[] = $jawabanSlik[$i]['id_jawaban'];
                        }
                        if (count($jawabanSlik) == 0) {
                            $data[] = null;
                        }
                    @endphp
                    <select name="dataLevelDua[]" id="dataLevelDua" class="form-select select2"
                        data-id_item={{ $itemSlik->id }}>
                        <option value=""> --Pilih Data -- </option>
                        @foreach ($itemSlik->option as $itemJawaban)
                            <option value="{{ $itemJawaban->skor . '-' . $itemJawaban->id }}"
                                {{ in_array($itemJawaban->id, $data) ? 'selected' : '' }}>
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
                <div class="input-box col-md-6">
                    @php
                        $jawabanLaporanSlik = \App\Models\JawabanTextModel::where('id_pengajuan', $dataUmum->id_pengajuan)
                            ->where('id_jawaban', 146)
                            ->first();
                    @endphp
                    <label for="">Laporan SLIK</label>
                    <a class="text-theme-primary underline underline-offset-4 cursor-pointer open-modal btn-file-preview"
                        data-title="{{$itemP->nama}}"
                        data-type="pdf"
                        data-filepath="{{ asset("../upload/{$pengajuan->id}/{$jawabanLaporanSlik->id_jawaban}/{$jawabanLaporanSlik->opsi_text}") }}">
                        Preview
                    </a>
                    <input type="hidden" name="id_file_text[]" value="146" id="">
                    <label for="update_file" style="display: none"
                        id="nama_file">{{ $jawabanLaporanSlik?->opsi_text }}</label>
                    <input type="file" name="update_file[]" id="laporan_slik"
                        placeholder="Masukkan informasi Laporan SLIK" class="form-input limit-size"
                        value="{{ $jawabanLaporanSlik?->opsi_text }}">
                    <span class="invalid-tooltip" style="display: none">Besaran file tidak boleh lebih dari 5 MB</span>
                    <input type="hidden" name="id_update_file[]" value="{{ $jawabanLaporanSlik?->id }}">
                    @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                        <div class="invalid-feedback">
                            {{ $errors->first('dataLevelDua.' . $key) }}
                        </div>
                    @endif
                    {{-- <span class="filename" style="display: inline;">{{ $jawabanLaporanSlik?->opsi_text }}</span> --}}
                    {{-- <span class="alert alert-danger">Maximum file upload is 5 MB</span> --}}
                </div>
            </div>
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Usaha :
                    </h2>
                </div>
            </div>
            <div class="form-group-1">
                <div class="input-box col-md-12">
                    <label for="">Jenis Usaha</label>
                    <textarea name="jenis_usaha" class="form-input @error('jenis_usaha') is-invalid @enderror" maxlength="255"
                        id="" cols="30" rows="4" placeholder="Jenis Usaha secara spesifik">{{ old('jenis_usaha', $dataUmum->jenis_usaha) }}</textarea>
                    @error('jenis_usaha')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="input-box col-md-12">
                <label for="">Alamat Usaha</label>
                <textarea name="alamat_usaha" class="form-textarea @error('alamat_usaha') is-invalid @enderror" maxlength="255"
                    id="" cols="30" rows="4" placeholder="Alamat Usaha disesuaikan dengan KTP">{{ old('alamat_usaha', $dataUmum->alamat_usaha) }}</textarea>
                @error('alamat_usaha')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Pengajuan :
                    </h2>
                </div>
            </div>
            <div class="form-group-2">
                <div class="input-box col-md-6">
                    <label for="">Jumlah Kredit yang diminta</label>
                    <input type="text" name="jumlah_kredit"
                        class="form-input rupiah @error('jumlah_kredit') is-invalid @enderror" id="jumlah_kredit"
                        cols="30" rows="4" placeholder="Jumlah Kredit"
                        value="{{ old('jumlah_kredit', $dataUmum->jumlah_kredit) }}">
                    @error('jumlah_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-6">
                    <label for="">Tenor Yang Diminta</label>
                    {{--  <select name="tenor_yang_diminta" id="tenor_yang_diminta"
                        class="form-select select2 @error('tenor_yang_diminta') is-invalid @enderror" required>
                        <option value="">-- Pilih Tenor --</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ ($i == $dataUmum->tenor_yang_diminta) ? 'selected' : '' }}> {{ $i . ' tahun' }} </option>
                        @endfor
                    </select>  --}}
                    <div class="flex items-center">
                        <div class="flex-1">
                            <input type="text" name="tenor_yang_diminta" id="tenor_yang_diminta"
                                class="w-full form-input only-number @error('tenor_yang_diminta') is-invalid @enderror"
                                aria-describedby="addon_tenor_yang_diminta" value="{{ $dataUmum->tenor_yang_diminta }}"
                                 maxlength="3" />
                        </div>
                        <div class="flex-shrink-0 mt-2.5rem">
                            <span class="form-input bg-gray-100">Bulan</span>
                        </div>
                    </div>
                    @error('tenor_yang_diminta')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group-1">
                <div class="input-box col-md-12">
                    <label for="">Tujuan Kredit</label>
                    <textarea name="tujuan_kredit" class="form-textarea @error('tujuan_kredit') is-invalid @enderror" maxlength="255"
                        id="" cols="30" rows="4" placeholder="Tujuan Kredit">{{ old('tujuan_kredit', $dataUmum->tujuan_kredit) }}</textarea>
                    @error('tujuan_kredit')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-12">
                    <label for="">Jaminan yang disediakan</label>
                    <textarea name="jaminan" class="form-textarea @error('jaminan') is-invalid @enderror" maxlength="255" id=""
                        cols="30" rows="4" placeholder="Jaminan yang disediakan">{{ old('jaminan', $dataUmum->jaminan_kredit) }}</textarea>
                    @error('jaminan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-12">
                    <label for="">Hubungan Bank</label>
                    <textarea name="hubungan_bank" class="form-textarea @error('hubungan_bank') is-invalid @enderror" maxlength="255"
                        id="" cols="30" rows="4" placeholder="Hubungan dengan Bank">{{ old('hubungan_bank', $dataUmum->hubungan_bank) }}</textarea>
                    @error('hubungan_bank')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-box col-md-12">
                    <label for="">Hasil Verifikasi</label>
                    <textarea name="hasil_verifikasi" class="form-textarea @error('hasil_verifikasi') is-invalid @enderror"
                        maxlength="255" id="" cols="30" rows="4" placeholder="Hasil Verifikasi Karakter Umum">{{ old('hasil_verifikasi', $dataUmum->verifikasi_umum) }}</textarea>
                    @error('hasil_verifikasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <hr>
                </div>
            </div>
        </div>
        <div class="flex justify-between">
            <a href="{{route('pengajuan-kredit.index')}}">
                <button type="button"
                    class="px-5 py-2 border rounded bg-white text-gray-500">
                    Kembali
                </button>
            </a>
            <button type="button"
            class="px-5 py-2 next-tab border rounded bg-theme-primary text-white"
            >
            Selanjutnya
            </button>
        </div>
    </div>
</div>
