<div class="modal-layout hidden" id="modal-add-tipe">
    <div class="modal modal-sm bg-white">
      <div class="modal-head">
        <div class="title">
          <h2 class="font-bold text-lg tracking-tighter text-theme-text">
            Tambah Tipe Kendaraan
          </h2>
        </div>
        <button data-dismiss-id="modal-add-tipe">
          <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="form-group-1 mb-4">
            <div class="input-box">
              <label for="">Nama Merk</label>
              <select name="merk" class="form-select" id="">
                <option value="">==Pilih Merk Kendaraan==</option>
                @foreach ($dataMerk as $item)
                    <option value="{{ $item->id }}">{{ $item->merk }}</option>
                @endforeach
              </select>
            </div>
            <div class="input-box">
              <label for="">Nama Tipe Kendaraan</label>
              <input type="text" name="" class="form-input" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-end">
        <button class="btn-cancel" data-dismiss-id="modal-add-tipe">
          Batal
        </button>
        <button class="btn-submit">Simpan</button>
      </div>
    </div>
  </div>
