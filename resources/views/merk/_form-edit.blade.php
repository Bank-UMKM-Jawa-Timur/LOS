<form action="{{ route('merk.update', $merk->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group row col-md-6">
        <label>Nama Merk Kendaraan</label>
        <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" placeholder="Nama Merk Kendaraan" value="{{old('merk', $merk->merk)}}">
        @error('merk')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
  </form>
  