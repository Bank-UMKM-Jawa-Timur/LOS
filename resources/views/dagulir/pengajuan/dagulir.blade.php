@php
    $status = config('dagulir.status');
    $jenis_usaha = config('dagulir.jenis_usaha');
    $tipe_pengajuan = config('dagulir.tipe_pengajuan');
@endphp
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
      <div class="form-group-2">
        <div class="input-box">
          <label for="">Nama </label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Nama"
            name="nama_pendaftar_dagulir"
            value="{{ $data->nama }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Nama PJ Ketua</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Nama PJ Ketua"
            name="nama_pj_dagulir"
            value="{{ $data->nama_pj_ketua == null ? '-' : $data->nama_pj_ketua }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">NIK</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan NIK"
            name="nik_dagulir"
            value="{{ $data->nik }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Tempat lahir</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Tempat Lahir"
            name="tempat_lahir_dagulir"
            value="{{ $data->tempat_lahir }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Tanggal lahir</label>
          <input
            type="date"
            class="form-input"
            placeholder="Masukan Tanggal Lahir"
            name="tanggal_lahir_dagulir"
            value="{{ $data->tanggal_lahir }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Telp</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Nomor Telepon"
            name="telp_dagulir"
            value="{{ $data->telp }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Jenis Usaha</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Jenis Usaha"
            name="jenis_usaha"
            value="
            @if ($data->jenis_usaha)
                {{array_key_exists(intval($data->jenis_usaha), $jenis_usaha) ? $jenis_usaha[intval($data->jenis_usaha)] : 'Tidak ditemukan'}}
            @else
                Tidak ada
            @endif"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Nominal Pengajuan</label>
          <input
            type="number"
            class="form-input"
            placeholder="Masukan Jenis Usaha"
            name="nominal_pengajuan"
            value="{{ $data->nominal }}"
            readonly
          />
        </div>
        <div class="input-box">
          <label for="">Tujuan Penggunaan</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Tujuan Penggunaan"
            name="tujuan_penggunaan"
            value="{{ $data->tujuan_penggunaan }}"
          />
        </div>
        <div class="input-box">
          <label for="">Jangka Waktu</label>
          <input
            type="text"
            class="form-input"
            placeholder="Masukan Jangka Waktu"
            name="jangka_waktu"
            value="{{ $data->jangka_waktu }}"
          />
        </div>
        <div class="input-box">
          <label for="">Keterangan Agunan</label>
          <input
            type="text"
            class="form-input"
            placeholder="Isi disini..."
            name="ket_agunan"
            {{-- value="{{ $data-> }}" --}}
          />
        </div>
        <div class="input-box">
          <label for="">Kode Bank Pusat</label>
          <input
            type="text"
            class="form-input"
            placeholder="Isi disini..."
            name="kode_bank"
            value="{{ $data->kode_bank_pusat }}"
          />
        </div>

      </div>
      <div class="form-group-3">
        <div class="input-box">
            <label for="">Kode List Cabang</label>
            <input
                type="text"
                class="form-input"
                placeholder="Isi disini..."
                {{-- value="{{ $data-> }}" --}}
            />
          </div>
        <div class="input-box">
          <label for="">Kecamatan Domisili</label>
          <input
            type="text"
            class="form-input"
            placeholder="Isi disini..."
            name="ket_agunan"
            {{-- value="{{ $data->kec_dom->kecamatan }}" --}}
            />
        </div>
        <div class="input-box">
            <label for="">Kota / Kabupaten</label>
            <input
                type="text"
                class="form-input"
                placeholder="Isi disini..."
                name="ket_agunan"
                {{-- value="{{ $data->kotakab_dom->kabupaten }}" --}}
            />
          </div>
      </div>
      <div class="form-group-1">
        <div class="input-box">
          <label for="">Alamat KTP</label>
            <input
                type="text"
                class="form-input"
                placeholder="Isi disini..."
                name="ket_agunan"
                value="{{ $data->alamat_ktp }}"
            />
        </div>

      </div>
      <div class="form-group-2">
        <div class="input-box">
          <label for="">Kecamatan Domisili</label>
            <input
                type="text"
                class="form-input"
                placeholder="Isi disini..."
                name="ket_agunan"
                {{-- value="{{ $data->kec_dom->kecamatan }}" --}}
            />
        </div>
        <div class="input-box">
            <label for="">Kota / Kabupaten Domisili</label>
            <input
                type="text"
                class="form-input"
                placeholder="Isi disini..."
                name="ket_agunan"
                {{-- value="{{ $data->kotakab->kabupaten }}" --}}
            />
          </div>
      </div>
      <div class="form-group-1">
        <div class="input-box">
          <label for="">Alamat Domisili</label>
          <textarea
            name=""
            class="form-textarea"
            placeholder="Alamat Domisili"
            id=""
          >{{ $data->alamat_dom }}</textarea>
        </div>

      </div>
      <div class="form-group-2">
        <div class="input-box">
          <label for="">Kecamatan Usaha</label>
          <input
            type="text"
            class="form-input"
            placeholder="Tempat Lahir"
            {{-- value="{{ $data->kec_usaha->kecamatan }}" --}}
          />
        </div>
        <div class="input-box">
          <label for="">Kabupaten / Kota Usaha</label>
          <input
            type="date"
            class="form-input"
            {{-- value="{{ $data->kotakab_usaha->kabupaten }}" --}}
          />
        </div>
      </div>
      <div class="form-group-1">
        <div class="input-box">
          <label for="">Alamat Usaha</label>
          <textarea
            name=""
            class="form-textarea"
            placeholder="Alamat Usaha"
            id=""
          >{{ $data->alamat_usaha }}</textarea>
        </div>
      </div>
      <div class="form-group-2">
        <div class="input-box">
            <label for="">NPWP</label>
            <input
              type="text"
              class="form-input"
              name=""
              value="{{ $data->npwp }}"
            />
          </div>
        <div class="input-box">
            <label for="">Jenis badan hukum</label>
            <input
              type="text"
              class="form-input"
              name=""
              value="{{ $data->npwp }}"
            />
        </div>
      </div>
      <div class="form-group-2">
        <div class="input-box">
          <label for="">Tempat Berdiri</label>
          <input
            type="text"
            class="form-input"
            name=""
            value="{{ $data->tempat_berdiri }}"
          />
        </div>
        <div class="input-box">
          <label for="">Tanggal Berdiri</label>
          <div class="input-grouped">
            <input
              type="date"
              class="form-input"
              name=""
              value="{{ $data->tanggal_berdiri }}"
            />
          </div>
        </div>
        <div class="input-box">
          <label for="">Tanggal Pengajuan</label>
          <div class="input-grouped">
            <input
              type="date"
              class="form-input"
              name=""
              value="{{ $data->tanggal }}"
            />
          </div>
        </div>
        <div class="input-box">
          <label for="">Kode Pendaftaran</label>
          <div class="input-grouped">
            <input
              type="text"
              class="form-input"
              name=""
              value="{{ $data->kode_pendaftaran }}"
            />
          </div>
        </div>
      </div>
      <div class="flex justify-between">
        <button
          class="px-5 py-2 border rounded bg-white text-gray-500"
        >
          Kembali
        </button>
        <button
          class="px-5 py-2 next-tab border rounded bg-theme-primary text-white"
        >
          Selanjutnya
        </button>
      </div>
    </div>
  </div>
