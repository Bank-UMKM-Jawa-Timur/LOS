<div class="modal-layout hidden" id="modal-update-data">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Update Data
                </h2>
            </div>
            <button type="button" data-dismiss-id="modal-add-kabupaten">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('master-dana.update',$data->id) }}" method="POST">
        @csrf
            <div class="modal-body">
                <div class="form-group-2 mb-4">
                    <div class="input-box">
                        <label for="">Dana Idle</label>
                        <input type="text" name="dana_idle"
                            class="form-input @error('dana_idle') is-invalid @enderror" placeholder="Dana Idle"
                            value="{{ old('dana_idle',$data->dana_idle) }}">
                        @error('dana_idle')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Dana Modal</label>
                        <input type="text" name="dana_modal"
                            class="form-input @error('dana_modal') is-invalid @enderror" placeholder="Dana Modal"
                            value="{{ old('dana_modal',$data->dana_modal) }}">
                        @error('dana_modal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn-cancel" data-dismiss-id="modal-add-kabupaten">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
