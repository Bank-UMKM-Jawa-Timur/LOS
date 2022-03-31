@extends('layouts.template')
@section('content')
@include('components.notification')

<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }
    .form-wizard h4{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 20px;
        /* border-bottom: 1px solid #dc3545; */
    }
    .form-wizard h5{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 18px;
        /* border-bottom: 1px solid #dc3545; */
    }
    .form-wizard h6{
        color: #c2c7cf;
        font-weight: 600 !important;
        font-size: 16px;
        /* border-bottom: 1px solid #dc3545; */
    }
</style>
<div class="">
    <div class="row">
        @forelse ($jawabanpengajuan as $item)
            <div class="form-group col-md-12">
                <label for="">{{ $item->nama }}</label>
                <div class="row sub">
                    <div class="col-md-6">
                        <label for="">Jawaban</label>
                        <input type="text" name="name" id="nama" class="form-control"  value="{{old('name',$item->name_option)}}" placeholder="Nama sesuai dengan KTP" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="">Skor</label>
                        <input type="text" name="name" id="nama" class="form-control"  value="{{old('skor',$item->skor)}}" placeholder="Nama sesuai dengan KTP" readonly>
                    </div>
                </div>
            </div>
        @empty

        @endforelse
    </div>
</div>


@endsection
