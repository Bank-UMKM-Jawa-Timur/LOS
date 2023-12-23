<div class="modal-layout hidden" id="modal-tambah-modal">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Perlimpahan Dana Cabang
                </h2>
            </div>
            <button type="button" data-dismiss-id="modal-tambah-modal">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('master-dana.store-dana') }}" method="POST">
        @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Cabang </label>
                        <input type="hidden" name="cabang" id="cabang">
                        <input type="hidden" name="id" id="id">
                        <input type="text" class="form-input bg-gray-200" id="nama_cabang" name="nama_cabang" readonly >
                    </div>
                    <div class="input-box">
                        <label for="">Dana Modal</label>
                        <input type="text" name="dana_modal"
                            class="form-input @error('dana_modal') is-invalid @enderror rupiah" placeholder="Dana Modal"
                            value="{{ old('dana_modal') }}">
                        @error('dana_modal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn-cancel" data-dismiss-id="modal-tambah-modal">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
