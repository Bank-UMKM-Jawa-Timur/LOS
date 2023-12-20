<div class="modal-layout hidden" id="modal-edit-cabang">
    <form id="form-edit-cabang" method="POST" action="{{ route('dagulir.master.cabang.update',1) }}">
    @csrf
    @method('PUT')
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Edit Kantor Cabang
                </h2>
            </div>
            <button data-dismiss-id="modal-edit-cabang" type="button">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
            <div class="modal-body">
                <div class="form-group-2 mb-4">
                    <input type="hidden" name="id" id="id">
                    <div class="input-box">
                        <label for="">Kode Cabang</label>
                        <input type="text" name="kode_cabang" id="kode_cabang"
                            class="form-input @error('kode_cabang') is-invalid @enderror" placeholder="Kode Cabang"
                            value="">
                        @error('kode_cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Kantor Cabang</label>
                        <input type="text" name="cabang" id="cabang" class="form-input @error('cabang') is-invalid @enderror"
                            placeholder="Nama Cabang" value="">
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
                        <input type="email" name="email" id="email" class="form-input @error('email') is-invalid @enderror"
                            placeholder="Email" value="">
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
                        <input type="text" name="alamat" id="alamat" class="form-input @error('alamat') is-invalid @enderror" placeholder="Alamat" value="">
                        @error('alamat')
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
        </form>
    </div>
</div>
@push('script-inject')
    {{-- <script>
        $('#form-edit-cabang .btn-submit').on('click', function(e) {
            $('#modal-edit-cabang #form-edit-cabang').submit()
        })
    </script> --}}
@endpush
