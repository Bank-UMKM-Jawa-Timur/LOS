<div class="modal-layout hidden" id="modal-edit-kabupaten">
    <form id="form-edit-kabupaten" method="POST" action="{{ route('dagulir.master.kabupaten.update',1) }}">
    @csrf
    @method('PUT')
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Edit Kabupaten
                </h2>
            </div>
            <button data-dismiss-id="modal-edit-kabupaten" type="button">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <input type="hidden" name="id" id="id">

                    <div class="input-box">
                        <label for="">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupaten" class="form-input @error('kabupaten') is-invalid @enderror"
                            placeholder="Nama kabupaten" value="">
                            @error('kabupaten')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-edit-cabang">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
    </div>
    </form>
</div>
