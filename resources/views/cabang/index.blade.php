@extends('layouts.template')

@section('page-header')
    @include('components.page-header', [
    'pageTitle' => $pageTitle,
    'pageSubtitle' => '',
    'pageIcon' => $pageIcon,
    'parentMenu' => $parentMenu,
    'current' => $current
    ])
@endsection

@section('content')

    @include('components.notification')

    <div class="row justify-content-between">
        <div class="col-md-6">
            @include('components.button-add', ['btnText' => $btnText, 'btnLink' => $btnLink])
        </div>        
        <div class="col-md-4">
            @include('components.search')
        </div>
    </div>
    @include('cabang._table')
    </div>

@endsection
