<form action="{{ route('kecamatan.update', $kecamatan->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="row">
    <div class="form-group col-md-6">
        <label>Kecamatan</label>
          <input type="text" name="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Nama Kecamatan" value="{{old('kecamatan', $kecamatan->kecamatan)}}">
          @error('kecamatan')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
    </div>

    <div class="form-group col-md-6">
      <label>Kabupaten</label>
      <select name="id_kabupaten" id="id_kabupaten" class="select2 form-control" style="width: 100%;" required>
          <option value="">Pilih Kabupaten</option>
          @foreach ($allKab as $kab)
              <option value="{{ $kab->id }}" {{ $kecamatan->id_kabupaten == $kab->id ? 'selected' : '' }}>{{ $kab->kabupaten }}</option>
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
