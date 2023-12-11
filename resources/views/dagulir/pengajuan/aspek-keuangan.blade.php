<div class="pb-10 space-y-3">
    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Aspek Keuangan</h2>
    <p class="font-semibold text-gray-400">Tambah Pengajuan Kredit</p>
  </div>
<div class="self-start bg-white w-full border">
    <div class="p-5 border-b">
      <h2 class="font-bold text-lg tracking-tighter">
        Pengajuan Kredit
      </h2>
    </div>
    <!-- aspek-keuangan -->
    <div class="p-5 space-y-5">
      <button
        data-modal-id="modal-perhitungan"
        class="open-modal flex gap-2 px-5 py-2 bg-theme-primary text-white rounded"
      >
        <span>
          <iconify-icon
            icon="akar-icons:calculator"
          ></iconify-icon>
        </span>
        <span> Perhitungan </span>
      </button>
      <div class="bg-red-50 p-4 border flex gap-2">
        <span>
          <iconify-icon
            icon="typcn:warning-outline"
            class="text-lg text-red-500"
          ></iconify-icon>
        </span>
        <p class="text-sm font-semibold text-red-500">
          Perhitungan kredit masih belum ditambahkan, silahkan
          klik button Perhitungan.
        </p>
      </div>
      <div class="form-group-2">
        <div class="input-box">
          <label for="">Repayment Capacity</label>
          <input
            type="text"
            name=""
            class="form-input disabled"
            id=""
            placeholder="Masukan informasi Repayment Capacity"
            disabled
          />
        </div>
      </div>
      <div class="form-group-1">
        <div class="input-box">
          <label for="">Pendapat dan Usulan Aspek Keuangan</label>
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