@extends('layouts.template')
@section('content')
<form method="post" action="{{ route('post-file', $id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row p-3">
        <div class="form-group">
            <label for="sppk">Upload File SPPK</label>
            <input type="file" name="sppk" id="sppk" class="form-control file" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="po">Upload File PO</label>
            <input type="file" name="po" id="po" class="form-control file" required>
        </div>
        <hr>
        <div class="form-group">
            <label for="pk">Upload File PK</label>
            <input type="file" name="pk" id="pk" class="form-control file" required>
        </div>
    </div>
    <div class="row">
        <div class="col text-right">
            <button type="submit" class="btn btn-info btn-simpan" id="submit">Simpan <span class="fa fa-save"></span></button>
        </div>
    </div>
</form>
@endsection