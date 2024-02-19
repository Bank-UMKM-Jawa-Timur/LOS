<div class="modal-layout hidden" id="modal-add-cabang">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Tambah Kantor Cabang
                </h2>
            </div>
            <button data-dismiss-id="modal-add-cabang">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.cabang.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group-2 mb-4">
                    <div class="input-box">
                        <label for="">Kode Cabang</label>
                        <input type="text" name="kode_cabang" id="kode-cabang-add"
                            class="form-input @error('kode_cabang') is-invalid @enderror" placeholder="Kode Cabang"
                            value="{{ old('kode_cabang') }}">
                        @error('kode_cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Kantor Cabang</label>
                        <input type="text" name="cabang" id="cabang-add"
                            class="form-input @error('cabang') is-invalid @enderror"
                            placeholder="Nama Cabang" value="{{ old('cabang') }}">
                            @error('cabang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>
                </div>
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Email</label>
                        <input type="email" name="email" id="email-add" class="form-input @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Alamat</label>
                        <input type="text" name="alamat" id="alamat-add" class="form-input @error('alamat') is-invalid @enderror" placeholder="Alamat" value="{{old('alamat')}}">
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-add-cabang">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
