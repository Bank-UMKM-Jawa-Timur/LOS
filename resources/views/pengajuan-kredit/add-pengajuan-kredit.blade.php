@extends('layouts.template')
@section('content')
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 1</label>
            <input type="text" class="form-control" placeholder="Input label 1">
        </div>
        <div class="col-md-6">
            <label for="">Label 2</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Select---</option>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 3</label>
            <input type="file" class="form-control" placeholder="Input label 1">
        </div>
        <div class="col-md-6">
            <label for="">Label 4</label>
            <input type="text" class="form-control" placeholder="Input label 4">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 5</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Select---</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Label 6</label>
            <input type="text" class="form-control" placeholder="Input label 6">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <label for="">Label 7</label>
            <textarea name="" class="form-control" id="" rows="5"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <div class="col text-right">
            <button class="btn btn-default"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
            <button class="btn btn-danger">Selanjutnya <span class="fa fa-chevron-right"></span></button>
        </div>
    </div>
@endsection