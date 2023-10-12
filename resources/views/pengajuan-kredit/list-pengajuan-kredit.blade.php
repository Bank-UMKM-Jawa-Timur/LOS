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
        </style>
    @endpush
    @include('components.notification')
    <div class="row d-flex justify-content-end">
        @if (Request()->query() == null)
            <div class="col-sm-4 d-inline-flex">
            @else
                <div class="col-sm-5 d-inline-flex">
        @endif
        <form action="" class="d-inline-flex">
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
            <button type="button" class="btn btn-sm btn-primary mb-2 ml-2" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-filter"></i> Filter
            </button>
            @if (Request()->query() != null)
                <a href="{{ url()->current() }}" class="btn btn-warning mb-2 ml-2"><i class="fa fa-undolar"></i> Reset
                    Filter</a>
            @endif
        </form>
    </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr class="table-primary">
                    <th class="text-center">#</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Nasabah</th>
                    <th class="text-center">Posisi</th>
                    <th>Durasi</th>
                    <th>Skor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data_pengajuan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->nama }}</td>
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
                            @if ($item->posisi == 'Proses Input Data')
                                @php
                                    $rentangStaff = \App\Models\PengajuanModel::find($item->id);
                                    $awal = date_create(date(now()));
                                    $akhir = date_create($rentangStaff->tanggal);
                                    $interval = $awal->diff($akhir);
                                    $result_rentang = $interval->format('%a');
                                @endphp
                                {{-- {{ $rentangPenyelia }} --}}
                                {{-- {{ $result_rentang.' hari' }} --}}
                                @if ($result_rentang != 0)
                                    @if ($result_rentang == 1 || $result_rentang == 2 || $result_rentang == 3)
                                        <font class="text-success">{{ $result_rentang . ' hari' }}</font>
                                    @elseif ($result_rentang == 4 || $result_rentang == 5 || $result_rentang == 6)
                                        <font class="text-warning">{{ $result_rentang . ' hari' }}</font>
                                    @else
                                        <font class="text-danger">{{ $result_rentang . ' hari' }}</font>
                                    @endif
                                @else
                                    {{ '-' }}
                                @endif
                            @elseif ($item->posisi == 'Review Penyelia')
                                @php
                                    $rentangPenyelia = \App\Models\PengajuanModel::find($item->id);
                                    $awal = date_create(date(now()));
                                    $akhir = date_create($rentangPenyelia->tanggal_review_penyelia);
                                    $interval = $awal->diff($akhir);
                                    $result_rentang = $interval->format('%a');
                                @endphp
                                @if ($item->tanggal_review_penyelia != null)
                                    @if ($result_rentang != 0)
                                        @if ($result_rentang == 1 || $result_rentang == 2 || $result_rentang == 3)
                                            <font class="text-success">{{ $result_rentang . ' hari' }}</font>
                                        @elseif ($result_rentang == 4 || $result_rentang == 5 || $result_rentang == 6)
                                            <font class="text-warning">{{ $result_rentang . ' hari' }}</font>
                                        @else
                                            <font class="text-danger">{{ $result_rentang . ' hari' }}</font>
                                        @endif
                                    @else
                                        {{ '-' }}
                                    @endif
                                @endif
                            @elseif ($item->posisi == 'PBP')
                                @php
                                    $rentangpbp = \App\Models\PengajuanModel::find($item->id);
                                    $awal = date_create(date(now()));
                                    $akhir = date_create($rentangpbp->tanggal_review_pbp);
                                    $interval = $awal->diff($akhir);
                                    $result_rentang = $interval->format('%a');
                                @endphp
                                @if ($item->tanggal_review_pbp != null)
                                    @if ($result_rentang != 0)
                                        @if ($result_rentang == 1 || $result_rentang == 2 || $result_rentang == 3)
                                            <font class="text-success">{{ $result_rentang . ' hari' }}</font>
                                        @elseif ($result_rentang == 4 || $result_rentang == 5 || $result_rentang == 6)
                                            <font class="text-warning">{{ $result_rentang . ' hari' }}</font>
                                        @else
                                            <font class="text-danger">{{ $result_rentang . ' hari' }}</font>
                                        @endif
                                    @else
                                        {{ '-' }}
                                    @endif
                                @endif
                            @else
                                @php
                                    $rentangPincab = \App\Models\PengajuanModel::find($item->id);
                                    $awal = date_create(date(now()));
                                    $akhir = date_create($rentangPincab->tanggal_review_pincab);
                                    $interval = $awal->diff($akhir);
                                    $result_rentang_pincab = $interval->format('%a');
                                @endphp
                                @if ($item->tanggal_review_pincab != null)
                                    @if ($result_rentang_pincab != 0)
                                        @if ($result_rentang_pincab == 1 || $result_rentang_pincab == 2 || $result_rentang_pincab == 3)
                                            <font class="text-success">{{ $result_rentang_pincab . ' hari' }}</font>
                                        @elseif ($result_rentang_pincab == 4 || $result_rentang_pincab == 5 || $result_rentang_pincab == 6)
                                            <font class="text-warning">{{ $result_rentang_pincab . ' hari' }}</font>
                                        @else
                                            <font class="text-danger">{{ $result_rentang_pincab . ' hari' }}</font>
                                        @endif
                                    @else
                                        {{ '-' }}
                                    @endif
                                @endif
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
                                <font class="text-success">Selesai</font>
                            @elseif ($item->posisi == 'Ditolak')
                                <font class="text-success">Ditolak</font>
                            @else
                                <font class="text-warning">On Progress</font>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                @php
                                    $userPBO = \App\Models\User::select('id')
                                        ->where('id_cabang', $item->id_cabang)
                                        ->where('role', 'PBO')
                                        ->whereNotNull('nip')
                                        ->first();
                                    
                                    $userPBP = \App\Models\User::select('id')
                                        ->where('id_cabang', $item->id_cabang)
                                        ->where('role', 'PBP')
                                        ->whereNotNull('nip')
                                        ->first();
                                @endphp
                                @if ($item->posisi == 'Review Penyelia')
                                    <div class="btn-group">
                                        @if (auth()->user()->id_cabang == '1')
                                            <button type="button" data-toggle="dropdown" class="btn btn-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-three-dots-vertical"
                                                    viewBox="0 0 16 16" style="color: black">
                                                    <path
                                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('pengajuan.detailjawaban', $item->id_pengajuan) }}"
                                                    class="dropdown-item">Review</a>
                                                <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                    data-target="#modalKembalikan-{{ $item->id }}" data-backto="Staff"
                                                    id="btnKembalikan">Kembalikan Ke Staff</a>
                                                @if ($userPBO)
                                                    <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pbo"
                                                        class="dropdown-item">Lanjutkan Ke PBO</a>
                                                @else
                                                    @if ($userPBP)
                                                        <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pbp"
                                                            class="dropdown-item">Lanjutkan Ke PBP</a>
                                                    @else
                                                        <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pincab"
                                                            class="dropdown-item">Lanjutkan Ke Pincab</a>
                                                    @endif
                                                @endif
                                                <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                    class="dropdown-item">Cetak</a>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-link" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-three-dots-vertical"
                                                    viewBox="0 0 16 16" style="color: black">
                                                    <path
                                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('pengajuan.detailjawaban', $item->id_pengajuan) }}"
                                                    class="dropdown-item">Review</a>
                                                <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                    data-target="#modalKembalikan-{{ $item->id }}" data-backto="Staff"
                                                    id="btnKembalikan">Kembalikan Ke Staff</a>
                                                @if ($userPBO)
                                                    <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pbo"
                                                        class="dropdown-item">Lanjutkan Ke PBO</a>
                                                @else
                                                    <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pincab"
                                                        class="dropdown-item">Lanjutkan Ke Pincab</a>
                                                @endif
                                                <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                    class="dropdown-item">Cetak</a>
                                            </div>
                                        @endif
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
                                            <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                class="dropdown-item">Cetak</a>
                                            @if ($item->posisi == "PBP")
                                                @if ($item->id_pbo != null)
                                                    <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                        data-target="#modalKembalikan-{{ $item->id }}" data-backto="PBO"
                                                        id="btnKembalikan">Kembalikan Ke PBO</a>
                                                @else
                                                    <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                        data-target="#modalKembalikan-{{ $item->id }}" data-backto="Penyelia"
                                                        id="btnKembalikan">Kembalikan Ke Penyelia</a>
                                                @endif
                                            @elseif ($item->posisi == "PBO")
                                                <a href="#" class="dropdown-item btn-kembalikan" data-toggle="modal"
                                                    data-target="#modalKembalikan-{{ $item->id }}" data-backto="Penyelia"
                                                    id="btnKembalikan">Kembalikan Ke Penyelia</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    @empty
                        <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data
                            Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $data_pengajuan->links() }}
            Menampilkan
            {{ $data_pengajuan->firstItem() }}
            -
            {{ $data_pengajuan->lastItem() }}
            dari
            {{ $data_pengajuan->total() }} Data
        </div>
        <div class="pull-right">
        </div>
    </div>
@endsection
@include('pengajuan-kredit.modal-filter')
@include('layouts.popup-upload-sppk')
@include('layouts.popup-upload-po')
@include('layouts.popup-upload-pk')
@include('layouts.modal-kembalikan')

@push('custom-script')
    <script>
        $('.btn-kembalikan').on('click', function (e) {
            const data_target = $(this).data('target')
            const data_backto = $(this).data('backto')
            
            $(`${data_target} .modal-title`).html(`Kembalikan ke ${data_backto}`)
        })
    </script>
@endpush
