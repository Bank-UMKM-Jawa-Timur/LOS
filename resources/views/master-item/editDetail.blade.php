<div class="form-group row row-detail" data-no="{{ $no }}">
    <input type="hidden" name='id_detail[]' class='idDetail' value='{{$idDetail}}'>
    <div class="col-md-4">
        <label>Opsi</label>
        <input type="text" id="option" value="{{ old($fields['option'], isset($edit) ? $edit['option'] : '') }}" name="option[]" class="form-control {{ isset($n)&&$errors->has('option.'.$n) ? ' is-invalid' : '' }}" placeholder="Nama Opsi" >
        @if(isset($n)&&$errors->has('option.'.$n))
            <div class="invalid-feedback">
                {{ $errors->first('option.'.$n) }}
            </div>
        @enderror
    </div>
    <div class="col-md-4">
        <label>Skor</label>
        <input type="number" id="skor" value="{{ old($fields['skor'], isset($edit) ? $edit['skor'] : '') }}" name="skor[]" class="form-control {{ isset($n)&&$errors->has('skor.'.$n) ? ' is-invalid' : '' }}">
        @if(isset($n)&&$errors->has('skor.'.$n))
            <div class="invalid-feedback">
                {{ $errors->first('skor.'.$n) }}
            </div>
        @enderror
    </div>
    <div class="col-md-4 my-4 py-2">
        <a class="btn btn-success addDetail" data-no='{{ $no }}' href=""> <i class="fa fa-plus"></i> </a>
        @if ($hapus)
        <a class="btn btn-danger deleteDetail addDeleteId" data-no='{{ $no }}' href=""> <i class="fa fa-minus"></i> </a>
        @endif
    </div>
</div>
