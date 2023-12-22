@include('dagulir.master-dana.cabang.modal.create')
@include('dagulir.master-dana.cabang.modal.tambah-modal')
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
<script>
    $(document).ready(function() {
        $('.show-tambah').off('click').on('click', function() {
            const target = $(this).data('target');
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $(`#${target} #nama_cabang`).val(nama);
            $(`#${target} #id`).val(id);
            $(`#${target}`).removeClass('hidden');
        })
    })
    $('#page_length').on('change', function() {
        $('#form').submit()
    })
    $('.rupiah').keyup(function(e) {
        var input = $(this).val()
        $(this).val(formatrupiah(input))
    });
    // formatrupiah();
    function formatrupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
</script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Dana Cabang
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Dana Cabang
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5">
                <div class="button-wrapper gap-2 flex lg:justify-end">
                    <button data-modal-id="modal-add-cabang"
                        class="open-modal px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                        <span class="mt-1 mr-3">
                        <iconify-icon icon="ph:plus-bold"></iconify-icon>
                        </span>
                        <span class="ml-1 text-sm"> Tambah </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="body-pages">
            <div class="table-wrapper border bg-white mt-8">
                <form id="form" method="get">
                    <div class="layout-wrapping p-3 lg:flex grid grid-cols-1 justify-center lg:justify-between">
                        <div class="left-layout lg:w-auto w-full lg:block flex justify-center">
                            <div class="flex gap-5 p-2">
                                <span class="mt-[10px] text-sm">Show</span>
                                <select name="page_length"
                                    class="border border-gray-300 rounded appearance-none text-center px-4 py-2 outline-none"
                                    id="page_length">
                                    <option value="10"
                                        @isset($_GET['page_length']) {{ $_GET['page_length'] == 10 ? 'selected' : '' }} @endisset>
                                        10</option>
                                    <option value="20"
                                        @isset($_GET['page_length']) {{ $_GET['page_length'] == 20 ? 'selected' : '' }} @endisset>
                                        20</option>
                                    <option value="50"
                                        @isset($_GET['page_length']) {{ $_GET['page_length'] == 50 ? 'selected' : '' }} @endisset>
                                        50</option>
                                    <option value="100"
                                        @isset($_GET['page_length']) {{ $_GET['page_length'] == 100 ? 'selected' : '' }} @endisset>
                                        100</option>
                                </select>
                                <span class="mt-[10px] text-sm">Entries</span>
                            </div>
                        </div>
                        <div class="right-layout lg:w-auto w-full">
                            <div class="input-search flex gap-2">
                                <input type="search" placeholder="Cari Kata Kunci... " name="q" id="q"
                                    class="w-full px-8 outline-none text-sm p-3 border"
                                    value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}" />
                                <button class="px-5 py-2 bg-theme-primary rounded text-white text-lg">
                                    <iconify-icon icon="ic:sharp-search" class="mt-2 text-lg"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="tables">
                            <thead>
                                <th class="text-center">No</th>
                                <th>Cabang</th>
                                <th>Dana Modal</th>
                                <th>Dana Idle</th>
                                <th>Plafon Akumulasi</th>
                                <th>Baki Debet</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @php
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $page_length = isset($_GET['page_length']) ? $_GET['page_length'] : 10;
                                    $start = $page == 1 ? 1 : $page * $page_length - $page_length + 1;
                                    $end = $page == 1 ? $page_length : $start + $page_length - 1;
                                    $i = $page == 1 ? 1 : $start;
                                @endphp
                                @foreach ($dana_cabang as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->cabang->cabang }}</td>
                                        <td>{{ number_format($item->dana_modal,0, ",", ".") }}</td>
                                        <td>{{ number_format($item->dana_idle,0, ",", ".") }}</td>
                                        <td>{{ number_format($item->loan_sum_plafon,0, ",", ".") }}</td>
                                        <td>{{ number_format($item->baki_debet,0, ",", ".") }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if ($status == true)
                                                <button
                                                    type="button"
                                                    class="btn bg-red-500 text-white show-tambah"
                                                    data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->cabang->cabang }}"
                                                    data-target="modal-tambah-modal"
                                                >Tambah Dana Modal</button></td>
                                            @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-table p-2">
                        <div class="flex justify-between pb-3">
                            <div class="mt-5 ml-5 text-sm font-medium text-gray-500">
                                <p>Showing {{ $start }} - {{ $end }} from {{ $dana_cabang->total() }} entries
                                </p>
                            </div>
                            {{ $dana_cabang->links('pagination::tailwind') }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
