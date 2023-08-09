@extends('layouts.template')

@section('content')
    @include('components.notification')
    <div class="row justify-content-between">
        <div class="col-md-6"></div>

        <div class="col-md-4">

            <form action="" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari Berdasarkan Email"
                        aria-label="Cati item" aria-describedby="basic-addon2" value="{{ Request::get('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('user.api-sessions._table')
    </div>
@endsection
