@extends('layouts.template')
@section('content')
    @php
        $user = DB::table('users')
            ->where('id', auth()->user()->id)
            ->first();
        $cabang = DB::table('cabang')
            ->where('id', $user->id_cabang)
            ->first();
    @endphp
    <div class="row mt-4">
        <div class="col">
            <div class="alert alert-primary font-weight-bold">Selamat Datang Di Aplikasi Analisa Kredit</div>
        </div>
    </div>
    {{-- @if ($user->level == 'Administrator' || $user->level == 'Admin' || $user->level == 'Kasat') --}}
    <div class="row">
        @if (auth()->user()->role == 'Administrator')
            {{-- Total Pengajuan --}}
            {{-- <div class="col-md-12 mb-4">
                <div class="card bg-rgb-success border border-success">
                    <div class="card-body py-4">
                        <span class="fa fa-calendar-check sticky-fa-card"></span>
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Total Pengajuan
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-12 mb-4">
                Total Pengajuan :
                {{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                })->when(Request()->cbg, function ($query, $cbg) {
                        return $query->where('id_cabang', $cbg);
                    })->count() }}
                <div class=" d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            {{-- Pengajuan Approve --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-success border border-success">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-calendar-check sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Disetujui
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Selesai')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?sts=Selesai" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Ditolak --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-danger border border-danger">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Ditolak
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Ditolak')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?sts=Ditolak" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Pincab --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Pincab
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Pincab')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Pincab" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBP --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBP Cabang 001
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'PBP')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=PBP" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBO --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBO
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'PBO')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=PBO" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Penyelia --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Penyelia
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Review Penyelia')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Review+Penyelia"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Staff --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Staff
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Proses Input Data')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Proses+Input+Data"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @elseif (auth()->user()->role == 'SPI' || auth()->user()->role == 'Kredit Umum')
            <div class="col-md-12 mb-4">
                Total Pengajuan :
                {{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                })->when(Request()->cbg, function ($query, $cbg) {
                        return $query->where('id_cabang', $cbg);
                    })->count() }}
                <div class=" d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            {{-- Pengajuan Approve --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-success border border-success">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-calendar-check sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Disetujui
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Selesai')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Ditolak --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-danger border border-danger">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Ditolak
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Ditolak')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Pincab --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Pincab
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Pincab')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBP --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBP Cabang 001
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'PBP')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBO --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBO
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'PBO')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Penyelia --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Penyelia
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Review Penyelia')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Staff --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Staff
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->when(Request()->cbg, function ($query, $cbg) {
                                        return $query->where('id_cabang', $cbg);
                                    })->where('posisi', 'Proses Input Data')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12 mb-4">
                Total Pengajuan :
                {{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                })->where('id_cabang', auth()->user()->id_cabang)->count() }}
                <div class=" d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal"
                        data-target="#exampleModal">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            {{-- Pengajuan Approve --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-success border border-success">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-calendar-check sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Disetujui
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'Selesai')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?sts=Selesai"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Ditolak --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-danger border border-danger">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Ditolak
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'Ditolak')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?sts=Ditolak"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Pincab --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Pincab
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'Pincab')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Pincab" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBP --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBP Cabang 001
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'PBP')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=PBP" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi PBO --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi PBO
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'PBO')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=PBO" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Penyelia --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Penyelia
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'Review Penyelia')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Review+Penyelia"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            {{-- Pengajuan Posisi Staff --}}
            <div class="col-md-4 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        {{-- <span class="fa fa-ban sticky-fa-card"></span> --}}
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Posisi Staff
                            </div>
                            <div class="col-md-4 pr-0 font-wight-bold">
                                <h1>{{ \App\models\PengajuanModel::when(Request()->tAwal && Request()->tAkhir, function ($query) {
                                    return $query->whereBetween('pengajuan.tanggal', [Request()->tAwal, Request()->tAkhir]);
                                })->where('id_cabang', auth()->user()->id_cabang)->where('posisi', 'Proses Input Data')->count() }}
                                </h1>
                            </div>
                        </div>
                        <hr>
                        <a href="/pengajuan-kredit?pss=Proses+Input+Data"
                            class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (auth()->user()->role == 'Administrator')
    @elseif(auth()->user()->role == 'SPI' || auth()->user()->role == 'Kredit Umum')
    @else
        <br>
        <h5 class="color-darkBlue font-weight-bold">Pengajuan Belum Ditindak Lanjuti</h5>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-custom">
                        <thead>
                            <tr class="table-primary">
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Sektor Kredit</th>
                                <th>Jenis Usaha</th>
                                <th>Jumlah Kredit yang diminta</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->sektor_kredit }}</td>
                                    <td>{{ $item->jenis_usaha }}</td>
                                    <td>Rp.{{ is_numeric($item->jumlah_kredit) ? number_format($item->jumlah_kredit, 2, '.', ',') : $item->jumlah_kredit }}
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"
                                        style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="get">
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-sm-6">
                                <label>Tanggal Awal</label>
                                <input type="date" name="tAwal" id="tAwal" class="form-control"
                                    value="{{ Request()->query('tAwal') }}">
                            </div>
                            <div class="col-sm-6">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tAkhir" id="tAkhir" class="form-control"
                                    value="{{ Request()->query('tAkhir') }}">
                            </div>
                            @if (auth()->user()->role == 'Administrator')
                                <div class="col-sm-6 mt-2">
                                    <label>Cabang</label>
                                    <select class="custom-select" id="inputGroupSelect01" name="cbg">
                                        @if (Request()->query('cbg') != null)
                                            @foreach ($cabangs as $items)
                                                @if ($items->id == Request()->query('cbg'))
                                                    <option selected value="{{ $items->id }}">
                                                        {{ $items->cabang }}</option>
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        <option selected disabled value="">Pilih Cabang</option>
                                    @endif
                                    @foreach ($cabangs as $item)
                                        <option value="{{ $item->id }}">{{ $item->cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#tAwal").on("change", function() {
        var result = $(this).val();
        if (result != null) {
            $("#tAkhir").prop("required", true)
        }
    });
</script>
@endsection
