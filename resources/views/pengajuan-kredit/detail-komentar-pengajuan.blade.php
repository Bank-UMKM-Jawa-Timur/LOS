@extends('layouts.template')
@section('content')
@include('components.notification')

<style>
    .sub label:not(.info){
        font-weight: 400;
    }
    h4{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 20px;
        /* border-bottom: 1px solid #dc3545; */
    }
    h5{
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
    <form action="{{ route('pengajuan.check.pincab.status.detail.post') }}" method="POST" >
    @csrf
        {{-- calon nasabah --}}
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">Nama Lengkap</label>
            <label for="staticEmail" class="col-sm-1 col-form-label">:</label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataUmum->nama }}">
            </div>
        </div>
        <div class="form-group row">
            {{-- alamat rumah --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Rumah</label>
            <label for="staticEmail" class="col-sm-1 col-form-label">:</label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataUmum->alamat_rumah }}</textarea>
            </div>
            {{-- alamat usaha --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Usaha</label>
            <label for="staticEmail" class="col-sm-1 col-form-label">:</label>
            <div class="col-sm-7">
                <textarea name="" class="form-control-plaintext" readonly id="" cols="5" rows="2" >{{ $dataUmum->alamat_usaha }}</textarea>
            </div>
            {{-- No KTP --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">No. KTP</label>
            <label for="staticEmail" class="col-sm-1 col-form-label">:</label>
            <div class="col-sm-7">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataUmum->no_ktp }}">
            </div>
            {{-- Tempat tanggal lahir --}}
            <label for="staticEmail" class="col-sm-3 col-form-label">Tempat, Tanggal lahir/Status</label>
            <label for="staticEmail" class="col-sm-1 col-form-label">:</label>
            <div class="col-sm-4">
                <div class="d-flex justify-content-end ">
                    <div class="">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataUmum->tempat_lahir.',' }}">
                    </div>
                    <div class="">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataUmum->tanggal_lahir }}">
                    </div>
                    <div class="">
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $dataUmum->status }}">
                    </div>
                </div>

            </div>
        </div>


        <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
    </form>
</div>


@endsection
