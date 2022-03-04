<form action="{{ route('cabang.store') }}" method="POST">
    @csrf
    <div class="form-group row col-md-6">
        <label>Pangkat</label>
        <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" placeholder="Nama Pangkat" value="{{old('pangkat')}}">
        @error('pangkat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
