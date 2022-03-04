<form action="{{ route('kabupaten.update', $kabupaten->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group row col-md-6">
      <label>Kabupaten</label>
        <input type="text" name="kabupaten" class="form-control @error('kabupaten') is-invalid @enderror" placeholder="Nama Kabupaten" value="{{old('kabupaten', $kabupaten->kabupaten)}}">
        @error('kabupaten')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
  </div>
  
  <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
