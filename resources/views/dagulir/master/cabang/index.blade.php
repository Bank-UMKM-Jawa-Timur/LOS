@include('dagulir.master.cabang.modal.create')
@include('dagulir.master.cabang.modal.delete')
@include('dagulir.master.cabang.modal.edit')
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
        $('#page_length').on('change', function() {
            $('#form').submit()
        })
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Cabang
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Cabang
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
                                <input type="search" placeholder="Cari... " name="q" id="q"
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
                                <th>Kode Cabang</th>
                                <th>Kantor Cabang</th>
                                <th>Email</th>
                                <th>Alamat</th>
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
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->kode_cabang }}</td>
                                        <td>{{ $item->cabang }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td class="m-2">
                                            <a href="javascript:void(0)" class="btn-edit show-edit-cabang" data-id="{{ $item->id }}"
                                                data-kode_cabang="{{$item->kode_cabang}}" data-cabang="{{$item->cabang}}"
                                                data-email="{{$item->email}}" data-alamat="{{$item->alamat}}"
                                                data-target="modal-edit-cabang"
                                                >
                                                <iconify-icon icon="uil:edit" class="icon"></iconify-icon>
                                            </a>
                                            <a href="javascript:void(0)" class="btn-delete show-hapus-cabang"
                                                data-target="modalhapuscabang" data-id="{{ $item->id }}">
                                                <iconify-icon class="icon" icon="ic:baseline-delete"></iconify-icon>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-table p-2">
                        <div class="flex justify-between pb-3">
                            <div class="mt-5 ml-5 text-sm font-medium text-gray-500">
                                <p>Showing {{ $start }} - {{ $end }} from {{ $data->total() }} entries
                                </p>
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
    <script>
        function generateCsrfToken() {
            return '{{ csrf_token() }}';
        }

        $('.show-edit-cabang').off('click').on('click', function() {
            const target = $(this).data('target')
            const id_cabang = $(this).data('id')
            console.log('id_cabang:', id_cabang);
            const kode_cabang = $(this).data('kode_cabang')
            const cabang = $(this).data('cabang')
            const email = $(this).data('email')
            const alamat = $(this).data('alamat')

            $(`#${target} #kode_cabang`).val(kode_cabang)
            $(`#${target} #cabang`).val(cabang)
            $(`#${target} #email`).val(email)
            $(`#${target} #alamat`).val(alamat)
            $(`#${target} #id`).val(id_cabang)
            $(`#${target}`).removeClass('hidden');
        })
        $('.show-hapus-cabang').off('click').on('click', function() {
            const target = $(this).data('target')
            $(`#${target}`).removeClass('hidden');
            var cabangId = $(this).data('id');
            var url = '{{ url('') }}'
            var deleteUrl = url + '/dagulir/master/cabang/' + cabangId;

            $('#form-delete-cabang').attr('action', deleteUrl);
            $('#form-delete-cabang').attr('method', 'POST'); // Diubah ke POST untuk Laravel
        })



    </script>
@endpush
