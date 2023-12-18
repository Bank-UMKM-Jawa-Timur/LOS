<form action="{{ route('update_password', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <div class="col-md-6">
            <label>Password Lama</label>
                <input type="password" name="old_pass" class="form-control @error('old_pass') is-invalid @enderror"
                    placeholder="Password lama" value="{{ old('old_pass') }}">
                @error('old_pass')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Password Baru</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password baru" value="{{ old('password') }}">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
        </div>
        <div class="col-md-6">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirmation" class="form-control @error('confirmation') is-invalid @enderror"
                placeholder="Konfirmasi password baru" value="{{ old('confirmation') }}">
            @error('confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
