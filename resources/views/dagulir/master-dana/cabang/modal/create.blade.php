<div class="modal-layout hidden" id="modal-add-cabang">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Perlimpahan Dana Cabang
                </h2>
            </div>
            <button type="button" data-dismiss-id="modal-add-kabupaten">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('master-dana.store-cabang') }}" method="POST">
        @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Cabang </label>
                        <select name="cabang" id="" class="form-select">
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $item)
                                <option value="{{ $item->id }}">{{ $item->cabang }}</option>
                            @endforeach
                        </select>
                        @error('cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Dana Idle</label>
                        <input type="text" name="dana_idle"
                            class="form-input @error('dana_idle') is-invalid @enderror rupiah" placeholder="Dana Idle"
                            value="{{ old('dana_idle') }}">
                        @error('dana_idle')
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
