<div class="pb-10 space-y-3">
  <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Aspek Jaminan</h2>
  <p class="font-semibold text-gray-400">Tambah Pengajuan Kredit</p>
</div>
<div class="self-start bg-white w-full border">
  <div class="p-5 border-b">
    <h2 class="font-bold text-lg tracking-tighter">
      Pengajuan Kredit
    </h2>
  </div>
  <!-- Aspek Jaminan -->
  <div
    class="p-5 w-full space-y-5"
    id="aspek-jaminan"
  >
    <div
      class="p-2 border-l-4 border-theme-primary bg-gray-100"
    >
      <h2
        class="font-semibold text-sm tracking-tighter text-theme-text"
      >
        Jaminan Utama
      </h2>
    </div>
    <div class="form-group-2">
      <div class="input-box">
        <label for="">Kelayakan Usaha </label>
        <select
          name=""
          class="form-select"
        >
          <option value="">-- Pilih Opsi --</option>
        </select>
      </div>
      <div class="input-box">
        <label for="">Foto Usaha </label>
        <div class="flex gap-4">
          <input type="file" class="form-input"" />
          <div class="flex gap-2">
            <button class="btn-add">
              <iconify-icon
                icon="fluent:add-16-filled"
                class="mt-2"
              ></iconify-icon>
            </button>
            <button class="btn-minus">
              <iconify-icon
                icon="lucide:minus"
                class="mt-2"
              ></iconify-icon>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="p-2 border-l-4 border-theme-primary bg-gray-100"
    >
      <h2
        class="font-semibold text-sm tracking-tighter text-theme-text"
      >
        Jaminan Tambahan
      </h2>
    </div>

    <div class="form-group-2">
      <div class="input-box">
        <label for="">Kelayakan Usaha </label>
        <select
          name=""
          class="form-select"
          id="usaha"
        >
          <option value="">-- Pilih Opsi --</option>
          <option value="">
            Tidak Memiliki Jaminan Tambahan
          </option>
          <option value="tanah">Tanah</option>
          <option value="kendaraan">Kendaraan Bermotor</option>
          <option value="tanah-dan-bangunan">
            Tanah dan Bangunan
          </option>
        </select>
      </div>
      <div
        class="input-box hidden"
        id="tanah"
      >
        <label for="">Tanah </label>
        <select
          name=""
          class="form-select"
        >
          <option value="">-- Pilih Opsi --</option>
        </select>
      </div>
      <div
        class="input-box hidden"
        id="kendaraan"
      >
        <label for="">Kendaraan Bermotor </label>
        <select
          name=""
          class="form-select"
        >
          <option value="">-- Pilih Opsi --</option>
        </select>
      </div>
      <div
        class="input-box hidden"
        id="tanah-dan-bangunan"
      >
        <label for="">Tanah & Bangunan</label>
        <select
          name=""
          class="form-select"
        >
          <option value="">-- Pilih Opsi --</option>
        </select>
      </div>
    </div>
    <div class="space-y-5">
      <div
        class="p-2 border-l-4 border-theme-primary bg-gray-100"
      >
        <h2
          class="font-semibold text-sm tracking-tighter text-theme-text"
        >
          Bukti Pemilikan Jaminan Tambahan
        </h2>
      </div>
      <div
        class="form-group-2 hidden"
        id="form-tanah"
      >
        <div class="input-box">
          <div class="flex gap-2">
            <input
              type="checkbox"
              class="form-check"
              id="shm-check"
            />
            <label for="shm-check">SHM No</label>
          </div>
          <input
            type="text"
            id="no-shm-input"
            placeholder="Masukan informasi"
            class="form-input disabled"
            disabled
          />
        </div>
        <div class="input-box">
          <div class="flex gap-2">
            <input
              type="checkbox"
              class="form-check"
              id="shgb-check"
            />
            <label for="shgb-check">SHGB No</label>
          </div>
          <input
            type="text"
            id="no-shgb-input"
            placeholder="Masukan informasi"
            class="form-input disabled"
            disabled
          />
        </div>
        <div class="input-box">
          <div class="flex gap-2">
            <input
              type="checkbox"
              class="form-check"
              id="petak-check"
            />
            <label for="petak-check">Petak / Letter C</label>
          </div>
          <input
            type="text"
            id="no-petak-input"
            placeholder="Masukan informasi"
            class="form-input disabled"
            disabled
          />
        </div>

        <div class="input-box">
          <label for="atas-nama">Atas Nama</label>
          <input
            type="text"
            id="no-shm"
            placeholder="Masukan informasi"
            class="form-input"
          />
        </div>
      </div>
      <div
        id="form-kendaraan"
        class="form-group-2 hidden"
      >
        <div class="input-box">
          <label for="atas-nama">BPKB No</label>
          <input
            type="text"
            id="no-shm"
            placeholder="Masukan informasi"
            class="form-input"
          />
        </div>
        <div class="input-box">
          <label for="atas-nama">Atas Nama</label>
          <input
            type="text"
            id="no-shm"
            placeholder="Masukan informasi"
            class="form-input"
          />
        </div>
      </div>
    </div>
    <div class="form-group-2">
      <div class="input-box">
        <label for="">Foto </label>
        <div class="flex gap-4">
          <input type="file" class="form-input"" />
          <div class="flex gap-2">
            <button class="btn-add">
              <iconify-icon
                icon="fluent:add-16-filled"
                class="mt-2"
              ></iconify-icon>
            </button>
            <button class="btn-minus">
              <iconify-icon
                icon="lucide:minus"
                class="mt-2"
              ></iconify-icon>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group-2">
      <div class="input-box">
        <label for="">Pengikatan Jaminan Tambahan </label>
        <select
          name=""
          class="form-select"
        >
          <option value="">-- Pilih Opsi --</option>
        </select>
      </div>
    </div>
    <div
      class="p-2 border-l-4 border-theme-primary bg-gray-100"
    >
      <h2
        class="font-semibold text-sm tracking-tighter text-theme-text"
      >
        Taksiran Harga
      </h2>
    </div>
    <div class="form-group-2">
      <div class="input-box">
        <label for="atas-nama">THU</label>
        <input
          type="text"
          id="no-shm"
          placeholder="Masukan informasi THU"
          class="form-input"
        />
      </div>
      <div class="input-box">
        <label for="atas-nama">THLS</label>
        <input
          type="text"
          id="no-shm"
          placeholder="Masukan informasi THLS"
          class="form-input"
        />
      </div>
    </div>
    <div
      class="p-2 border-l-4 border-theme-primary bg-gray-100"
    >
      <h2
        class="font-semibold text-sm tracking-tighter text-theme-text"
      >
        Asuransi Penjaminan
      </h2>
    </div>
    <div class="form-group-2">
      <div class="input-box">
        <label for="atas-nama">Nama Asuransi</label>
        <input
          type="text"
          id="no-shm"
          placeholder="Masukan informasi"
          class="form-input"
        />
      </div>
      <div class="input-box">
        <label for="atas-nama"
          >Nilai Pertanggungan Asuransi</label
        >
        <input
          type="text"
          id="no-shm"
          placeholder="Masukan informasi Nilai Pertanggungan Asuransi"
          class="form-input"
        />
      </div>
      <div class="input-box">
        <label for="atas-nama"
          >Masa Berlaku Asuransi Penjaminan</label
        >
        <div class="input-grouped">
          <input
            type="text"
            id="no-shm"
            placeholder="Masukan informasi"
            class="form-input"
          />
          <div class="group-text">
            <p>Bulan</p>
          </div>
        </div>
      </div>
      <div class="input-box">
        <label for="atas-nama">Ratio Coverage</label>
        <div class="input-grouped">
          <input
            type="text"
            id="no-shm"
            placeholder="Masukan informasi Ratio Coverage"
            class="form-input disabled"
          />
          <div class="group-text">
            <p>%</p>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group-1">
      <div class="input-box">
        <label for=""
          >Pendapat dan usulan aspek managemment</label
        >
        <textarea
          name=""
          class="form-textarea"
          placeholder="Pendapat per aspek"
          id=""
        ></textarea>
      </div>
    </div>
    <div class="flex justify-between">
      <button
        class="px-5 py-2 border rounded bg-white text-gray-500"
      >
        Kembali
      </button>
      <div>
        <button
        class="px-5 prev-tab py-2 border rounded bg-theme-secondary text-white"
      >
        Sebelumnya
      </button>
      <button
        class="px-5 next-tab py-2 border rounded bg-theme-primary text-white"
      >
        Selanjutnya
      </button>
      </div>
    </div>
  </div>
</div>