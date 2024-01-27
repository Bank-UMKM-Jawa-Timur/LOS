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
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Email User</label>
                        <input type="text" name="email" class="form-input email-edit" />
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group-2">
                    <div class="input-box" id="cabang">
                        <label for="">Kantor Cabang</label>
                        <select name="cabang" id="cabang" class="form-input @error('cabang') is-invalid @enderror">
                            <option value="">Pilih cabang</option>
                            @foreach ($allCab as $item)
                                <option value="{{$item->id}}">{{$item->cabang}}</option>
                            @endforeach
                        </select>
                        @error('cabang')
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
                            <option value="Kredit Program" {{ old('role') == 'Kredit Program' ? ' selected' : '' }}>Kredit Program
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-box">
                        <div class="flex items-center">
                            <input id="checked-checkbox-dagulir" type="checkbox" name="is_dagulir" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 mx-2">Is Dagulir</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button type="button" class="btn-cancel" data-dismiss-id="modal-edit-user">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
