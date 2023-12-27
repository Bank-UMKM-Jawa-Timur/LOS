@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
               Analisa Kredit
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Draft Pengajuan Kredit
            </h2>
        </div>
    </div>
    <div class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5">
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
                            <th>Tanggal Input</th>
                            <th>Nama Nasabah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $page_length = isset($_GET['page_length']) ? $_GET['page_length'] : 10;
                            $start = $page == 1 ? 1 : $page * $page_length - $page_length + 1;
                            $end = $page == 1 ? $page_length : $start + $page_length - 1;
                            $i = $page == 1 ? 1 : $start;
                        @endphp
                        @forelse ($data_pengajuan as $key => $item)
                            <tr>
                                <    <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <div class="flex justify-center">
                                        <div class="dropdown-tb">
                                            <button class="dropdown-tb-toggle border rounded px-4 py-2 hover:bg-gray-100 hover:text-gray-500">
                                                <iconify-icon icon="ph:dots-three-outline-vertical-fill" class="mt-2">
                                                </iconify-icon>
                                            </button>
                                            <ul class="dropdown-tb-menu hidden">
                                                <a href="{{ route('dagulir.temp.continue', $item->id) }}"
                                                    class="dropdown-item cursor-pointer w-full">
                                                    <li class="item-tb-dropdown">
                                                        Lanjutkan
                                                    </li>
                                                </a>
                                                <a href="javascript:void(0)" class="modalConfirmDelete cursor-pointer w-full" data-nama="{{$item->nama}}" data-modal-id="{{ $item->id }}">
                                                    <li class="item-tb-dropdown">
                                                        Hapus
                                                    </li>
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data Belum Ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="footer-table p-2">
                <div class="flex justify-between">
                    <div class="mt-5 ml-5 text-sm font-medium text-gray-500">
                    <p>Showing {{ $start }} - {{ $end }} from {{ $data_pengajuan->total() }} entries</p>
                    </div>
                    {{ $data_pengajuan->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection