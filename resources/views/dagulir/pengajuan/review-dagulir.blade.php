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
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="nama_lengkap"
                    value="{{ $dagulir->nama }}"
                    readonly
                />
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tempat lahir</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Masukan Tempat Lahir"
                    name="tempat_lahir"
                    value="{{ $dagulir->tempat_lahir }}"
                    readonly

                />
            </div>
            <div class="input-box">
                <label for="">Tanggal lahir</label>
                <input
                    type="date"
                    class="form-input"
                    placeholder="Masukan Tanggal Lahir"
                    name="tanggal_lahir"
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal_lahir)) }}"
                    readonly
                />
            </div>
            <div class="input-box">
                <label for="">Telp</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nomor Telepon"
                    name="telp"
                    value="{{ $dagulir->telp }}"
                    readonly
                />
            </div>
            <div class="input-box">
                <label for="">Jenis Usaha</label>
                <select disabled name="jenis_usaha" id="" class="form-select" disabled>
                    <option value="">Pilih Jenis Usaha</option>
                    @foreach ($jenis_usaha as $key => $value)
                        <option value="{{ $key }}" {{ $key == $dagulir->jenis_usaha ? 'selected' : ''}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-box">
                <label for="">Email</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $dagulir->email }}"
                    readonly
                />
            </div>
            <div class="input-box">
                <label for="">NIK</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Masukan NIK"
                    name="nik"
                    value="{{ $dagulir->nik }}"
                    readonly
                />
            </div>
        </div>
        <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten KTP</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan Nama"
                        name="email"
                        value="{{ $kabupaten_ktp->kabupaten }}"
                        readonly
                    />

                </div>
                <div class="input-box">
                    <label for="">Kecamatan KTP</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan Nama"
                        name="email"
                        value="{{ $kecamatan_ktp->kecamatan }}"
                        readonly
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
                >{{ $dagulir->alamat_ktp }}</textarea>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Domisili</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kabupaten_dom->kabupaten }}"
                    readonly
                />
            </div>
            <div class="input-box">
                <label for="">Kecamatan Domisili</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kecamatan_dom->kecamatan }}"
                    readonly
                />
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Domisili</label>
                <textarea
                    name="alamat_domisili"
                    class="form-textarea"
                    placeholder="Alamat Domisili"
                    id=""
                >{{ $dagulir->alamat_dom }}</textarea>
            </div>

        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Kota / Kabupaten Usaha</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kabupaten_usaha->kabupaten }}"
                    readonly
                />
            </div>
            <div class="input-box">
                <label for="">Kecamatan Usaha</label>
                <input
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama"
                    name="email"
                    value="{{ $kecamatan_usaha->kecamatan }}"
                    readonly
                />
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Alamat Usaha</label>
                <textarea
                    name="alamat_usaha"
                    class="form-textarea"
                    placeholder="Alamat Usaha"
                    id=""
                >{{ $dagulir->alamat_usaha }}</textarea>
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Nominal Pengajuan</label>
                <input
                    type="number"
                    class="form-input"
                    placeholder="Nominal Pengajuan"
                    name="nominal_pengajuan"
                    value="{{ $dagulir->nominal }}"
                />
            </div>
            <div class="input-box">
                <label for="">Jangka Waktu</label>
                <input
                    type="number"
                    class="form-input"
                    placeholder="Masukan Jangka Waktu"
                    name="jangka_waktu"
                    value="{{ $dagulir->jangka_waktu }}"
                />
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Tujuan Penggunaan</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Masukan Tujuan Penggunaan"
                    name="tujuan_penggunaan"
                    value="{{ $dagulir->tujuan_penggunaan }}"
                />
            </div>
            <div class="input-box">
                <label for="">Keterangan Agunan</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Isi disini..."
                    name="ket_agunan"
                />
            </div>
        </div>
        <div class="form-group-1">
            <div class="input-box">
                <label for="">Tipe Pengajuan</label>
                <select disabled name="tipe_pengajuan" id="tipe" class="form-select">
                    <option value="0">Tipe Pengajuan</option>
                    @foreach ($tipe as $key => $value)
                    <option value="{{ $key }}" {{ $key == $dagulir->tipe ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div id="nama_pj" class="input-box hidden">
            <label for="">Nama PJ Ketua</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    placeholder="Masukan Nama PJ Ketua"
                    name="nama_pj"
                    value="{{ $dagulir->nama_pj_ketua }}"
                />
            </div>
        </div>
        <div class="form-group-2">
            <div class="input-box">
                <label for="">Jenis badan hukum</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    name="jenis_badan_hukum"
                    value="{{ $dagulir->jenis_badan_hukum }}"
                />
            </div>
            <div class="input-box">
                <label for="">Tempat Berdiri</label>
                <input
                    readonly
                    type="text"
                    class="form-input"
                    name="tempat_berdiri"
                    value="{{ $dagulir->tempat_berdiri }}"

                />
            </div>
            <div class="input-box">
                <label for="">Tanggal Berdiri</label>
                <div class="input-grouped">
                    <input
                    type="date"
                    class="form-input"
                    name="tanggal_berdiri"
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal_berdiri)) }}"

                    />
                </div>
            </div>
            <div class="input-box">
                <label for="">Tanggal Pengajuan</label>
                <div class="input-grouped">
                    <input
                    type="date"
                    class="form-input"
                    name="tanggal_pengajuan"
                    value="{{ date('Y-m-d',strtotime($dagulir->tanggal)) }}"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
