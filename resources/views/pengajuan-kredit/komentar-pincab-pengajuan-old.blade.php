@extends('layouts.template')
@section('content')

    @push('extraStyle')
        <style>
            .text-sm span {
                font-size: 14px;
                margin: 0;
            }
            .text-color-soft {
                color: rgba(0, 0, 0, 0.3);
            }
            #loadingModal {
            sckground: none;
            }

            #loadingModal .modal-dialog {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
            }

            #loadingModal .modal-content {
                padding: 20px;
            }
        </style>
    @endpush
    @include('components.notification')
    {{-- @include('pengajuan-kredit.filter-pengajuan') --}}

    <div class="row d-flex justify-content-end">
        @if (Request()->query() == null)
            <div class="col-sm-4 d-inline-flex">
            @else
                <div class="col-sm-5 d-inline-flex">
        @endif

        <form action='' class="d-inline-flex">
            @if (Request()->tAwal != null)
                <input type="text" name="tAwal" value="{{ Request()->tAwal }}" hidden>
            @endif
            @if (Request()->tAkhir != null)
                <input type="text" name="tAkhir" value="{{ Request()->tAkhir }}" hidden>
            @endif
            @if (Request()->cbg != null)
                <input type="text" name="cbg" value="{{ Request()->cbg }}" hidden>
            @endif
            @if (Request()->pss != null)
                <input type="text" name="pss" value="{{ Request()->pss }}" hidden>
            @endif
            @if (Request()->score != null)
                <input type="text" name="score" value="{{ Request()->score }}" hidden>
            @endif
            @if (Request()->sts != null)
                <input type="text" name="sts" value="{{ Request()->sts }}" hidden>
            @endif
            <input required type="search" value="{{ Request()->query('search') }}" name="search" class="form-control mb-2"
                placeholder="Cari Nama Nasabah" value="" required>
            <button type="submit" class="btn btn-sm btn-primary mb-2 ml-2">
                <i class="fa fa-search"></i> Cari
            </button>
        </form>

        <button type="button" class="btn btn-sm btn-primary mb-2 ml-2" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-filter"></i> Filter
        </button>
        @if (Request()->query() != null)
            <a href="{{ url()->current() }}" class="btn btn-warning mb-2 ml-2"><i class="fa fa-undolar"></i> Reset
                Filter</a>
        @endif
    </div>
    </div>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-database"></i> Data Pengajuan</button>
    </li>
    @if (auth()->user()->role == 'Administrator')
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-trash"></i> Sampah Pengajuan</button>
    </li>
    @endif
    </ul>
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <br>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover table-custom">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center">#</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Nasabah</th>
                            @if (auth()->user()->role == 'Administrator')
                                <th>Cabang</th>
                            @endif
                            <th class="text-center">Posisi</th>
                            <th>Durasi</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_pengajuan as $item)
                            @php
                                $countAlasan = \App\Models\AlasanPengembalianData::where('id_pengajuan', $item->id)
                                            ->join('users', 'users.id', 'alasan_pengembalian_data.id_user')
                                            ->select('users.nip', 'alasan_pengembalian_data.*')
                                            ->count();
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->nama }}</td>
                                @if (auth()->user()->role == 'Administrator')
                                    @php
                                        $c = \App\Models\Cabang::where('id', $item->id_cabang)->first();
                                    @endphp
                                    <td>{{ $c->cabang }}</td>
                                @endif
                                <td class="text-center text-sm">
                                    @if ($item->posisi == 'Proses Input Data')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_staf)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Staf%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Staff</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'Review Penyelia')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_penyelia)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Penyelia%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Penyelia</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'PBO')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pbo)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'PBO%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>PBO</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'PBP')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pbp)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'PBP%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>PBP</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'Pincab')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pincab)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Pincab%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Pincab</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @else
                                        <span>Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->posisi == 'Selesai')
                                        @php
                                            $awal = date_create($item->tanggal);
                                            $akhir = date_create($item->tanggal_review_pincab);
                                            $interval = $akhir->diff($awal);
                                            $res = $interval->format('%a');
                                        @endphp

                                         @if ($res != 0)
                                            @if ($res == 1 || $res == 2 || $res == 3)
                                                <font class="text-success">{{ $res . ' hari' }}</font>
                                            @elseif ($res == 4 || $res == 5 || $res == 6)
                                                <font class="text-warning">{{ $res . ' hari' }}</font>
                                            @else
                                                <font class="text-danger">{{ $res . ' hari' }}</font>
                                            @endif
                                        @else
                                            {{ '-' }}
                                        @endif
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $avgResult = $item->average_by_sistem;
                                        if ($item->posisi == 'Review Penyelia')
                                            $avgResult = $item->average_by_penyelia ? $item->average_by_penyelia : $item->average_by_sistem;
                                        else if ($item->posisi == 'PBO')
                                            $avgResult = $item->average_by_pbo ? $item->average_by_pbo : $item->average_by_penyelia;
                                        else if ($item->posisi == 'PBP')
                                            $avgResult = $item->average_by_pbp ? $item->average_by_pbp : $item->average_by_pbo;
                                        else if ($item->posisi == 'Pincab') {
                                            if (!$item->average_by_penyelia && !$item->average_by_pbo && $item->average_by_pbp)
                                                $avgResult = $item->average_by_pbp;
                                            else if (!$item->average_by_penyelia && $item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_pbo;
                                            else if ($item->average_by_penyelia && !$item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_penyelia;
                                        }
                                        else if ($item->posisi == 'Ditolak') {
                                            if (!$item->average_by_penyelia && !$item->average_by_pbo && $item->average_by_pbp)
                                                $avgResult = $item->average_by_pbp;
                                            else if (!$item->average_by_penyelia && $item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_pbo;
                                            else if ($item->average_by_penyelia && !$item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_penyelia;
                                        }
                                        else if ($item->posisi == 'Selesai') {
                                            if (!$item->average_by_penyelia && !$item->average_by_pbo && $item->average_by_pbp)
                                                $avgResult = $item->average_by_pbp;
                                            else if (!$item->average_by_penyelia && $item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_pbo;
                                            else if ($item->average_by_penyelia && !$item->average_by_pbo && !$item->average_by_pbp)
                                                $avgResult = $item->average_by_penyelia;
                                        }

                                        if ($avgResult > 0 && $avgResult <= 2) {
                                            $status = "merah";
                                        } elseif ($avgResult > 2 && $avgResult <= 3) {
                                            $status = "kuning";
                                        } elseif ($avgResult > 3) {
                                            $status = "hijau";
                                        } else {
                                            $status = "merah";
                                        }
                                    @endphp
                                    @if ($status == 'hijau')
                                        <font class="text-success">
                                            {{ $avgResult }}
                                        </font>
                                    @elseif ($status == 'kuning')
                                        <font class="text-warning">
                                            {{ $avgResult }}
                                        </font>
                                    @elseif ($status == 'merah')
                                        <font class="text-danger">
                                            {{ $avgResult }}
                                        </font>
                                    @else
                                        <font class="text-secondary">
                                            {{ $avgResult }}
                                        </font>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->posisi == 'Selesai')
                                        <font class="text-success">Disetujui</font>
                                    @elseif ($item->posisi == 'Ditolak')
                                        <font class="text-danger">Ditolak</font>
                                    @else
                                        <font class="text-warning">On Progress</font>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if ($item->posisi == 'Pincab')
                                            <div class="btn-gtoup">
                                                <button type="button" data-toggle="dropdown" class="btn btn-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16"
                                                        style="color: black">
                                                        <path
                                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (Auth::user()->role == 'Pincab')
                                                        <a href="{{ route('pengajuan.check.pincab.status.detail', $item->id_pengajuan) }}"
                                                            class="dropdown-item">Review</a>
                                                        @if ($item->id_pbp != null)
                                                            <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                                data-target="#modalKembalikan-{{ $item->id }}" data-backto="PBP"
                                                                id="btnKembalikan">Kembalikan ke PBP</a>
                                                        @elseif ($item->id_pbp == null && $item->id_pbo != null)
                                                            <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                                data-target="#modalKembalikan-{{ $item->id }}" data-backto="PBO"
                                                                id="btnKembalikan">Kembalikan ke PBO</a>
                                                        @else
                                                            <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                                data-target="#modalKembalikan-{{ $item->id }}" data-backto="Penyelia"
                                                                id="btnKembalikan">Kembalikan ke Penyelia</a>
                                                        @endif
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-id="{{ $item->id_pengajuan }}"
                                                            data-target="#exampleModal-{{ $item->id_pengajuan }}">Disetujui /
                                                            Ditolak</a>
                                                    @endif
                                                    <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                        class="dropdown-item">Cetak
                                                    </a>
                                                    @if (Auth::user()->role == 'Administrator')
                                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalLogPengajuan-{{ $item->id }}">
                                                            Log Pengajuan
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item text-danger" data-toggle="modal" data-target="#confirmHapusModal{{$item->id}}">
                                                        Hapus
                                                        </a>
                                                    @endif
                                                    @if (Auth::user()->role == 'SPI' || Auth::user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                                                        <a href="{{ route('pengajuan.check.pincab.status.detail', $item->id_pengajuan) }}"
                                                            class="dropdown-item">Review Pengajuan</a>
                                                        @if ($countAlasan > 0)
                                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRiwayatPengembalian-{{ $item->id }}">
                                                                Riwayat Pengembalian
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                        @elseif ($item->posisi == 'Selesai')
                                            <div class="btn-gtoup">
                                                <button type="button" data-toggle="dropdown" class="btn btn-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16"
                                                        style="color: black">
                                                        <path
                                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (Auth::user()->role == 'Pincab')
                                                        <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                            class="dropdown-item">Cetak</a>
                                                    @endif
                                                    @if (Auth::user()->role == 'SPI' || Auth::user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                                                        <a href="{{ route('pengajuan.check.pincab.status.detail', $item->id_pengajuan) }}"
                                                            class="dropdown-item">Review Pengajuan</a>
                                                        @if ($countAlasan > 0)
                                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRiwayatPengembalian-{{ $item->id }}">
                                                                Riwayat Pengembalian
                                                            </a>
                                                        @endif
                                                    @endif

                                                    @if (Auth::user()->role == 'Administrator')
                                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalLogPengajuan-{{ $item->id }}">
                                                            Log Pengajuan
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item text-danger" data-toggle="modal" data-target="#confirmHapusModal{{$item->id}}">
                                                        Hapus
                                                        </a>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="btn-group">
                                                <button type="button" data-toggle="dropdown" class="btn btn-link">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16"
                                                        style="color: black">
                                                        <path
                                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (Auth::user()->role == 'SPI' || Auth::user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                                                        <a href="{{ route('pengajuan.check.pincab.status.detail', $item->id_pengajuan) }}"
                                                            class="dropdown-item">Review Pengajuan</a>
                                                        @if ($countAlasan > 0)
                                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalRiwayatPengembalian-{{ $item->id }}">
                                                                Riwayat Pengembalian
                                                            </a>
                                                        @endif
                                                    @endif
                                                    <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                        class="dropdown-item">Cetak</a>
                                                    @if (Auth::user()->role == 'Administrator')
                                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modalLogPengajuan-{{ $item->id }}">
                                                            Log Pengajuan
                                                        </a>
                                                        <a href="javascript:void(0)" class="dropdown-item text-danger" data-toggle="modal" data-target="#confirmHapusModal{{$item->id}}">
                                                        Hapus
                                                        </a>
                                                    @endif
                                                </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>


                            {{-- modal hapus --}}
                            <div class="modal fade" id="confirmHapusModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Hapus Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda Yakin Ingin Menghapus Pengajuan Kredits, Atas Nama <b>{{$item->nama}}</b>?</p>
                                            <p>Note! Data Yang Dihapus Akan Di Pindah Ke Sampah.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('delete-pengajuan-kredit', $item->id) }}" id="deleteForm" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                <input type="hidden" name="idPengajuan" value="{{$item->id}}">
                                                <button type="submit" id="btn-hapus" class="btn btn-danger hapus">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                    {{ $data_pengajuan->links() }}
                    Menampilkan
                    {{ $data_pengajuan->firstItem() }}
                    -
                    {{ $data_pengajuan->lastItem() }}
                    dari
                    {{ $data_pengajuan->total() }} Data
                    <div class="pull-right">
                    </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->role == 'Administrator')
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <br>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover table-custom">
                    <thead>
                        <tr class="table-primary">
                            <th class="text-center">#</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Nasabah</th>
                            <th>Cabang</th>
                            <th class="text-center">Posisi</th>
                            <th>Status</th>
                            <th>Tanggal Hapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sampah_pengajuan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->nama }}</td>
                                @if (auth()->user()->role == 'Administrator')
                                    @php
                                        $c = \App\Models\Cabang::where('id', $item->id_cabang)->first();
                                    @endphp
                                    <td>{{ $c->cabang }}</td>
                                @endif
                                <td class="text-center text-sm">
                                    @if ($item->posisi == 'Proses Input Data')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_staf)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Staf%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Staff</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'Review Penyelia')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_penyelia)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Penyelia%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Penyelia</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'PBO')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pbo)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'PBO%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>PBO</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'PBP')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pbp)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'PBP%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>PBP</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @elseif ($item->posisi == 'Pincab')
                                        @php
                                            $nama_pemroses = 'undifined';
                                            $user = \App\Models\User::select('nip')->where('id', $item->id_pincab)->first();
                                            if ($user)
                                                $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($user->nip);
                                            else {
                                                $check_log = \DB::table('log_pengajuan')
                                                                ->select('nip')
                                                                ->where('id_pengajuan', $item->id)
                                                                ->where('activity', 'LIKE', 'Pincab%')
                                                                ->orderBy('id', 'DESC')
                                                                ->first();
                                                if ($check_log)
                                                    $nama_pemroses = \App\Http\Controllers\PengajuanKreditController::getKaryawanFromAPIStatic($check_log->nip);
                                            }
                                        @endphp
                                        <span>Pincab</span>
                                        <br>
                                        <span class="text-color-soft">({{$nama_pemroses}})</span>
                                    @else
                                        <span>Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->posisi == 'Selesai')
                                        <font class="text-success">Disetujui</font>
                                    @elseif ($item->posisi == 'Ditolak')
                                        <font class="text-danger">Ditolak</font>
                                    @else
                                        <font class="text-warning">On Progress</font>
                                    @endif
                                </td>
                                <td>
                                    {{$item->deleted_at}}
                                </td>
                                <td>
                                    <div class="d-flex">
                                       <a href="javascript:void(0)" class="btn btn-warning" style="text-decoration: none;" data-toggle="modal" data-target="#confirmModal{{$item->id}}">
                                            Kembalikan
                                       </a>
                                    </div>
                                </td>
                            </tr>

                            {{-- modal restore --}}
                            <div class="modal fade" id="confirmModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p> Apakah Anda yakin ingin mengembalikan data pengajuan atas nama <b>{{$item->nama}}</b>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ route('restore-pengajuan-kredit') }}" id="restoreForm" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="idPengajuan" value="{{$item->id}}">
                                                <button type="submit" id="btn-restore" class="btn btn-danger restore">Kembalikan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                    {{ $sampah_pengajuan->links() }}
                    Menampilkan
                    {{ $sampah_pengajuan->firstItem() }}
                    -
                    {{ $sampah_pengajuan->lastItem() }}
                    dari
                    {{ $sampah_pengajuan->total() }} Data
                    <div class="pull-right">
                    </div>
            </div>
        </div>
    </div>
    @endif
    </div>

    <style>
    .delete-link {
        cursor: pointer;
        color: red;
    }
    </style>



    {{-- modal loading post --}}
    <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-body text-center">
            <img src="https://media.tenor.com/lUIQnRFbpscAAAAi/loading.gif" alt="Loading GIF">
        </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".hapus").on('click', function(e) {
                $("#loadingModal").modal({
                    keyboard: false
                });
                $("#loadingModal").modal("show");
            });

            $(".restore").on('click', function(e) {
                $("#loadingModal").modal({
                    keyboard: false
                });
                $("#loadingModal").modal("show");
            });
        });
        $('.btn-kembalikan').on('click', function (e) {
            const data_target = $(this).data('target')
            const data_backto = $(this).data('backto')

            $(`${data_target} .modal-title`).html(`Kembalikan ke ${data_backto}`)
        })
    </script>

    @include('pengajuan-kredit.modal-filter')
    @include('layouts.modal')
    @include('layouts.popup-upload-sppk')
    @include('layouts.popup-upload-po')
    @include('layouts.popup-upload-pk')
    @include('layouts.modal-kembalikan')
    @include('pengajuan-kredit.modal.modal-log-pengajuan')
    @include('pengajuan-kredit.modal.modal-riwayat')


@endsection
