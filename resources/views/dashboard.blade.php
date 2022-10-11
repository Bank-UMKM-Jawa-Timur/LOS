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
    </div>
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
                                <td>Rp.{{ number_format($item->jumlah_kredit, 2, '.', ',') }}</td>
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
