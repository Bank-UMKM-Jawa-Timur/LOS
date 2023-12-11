<div class="pb-10 space-y-3">
  <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Data PO</h2>
  <p class="font-semibold text-gray-400">Tambah Pengajuan Kredit</p>
</div>
<div class="self-start bg-white w-full border">
  <div class="p-5 border-b">
    <h2 class="font-bold text-lg tracking-tighter">
      Pengajuan Kredit
    </h2>
  </div>
  <!-- Aspek umum -->
  <div
    class="p-5 w-full space-y-5"
    id="aspek-umum"
  >
    <div class="form-group-2">
      <div class="input-box">
        <label for="">Ijin Usaha </label>
        <select
          name=""
          class="form-select"
          id="ijin-usaha"
        >
          <option value="">-- Pilih Ijin Usaha --</option>
          <option value="nib">NIB</option>
          <option value="sku">Surat Keterangan Usaha</option>
          <option value="">Tidak ada legalitas usaha</option>
        </select>
      </div>
      <div
        class="input-box hidden"
        id="have-npwp"
      >
        <label
          for="is-npwp"
          class="font-semibold text-theme-text"
          >Memiliki NPWP</label
        >
        <div class="flex gap-2 rounded p-2 w-full border">
          <input
            type="checkbox"
            name=""
            class="form-check cursor-pointer"
            id="is-npwp"
          />
          <label
            for="is-npwp"
            class="font-semibold cursor-pointer text-theme-text"
            >IYA</label
          >
        </div>
      </div>
    </div>
    <div
      class="form-group-2 hidden"
      id="sku"
    >
      <div class="input-box">
        <label for="">Surat Keterangan Usaha </label>
        <input
          type="text"
          class="form-input"
          placeholder="Masukan informasi"
        />
      </div>
      <div class="input-box">
        <label for="">Dokumen Surat Keterangan Usaha </label>
        <input
          type="file"
          class="form-input"
        />
      </div>
    </div>

    <div
      class="form-group-2 hidden"
      id="nib"
    >
      <div class="input-box">
        <label for="">NIB </label>
        <input
          type="text"
          class="form-input"
          placeholder="Masukan informasi"
        />
      </div>
      <div class="input-box">
        <label for="">Dokumen NIB </label>
        <input
          type="file"
          class="form-input"
        />
      </div>
    </div>
    <div
      class="form-group-2 hidden"
      id="npwp"
    >
      <div class="input-box">
        <label for="">NPWP </label>
        <input
          type="text"
          class="form-input"
          placeholder="Masukan informasi"
        />
      </div>
      <div class="input-box">
        <label for="">Dokumen NPWP </label>
        <input
          type="file"
          class="form-input"
        />
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