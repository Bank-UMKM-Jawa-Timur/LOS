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
            name="tAwal" 
            id="tAwal"
            class="form-input"
            value="{{ Request()->query('tAwal') }}">
          />
        </div>
        <div class="input-box">
          <label for="tAkhir">Tanggal Akhir</label>
          <input
            type="date"
            name="tAkhir" 
            id="tAkhir"
            class="form-input"
            value="{{ Request()->query('tAkhir') }}"
          />
          <small id="errorAkhir" class="form-text text-danger">Tanggal akhir tidak boleh kurang
            dari tanggal awal</small>
        </div>
      </div>
      <div class="form-group-2 mb-4">
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
        <div class="input-box">
          <label for="">Posisi</label>
          <select
            name=""
            class="form-select"
            id=""
          >
            <option value="">-- Pilih Posisi --</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Score</label>
          <select
            name=""
            class="form-select"
            id=""
          >
            <option value="">-- Pilih Score --</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Status</label>
          <select
            name=""
            class="form-select"
            id=""
          >
            <option value="">-- Pilih Status --</option>
          </select>
        </div>
      </div>
      <div class="modal-info">
        <p>
          isi form berikut untuk memfilter sebagian data untuk ditampilkan
          tiap perbulan, pertahun atau perhari di setiap cabang dan juga
          lainya.
        </p>
      </div>
    </form>
  </div>
  <div class="modal-footer justify-end">
    <button
      class="btn-cancel"
      data-dismiss-id="modal-filter"
    >
      Batal
    </button>
    <button class="btn-submit">Filter</button>
  </div>
</div>
</div>