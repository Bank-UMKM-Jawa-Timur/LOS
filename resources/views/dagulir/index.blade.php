@extends('layouts.tailwind-template')

@section('modal')

@include('dagulir.modal.filter')

@include('dagulir.pengajuan-kredit.modal.pilih-penyelia')
@include('dagulir.modal.konfirmSendToPinca')
@include('dagulir.modal.cetak-file-sppk')
@include('dagulir.modal.cetak-file-pk')
@include('dagulir.modal.approval')
@include('dagulir.modal.approvalSipde')
@endsection

@push('script-inject')
<script>
    $('#page_length').on('change', function() {
        $('#form').submit()
    })
</script>
@endpush

@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Dagulir
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Dagulir
            </h2>
        </div>
        <div class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5">
            <div class="left-button gap-2 flex lg:justify-end">
                @if (Request()->query() != null)
                    <a href="{{ route('dagulir.pengajuan.index') }}"
                        class="px-7 py-2 cursor-pointer  rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                        <span class="mt-1 mr-3">
                            <iconify-icon icon="pajamas:repeat"></iconify-icon>
                        </span>
                        <span class="ml-1 text-sm"> Reset </span>
                    </a>
                @endif
                <a data-modal-id="modal-filter"
                    class="open-modal px-7 cursor-pointer py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="lg:w-[24px] w-[19px]" viewBox="-2 -2 24 24">
                            <path fill="currentColor"
                                d="m2.08 2l6.482 8.101A2 2 0 0 1 9 11.351V18l2-1.5v-5.15a2 2 0 0 1 .438-1.249L17.92 2H2.081zm0-2h15.84a2 2 0 0 1 1.561 3.25L13 11.35v5.15a2 2 0 0 1-.8 1.6l-2 1.5A2 2 0 0 1 7 18v-6.65L.519 3.25A2 2 0 0 1 2.08 0z" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Filter </span>
                </a>
            </div>
            @if (Auth()->user()->role == 'Staf Analis Kredit')
            <div class="right-button gap-2 flex lg:justify-start">
                <a href="{{ route('dagulir.pengajuan.create') }}"
                    class="px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                    <span class="mt-1 mr-3">
                        <iconify-icon icon="fa6-solid:plus"></iconify-icon>
                    </span>
                    <span class="ml-1 text-sm"> Tambah pengajuan </span>
                </a>
            </div>
            @endif
        </div>
    </div>
    <div class="body-pages">
        <div class="table-wrapper border bg-white mt-3">
            <form id="form" method="get">
                <div class="layout-wrapping p-3 lg:flex grid grid-cols-1 justify-center lg:justify-between">
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
                    <div class="left-layout lg:w-auto w-full lg:block flex justify-center">
                        <div class="flex gap-5 p-2">
                            <span class="mt-[10px] text-sm">Show</span>
                            <select name="page_length"
                                class="border border-gray-300 rounded appearance-none text-center px-4 py-2 outline-none"
                                id="page_length">
                                <option value="10" @isset($_GET['page_length']) {{ $_GET['page_length']==10 ? 'selected'
                                    : '' }} @endisset>
                                    1</option>
                                <option value="20" @isset($_GET['page_length']) {{ $_GET['page_length']==20 ? 'selected'
                                    : '' }} @endisset>
                                    20</option>
                                <option value="50" @isset($_GET['page_length']) {{ $_GET['page_length']==50 ? 'selected'
                                    : '' }} @endisset>
                                    50</option>
                                <option value="100" @isset($_GET['page_length']) {{ $_GET['page_length']==100
                                    ? 'selected' : '' }} @endisset>
                                    100</option>
                            </select>
                            <span class="mt-[10px] text-sm">Entries</span>
                        </div>
                    </div>
                    <div class="right-layout lg:w-auto w-full">
                        <div class="input-search flex gap-2">
                            <input type="search" placeholder="Cari kata kunci... " name="q" id="q"
                                class="w-full px-8 outline-none text-sm p-3 border"
                                value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}" />
                            <button class="px-5 py-2 bg-theme-primary rounded text-white text-lg">
                                <iconify-icon icon="ic:sharp-search" class="mt-2 text-lg"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pl-5 pr-5">
                    <table class="tables">
                        <thead>
                            <tr>
                                <th class="w-5">No.</th>
                                <th>Kode SIPDE</th>
                                <th>Nama</th>
                                <th class="w-10">Tanggal Pengajuan</th>
                                <th class="w-13">Jenis Usaha</th>
                                <th class="w-11">Tipe Pengajuan</th>
                                <th>Plafon</th>
                                <th class="w-13">Tenor</th>
                                <th class="w-13">Skor</th>
                                <th class="w-13">Status Pincetar</th>
                                <th class="w-7">Status SIPDE</th>
                                <th class="w-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $page_length = isset($_GET['page_length']) ? $_GET['page_length'] : 10;
                            $start = $page == 1 ? 1 : $page * $page_length - $page_length + 1;
                            $end = $page == 1 ? $page_length : $start + $page_length - 1;
                            $i = $page == 1 ? 1 : $start;
                            $status = config('dagulir.status');
                            $jenis_usaha = config('dagulir.jenis_usaha');
                            $tipe_pengajuan = config('dagulir.tipe_pengajuan');
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->kode_pendaftaran != null ? $item->kode_pendaftaran : '-' }}</td>
                                <td class="font-semibold uppercase">{{ ucwords($item->nama) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d-m-Y') }}</td>
                                <td>
                                    @if ($item->jenis_usaha)
                                    {{array_key_exists(intval($item->jenis_usaha), $jenis_usaha) ?
                                    $jenis_usaha[intval($item->jenis_usaha)] : 'Tidak ditemukan'}}
                                    @else
                                    Tidak ada
                                    @endif
                                </td>
                                <td>
                                    @if ($item->tipe)
                                    {{array_key_exists(intval($item->tipe), $tipe_pengajuan) ?
                                    $tipe_pengajuan[intval($item->tipe)] : 'Tidak ditemukan'}}
                                    @else
                                    Tidak ada
                                    @endif
                                </td>
                                <td>
                                    {{ number_format($item->nominal,0,',','.') }}
                                </td>
                                <td>
                                    {{$item->jangka_waktu}} Bulan
                                </td>
                                <td>
                                    @php
                                    $avgResult = $item->pengajuan->average_by_sistem;
                                    if ($item->pengajuan->posisi == 'Review Penyelia')
                                    $avgResult = $item->pengajuan->average_by_penyelia ?
                                    $item->pengajuan->average_by_penyelia : $item->pengajuan->average_by_sistem;
                                    else if ($item->pengajuan->posisi == 'PBO')
                                    $avgResult = $item->pengajuan->average_by_pbo ? $item->pengajuan->average_by_pbo :
                                    $item->pengajuan->average_by_penyelia;
                                    else if ($item->pengajuan->posisi == 'PBP')
                                    $avgResult = $item->pengajuan->average_by_pbp ? $item->pengajuan->average_by_pbp :
                                    $item->pengajuan->average_by_pbo;
                                    else if ($item->pengajuan->posisi == 'Pincab') {
                                    if (!$item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo &&
                                    $item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbp;
                                    else if (!$item->pengajuan->average_by_penyelia && $item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbo;
                                    else if ($item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_penyelia;
                                    }
                                    else if ($item->pengajuan->posisi == 'Ditolak') {
                                    if (!$item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo &&
                                    $item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbp;
                                    else if (!$item->pengajuan->average_by_penyelia && $item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbo;
                                    else if ($item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_penyelia;
                                    }
                                    else if ($item->pengajuan->posisi == 'Selesai') {
                                    if (!$item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo &&
                                    $item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbp;
                                    else if (!$item->pengajuan->average_by_penyelia && $item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_pbo;
                                    else if ($item->pengajuan->average_by_penyelia && !$item->pengajuan->average_by_pbo
                                    && !$item->pengajuan->average_by_pbp)
                                    $avgResult = $item->pengajuan->average_by_penyelia;
                                    }
                                    $status_skor = "";
                                    if ($avgResult > 0 && $avgResult <= 2) { $status_skor="merah" ; } elseif
                                        ($avgResult> 2 && $avgResult <= 3) { $status_skor="kuning" ; } elseif
                                            ($avgResult> 3) {
                                            $status_skor = "hijau";
                                            } else {
                                            $status_skor = "merah";
                                            }
                                            @endphp
                                            @if ($status_skor == 'hijau')
                                            <font class="text-green-500">
                                                {{ $avgResult }}
                                            </font>
                                            @elseif ($status_skor == 'kuning')
                                            <font class="text-yellow-500">
                                                {{ $avgResult }}
                                            </font>
                                            @elseif ($status_skor == 'merah')
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
                                    {{$item->pengajuan->posisi}}
                                    @if ($item->pengajuan->posisi != 'Selesai' || $item->pengajuan->posisi != 'Ditolak')
                                    <p class="text-red-500">{{ $item->nama_pemroses }}</p>
                                    @endif
                                </td>
                                <td>
                                    {{ array_key_exists(intval($item->status), $status) ? $status[intval($item->status)]
                                    : 'Tidak ditemukan' }}
                                </td>
                                <td>
                                    <div class="flex">
                                        <div class="dropdown-tb">
                                            <button type="button"
                                                class="dropdown-tb-toggle border rounded px-4 py-2 hover:bg-gray-100 hover:text-gray-500">
                                                <iconify-icon icon="ph:dots-three-outline-vertical-fill" class="mt-2">
                                                </iconify-icon>
                                            </button>
                                            <ul class="dropdown-tb-menu hidden">
                                                @if (Auth::user()->role == 'Staf Analis Kredit' &&
                                                $item->pengajuan->posisi == 'Proses Input Data')
                                                <li class="item-tb-dropdown">
                                                    <a href="#"
                                                        onclick="showTindakLanjut({{ $item->pengajuan->id }},'penyelia kredit')"
                                                        class="cursor-pointer">Tindak lanjut Review Penyelia</a>
                                                </li>
                                                @endif
                                                @if (Auth::user()->role == 'Staf Analis Kredit' &&
                                                $item->pengajuan->posisi == 'Selesai')
                                                @php
                                                $tglCetak = DB::table('log_cetak_kkb')
                                                ->where('id_pengajuan', $item->pengajuan->id)
                                                ->first();
                                                @endphp

                                                @if ($tglCetak == null || !$tglCetak->tgl_cetak_sppk)
                                                <li class="item-tb-dropdown">
                                                    <a target="_blank"
                                                        href="{{ route('dagulir.cetak-sppk-dagulir', $item->pengajuan->id) }}"
                                                        class="dropdown-item">Cetak SPPK</a>
                                                </li>
                                                @elseif (!$item->pengajuan->sppk && $tglCetak->tgl_cetak_sppk)
                                                <li class="item-tb-dropdown">
                                                    <a href="#" class="dropdown-item show-upload-sppk"
                                                        data-toggle="modal" data-target="uploadSPPKModal"
                                                        data-id="{{ $item->pengajuan->id }}"
                                                        data-kode_pendaftaran="{{$item->kode_pendaftaran}}">Upload File
                                                        SPPK</a>
                                                </li>
                                                @elseif (!$tglCetak->tgl_cetak_pk && $item->pengajuan->sppk &&
                                                $tglCetak->tgl_cetak_sppk )
                                                <li class="item-tb-dropdown">
                                                    <a target="_blank"
                                                        href="{{ route('dagulir.cetak-pk-dagulir', $item->pengajuan->id) }}"
                                                        class="dropdown-item">Cetak PK</a>
                                                </li>
                                                @elseif (!$item->pengajuan->pk && $tglCetak->tgl_cetak_pk &&
                                                $item->pengajuan->sppk)
                                                <li class="item-tb-dropdown">
                                                    <a href="#" class="dropdown-item show-upload-pk" data-toggle="modal"
                                                        data-target="uploadPKModal" data-id="{{ $item->pengajuan->id }}"
                                                        data-kode_pendaftaran="{{$item->kode_pendaftaran}}">Upload File
                                                        PK</a>
                                                </li>
                                                @endif
                                                @endif
                                                @if ((Auth()->user()->role == 'Penyelia Kredit'))
                                                @if ($item->pengajuan->posisi == 'Review Penyelia')
                                                <li class="item-tb-dropdown">
                                                    <a href="{{ route('dagulir.detailjawaban', $item->pengajuan->id) }}"
                                                        class="cursor-pointer">Review</a>
                                                </li>
                                                @endif
                                                @if ($item->pengajuan->posisi == 'Review Penyelia' &&
                                                $item->pengajuan->tanggal_review_penyelia)
                                                <li class="item-tb-dropdown">
                                                    <a href="javascript:void(0)" id="modalConfirmPincab"
                                                        data-id_pengajuan="{{$item->pengajuan->id}}"
                                                        data-nama="{{$item->nama}}"
                                                        class="cursor-pointer item-dropdown">Lanjutkan Ke Pincab</a>
                                                </li>
                                                @endif
                                                @elseif ((Auth()->user()->role == 'PBO'))
                                                @if ($item->pengajuan->posisi == 'PBO' &&
                                                $item->pengajuan->tanggal_review_penyelia
                                                && $item->pengajuan->id_pbo)
                                                <li class="item-tb-dropdown">
                                                    <a href="{{ route('dagulir.detailjawaban', $item->pengajuan->id) }}"
                                                        class="cursor-pointer">Review</a>
                                                </li>
                                                @endif
                                                @if ($item->pengajuan->posisi == 'PBO' &&
                                                $item->pengajuan->tanggal_review_pbo
                                                && $item->pengajuan->id_pbo)
                                                <li class="item-tb-dropdown">
                                                    <a href="javascript:void(0)" id="modalConfirmPincab"
                                                        data-id_pengajuan="{{$item->pengajuan->id}}"
                                                        data-nama="{{$item->nama}}"
                                                        class="cursor-pointer item-dropdown">Lanjutkan Ke Pincab</a>
                                                </li>
                                                @endif
                                                @elseif ((Auth()->user()->role == 'PBP'))
                                                @if ($item->pengajuan->posisi == 'PBP' &&
                                                $item->pengajuan->tanggal_review_pbp
                                                && $item->pengajuan->id_pbp)
                                                <li class="item-tb-dropdown">
                                                    <a href="{{ route('dagulir.detailjawaban', $item->pengajuan->id) }}"
                                                        class="cursor-pointer">Review</a>
                                                </li>
                                                @endif
                                                @if ($item->pengajuan->posisi == 'PBP' &&
                                                $item->pengajuan->tanggal_review_penyelia
                                                && ($item->pengajuan->id_pbo && $item->pengajuan->tanggal_review_pbo)
                                                && ($item->pengajuan->id_pbp && $item->pengajuan->tanggal_review_pbp))
                                                <li class="item-tb-dropdown">
                                                    <a href="javascript:void(0)" id="modalConfirmPincab"
                                                        data-id_pengajuan="{{$item->pengajuan->id}}"
                                                        data-nama="{{$item->nama}}"
                                                        class="cursor-pointer item-dropdown">Lanjutkan Ke Pincab</a>
                                                </li>
                                                @endif
                                                @elseif ((Auth()->user()->role == 'Pincab'))
                                                @if ($item->pengajuan->posisi != 'Ditolak' && $item->pengajuan->posisi
                                                != 'Selesai')
                                                @if ($item->pengajuan->id_pincab)
                                                <li class="item-tb-dropdown">
                                                    <a href="{{ route('dagulir.detailjawaban_pincab', $item->pengajuan->id) }}"
                                                        class="cursor-pointer">Review</a>
                                                </li>
                                                @endif
                                                @endif
                                                @else
                                                <li class="item-tb-dropdown">
                                                    <a href="{{ route('dagulir.cetak-surat', $item->pengajuan->id) }}"
                                                        class="cursor-pointer" target="_blank">Cetak</a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="footer-table p-2">
                    <div class="flex justify-between pb-3">
                        <div class="mt-5 ml-5 text-sm font-medium text-gray-500">
                            <p>Showing {{ $start }} - {{ $end }} from {{ $data->total() }} entries</p>
                        </div>
                        {{ $data->links('pagination::tailwind') }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('script-inject')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    if (document.getElementById('modalConfirmPincab')) {
        document.getElementById('modalConfirmPincab').addEventListener('click', function () {
            document.getElementById('confirmationModal').classList.remove('hidden');
            document.getElementById('confirmationModal').classList.add('h-full');
            var nama = $('#modalConfirmPincab').data('nama');
            var namaHtml = nama.toLowerCase();
            var idPengajuan = $('#modalConfirmPincab').data('id_pengajuan');
            console.log(idPengajuan);
            $('#nama_pengajuan').html(namaHtml);
            $('[name="id_pengajuan"]').val(idPengajuan);
        });
    }

    if (document.getElementById('cancelAction')) {
        document.getElementById('cancelAction').addEventListener('click', function () {
            document.getElementById('confirmationModal').classList.add('hidden');
            document.getElementById('confirmationModal').classList.remove('flex');
        });
    }

    $('.show-upload-sppk').on('click', function() {
        const target = $(this).data('target')
        const id = $(this).data('id')
        const url_form = "{{url('/dagulir/post-file')}}/"+id
        const url_cetak = "{{url('/dagulir/cetak-sppk')}}/"+id
        var token = generateCsrfToken()

        $(`#${target} #form-sppk`).attr('action', url_form)
        $(`#${target} #token`).val(token)
        $(`#${target} #btn-cetak-file`).attr('href', url_cetak)
        $(`#${target}`).removeClass('hidden');
    })

    $('.show-upload-pk').on('click', function() {
        const target = $(this).data('target')
        const id = $(this).data('id')
        const kode_pendaftaran = $(this).data('kode_pendaftaran')
        const url_form = "{{url('/dagulir/post-file')}}/"+id
        const url_cetak = "{{url('/dagulir/cetak-pk')}}/"+id
        var token = generateCsrfToken()

        $(`#${target} #form-pk`).attr('action', url_form)
        $(`#${target} #token`).val(token)
        $(`#${target} #btn-cetak-file`).attr('href', url_cetak)
        $(`#${target} #kode_pendaftaran`).val(kode_pendaftaran)
        $(`#${target}`).removeClass('hidden');
    })

    $('#btn-filter').on('click', function () { 
        let tAwal = document.getElementById('tAwal');
        $('#form-filter').submit()
    })

    $("#tAwal").on("change", function() {
        var result = $(this).val();
        if (result != null) {
            $("#tAkhir").prop("required", true)
        }
    });

    var token = "gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj";
    var cbgValue = '{{ Request()->query('cbg') }}';

    $(document).ready(function() {
        $("#errorAkhir").hide();

        $.ajax({
            type: "GET",
            url: "/api/v1/get-cabang", 
            headers: {
                'token': token,
            },
            success: function (response) {
                response.data.forEach(element => {
                    $('#cabang').append(
                        `<option value="${element.kode_cabang}" ${cbgValue == element.kode_cabang ? 'selected' : ''}>${element.cabang}</option>`
                    );
                });
            }
        });
    })

    $("#tAkhir").on("change", function() {
        var tAkhir = $(this).val();
        var tAwal = $("#tAwal").val();
        if (Date.parse(tAkhir) < Date.parse(tAwal)) {
            $("#tAkhir").val('');
            $("#errorAkhir").show();
        } else {
            $("#errorAkhir").hide();
        }
    })
</script>
@endpush