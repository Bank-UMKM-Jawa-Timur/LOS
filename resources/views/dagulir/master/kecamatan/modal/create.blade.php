<div
      class="modal-layout hidden"
      id="modal-add-kecamatan"
    >
      <div class="modal modal-sm bg-white">
        <div class="modal-head">
          <div class="title">
            <h2 class="font-bold text-lg tracking-tighter text-theme-text">
              Tambah Kecamatan
            </h2>
          </div>
          <button data-dismiss-id="modal-add-kecamatan">
            <iconify-icon
              icon="iconamoon:close-bold"
              class="text-2xl"
            ></iconify-icon>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('dagulir.master.kecamatan.store') }}" method="POST">
            @csrf
            <div class="form-group-1 mb-4">
              <div class="input-box">
                <label for="">Nama Kecamatan</label>
                <input
                  type="text"
                  name=""
                  class="form-input"
                />
              </div>
              <div class="input-box">
                <label for="">Pilih Kabupaten</label>
                <select
                  name=""
                  class="form-select"
                  id=""
                >
                  <option value="">-- Pilih Kabupaten --</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-end">
          <button
            class="btn-cancel"
            data-dismiss-id="modal-add-kecamatan"
          >
            Batal
          </button>
          <button class="btn-submit">Simpan</button>
        </div>
      </div>
    </div>