<div
class="modal-layout hidden"
id="modal-filter"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-lg tracking-tighter text-theme-text">
        Filter data
      </h2>
    </div>
    <button data-dismiss-id="modal-filter">
      <iconify-icon
        icon="iconamoon:close-bold"
        class="text-2xl"
      ></iconify-icon>
    </button>
  </div>
  <div class="modal-body">
    <form action="">
      <div class="form-group-2 mb-4">
        <div class="input-box">
          <label for="">Tanggal Awal</label>
          <input
            type="date"
            name="tanggal"
            class="form-input"
            id="tgl_awal"
          />
        </div>
        <div class="input-box">
          <label for="">Tanggal Akhir</label>
          <input
            type="date"
            name="tanggal"
            class="form-input"
            id="tgl_akhir"
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
      <div class="modal-info">
        <p>
          isi form berikut untuk memfilter sebagian data untuk ditampilkan
          tiap perbulan, pertahun atau perhari di setiap cabang.
        </p>
      </div>
    </form>
  </div>
  <div class="modal-footer justify-end">
    <button
      class="btn-cancel"
      data-dismiss-id="modal-filter">
      Batal
    </button>
    <button class="btn-submit" id="btnFilter">Filter</button>
  </div>
</div>
</div>