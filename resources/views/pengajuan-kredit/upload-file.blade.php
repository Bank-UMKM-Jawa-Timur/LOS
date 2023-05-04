@extends('layouts.template')
@section('content')
<form method="post" action="{{ route('upload-file') }}" enctype="multipart/form-data">
    @csrf
    <div class="row p-3">
        <div class="form-group">
            <label for="file-sppk">Upload File SPPK</label>
            <input type="file" name="file-sppk" id="file-sppk" class="form-control-file" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="file-po">Upload File PO</label>
            <input type="file" name="file-po" id="file-po" class="form-control-file" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="file-pk">Upload File PK</label>
            <input type="file" name="file-pk" id="file-pk" class="form-control-file" required>
        </div>
    </div>
</form>
    <div class="row">
        <div class="col text-right">
            <button type="submit" class="btn btn-info btn-simpan" id="submit">Simpan <span class="fa fa-save"></span></button>
        </div>
    </div>
@endsection