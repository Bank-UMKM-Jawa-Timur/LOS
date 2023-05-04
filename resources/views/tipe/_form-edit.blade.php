<form action="" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Tipe Kendaraan</label>
            <input type="text" name="tipe" class="form-control @error('tipe') is-invalid @enderror" placeholder="Nama Tipe Kendaraan" value="{{old('tipe')}}">
            @error('tipe')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    
        <div class="form-group col-md-6">
            <label>Merk</label>
            <select name="id_merk" id="id_merk" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih merk</option>
                <option value="">Honda</option>
                <option value="">Yamaha</option>
                <option value="">Suzuki</option>
            </select>
            @error('id_merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
