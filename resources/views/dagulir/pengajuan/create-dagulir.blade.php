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
                        type="text"
                        class="form-input"
                        placeholder="Masukan Nama"
                        name="nama_lengkap"
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
                    />
                </div>
                <div class="input-box">
                    <label for="">Tanggal lahir</label>
                    <input
                        type="date"
                        class="form-input"
                        placeholder="Masukan Tanggal Lahir"
                        name="tanggal_lahir"
                    />
                </div>
                <div class="input-box">
                    <label for="">Telp</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan Nomor Telepon"
                        name="telp"
                    />
                </div>
                <div class="input-box">
                    <label for="">Jenis Usaha</label>
                    <select name="jenis_usaha" id="" class="form-select">
                        <option value="">Pilih Jenis Usaha</option>
                        @foreach ($jenis_usaha as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
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
                    />
                </div>
                <div class="input-box">
                    <label for="">NIK</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan NIK"
                        name="nik"
                    />
                </div>
            </div>
            <div class="form-group-2">
                    <div class="input-box">
                        <label for="">Kota / Kabupaten KTP</label>
                        <select name="kode_kotakab_ktp" class="form-select @error('kabupaten') is-invalid @enderror select2"
                            id="kabupaten">
                            <option value="0"> --- Pilih Kabupaten --- </option>
                            @foreach ($dataKabupaten as $item)
                                <option value="{{ $item->id }}">{{ $item->kabupaten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="">Kecamatan KTP</label>
                        <select name="kecamatan_sesuai_ktp" id="kecamatan" class="form-select @error('kec') is-invalid @enderror select2">
                            <option value="0"> --- Pilih Kecamatan --- </option>
                        </select>
                    </div>
            </div>
            <div class="form-group-1">
                <div class="input-box">
                    <label for="">Alamat KTP</label>
                    <textarea
                        name="alamat_sesuai_ktp"
                        class="form-textarea"
                        placeholder="Alamat Domisili"
                        id=""
                    ></textarea>
                </div>
            </div>
            <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten Domisili</label>
                    <select name="kode_kotakab_domisili" class="form-select @error('kabupaten_domisili') is-invalid @enderror select2"
                        id="kabupaten_domisili">
                        <option value="0"> --- Pilih Kabupaten --- </option>
                        @foreach ($dataKabupaten as $item)
                            <option value="{{ $item->id }}">{{ $item->kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-box">
                    <label for="">Kecamatan Domisili</label>
                    <select name="kecamatan_domisili" id="kecamatan_domisili" class="form-select @error('kecamatan_domisili') is-invalid @enderror select2">
                        <option value="0"> --- Pilih Kecamatan --- </option>
                    </select>
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
                    ></textarea>
                </div>

            </div>
            <div class="form-group-2">
                <div class="input-box">
                    <label for="">Kota / Kabupaten Usaha</label>
                    <select name="kode_kotakab_usaha" class="form-select @error('kabupaten_usaha') is-invalid @enderror select2"
                        id="kabupaten_usaha">
                        <option value="0"> --- Pilih Kabupaten --- </option>
                        @foreach ($dataKabupaten as $item)
                            <option value="{{ $item->id }}">{{ $item->kabupaten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-box">
                    <label for="">Kecamatan Usaha</label>
                    <select name="kecamatan_usaha" id="kecamatan_usaha" class="form-select @error('kecamatan_usaha') is-invalid @enderror select2">
                        <option value="0"> --- Pilih Kecamatan --- </option>
                    </select>
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
                    ></textarea>
                </div>
            </div>
            <div class="form-group-2">
                <div class="input-box">
                    <label for="">Nominal Pengajuan</label>
                    <input
                        type="text"
                        class="form-input rupiah"
                        placeholder="Nominal Pengajuan"
                        name="nominal_pengajuan"
                    />
                </div>
                <div class="input-box">
                    <label for="">Jangka Waktu</label>
                    <input
                        type="number"
                        class="form-input"
                        placeholder="Masukan Jangka Waktu"
                        name="jangka_waktu"
                    />
                </div>
            </div>
            <div class="form-group-2">
                <div class="input-box">
                    <label for="">Tujuan Penggunaan</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan Tujuan Penggunaan"
                        name="tujuan_penggunaan"
                    />
                </div>
                <div class="input-box">
                    <label for="">Keterangan Agunan</label>
                    <input
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
                    <select name="tipe_pengajuan" id="tipe" class="form-select">
                        <option value="0">Tipe Pengajuan</option>
                        @foreach ($tipe as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="nama_pj" class="input-box hidden">
                <label for="">Nama PJ Ketua</label>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Masukan Nama PJ Ketua"
                        name="nama_pj"
                    />
                </div>
            </div>

            <div class="form-group-2">
                <div class="input-box">
                    <label for="">Jenis badan hukum</label>
                    <input
                        type="text"
                        class="form-input"
                        name="jenis_badan_hukum"

                    />
                </div>
                <div class="input-box">
                    <label for="">Tempat Berdiri</label>
                    <input
                        type="text"
                        class="form-input"
                        name="tempat_berdiri"

                    />
                </div>
                <div class="input-box">
                    <label for="">Tanggal Berdiri</label>
                    <div class="input-grouped">
                        <input
                        type="date"
                        class="form-input"
                        name="tanggal_berdiri"

                        />
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

