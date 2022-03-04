<form action="{{ route('cabang.update', $cabang->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="row">
    <div class="form-group col-md-6">
        <label>Cabang</label>
        <input type="text" name="cabang" class="form-control @error('cabang') is-invalid @enderror" placeholder="Nama Cabang" value="{{old('cabang', $cabang->cabang)}}">
        @error('cabang')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group col-md-6">
      <label>Alamat</label>
      <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" value="{{old('alamat', $cabang->alamat)}}">
      @error('alamat')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-6">
      <label class="">Kabupaten</label>
      <select name="id_kabupaten" id="id_kabupaten" class="select2 form-control" style="width: 100%;" required>
        <option value="">Pilih Kabupaten</option>
        @foreach ($allKab as $kab)
            <option value="{{ $kab->id }}" {{$kab->id == $cabang->id_kabupaten ? 'selected' : ''}} >{{ $kab->kabupaten }}</option>
        @endforeach
      </select>
      @error('id_kabupaten')
          <div class="invalid-feedback">
              {{ $message }}
          </div>
      @enderror
    </div>
  </div>
  
  <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
