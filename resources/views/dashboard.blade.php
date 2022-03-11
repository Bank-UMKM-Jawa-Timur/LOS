@extends('layouts.template')
@section('content')
    <div class="row mt-4">
        <div class="col">
            <div class="alert alert-primary font-weight-bold">Selamat Datang Di Aplikasi Analisa Kredit</div>
        </div>
    </div>
    {{-- @if (auth()->user()->level == 'Administrator' || auth()->user()->level == 'Admin' || auth()->user()->level == 'Kasat') --}}
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-primary border border-primary">
                <div class="card-body py-4">
                    <span class="fa fa-calendar-check sticky-fa-card"></span>
                    <div class="row align-items-center">
                        <div class="col-md-8 pr-0 font-weight-bold">
                            Yang Telah Di Analisa
                        </div>
                        <div class="col-md-4 pr-0 text-center">
                            {{-- <h1>{{ \App\Models\Penugasan::where('status', 'Rencana')->count() }}</h1> --}}
                            <h1>1</h1>
                        </div>
                    </div>
                    <hr>
                    <a href="#" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                        Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-success border border-success">
                <div class="card-body py-4">
                    <i class="fas fa-check sticky-fa-card"></i>
                    <div class="row">
                        <div class="col-md-8 pr-0 font-weight-bold">
                            Analisa Status Hijau
                        </div>
                        <div class="col-md-4 pl-0 text-center font-weight-bold">
                            <h1>2</h1>
                            {{-- <h1>{{ \App\Models\Penugasan::where('status', 'Pelaksanaan')->count() }}</h1> --}}
                        </div>
                    </div>
                    <hr>
                    <a href="#" class="btn btn-success btn-sm b-radius-3 px-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-warning border border-warning">
                <div class="card-body py-4">
                    <i class="fa fa-exclamation-triangle sticky-fa-card"></i>
                    <div class="row font-weight-bold">
                        <div class="col-md-8 pr-0">
                            Analisa Status Kuning
                        </div>
                        <div class="col-md-4 pl-0 text-center">
                            <h1>3</h1>
                            {{-- <h1>{{ \App\Models\Penugasan::where('status', 'Selesai')->count() }}</h1> --}}
                        </div>
                    </div>
                    <hr>
                    <a href="#" class="btn btn-warning btn-sm b-radius-3 px-3">Lihat
                        Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-danger border border-danger">
                <div class="card-body py-4">
                    <i class="fa fa-ban sticky-fa-card"></i>
                    <div class="row font-weight-bold">
                        <div class="col-md-8 pr-0">
                            Analisa Status Merah
                        </div>
                        <div class="col-md-4 pl-0 text-center">
                            <h1>4</h1>
                            {{-- <h1>{{ \App\Models\Penugasan::where('status', 'Batal')->count() }}</h1> --}}
                        </div>
                    </div>
                    <hr>
                    <a href="#" class="btn btn-danger btn-sm b-radius-3 px-3">Lihat
                        Detail</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{-- @endif --}}
    {{-- <div class="row">
        <div class="col-md-6">
            <h5 class="font-weight-bold color-darkBlue">Kegiatan Penugasan Hari Ini</h5>
        </div>
        <div class="col-md-6 text-right">
            <a href="#">Lihat Semua Analisis</a>
        </div>
    </div>
    <hr class="mt-2"> --}}
@endsection
