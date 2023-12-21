<div class="modal-layout hidden" id="modalEdit">

    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Edit Kecamatan
                </h2>
            </div>
            <button data-dismiss-id="modalEdit" type="button">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form id="form-edit-kabupaten" method="POST" action="{{ route('dagulir.master.kecamatan.update',1) }}">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <input type="hidden" name="id" id="id">

                    <div class="input-box">
                        <label for="">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" class="form-input @error('kecamatan') is-invalid @enderror"
                            placeholder="Nama Kecamatan" value="">
                            @error('kecamatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Kabupaten</label>
                        <select name="kabupaten" id="kabupaten" class="form-select">
                            <option value="0"> -- Pilih Kabupaten -- </option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modalEdit">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>

    </div>
</div>
