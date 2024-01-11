@extends('layouts.tailwind-template')

@section('modal')
    @include('pengajuan-kredit.modal.new-modal-filter')
    @include('components.new.modal.loading')
    @include('pengajuan-kredit.modal.modal-kembalikan-new')
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
                                        @if ($item->posisi == 'Selesai')
                                            <span>Disetujui</span>
                                        @else
                                            <span>Ditolak</span>
                                        @endif
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
                                                <font class="text-green-500">{{ $res . ' hari' }}</font>
                                            @elseif ($res == 4 || $res == 5 || $res == 6)
                                                <font class="text-yellow-500">{{ $res . ' hari' }}</font>
                                            @else
                                                <font class="text-red-500">{{ $res . ' hari' }}</font>
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
                                        <font class="text-green-500">
                                            {{ $avgResult }}
                                        </font>
                                    @elseif ($status == 'kuning')
                                        <font class="text-yellow-500">
                                            {{ $avgResult }}
                                        </font>
                                    @elseif ($status == 'merah')
                                        <font class="text-red-500">
                                            {{ $avgResult }}
                                        </font>
                                    @else
                                        <font class="text-neutral-800">
                                            {{ $avgResult }}
                                        </font>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->posisi == 'Selesai')
                                        <font class="text-green-500">Disetujui</font>
                                    @elseif ($item->posisi == 'Ditolak')
                                        <font class="text-red-500">Ditolak</font>
                                    @else
                                        <font class="text-yellow-500">On Progress</font>
                                    @endif
                                </td>
                                <td class="flex justify-center">
                                <div class="dropdown-tb">
                                    @php
                                    $userPBP = \App\Models\User::select('id')
                                        ->where('id_cabang', $item->id_cabang)
                                        ->where('role', 'PBP')
                                        ->whereNotNull('nip')
                                        ->first();
                                    @endphp
                                        <button
                                            class="dropdown-tb-toggle border rounded px-4 py-2 hover:bg-gray-100 hover:text-gray-500">
                                            <iconify-icon icon="ph:dots-three-outline-vertical-fill" class="mt-2">
                                            </iconify-icon>
                                        </button>
                                        <ul class="dropdown-tb-menu hidden">
                                                @if (Auth::user()->role == 'PBP' && $item->posisi == 'PBP')
                                                            <a href="{{ route('pengajuan.detailjawaban', $item->id_pengajuan) }}"
                                                                class="dropdown-item w-full cursor-pointer review-pbo-pbp">
                                                                <li class="item-tb-dropdown">
                                                                    Review
                                                                </li>
                                                            </a>
                                                        @if ($item->id_pbo != null)
                                                            <a href="#" class="w-full cursor-pointer kembalikan_pengajuan" data-id="{{ $item->id }}" data-backto="PBO" data-target="modalKembalikan">
                                                                <li class="item-tb-dropdown open-modal">
                                                                    Kembalikan ke PBO
                                                                </li>
                                                            </a>
                                                        @else
                                                            <a href="#" class="w-full cursor-pointer kembalikan_pengajuan" data-id="{{ $item->id }}" data-backto="Penyelia" data-target="modalKembalikan">
                                                                <li class="item-tb-dropdown open-modal">
                                                                    Kembalikan ke Penyelia
                                                                </li>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}"
                                                            class="dropdown-item w-full cursor-pointer">
                                                            <li class="item-tb-dropdown">
                                                                Tindak lanjut Pincab
                                                            </li>
                                                        </a>
                                                        <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                            class="dropdown-item w-full cursor-pointer">
                                                            <li class="item-tb-dropdown">
                                                                Cetak
                                                            </li>
                                                        </a>
                                                @elseif (Auth::user()->role == 'PBO' && $item->posisi == 'PBO')
                                                            <a href="{{ route('pengajuan.detailjawaban', $item->id_pengajuan) }}"
                                                                class="dropdown-item w-full cursor-pointer review-pbo-pbp">
                                                                <li class="item-tb-dropdown">
                                                                    Review
                                                                </li>
                                                            </a>
                                                            <a href="#" class="w-full cursor-pointer kembalikan_pengajuan" data-id="{{ $item->id }}" data-backto="Penyelia" data-target="modalKembalikan">
                                                                <li class="item-tb-dropdown open-modal">
                                                                    Kembalikan ke Penyelia
                                                                </li>
                                                            </a>
                                                        @if ($item->id_cabang == 1)
                                                                @if ($userPBP)
                                                                    <a class="w-full cursor-pointer review-pbo-pbp" href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pbp">
                                                                        <li class="item-tb-dropdown">
                                                                            Tindak Lanjut ke PBP
                                                                        </li>
                                                                    </a>
                                                                @else
                                                                <a class="w-full cursor-pointer review-pbo-pbp" href="{{ route('pengajuan.check.pincab', $item->id_pengajuan) }}?to=pincab">
                                                                    <li class="item-tb-dropdown">
                                                                        Tindak Lanjut ke Pincab
                                                                    </li>
                                                                </a>
                                                                @endif
                                                            @endif
                                                            <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                                class="dropdown-item">
                                                                <li class="item-tb-dropdown">
                                                                    Cetak
                                                                </li>
                                                            </a>
                                                        @else
                                                        <a target="_blank" href="{{ route('cetak', $item->id_pengajuan) }}"
                                                            class="dropdown-item w-full cursor-pointer">
                                                            <li class="item-tb-dropdown">
                                                                Cetak
                                                            </li>
                                                        </a>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                            @empty
                                <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data
                                    Kosong</td>
                                </tr>
                            @endforelse
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
@push('script-inject')
<script>
    $('.review-pbo-pbp').on('click', function(){
        $("#preload-data").removeClass("hidden");
    })
    $('.btn-kembalikan-pengajuan').on('click', function(){
        $("#modalKembalikan").addClass("hidden");
        $("#preload-data").removeClass("hidden");

    })

    $('.kembalikan_pengajuan').on('click', function(){
        const target = '#modalKembalikan';
        const id = $(this).data('id');
        const backto = $(this).data('backto')

        console.log(backto);
        $(`${target} #id_pengajuan`).val(id)
        $(`${target} #text_backto`).html(backto)
        $(`${target}`).removeClass('hidden')
    })
</script>
@endpush
