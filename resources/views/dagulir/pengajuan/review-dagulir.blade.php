<div class="pb-10 space-y-3">
    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Dagulir</h2>
    <p class="font-semibold text-gray-400">Review Pengajuan</p>
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
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nama Lengkap</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="nama_lengkap"
                    readonly
                    value="{{ $data->nama }}"
                />
            </div>
            <div class="input-box">
                <label for="">Email</label>
                <input
                readonly
                type="text"
                class="form-input"
                placeholder="Masukan Email"
                name="email"
                readonly
                value="{{ $data->email }}"
                />
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tempat lahir</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Tempat Lahir"
                    name="tempat_lahir"
                    readonly
                    value="{{ $data->tempat_lahir }}"
                />
            </div>
            <div class="input-box">
                <label for="">Tanggal lahir</label>
                <input
                readonly
                    type="date"
                    class="form-input"
                    placeholder="Masukan Tanggal Lahir"
                    name="tanggal_lahir"
                    readonly
                    value="{{ date('Y-m-d', strtotime($data->tanggal_lahir)) }}"
                />
            </div>
            <div class="input-box">
                <label for="">Telp</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nomor Telepon"
                    name="telp"
                    readonly
                    value="{{ $data->telps }}"
                />
            </div>
            <div class="input-box">
                <label for="">Jenis Usaha</label>
                <select disabled name="jenis_usaha" id="" class="form-select">
                    <option value="">Pilih Jenis Usaha</option>
                    @foreach ($jenis_usaha as $key => $value)
                        <option value="{{ $key }}" {{  $key == $data->tipe_usaha ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="ktp_nasabah" id="foto-nasabah">Foto Nasabah</label>
                <img src="{{ asset('..') . '/' . $pengajuan->id . '/' . $data->foto_nasabah }}" alt="">
            </div>
            <div class="input-box">
                <label for="">Status</label>
                <select disabled name="status" id="status_nasabah" class="form-select" disabled>
                    <option value="0" {{ $data->status_pernikahan == '0' ? 'selected' : '' }}>Pilih Status</option>
                    <option value="1" {{ $data->status_pernikahan == '1' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="2" {{ $data->status_pernikahan == '2' ? 'selected' : '' }}>Menikah</option>
                    <option value="3" {{ $data->status_pernikahan == '3' ? 'selected' : '' }}>Duda</option>
                    <option value="4" {{ $data->status_pernikahan == '4' ? 'selected' : '' }}>Janda</option>
                </select>
            </div>
            <div class="input-box">
                <label for="">NIK</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    placeholder="Masukan NIK"
                    name="nik_nasabah"
                    value="{{ $data->nik }}"
                    oninput="validateNIK(this)"
                />
            </div>
            <div class="input-box" id="ktp-nasabah">
                <label for="ktp_nasabah" id="label-ktp-nasabah">Foto KTP Nasabah</label>
                <div class="flex gap-4">
                    <img src="{{ asset('..') . '/' . $pengajuan->id . '/' . $data->foto_ktp }}" alt="">

                </div>
            </div>
            <div class="input-box {{ $data->status_pernikahan == '2' ? '' : 'hidden' }}" id="nik_pasangan">
                <label for="">NIK Pasangan</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    placeholder="Masukan NIK Pasangan"
                    name="nik_pasangan"
                    value="{{ $data->nik_pasangan }}"
                    oninput="validateNIK(this)"
                />
            </div>
            <div class="input-box {{ $data->status_pernikahan == '2' ? '' : 'hidden' }}" id="ktp-pasangan">
                <label for="ktp_pasangan" id="">Foto KTP Pasangan</label>
                <img src="{{ asset('..') . '/' . $pengajuan->id . '/' . $data->foto_pasangan }}" alt="">
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Slik</label>
                <select disabled class="form-select" name="id_slik">
                    <option value="">Pilih Slik</option>
                    @foreach ($itemSlik->option as $itemJawaban)
                        <option value="{{ $itemJawaban->id }}" {{ $itemJawaban->id == $data->id_slik  ? 'selected' : ''}}>{{ $itemJawaban->option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">File Slik</label>
                @php
                    $file_parts = pathinfo(asset('..') . '/' . $dagulir->id . '/' . $data->id_slik.'/'.$data->file_slik);
                @endphp
                @if ($file_parts['extension'] == 'pdf')
                <iframe
                src="{{ asset('..') . '/upload/'. $dagulir->id . '/' .$data->id_slik.'/'.$data->file_slik }}"
                width="100%" height="800px"></iframe>
                @else
                <img src="{{ asset('..') . '/upload/' . $dagulir->id . '/' . $data->id_slik.'/'.$data->file_slik }}"
                alt="" width="800px">

                @endif
            </div>
        </div>
        <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten KTP</label>
                    <label for="">NIK Pasangan</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kabupaten_ktp->kabupaten }}"
                    />

                </div>
                <div class="input-box">
                    <label for="">Kecamatan KTP</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kecamatan_ktp->kecamatan }}"
                    />
                </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat KTP</label>
                <textarea
                    readonly
                    name="alamat_sesuai_ktp"
                    class="form-textarea"
                    placeholder="Alamat Domisili"
                    id=""
                >{{ $data->alamat_ktp }}</textarea>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Domisili</label>
                <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kabupaten_dom->kabupaten }}"
                    />
            </div>
            <div class="input-box">
                <label for="">Kecamatan Domisili</label>
                <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kecamatan_dom->kecamatan }}"
                    />
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Domisili</label>
                <textarea
                    readonly
                    name="alamat_domisili"
                    class="form-textarea"
                    placeholder="Alamat Domisili"
                    id=""
                {{ $data->alamat_dom }}></textarea>
            </div>

        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Usaha</label>
                <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kabupaten_usaha->kabupaten }}"
                    />
            </div>
            <div class="input-box">
                <label for="">Kecamatan Usaha</label>
                <input
                type="text"
                class="form-input"
                placeholder="Masukan NIK Pasangan"
                name="nik_pasangan"
                value="{{ $kecamatan_usaha->kecamatan }}"
            />
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Usaha</label>
                <textarea
                    readonly
                    name="alamat_usaha"
                    class="form-textarea"
                    placeholder="Alamat Usaha"
                    id=""
                >{{ $data->alamat_usaha }}</textarea>
            </div>
        </div>

        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nominal Pengajuan</label>
                <input
                    type="text"
                    readonly
                    class="form-input rupiah"
                    placeholder="Nominal Pengajuan"
                    name="nominal_pengajuan"
                    value="{{ $data->nominal }}"
                />
            </div>
            <div class="input-box">
                <label for="">Jangka Waktu</label>
                <div class="flex items-center">
                    <div class="flex-1">
                        <input
                            type="number"
                            class="w-full form-input"
                            placeholder="Masukan Jangka Waktu"
                            name="jangka_waktu"
                            aria-label="Jangka Waktu"
                            aria-describedby="basic-addon2"
                            value="{{ $data->jangka_waktu }}"
                        />
                    </div>
                    <div class="flex-shrink-0 mt-2.5rem">
                        <span class="form-input bg-gray-100">Bulan</span>
                    </div>
                </div>
                {{-- <input
                    type="number"
                    class="form-input"
                    placeholder="Masukan Jangka Waktu"
                    name="jangka_waktu"
                    style="width: 80%; box-sizing: border-box; padding-right: 8px;"
                />
                <span style="width: 20%; box-sizing: border-box; display: inline-block;">Bulan</span> --}}
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tujuan Penggunaan</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    placeholder="Masukan Tujuan Penggunaan"
                    name="tujuan_penggunaan"
                    value="{{ $data->tujuan_penggunaan }}"
                />
            </div>
            <div class="input-box">
                <label for="">Jaminan yang disediakan</label>
                <select disabled name="ket_agunan" id="" class="form-select">
                    <option value="shm" {{$data->ket_agunan ? 'selected' : ''}}>SHM</option>
                    <option value="bpkb" {{$data->ket_agunan ? 'selected' : ''}}>BPKB</option>
                    <option value="shgb" {{$data->ket_agunan ? 'selected' : ''}}>SHGB</option>
                    <option value="lainnya" {{$data->ket_agunan ? 'selected' : ''}}>Lainnya</option>
                </select>
            </div>
        </div>

        <div class="form-group-2" id="form_tipe_pengajuan">
            <div class="input-box">
                <label for="">Tipe Pengajuan</label>
                <select disabled name="tipe_pengajuan" id="tipe" class="form-select">
                    <option value="0">Tipe Pengajuan</option>
                    @foreach ($tipe as $key => $value)
                    <option value="{{ $key }}" {{  $key  == $data->tipe ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            @if ($tipe != 2)
                <div id="nama_pj" class="input-box hidden">
                <label for="" id="label_pj"></label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan disini .."
                        name="nama_pj"
                        value="{{ $data->nama_pj }}"
                    />
                </div>
            @endif
            <div class="input-box">
                <label for="">Jenis badan hukum</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    name="jenis_badan_hukum"
                    value="{{ $data->jenis_badan_hukum }}"

                />
            </div>
            <div class="input-box hidden" id="tempat_berdiri">
                <label for="">Tempat Berdiri</label>
                <input
                    type="text"
                    readonly
                    class="form-input"
                    name="tempat_berdiri"
                    value="{{ $data->tempat_berdiri }}"

                />
            </div>
            <div class="input-box hidden" id="tanggal_berdiri">
                <label for="">Tanggal Berdiri</label>
                <div class="input-grouped">
                    <input
                    readonly
                    type="date"
                    class="form-input"
                    name="tanggal_berdiri"
                    value="{{ date('Y-m-d', strtotime($data->tanggal_berdiri)) }}"

                    />
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Hubungan Bank</label>
                <textarea
                    readonly
                    name="hub_bank"
                    class="form-textarea"
                    placeholder="Hubungan Bank"
                    id=""
                >{{ $data->hubungan_bank }}</textarea>
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

