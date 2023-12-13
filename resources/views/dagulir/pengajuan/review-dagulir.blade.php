
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
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Nama Lengkap</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama"
                    name="nama_lengkap"
                    value="{{ $dagulir->nama }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nama ? $dagulir->nama : '-' }}</span>
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
                    value="{{ $dagulir->tempat_lahir }}"
                    readonly

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
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal_lahir)) }}"
                    readonly
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
                    value="{{ $dagulir->telp }}"
                    readonly
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
                        <option value="{{ $key }}" {{ $key == $dagulir->jenis_usaha ? 'selected' : ''}}>{{ $value }}</option>
                    @endforeach
                </select> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->jenis_usaha ? $dagulir->jenis_usaha : '-'  }}</span>
                </div>
            </div>
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
            </div>
            <div class="input-box">
                <label for="">NIK</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan NIK"
                    name="nik"
                    value="{{ $dagulir->nik }}"
                    readonly
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nik  ? $dagulir->nik : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten KTP</label>
                    <input
                        type="hidden"
                        class="form-input-read-only"
                        placeholder="Masukan Nama"
                        name="email"
                        value="{{ $kabupaten_ktp->kabupaten }}"
                        readonly
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
                        placeholder="Masukan Nama"
                        name="email"
                        value="{{ $kecamatan_ktp->kecamatan }}"
                        readonly
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
                {{-- <textarea
                    name="alamat_usaha"
                    class="form-textarea-read-only"
                    placeholder="Alamat Usaha"
                    id=""
                >{{ $dagulir->alamat_usaha }}</textarea> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->alamat_usaha ? $dagulir->alamat_usaha : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nominal Pengajuan</label>
                {{-- <input
                    type="number"
                    class="form-input-read-only"
                    placeholder="Nominal Pengajuan"
                    name="nominal_pengajuan"
                    value="{{ $dagulir->nominal }}"
                /> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nominal ? $dagulir->nominal : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Jangka Waktu</label>
                <input
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Jangka Waktu"
                    name="jangka_waktu"
                    value="{{ $dagulir->jangka_waktu }}"
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
                    type="text"
                    class="form-input-read-only"
                    placeholder="Isi disini..."
                    name="ket_agunan"
                    value="{{ $dagulir->ket_agunan }}"
                /> --}}
                <div class="p-2 bg-white border-b">
                </div>
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Tipe Pengajuan</label>
                {{-- <select disabled name="tipe_pengajuan" id="tipe" class="form-select-read-only">
                    <option value="0">Tipe Pengajuan</option>
                    @foreach ($tipe as $key => $value)
                    <option value="{{ $key }}" {{ $key == $dagulir->tipe ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select> --}}
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tipe ? $dagulir->tipe : '-' }}</span>
                </div>
            </div>
            <div id="nama_pj" class="input-box hidden">
            <label for="">Nama PJ Ketua</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    placeholder="Masukan Nama PJ Ketua"
                    name="nama_pj"
                    value="{{ $dagulir->nama_pj_ketua }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->nama_pj_ketua ? $dagulir->nama_pj_ketua : '-' }}</span>
                </div>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Jenis badan hukum</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    name="jenis_badan_hukum"
                    value="{{ $dagulir->jenis_badan_hukum }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->jenis_badan_hukum ? $dagulir->jenis_badan_hukum : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Tempat Berdiri</label>
                <input
                    readonly
                    type="hidden"
                    class="form-input-read-only"
                    name="tempat_berdiri"
                    value="{{ $dagulir->tempat_berdiri }}"
                />
                <div class="p-2 bg-white border-b">
                    <span>{{ $dagulir->tempat_berdiri ? $dagulir->tempat_berdiri : '-' }}</span>
                </div>
            </div>
            <div class="input-box">
                <label for="">Tanggal Berdiri</label>
                <div class="input-grouped">
                    <input
                    type="hidden"
                    class="form-input-read-only"
                    name="tanggal_berdiri"
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) }}"

                    />
                    <div class="p-2 bg-white border-b">
                        <span>{{ date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) ? date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) : '-' }}</span>
                    </div>
                </div>
            </div>
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
    </div>
</div>
