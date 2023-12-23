<div class="modal-layout hidden" id="modal-edit-user">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Edit User
                </h2>
            </div>
            <button data-dismiss-id="modal-edit-user">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.user.update', 1) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_user" class="id-user">
            <div class="modal-body">
                <div class="form-group-2 mb-4">
                    <div class="input-box">
                        <label for="">NIP User</label>
                        <input type="text" name="nip" class="form-input nip-edit" />
                        @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Nama User</label>
                        <input type="text" name="name" class="form-input name-edit" />
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group-2 mb-4">
                    <div class="input-box">
                        <label for="">Email User</label>
                        <input type="text" name="email" class="form-input email-edit" />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <label for="">Role User</label>
                        <select name="role" id="role" class="form-input @error('role') is-invalid @enderror">
                            <option value="">Pilih Role User</option>
                            <option value="Administrator" {{ old('role') == 'Administrator' ? ' selected' : '' }} selected>
                                Administrator</option>
                            <option value="Pincab" {{ old('role') == 'Pincab' ? ' selected' : '' }}>Pincab</option>
                            <option value="PBO" {{ old('role') == 'PBO' ? ' selected' : '' }}>PBO</option>
                            <option value="PBP" {{ old('role') == 'PBP' ? ' selected' : '' }}>PBP</option>
                            <option value="Penyelia Kredit" {{ old('role') == 'Penyelia Kredit' ? ' selected' : '' }}>
                                Penyelia Kredit
                            </option>
                            <option value="Staf Analis Kredit"
                                {{ old('role') == 'Staf Analis Kredit' ? ' selected' : '' }}>Staf Analis Kredit
                            </option>
                            <option value="SPI" {{ old('role') == 'SPI' ? ' selected' : '' }}>SPI</option>
                            <option value="Kredit Umum" {{ old('role') == 'Kredit Umum' ? ' selected' : '' }}>Kredit
                                Umum</option>
                            <option value="Direksi" {{ old('role') == 'Direksi' ? ' selected' : '' }}>Direksi</option>
                            <option value="Pemasaran" {{ old('role') == 'Pemasaran' ? ' selected' : '' }}>Pemasaran
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group-1">
                    <div class="input-box">
                        <label for="">Kantor Cabang</label>
                        <select name="cabang" id="cabang" class="form-input @error('cabang') is-invalid @enderror">
                            <option value="">Pilih cabang</option>
                            @foreach ($allCab as $item)
                                <option value="{{$item->cabang}}">{{$item->cabang}}</option>
                            @endforeach
                        </select>
                        @error('cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" data-dismiss-id="modal-edit-user">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
