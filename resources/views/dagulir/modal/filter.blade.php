<div class="modal-layout hidden" id="modal-filter">
  <div class="modal modal-sm bg-white">
    <div class="modal-head">
      <div class="title">
        <h2 class="font-bold text-lg tracking-tighter text-theme-text">
          Filter data
        </h2>
      </div>
      <button data-dismiss-id="modal-filter">
        <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
      </button>
    </div>
    <div class="modal-body">
      <form action="">
        <div class="form-group-2 mb-4">
          <div class="input-box">
            <label for="">Tanggal Awal</label>
            <input type="date" name="tanggal" class="form-input" />
          </div>
          <div class="input-box">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="tanggal" class="form-input" />
          </div>
          {{-- <div class="input-box">
            <label for="">Cabang</label>
            <select name="" id="" class="form-input cek-sub-column">
              <option value="" selected>Pilih Cabang</option>
            </select>
          </div> --}}
          <div class="input-box">
            <label for="">Posisi</label>
            <select name="" id="" class="form-input cek-sub-column">
              <option value="" selected>Pilih Posisi</option>
            </select>
          </div>
          <div class="input-box">
            <label for="">Score</label>
            <select name="" id="" class="form-input cek-sub-column">
              <option value="" selected>Pilih Score</option>
            </select>
          </div>
          <div class="input-box">
            <label for="">Status</label>
            <select name="" id="" class="form-input cek-sub-column">
              <option value="" selected>Pilih Status</option>
            </select>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer justify-end">
      <button class="btn-cancel" data-dismiss-id="modal-filter">
        Batal
      </button>
      <button class="btn-submit">Filter</button>
    </div>
  </div>
</div>