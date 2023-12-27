@extends('layouts.tailwind-template')

@section('modal')
    @include('pengajuan-kredit.modal.new-modal-filter')
@endsection

@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head space-y-5 w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Analisa Kredit
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Analisa Kredit
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5">
                <div class="left-button gap-2 flex lg:justify-end">
                    @if (Request()->query() != null)
                    <a href="{{ url()->current() }}"
                        class="px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                        <span class="mt-1 mr-3">
                            <iconify-icon icon="pajamas:repeat"></iconify-icon>
                        </span>
                        <span class="ml-1 text-sm"> Reset </span>
                    </a>
                    @endif
                        <a  data-modal-id="modal-filter" href="#"
                            class="open-modal px-7 py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary">
                            <span class="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lg:w-[24px] w-[19px]" viewBox="-2 -2 24 24">
                                    <path fill="currentColor"
                                        d="m2.08 2l6.482 8.101A2 2 0 0 1 9 11.351V18l2-1.5v-5.15a2 2 0 0 1 .438-1.249L17.92 2H2.081zm0-2h15.84a2 2 0 0 1 1.561 3.25L13 11.35v5.15a2 2 0 0 1-.8 1.6l-2 1.5A2 2 0 0 1 7 18v-6.65L.519 3.25A2 2 0 0 1 2.08 0z" />
                                </svg>
                            </span>
                            <span class="ml-3 text-sm"> Filter </span>
                        </a>

                </div>

            </div>
        </div>
        <div class="body-pages">
            <div class="table-wrapper border bg-white mt-3">
                <div class="layout-wrapping p-3 lg:flex grid grid-cols-1 justify-center lg:justify-between">
                    <div class="left-layout lg:w-auto w-full lg:block flex justify-center">
                        <div class="flex gap-5 p-2">
                            <span class="mt-[10px] text-sm">Show</span>
                            <select name=""
                                class="border border-gray-300 rounded appearance-none text-center px-4 py-2 outline-none"
                                id="">
                                <option value="">10</option>
                                <option value="">15</option>
                                <option value="">20</option>
                            </select>
                            <span class="mt-[10px] text-sm">Entries</span>
                        </div>
                    </div>
                    <div class="right-layout lg:w-auto w-full">
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
                        <div class="input-search flex gap-2">
                            <input type="search"  value="{{ Request()->query('search') }}"  placeholder="Cari nama nasabah... "
                                class="w-full px-8 outline-none text-sm p-3 border" />
                            <button class="px-5 py-2 bg-theme-primary rounded text-white text-lg">
                                <iconify-icon icon="ic:sharp-search" class="mt-2 text-lg"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="tables">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nama Nasabah</th>
                                <th>Posisi</th>
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
                                {{-- modal hapus
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
                                </div> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="footer-table p-4">
                    <div class="flex justify-between">
                        <div class="mt-3 mr-5 text-sm font-medium text-gray-500">
                            <p>
                                {{ $data_pengajuan->links() }}
                                Menampilkan
                                {{ $data_pengajuan->firstItem() }}
                                -
                                {{ $data_pengajuan->lastItem() }}
                                dari
                                {{ $data_pengajuan->total() }}
                                Data
                            </p>
                        </div>
                        {{ $data_pengajuan->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@include('pengajuan-kredit.modal.modal-kembalikan')
