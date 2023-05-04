<form action="{{ route('tipe.update', $tipe->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label>Merk Kendaraan</label>
            <select name="id_merk" id="id_merk" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Merk Kendaraan</option>
                @foreach ($dataMerk as $item)
                    <option value="{{ $item->id }}" {{ ($item->id == $tipe->id_merk) ? 'selected' : '' }}>{{ $item->merk }}</option>
                @endforeach
            </select>
            @error('id_merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label>Tipe Kendaraan</label>
            <input type="text" name="tipe" class="form-control @error('tipe') is-invalid @enderror" placeholder="Nama tipe kendaraan" value="{{old('tipe', $tipe->tipe)}}">
            @error('tipe')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
