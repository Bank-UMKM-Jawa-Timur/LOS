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
    <form action="" action="POST">
    @csrf
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
                <div class="form-group col-md-12">
                    <label for="">Komentar</label>
                    <textarea name="komentar" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
            @empty
                <p class="text-center">Tidak ada data yang tersimpan.</p>
            @endforelse
        </div>
        <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
    </form>
</div>


@endsection
