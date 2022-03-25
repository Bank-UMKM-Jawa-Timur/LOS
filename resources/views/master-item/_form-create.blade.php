<form action="{{ route('master-item.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-4">
            <label>Level</label>
            <select name="" id="" class="form-control" >
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Item Turunan 1</label>
            <select name="" id="" class="form-control" >
                <option value="1">1-Aspek Management</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Item Turunan 2</label>
            <select name="" id="" class="form-control" >
                <option value="1">1-Aspek Management</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </div>
    <hr>
    <p><strong>Opsi atau Jawaban</strong></p>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Opsi</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-5">
            <label>Skor</label>
            <input type="number" name="skor" class="form-control @error('skor') is-invalid @enderror" placeholder="Skor" value="{{old('skor')}}">
            @error('skor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-3">
            <div class="d-flex">
                <div class="py-4">
                    <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary"></i></a>
                </div>
                {{-- @if ($hapus) --}}
                <div class="p-3 py-4">
                    <a class="deleteDetail"  href=""><i class="fa fa-minus-square text-danger "></i></a>
                </div>
                {{-- @endif --}}
                 {{-- @if($hapus) --}}
                {{-- @endif --}}
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
@push('custom-script')
    <script>

    </script>
@endpush
