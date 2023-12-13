<div class="form-group-1">
    <div class="input-box">
        <label for="">Nama Lengkap</label>
        <input
            type="text"
            class="form-input"
            placeholder="Masukan Nama"
            name="nama_lengkap"
            value="{{ $dagulir->nama }}"
            readonly
        />
    </div>
</div>
<div class="form-group-2 ">
    <div class="input-box">
        <label for="">Tempat lahir</label>
        <input
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
            type="text"
            class="form-input"
            placeholder="Masukan Nomor Telepon"
            name="telp"
            value="{{ $dagulir->telp }}"
        />
    </div>
    <div class="input-box">
        <label for="">Jenis Usaha</label>
        <select name="jenis_usaha" id="" class="form-select">
            <option value="">Pilih Jenis Usaha</option>
            @foreach ($jenis_usaha as $key => $value)
                <option value="{{ $jenis_usaha[$key]['kode'] }}" {{ $jenis_usaha[$key]['kode'] == $dagulir->jenis_usaha ? 'selected' : ''}}>{{ $jenis_usaha[$key]['jenis_usaha'] }}</option>
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
        />
    </div>
    <div class="input-box">
        <label for="">NIK</label>
        <input
            type="text"
            class="form-input"
            placeholder="Masukan NIK"
            name="nik"
            value="{{ $dagulir->nik }}"
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
                    <option value="{{ $item->id }}" {{ $item->id == $dagulir->kotakab_ktp  ? 'selected' : ''}}>{{ $item->kabupaten }}</option>
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
        >{{ $dagulir->alamat_ktp }}</textarea>
    </div>
</div>
<div class="form-group-2">
    <div class="input-box">
        <label for="">Kota / Kabupaten Domisili</label>
        <select name="kode_kotakab_domisili" class="form-select @error('kabupaten_domisili') is-invalid @enderror select2"
            id="kabupaten_domisili">
            <option value="0"> --- Pilih Kabupaten --- </option>
            @foreach ($dataKabupaten as $item)
                <option value="{{ $item->id }}" {{ $item->id == $dagulir->kotakab_dom  ? 'selected' : ''}}>{{ $item->kabupaten }}</option>
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
        >{{ $dagulir->alamat_dom }}</textarea>
    </div>

</div>
<div class="form-group-2">
    <div class="input-box">
        <label for="">Kota / Kabupaten Usaha</label>
        <select name="kode_kotakab_usaha" class="form-select @error('kabupaten_usaha') is-invalid @enderror select2"
            id="kabupaten_usaha">
            <option value="0"> --- Pilih Kabupaten --- </option>
            @foreach ($dataKabupaten as $item)
                <option value="{{ $item->id }}" {{ $item->id == $dagulir->kotakab_usaha  ? 'selected' : ''}}>{{ $item->kabupaten }}</option>
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
            <option value="{{ $tipe[$key]['id'] }}" {{ $tipe[$key]['id'] == $dagulir->tipe ? 'selected' : '' }}>{{ $tipe[$key]['nama'] }}</option>
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
            value="{{ $dagulir->nama_pj_ketua }}"
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
            value="{{ $dagulir->jenis_badan_hukum }}"
        />
    </div>
    <div class="input-box">
        <label for="">Tempat Berdiri</label>
        <input
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
