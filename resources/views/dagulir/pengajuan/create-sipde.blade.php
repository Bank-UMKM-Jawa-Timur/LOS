@push('script-inject')
    <script>
        $('#jangka_waktu').on('change', function() {
            limitJangkaWaktu()
        })
        $('#jumlah_kredit').on('change', function() {
            limitJangkaWaktu()
        })

        function limitJangkaWaktu() {
            var nominal = $('#jumlah_kredit').val()
            nominal = nominal != '' ? nominal.replaceAll('.','') : 0
            var limit = 50000000
            if (parseInt(nominal) > limit) {
                var jangka_waktu = $('#jangka_waktu').val()
                if (jangka_waktu != '') {
                    jangka_waktu = parseInt(jangka_waktu)
                    if (jangka_waktu <= 36) {
                        $('.jangka_waktu_error').removeClass('hidden')
                        $('.jangka_waktu_error').html('Jangka waktu harus lebih dari 36 bulan.')
                    }
                    else {
                        $('.jangka_waktu_error').addClass('hidden')
                        $('.jangka_waktu_error').html('')
                    }
                }
            }
            else {
                $('.jangka_waktu_error').addClass('hidden')
                $('.jangka_waktu_error').html('')
            }
        }
    </script>
@endpush
<div class="pb-10 space-y-3">
    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Dagulir</h2>
    <p class="font-semibold text-gray-400">Tambah Pengajuan</p>
</div>
<div class="self-start bg-white w-full border">

    <div class="p-5 border-b">
        <h2 class="font-bold text-lg tracking-tighter">
            Pengajuan Masuk
        </h2>
    </div>
    <!-- data umum -->
    <div
        class="p-5 w-full space-y-5 "
        id="data-umum"
    >
        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Diri :
                    </h2>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nama Lengkap</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukkan Nama"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $dataUmumNasabah->nama ? $dataUmumNasabah->nama : '') }}"
                    disabled
                />
            </div>
            <div class="input-box">
                <label for="">Email</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="email"
                    class="form-input"
                    placeholder="Masukkan Email"
                    name="email"
                    value="{{ old('email', $dataUmumNasabah->email ? $dataUmumNasabah->email : '') }}"
                    disabled
                />
            </div>
        </div>
        <div class="form-group-3">
            <div class="input-box">
                <label for="">Tempat lahir</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukkan Tempat Lahir"
                    name="tempat_lahir"
                    value="{{ old('tempat_lahir', $dataUmumNasabah->tempat_lahir ? $dataUmumNasabah->tempat_lahir : '') }}"
                    disabled
                />
            </div>
            <div class="input-box">
                <label for="">Tanggal lahir</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="date"
                    class="form-input"
                    placeholder="Masukkan Tanggal Lahir"
                    name="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $dataUmumNasabah->tanggal_lahir ? $dataUmumNasabah->tanggal_lahir : '') }}"
                    disabled
                />
            </div>
            <div class="input-box">
                <label for="">Telp</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukkan Nomor Telepon"
                    name="telp"
                    oninput="validatePhoneNumber(this)"
                    value="{{ old('telp', $dataUmumNasabah->telp ? $dataUmumNasabah->telp : '') }}"
                    disabled
                />
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="ktp_nasabah" id="foto-nasabah">Foto Nasabah</label><small class="text-red-500 font-bold">*</small>
                <div class="flex gap-4">
                    <input type="file" name="foto_nasabah" class="form-input limit-size-2" />
                </div>
                <span class="error-limit text-red-500" style="display: none; margin-top: 0;">Maximum upload file
                    size is 2 MB</span>
            </div>
            <div class="input-box">
                <label for="">Status</label><small class="text-red-500 font-bold">*</small>
                <select name="status" id="status_nasabah" class="form-select">
                    <option value="0" {{ old('status_nasabah') == '0' ? 'selected' : '' }}>Pilih Status</option>
                    <option value="1" {{ old('status_nasabah') == '1' ? 'selected' : ''}}>Belum Menikah</option>
                    <option value="2" {{ old('status_nasabah') == '2' ? 'selected' : ''}}>Menikah</option>
                    <option value="3" {{ old('status_nasabah') == '3' ? 'selected' : ''}}>Duda</option>
                    <option value="4" {{ old('status_nasabah') == '4' ? 'selected' : ''}}>Janda</option>
                </select>
            </div>
            <div class="input-box">
                <label for="">NIK</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan NIK"
                    name="nik_nasabah"
                    oninput="validateNIK(this)"
                    value="{{ old('nik_nasabah', $dataUmumNasabah->nik ? $dataUmumNasabah->nik : '') }}"
                    disabled
                />
            </div>
            <div class="input-box" id="ktp-nasabah">
                <label for="ktp_nasabah" id="label-ktp-nasabah">Foto KTP Nasabah</label><small class="text-red-500 font-bold">*</small>
                <div class="flex gap-4">
                    <input type="file" name="ktp_nasabah" class="form-input limit-size-2" />
                </div>
                <span class="text-red-500" style="display: none; margin-top: 0;">Maximum upload file
                    size is 2 MB</span>
            </div>
            <div class="input-box hidden" id="nik_pasangan">
                <label for="">NIK Pasangan</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan NIK Pasangan"
                    name="nik_pasangan"
                    value="{{ old('nik_pasangan') }}"
                    oninput="validateNIK(this)"
                />
            </div>
            <div class="input-box hidden" id="ktp-pasangan">
                <label for="ktp_pasangan" id="">Foto KTP Pasangan</label><small class="text-red-500 font-bold">*</small>
                <div class="flex gap-4">
                    <input type="file" name="ktp_pasangan" class="form-input limit-size-2" />
                </div>
                <span class="text-red-500" style="display: none; margin-top: 0;">Maximum upload file
                    size is 2 MB</span>
            </div>
        </div>
        <div class="form-group-3">
            <div class="input-box">
                <label for="">Kota / Kabupaten KTP</label><small class="text-red-500 font-bold">*</small>
                <select name="kode_kotakab_ktp" class="form-select @error('kabupaten') is-invalid @enderror select2"
                    id="kabupaten" disabled>
                    <option value="0"> --- Pilih Kabupaten --- </option>
                    @foreach ($dataKabupaten as $item)
                        <option value="{{ $item->id }}" {{ old('kode_kotakab_ktp', $dataUmumNasabah->kotakab_ktp) == $item->id ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">Kecamatan KTP</label><small class="text-red-500 font-bold">*</small>
                <select name="kecamatan_sesuai_ktp" id="kecamatan" class="form-select @error('kec') is-invalid @enderror select2" disabled>
                    <option value="0"> --- Pilih Kecamatan --- </option>
                    @foreach ($allKec as $item)
                        <option value="{{ $item->id }}" {{ old('kecamatan_sesuai_ktp', $dataUmumNasabah->kec_ktp) == $item->id ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">Desa KTP</label><small class="text-red-500 font-bold">*</small>
                <select name="desa" id="desa" class="form-select @error('desa') is-invalid @enderror select2">
                    <option value="0"> --- Pilih Desa --- </option>
                    @foreach ($allDesa as $item)
                        <option value="{{ $item->id }}" {{ old('desa') == $item->id ? 'selected' : '' }}>{{ $item->desa }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat KTP</label><small class="text-red-500 font-bold">*</small>
                <textarea
                    name="alamat_sesuai_ktp"
                    class="form-textarea"
                    placeholder="Alamat KTP"
                    id="alamat_sesuai_ktp"
                    disabled
                >{{ old('alamat_sesuai_ktp', $dataUmumNasabah->alamat_ktp ? $dataUmumNasabah->alamat_ktp : '') }}</textarea>
            </div>
        </div>
        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Domisili :
                    </h2>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Domisili</label><small class="text-red-500 font-bold">*</small>
                <select name="kode_kotakab_domisili" class="form-select @error('kabupaten_domisili') is-invalid @enderror select2"
                    id="kabupaten_domisili" disabled>
                    <option value="0"> --- Pilih Kabupaten --- </option>
                    @foreach ($dataKabupaten as $item)
                        <option value="{{ $item->id }}" {{ old('kode_kotakab_domisili', $dataUmumNasabah->kotakab_dom) == $item->id ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">Kecamatan Domisili</label><small class="text-red-500 font-bold">*</small>
                <select name="kecamatan_domisili" id="kecamatan_domisili" class="form-select @error('kecamatan_domisili') is-invalid @enderror select2" disabled>
                    <option value="0"> --- Pilih Kecamatan --- </option>
                    @foreach ($allKecDom as $item)
                        <option value="{{ $item->id }}" {{ old('kecamatan_sesuai_ktp', $dataUmumNasabah->kec_dom) == $item->id ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Domisili</label><small class="text-red-500 font-bold">*</small>
                <textarea
                    name="alamat_domisili"
                    class="form-textarea"
                    placeholder="Alamat Domisili"
                    id=""
                    disabled
                >{{ old('alamat_domisili', $dataUmumNasabah->alamat_dom ? $dataUmumNasabah->alamat_dom : '') }}</textarea>
            </div>

        </div>

        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        File Slik :
                    </h2>
                </div>
            </div>
        </div>

        <div class="form-group-2">
            <div class="input-box">
                <label for="">{{ $itemSlik->nama }}</label><small class="text-red-500 font-bold">*</small>
                <select name="dataLevelDua[{{ $itemSlik->id }}]" id="dataLevelDua" class="form-select"
                    data-id_item={{ $itemSlik->id }}>
                    <option value=""> --Pilih Data -- </option>
                    @foreach ($itemSlik->option as $itemJawaban)
                    <option value="{{ $itemJawaban->skor . '-' . $itemJawaban->id }}" {{ old('dataLevelDua[]') == $itemJawaban->skor . '-' . $itemJawaban->id ? 'selected' : '' }}>
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
            <div class="input-box">
                <label for="">{{ $itemP->nama }}</label><small class="text-red-500 font-bold">*</small>
                <input type="hidden" name="id_item_file[{{ $itemP->id }}]" value="{{ $itemP->id }}" id="">
                <input type="file" name="upload_file[{{ $itemP->id }}]" id="file_slik" data-id=""
                    placeholder="Masukkan informasi {{ $itemP->nama }}" class="form-input limit-size-slik">
                @if (isset($key) && $errors->has('dataLevelDua.' . $key))
                <div class="invalid-feedback">
                    {{ $errors->first('dataLevelDua.' . $key) }}
                </div>
                @endif
                <span class="filename" style="display: inline;"></span>
            </div>
            <span class="text-red-500 m-0" style="display: none">Maximum upload file
                size is 10 MB</span>
        </div>

        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Usaha :
                    </h2>
                </div>
            </div>
        </div>
        <div class="form-group-3">
            <div class="input-box">
                <label for="">Jenis Usaha</label><small class="text-red-500 font-bold">*</small>
                <select name="jenis_usaha" id="" class="form-select" disabled>
                    <option value="">Pilih Jenis Usaha</option>
                    @foreach ($jenis_usaha as $key => $value)
                        <option value="{{ $key }}" {{ old('jenis_usaha', $dataUmumNasabah->jenis_usaha) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-box">
                <label for="">Kota / Kabupaten Usaha</label><small class="text-red-500 font-bold">*</small>
                <select name="kode_kotakab_usaha" class="form-select @error('kabupaten_usaha') is-invalid @enderror select2"
                    id="kabupaten_usaha" disabled>
                    <option value="0"> --- Pilih Kabupaten --- </option>
                    @foreach ($dataKabupaten as $item)
                        <option value="{{ $item->id }}" {{ old('kabupaten_usaha', $dataUmumNasabah->kotakab_usaha) == $item->id ? 'selected' : '' }}>{{ $item->kabupaten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">Kecamatan Usaha</label><small class="text-red-500 font-bold">*</small>
                <select name="kecamatan_usaha" id="kecamatan_usaha" class="form-select @error('kecamatan_usaha') is-invalid @enderror select2" disabled>
                    <option value="0"> --- Pilih Kecamatan --- </option>
                    @foreach ($allKecUsaha as $item)
                        <option value="{{ $item->id }}" {{ old('kecamatan_usaha', $dataUmumNasabah->kec_usaha) == $item->id ? 'selected' : '' }}>{{ $item->kecamatan }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Usaha</label><small class="text-red-500 font-bold">*</small>
                <textarea
                    name="alamat_usaha"
                    class="form-textarea"
                    placeholder="Alamat Usaha"
                    id=""
                    disabled
                >{{ old('alamat_usaha', $dataUmumNasabah->alamat_usaha ? $dataUmumNasabah->alamat_usaha : '') }}</textarea>
            </div>
        </div>
        <div class="form-group-1 col-span-2">
            <div>
                <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Pengajuan :
                    </h2>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Plafon</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input rupiah"
                    placeholder="Plafon"
                    name="nominal_pengajuan"
                    id="jumlah_kredit"
                    value="{{ old('nominal_pengajuan', $dataUmumNasabah->nominal ? $dataUmumNasabah->nominal : $dataUmumNasabah->nominal) }}"
                    disabled
                />
            </div>
            <div class="input-box">
                <label for="">Jangka Waktu</label><small class="text-red-500 font-bold">*</small>
                <div class="flex items-center">
                    <div class="flex-1">
                        <input
                            type="number"
                            class="w-full form-input"
                            placeholder="Masukan Jangka Waktu"
                            name="jangka_waktu"
                            id="jangka_waktu"
                            aria-label="Jangka Waktu"
                            value="{{ old('jangka_waktu', $dataUmumNasabah->jangka_waktu ? $dataUmumNasabah->jangka_waktu : '') }}"
                            aria-describedby="basic-addon2"
                            disabled
                        />
                        <span class="jangka_waktu_error text-red-400 hidden"></span>
                    </div>
                    <div class="flex-shrink-0 mt-2.5rem">
                        <span class="form-input bg-gray-100">Bulan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tujuan Penggunaan</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Tujuan Penggunaan"
                    name="tujuan_penggunaan"
                    value="{{ old('tujuan_penggunaan', $dataUmumNasabah->tujuan_penggunaan) }}"
                    disabled
                />
            </div>
            <div class="input-box">
                <label for="">Jaminan yang disediakan</label><small class="text-red-500 font-bold">*</small>
                <select name="ket_agunan" id="" class="form-select" disabled>
                    <option value="0" >Pilih Jaminan</option>
                    <option value="shm" {{ old('ket_agunan', $dataUmumNasabah->ket_agunan ? $dataUmumNasabah->ket_agunan : '') == 'shm' ? 'selected' : '' }}>SHM</option>
                    <option value="bpkb" {{ old('ket_agunan', $dataUmumNasabah->ket_agunan ? $dataUmumNasabah->ket_agunan : '') == 'bpkb' ? 'selected' : '' }}>BPKB</option>
                    <option value="shgb" {{ old('ket_agunan', $dataUmumNasabah->ket_agunan ? $dataUmumNasabah->ket_agunan : '') == 'shgb' ? 'selected' : '' }}>SHGB</option>
                    <option value="lainnya" {{ old('ket_agunan', $dataUmumNasabah->ket_agunan ? $dataUmumNasabah->ket_agunan : '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="input-box">
                <label for="">Jenis badan hukum</label><small class="text-red-500 font-bold">*</small>
                <select name="jenis_badan_hukum" id="jenis_badan_hukum" class="form-select" disabled>
                    <option value="0">Jenis Badan Hukum</option>
                    <option value="Berbadan Hukum" {{ old('jenis_berbadan', $dataUmumNasabah->jenis_badan_hukum) == 'Berbadan Hukum' ? 'selected' : '' }}>Berbadan Hukum</option>
                    <option value="Tidak Berbadan Hukum" {{ old('jenis_berbadan', $dataUmumNasabah->jenis_badan_hukum) == 'Tidak Berbadan Hukum' ? 'selected' : '' }}>Tidak Berbadan Hukum</option>
                </select>
            </div>
            <div class="input-box">
                <label for="">Tipe Pengajuan</label><small class="text-red-500 font-bold">*</small>
                <select name="tipe_pengajuan" id="tipe" class="form-select" {{$dataUmumNasabah->tipe ? 'disabled' : ''}}>
                    <option value="0">Tipe Pengajuan</option>
                    @foreach ($tipe as $key => $value)
                        <option value="{{ $key }}" {{ old('tipe_pengajuan', $dataUmumNasabah->tipe ? $dataUmumNasabah->tipe : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group-3 hidden" id="tempat_berdiri">
            <div id="nama_pj" class="input-box">
                <label for="" id="label_pj"></label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukkan disini .."
                    name="nama_pj"
                    disabled
                    value="{{ old('nama_pj', $dataUmumNasabah->nama_pj_ketua ? $dataUmumNasabah->nama_pj_ketua : '') }}"
                />
            </div>
            <div class="input-box">
                <label for="">Tempat Berdiri</label><small class="text-red-500 font-bold">*</small>
                <input
                    type="text"
                    class="form-input"
                    name="tempat_berdiri"
                    placeholder="Masukkan disini"
                    value="{{ old('tempat_berdiri', $dataUmumNasabah->tempat_berdiri ? $dataUmumNasabah->tempat_berdiri : '') }}"
                />
            </div>
            <div class="input-box">
                <label for="">Tanggal Berdiri</label><small class="text-red-500 font-bold">*</small>
                <div class="input-grouped">
                    <input
                    type="date"
                    class="form-input"
                    name="tanggal_berdiri"
                    value="{{ old('tanggal_berdiri', $dataUmumNasabah->tanggal_berdiri ? $dataUmumNasabah->tanggal_berdiri : '') }}"
                    />
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Hubungan Bank</label><small class="text-red-500 font-bold">*</small>
                <textarea
                    name="hub_bank"
                    class="form-textarea"
                    placeholder="Hubungan Bank"
                    id=""
                >{{ old('hub_bank') }}</textarea>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Hasil Verifikasi</label><small class="text-red-500 font-bold">*</small>
                <textarea
                    name="hasil_verifikasi"
                    class="form-textarea"
                    placeholder="Hasil Verikasi"
                    id=""
                >{{ old('hasil_verifikasi') }}</textarea>
            </div>
        </div>
        <div class="flex justify-between">
            <button type="button"
            class="px-5 py-2 border rounded bg-white text-gray-500"
            >
            Kembali
            </button>
            <button type="button"
            class="px-5 py-2 next-tab border rounded bg-theme-primary text-white"
            >
            Selanjutnya
            </button>
        </div>
    </div>
</div>
