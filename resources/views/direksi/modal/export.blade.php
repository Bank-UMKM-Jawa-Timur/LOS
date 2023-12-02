<div
class="modal-layout hidden"
id="modal-filter-export"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-lg tracking-tighter text-theme-text">
        Filter print data nominatif
      </h2>
    </div>
    <button data-dismiss-id="modal-filter-export">
      <iconify-icon
        icon="iconamoon:close-bold"
        class="text-2xl"
      ></iconify-icon>
    </button>
  </div>
  <div class="modal-body">
    <form action="">
      <div class="form-group-1 mb-4">
        <div class="input-box">
          <label for="">Kategori</label>
          <select
            name=""
            class="form-select"
            id="categori"
          >
            <option value="">-- Pilih Kategori --</option>
            <option value="date">Tanggal (awal & akhir)</option>
            <option value="all">Keseluruhan</option>
          </select>
        </div>
      </div>
      <div
        class="form-group-2 mb-4 hidden"
        id="is-date"
      >
        <div class="input-box">
          <label for="">Tanggal Awal</label>
          <input
            type="date"
            name="tanggal"
            class="form-input"
          />
        </div>
        <div class="input-box">
          <label for="">Tanggal Akhir</label>
          <input
            type="date"
            name="tanggal"
            class="form-input"
          />
        </div>
      </div>
      <div class="form-group-1 mb-4">
        <div class="input-box">
          <label for="">Cabang</label>
          <select
            name=""
            class="form-select"
            id=""
          >
            <option value="">-- Pilih Cabang --</option>
          </select>
        </div>
      </div>
      <div class="form-group-1 mb-4">
        <div class="input-box">
          <label for="">Jenis Export</label>
          <select
            name=""
            class="form-select"
            id=""
          >
            <option value="">-- Pilih Jenis Export --</option>
          </select>
        </div>
      </div>
      <div class="modal-info">
        <p>
          isi form berikut untuk mengexport sesuai data untuk ditampilkan
          pertabel dalam bentuk format pdf atau excel.
        </p>
      </div>
    </form>
  </div>
  <div class="modal-footer justify-end">
    <button
      class="btn-cancel"
      data-dismiss-id="modal-filter-export"
    >
      Batal
    </button>
    <button class="btn-submit">Export</button>
  </div>
</div>
</div>
