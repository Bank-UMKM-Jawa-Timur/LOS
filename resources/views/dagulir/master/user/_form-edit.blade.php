<form action="{{ route('user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-4">
            <label>NIP User</label>
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP User" value="{{old('nip', $user->nip)}}">
            @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Nama User</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama User" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Nama Email</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email User" value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Role User</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                <option value="">Pilih Role User</option>
                <option value="Administrator" {{ old('role', $user->role) == 'Administrator' ? ' selected' : '' }}>Administrator</option>
                <option value="Pincab" {{ old('role', $user->role) == 'Pincab' ? ' selected' : '' }}>Pincab</option>
                <option value="PBO" {{ old('role', $user->role) == 'PBO' ? ' selected' : '' }}>PBO</option>
                <option value="PBP" {{ old('role', $user->role) == 'PBP' ? ' selected' : '' }}>PBP</option>
                <option value="Penyelia Kredit" {{ old('role', $user->role) == 'Penyelia Kredit' ? ' selected' : '' }}>Penyelia Kredit</option>
                <option value="Staf Analis Kredit" {{ old('role', $user->role) == 'Staf Analis Kredit' ? ' selected' : '' }}>Staf Analis Kredit</option>
                <option value="SPI" {{ old('role', $user->role) == 'SPI' ? ' selected' : '' }}>SPI</option>
                <option value="Kredit Umum" {{ old('role', $user->role) == 'Kredit Umum' ? ' selected' : '' }}>Kredit Umum</option>
                <option value="Direksi" {{ old('role', $user->role) == 'Direksi' ? ' selected' : '' }}>Direksi</option>
                <option value="Pemasaran" {{ old('role', $user->role) == 'Pemasaran' ? ' selected' : '' }}>Pemasaran</option>
            </select>
            @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6" id="rowCabang">
            <label>Cabang</label>
            <select name="id_cabang" id="id_cabang" class="form-control select2 @error('id_cabang') is-invalid @enderror">
                <option value="">Pilih Cabang</option>
                @foreach ($allCab as $cab)
                    <option value="{{ $cab->id }}"
                        {{ old('id_cabang', $user->id_cabang) == $cab->id ? 'selected' : '' }}>
                        {{ $cab->cabang }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>

@push('custom-script')
    <script>
        $(document).ready(function() {
            var role = $("#role option:selected").val()
            rowCabangVisibility(role)

            // Role on change
            if (role == "Staf Analis Kredit") {
                $('#rowCabang').show();
            }else if (role == "Penyelia Kredit"){
                $('#rowCabang').show();
            }else if (role == "Pincab"){
                $('#rowCabang').show();
            }else{
                $('#rowCabang').hide();
            }
            $('#role').change(function() {
                var hasilRole = $(this).val();
                rowCabangVisibility(hasilRole)
            });
        });

        function rowCabangVisibility(role) {
            if (role == "Penyelia Kredit") {
                $('#rowCabang').show();
            }else if (role == "Pincab"){
                $('#rowCabang').show();
            }else if (role == "Staf Analis Kredit"){
                $('#rowCabang').show();
            }else if (role == "PBO") {
                $('#rowCabang').show();
            }else{
                $('#rowCabang').hide();
            }
        }
    </script>
@endpush
