<div class="modal-layout hidden" id="modal-add-kabupaten">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Tambah Kabupaten
                </h2>
            </div>
            <button data-dismiss-id="modal-add-kabupaten">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.kabupaten.store') }}">
        @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Nama Kabupaten</label>
                        <input type="text" name="kabupaten"
                            class="form-input @error('kabupaten') is-invalid @enderror" placeholder="Nama Kabupaten"
                            value="{{ old('kabupaten') }}">
                        @error('kabupaten')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" data-dismiss-id="modal-add-kabupaten">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
