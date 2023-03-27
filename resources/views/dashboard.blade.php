@extends('layouts.template')
@section('content')
    @php
        $user = DB::table('users')->where('id', auth()->user()->id)->first();
        $cabang = DB::table('cabang')->where('id', $user->id_cabang)->first();
    @endphp
    <div class="row mt-4">
        <div class="col">
            <div class="alert alert-primary font-weight-bold">Selamat Datang Di Aplikasi Analisa Kredit</div>
        </div>
    </div>
    {{-- @if ($user->level == 'Administrator' || $user->level == 'Admin' || $user->level == 'Kasat') --}}
    <div class="row">
        @if (auth()->user()->role == "Administrator")
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
                Total Pengajuan : {{ \App\models\PengajuanModel::count() }}
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'Selesai')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'Ditolak')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'Pincab')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'PBP')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'Review Penyelia')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
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
                                <h1>{{ \App\models\PengajuanModel::where('posisi', 'Proses Input Data')->count() }}</h1>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @else    
            <div class="col-md-3 mb-4">
                <div class="card bg-rgb-primary border border-primary">
                    <div class="card-body py-4">
                        <span class="fa fa-calendar-check sticky-fa-card"></span>
                        <div class="row align-items-center">
                            <div class="col-md-8 pr-0 font-weight-bold">
                                Pengajuan Telah Ditinjak Lanjuti
                            </div>
                            <div class="col-md-4 pr-0 text-center">
                                @if (auth()->user()->role == "Pincab")
                                    <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['Selesai','Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>
                                @elseif (auth()->user()->role == "Penyelia Kredit")
                                    @if (auth()->user()->id_cabang == '1')
                                        <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['PBP','Pincab','Selesai','Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>
                                    @else
                                        <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['Pincab','Selesai','Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>   
                                    @endif
                                @elseif (auth()->user()->role == "PBP")
                                    <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['Pincab','Selesai','Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>
                                @elseif (auth()->user()->role == "Staf Analis Kredit")
                                    <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['Review Penyelia','Pincab','Selesai', 'Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>
                                @else
                                    <h1>{{ \App\Models\PengajuanModel::whereIn('posisi', ['Selesai', 'Ditolak'])->where('id_cabang', auth()->user()->id_cabang)->count() }}</h1>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-primary-detail btn-sm b-radius-3 px-3">Lihat
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
                                Pengajuan Belum Ditindak Lanjuti
                            </div>
                            <div class="col-md-4 pl-0 text-center">
                                @if (auth()->user()->role == "Staf Analis Kredit")
                                    <h1>{{ \App\Models\PengajuanModel::where('posisi','Proses Input Data')->where('id_cabang', $user->id_cabang)->count() }}</h1>
                                @elseif (auth()->user()->role == "Penyelia Kredit")
                                    <h1>{{ \App\Models\PengajuanModel::where('posisi','Review Penyelia')->where('id_cabang', $user->id_cabang)->count() }}</h1>
                                @elseif (auth()->user()->role == "PBP")
                                    <h1>{{ \App\Models\PengajuanModel::where('posisi','PBP')->where('id_cabang', $user->id_cabang)->count() }}</h1>
                                @elseif (auth()->user()->role == "Pincab")
                                    <h1>{{ \App\Models\PengajuanModel::where('posisi','Pincab')->where('id_cabang', $user->id_cabang)->count() }}</h1>
                                @else
                                    <h1>0</h1>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('pengajuan-kredit.index') }}" class="btn btn-danger btn-sm b-radius-3 px-3">Lihat
                            Detail</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if (auth()->user()->role == "Administrator")
        
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
                                    <td>Rp.{{ (is_numeric($item->jumlah_kredit)) ? number_format($item->jumlah_kredit, 2, '.', ',') : $item->jumlah_kredit }}</td>
                                    <td>{{ date('d-m-Y',strtotime( $item->tanggal ) ) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    @endif
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
