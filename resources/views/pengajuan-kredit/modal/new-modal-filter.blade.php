<form id="form-filter" method="get">
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
            name="cbg"
            class="form-select"
            id="cabang"
          >
            <option value="">-- Pilih Cabang --</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Posisi</label>
          <select
            name="pss"
            class="form-select"
            id="pss"
          >
            <option value="" selected>-- Pilih Posisi --</option>
            <option value="Proses Input Data">Proses Input Data</option>
            <option value="Review Penyelia">Review Penyelia</option>
            <option value="PBO">PBO</option>
            <option value="PBP">PBP</option>
            <option value="Pincab">Pincab</option>
            <option value="Selesai">Selesai</option>
            <option value="Ditolak">Ditolak</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Score</label>
          <select name="" class="form-select" id="">
              @if (Request()->query('score') == null)
                  <option value="" selected>-- Pilih Score --</option>
              @else
                  <option selected value="{{ Request()->query('score') }}">
                      {{ Request()->query('score') }}</option>
              @endif

              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Status</label>
          <select
            name="sts"
            class="form-select"
            id="sts"
          >
            <option value="">-- Pilih Status --</option>
            <option value="hijau">Hijau</option>
            <option value="kuning">Kuning</option>
            <option value="merah">Merah</option>
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
    <button type="submit" class="btn-submit" data-dismiss-id="modal-filter" id="btn_filter">Filter</button>
  </div>
</div>
</div>
</form>