<div class="modal-layout hidden" id="modal-add-desa">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Tambah Desa
                </h2>
            </div>
            <button data-dismiss-id="modal-add-desa">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.desa.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="desa">Nama Desa</label>
                        <input type="text" name="desa" class="form-input" />
                    </div>
                </div>
                <div class="form-group-2">
                    <div class="input-box">
                        <label for="id_kabupaten">Pilih Kabupaten</label>
                        <select name="id_kabupaten" class="form-select" id="kabupaten_select">
                            <option value="">-- Pilih Kabupaten --</option>
                            @foreach ($kabupaten as $key => $item)
                                <option value="{{ $item->id }}" data-key="{{ $key }}">
                                    {{ $item->kabupaten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="id_kecamatan">Pilih Kecamatan</label>
                        <select name="id_kecamatan" class="form-select" id="kecamatan_select">
                            <option value="">-- Pilih kecamatan --</option>
                            @foreach ($kecamatan as $key => $item)
                                <option value="{{ $item->id }}" data-key="{{ $key }}">
                                    {{ $item->kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-add-desa">
                    Batal
                </button>
                <button class="btn-submit" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
