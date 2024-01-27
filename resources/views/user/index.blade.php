@extends('layouts.template')

@section('content')
    @include('components.notification')
    <div class="row justify-content-between">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <a href="{{ $btnLink }}" class="btn btn-primary px-3"><i class="fa fa-plus-circle"></i>
                        {{ $btnText }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <form action="" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari item"
                        aria-label="Cati item" aria-describedby="basic-addon2" value="{{Request::get('keyword')}}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('user._table')
    </div>
@endsection

