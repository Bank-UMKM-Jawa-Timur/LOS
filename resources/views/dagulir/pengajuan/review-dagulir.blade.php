
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
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="nama_lengkap"
                    readonly
                    value="{{ $data->nama }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nama ? $dagulir->nama : '-' }}</span>
                </div>
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
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->email ? $dagulir->email : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tempat lahir</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Tempat Lahir"
                    name="tempat_lahir"
                    readonly
                    value="{{ $data->tempat_lahir }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tempat_lahir ? $dagulir->tempat_lahir : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Tanggal lahir</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Tanggal Lahir"
                    name="tanggal_lahir"
                    readonly
                    value="{{ date('Y-m-d', strtotime($data->tanggal_lahir)) }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ date('Y-m-d',strtotime($dagulir->tanggal_lahir)) ? date('Y-m-d',strtotime($dagulir->tanggal_lahir)) : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Telp</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nomor Telepon"
                    name="telp"
                    readonly
                    value="{{ $data->telp }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->telp ?   $dagulir->telp : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Jenis Usaha</label>
                {{-- <select disabled name="jenis_usaha" id="" class="form-select-read-only" disabled>
                    <option value="">Pilih Jenis Usaha</option>
                    @foreach ($jenis_usaha as $key => $value)
                        <option value="{{ $key }}" {{  $key == $data->tipe_usaha ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->jenis_usaha ? $dagulir->jenis_usaha : '-'  }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Email</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $dagulir->email }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->email ? $dagulir->email : '-' }}</span>
                </div>
                <label for="ktp_nasabah" id="foto-nasabah">Foto Nasabah</label>
                <img src="{{ asset('..') . '/' . $pengajuan->id . '/' . $data->foto_nasabah }}" alt="">
            </div>
            <div class="input-box">
                <label for="">Status Pernikahan</label>
                <select disabled name="status" id="status_nasabah" class="form-select" disabled>
                    <option value="0" {{ $data->status_pernikahan == '0' ? 'selected' : '' }}>Pilih Status</option>
                    <option value="1" {{ $data->status_pernikahan == '1' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="2" {{ $data->status_pernikahan == '2' ? 'selected' : '' }}>Menikah</option>
                    <option value="3" {{ $data->status_pernikahan == '3' ? 'selected' : '' }}>Duda</option>
                    <option value="4" {{ $data->status_pernikahan == '4' ? 'selected' : '' }}>Janda</option>
                </select>
                <input type="hidden" name="status" id="status_nasabah" value="{{$dagulir->status_pernikahan}}">
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->status_pernikahan  ? $dagulir->status_pernikahan : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">NIK</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan NIK"
                    name="nik_nasabah"
                    value="{{ $data->nik }}"
                    oninput="validateNIK(this)"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nik  ? $dagulir->nik : '-' }}</span>
                </div>
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
                    type="hidden"
                    readonly
                    class="form-input"
                    placeholder="Masukan NIK Pasangan"
                    name="nik_pasangan"
                    value="{{ $data->nik_pasangan }}"
                    oninput="validateNIK(this)"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nik_pasangan  ? $dagulir->nik_pasangan : '-' }}</span>
                </div>
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
                <div class="p-2 bg-white border-b">
                    @foreach ($itemSlik->option as $itemJawaban)
                        <span>{{ $itemJawaban->id == $data->id_slik  ? $itemJawaban->option : ''}}</span>
                    @endforeach
                </div>
            </div>
            <div class="input-box">
                <label for="">File Slik</label>
                @php
                    $file_parts = pathinfo(asset('..') . '/' . $dagulir->id . '/' . $data->id_slik.'/'.$data->file_slik);
                @endphp
                @if (array_key_exists('extension', $file_parts))
                    @if ($file_parts['extension'] == 'pdf')
                        <iframe
                        src="{{ asset('..') . '/upload/'. $dagulir->id . '/' .$data->id_slik.'/'.$data->file_slik }}"
                        width="100%" height="800px"></iframe>
                    @else
                        <img src="{{ asset('..') . '/upload/' . $dagulir->id . '/' . $data->id_slik.'/'.$data->file_slik }}"
                        alt="" width="800px">
                    @endif
                @endif
            </div>
        </div>
        <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten KTP</label>
                    <label for="">NIK Pasangan</label>
                    <input
                        type="hidden"
                        class="form-input-read-only"
                        placeholder="Masukan NIK Pasangan"
                        name="nik_pasangan"
                        value="{{ $kabupaten_ktp->kabupaten }}"
                    />
                    <div class="p-2 bg-white border-b">
                        <span>{{ $kabupaten_ktp->kabupaten ? $kabupaten_ktp->kabupaten : '-' }}</span>
                    </div>
                </div>
                <div class="input-box">
                    <label for="">Kecamatan KTP</label>
                    <input
                        type="hidden"
                        class="form-input-read-only"
                        name="email"
                        value="{{ $kecamatan_ktp->kecamatan }}"
                    />
                    <div class="p-2 bg-white border-b">
                        <span>{{ $kecamatan_ktp->kecamatan ? $kecamatan_ktp->kecamatan : '-' }}</span>
                    </div>
                </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat KTP</label>
                {{-- <textarea
                    readonly
                    name="alamat_sesuai_ktp"
                    class="form-textarea-read-only"
                    placeholder="Alamat Domisili"
                    id=""
                >{{ $dagulir->alamat_ktp }}</textarea> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->alamat_ktp ? $dagulir->alamat_ktp : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Domisili</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kabupaten_dom->kabupaten }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $kabupaten_dom->kabupaten ? $kabupaten_dom->kabupaten : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Kecamatan Domisili</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kecamatan_dom->kecamatan }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $kecamatan_dom->kecamatan ? $kecamatan_dom->kecamatan : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Domisili</label>
                {{-- <textarea
                    name="alamat_domisili"
                    class="form-textarea-read-only"
                    placeholder="Alamat Domisili"
                    id=""
                >{{ $dagulir->alamat_dom }}</textarea> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $kecamatan_dom->kecamatan ? $kecamatan_dom->kecamatan : '-' }}</span>
                </div>
            </div>

        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Usaha</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kabupaten_usaha->kabupaten }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $kabupaten_usaha->kabupaten ? $kabupaten_usaha->kabupaten : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Kecamatan Usaha</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kecamatan_usaha->kecamatan }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $kecamatan_usaha->kecamatan ? $kecamatan_usaha->kecamatan : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Usaha</label>
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->alamat_usaha ? $dagulir->alamat_usaha : '-' }}</span>
                </div>
            </div>
        </div>

        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nominal Pengajuan</label>
                {{-- <input
                    type="text"
                    readonly
                    class="form-input rupiah"
                    placeholder="Nominal Pengajuan"
                    name="nominal_pengajuan"
                    value="{{ $data->nominal }}"
                /> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nominal ? number_format($dagulir->nominal, 0, ',', '.') : '-' }}</span>
                </div>
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
                        <div class="p-2 bg-white border-b">
                            <span>{{ $dagulir->jangka_waktu ? $dagulir->jangka_waktu : '-' }}</span>
                        </div>
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
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->jangka_waktu ? $dagulir->jangka_waktu : '-' }}"</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tujuan Penggunaan</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Tujuan Penggunaan"
                    name="tujuan_penggunaan"
                    value="{{ $dagulir->tujuan_penggunaan }}"
                    
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tujuan_penggunaan ? $dagulir->tujuan_penggunaan : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Keterangan Agunan</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Isi disini..."
                    name="ket_agunan"
                    value="{{ $dagulir->ket_agunan }}"
                /> 
                <div class="p-2 bg-white border-b">
                    {{ $dagulir->ket_agunan }}
                </div>
            </div>
        </div>

        <div class="form-group-2" id="form_tipe_pengajuan">
            <div class="input-box">
                <label for="">Tipe Pengajuan</label>
                {{-- <select disabled name="tipe_pengajuan" id="tipe" class="form-select-read-only">
                    <option value="0">Tipe Pengajuan</option>
                    @foreach ($tipe as $key => $value)
                    <option value="{{ $key }}" {{  $key  == $data->tipe ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tipe ? $dagulir->tipe : '-' }}</span>
                </div>
            </div>
            @if ($tipe != 2)
                <div id="nama_pj" class="input-box hidden">
                <label for="" id="label_pj"></label>
                    <input
                        type="hidden"
                        class="form-input"
                        placeholder="Masukan disini .."
                        name="nama_pj"
                        value="{{ $data->nama_pj }}"
                    />
                </div>
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nama_pj ? $dagulir->nama_pj : '-' }}</span>
                </div>
            @endif
            <div class="input-box">
                <label for="">Jenis badan hukum</label>
                <input
                    type="hidden"
                    readonly
                    class="form-input"
                    name="jenis_badan_hukum"
                    value="{{ $data->jenis_badan_hukum }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->jenis_badan_hukum ? $dagulir->jenis_badan_hukum : '-' }}</span>
                </div>
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
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tempat_berdiri ? $dagulir->tempat_berdiri : '-' }}</span>
                </div>
            </div>
            <div class="input-box hidden" id="tanggal_berdiri">
                <label for="">Tanggal Berdiri</label>
                <div class="input-grouped">
                    <input
                    type="hidden"
                    class="form-input-read-only"
                    name="tanggal_berdiri"
                    value="{{ date('Y-m-d', strtotime($data->tanggal_berdiri)) }}"

                    />
                    <div class="p-2 bg-white border-b">
                        <span>{{ date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) ? date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Tanggal Pengajuan</label>
                <div class="input-grouped">
                    <input
                    type="hidden"
                    class="form-input-read-only"
                    name="tanggal_pengajuan"
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal)) }}"
                    />
                    <br>
                    <div class="p-2 bg-white border-b">
                        <span>{{ date('Y-m-d',strtotime($dagulir->tanggal)) ? date('Y-m-d',strtotime($dagulir->tanggal)) : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Hubungan Bank</label>
                <div class="p-2 bg-white border-b">
                    <span>{{ $data->hubungan_bank ? $data->hubungan_bank : '-' }}</span>
                </div>
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

