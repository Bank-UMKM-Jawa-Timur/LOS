<div class="modal-layout hidden" id="modal-add-kecamatan">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Tambah Kecamatan
                </h2>
            </div>
            <button data-dismiss-id="modal-add-kecamatan" type="button">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.kecamatan.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Nama Kecamatan</label>
                        <input type="text" name="kecamatan"
                            class="form-input @error('kecamatan') is-invalid @enderror" placeholder="Nama Kecamatan"
                            value="{{ old('kecamatan') }}">
                    </div>
                    <div class="input-box">
                        <label for="">Pilih Kabupaten</label>
                        <select name="id_kabupaten" class="form-select" id="id_kabupaten">
                            <option value="">-- Pilih Kabupaten --</option>
                            @foreach ($allKab as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_kabupaten') == $item->id ? ' selected' : '' }}>{{ $item->kabupaten }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kabupaten')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-add-kecamatan">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
