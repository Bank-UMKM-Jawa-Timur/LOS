<form action="{{ route('cabang.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Kode Cabang</label>
            <input type="text" name="kode_cabang" class="form-control @error('kode_cabang') is-invalid @enderror" placeholder="Kode Cabang" value="{{old('kode_cabang')}}">
            @error('kode_cabang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label>Kantor Cabang</label>
            <input type="text" name="cabang" class="form-control @error('cabang') is-invalid @enderror" placeholder="Nama Cabang" value="{{old('cabang')}}">
            @error('cabang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" value="{{old('alamat')}}">
            @error('alamat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
