<form action="{{ route('user.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-4">
            <label>NIP User</label>
            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP User" value="{{old('nip')}}">
            @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Nama User</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama User" value="{{old('name')}}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Email User</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email User" value="{{old('email')}}">
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
                <option value="Administrator" {{ old('role') == 'Administrator' ? ' selected' : '' }}>Administrator</option>
                <option value="Pincab" {{ old('role') == 'Pincab' ? ' selected' : '' }}>Pincab</option>
                <option value="PBO / PBP" {{ old('role') == 'PBO / PBP' ? ' selected' : '' }}>PBO / PBP</option>
                <option value="Penyelia Kredit" {{ old('role') == 'Penyelia Kredit' ? ' selected' : '' }}>Penyelia Kredit</option>
                <option value="Staf Analis Kredit" {{ old('role') == 'Staf Analis Kredit' ? ' selected' : '' }}>Staf Analis Kredit</option>
                <option value="SPI" {{ old('role') == 'SPI' ? ' selected' : '' }}>SPI</option>
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
                        {{ old('id_cabang') == $cab->id ? 'selected' : '' }}>
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
            $('#rowCabang').hide();

            // Role on change
            $('#role').change(function() {
                let role = $(this).val();

                if (role != 'Administrator' && role != 'SPI') {
                    $('#rowCabang').show();
                } else if (role == 'Administrator' && role == 'SPI') {
                    $('#rowCabang').hide();
                }
            });
        });
    </script>
@endpush
