@extends('layouts.template')


@section('content')
@isset($force)
    @if ($force)
        <style>
            #navDashboard{
                pointer-events: none;
            }
            #navAnalisa{
                pointer-events: none;
            }
            #navAdmin{
                pointer-events: none;
            }
        </style>
    @endif
@endisset
   
    @include('user._form-change-password')
@endsection
