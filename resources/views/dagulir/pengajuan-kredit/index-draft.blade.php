@extends('layouts.tailwind-template')

@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head space-y-5 w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Draft Pengajuan Kredit
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Draft Pengajuan Kredit
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5">
                {{-- <div class="left-button gap-2 flex lg:justify-end">
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
                        
                </div> --}}
                    {{-- <button type="button" class="btn btn-sm btn-primary mb-2 ml-2" data-toggle="modal" data-target="#modal-filter">
                        <i class="fa fa-filter"></i> Filter
                    </button> --}}
                {{-- <div class="right-button gap-2 flex lg:justify-start">
                    <a data-modal-id="modal-filter"
                        class="open-modal px-7 py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary">
                        <span class="">
                            <iconify-icon icon="fluent:drafts-16-regular"></iconify-icon>
                        </span>
                        <span class="ml-3 text-sm"> Draft </span>
                    </a>
                    <a href="form/pengajuan-form/data-umum.html"
                        class="px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                        <span class="mt-1 mr-3">
                            <iconify-icon icon="fa6-solid:plus"></iconify-icon>
                        </span>
                        <span class="ml-1 text-sm"> Tambah pengajuan </span>
                    </a>
                </div> --}}
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
                        {{-- @if (Request()->tAwal != null)
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
                        @endif --}}
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
                            <tr>
                                <td>1</td>
                                <td>Agung</td>
                                <td>19 Desember 2023</td>
                                <td>
                                    <button class="dropdown-tb-toggle border rounded px-4 py-2 hover:bg-gray-100 hover:text-gray-500">
                                        <iconify-icon icon="ph:dots-three-outline-vertical-fill" class="mt-2">
                                        </iconify-icon>
                                    </button>
                                    <ul class="dropdown-tb-menu hidden">
                                        <li class="item-tb-dropdown">
                                            <a target="_blank" href="#"
                                                class="dropdown-item">Lanjuti</a>
                                        </li>
                                        <li class="item-tb-dropdown">
                                            <a href="#">Hapus</a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer-table p-4">
                    <div class="flex justify-between">
                        <div class="mt-3 mr-5 text-sm font-medium text-gray-500">
                            <p>  
                                {{-- {{ $data_pengajuan->links() }}
                                Menampilkan
                                {{ $data_pengajuan->firstItem() }}
                                -
                                {{ $data_pengajuan->lastItem() }}
                                dari
                                {{ $data_pengajuan->total() }} --}}
                                menampilkan 1-10 dari
                                Data
                                5
                            </p>
                        </div>
                        {{-- {{ $data_pengajuan->links('pagination::tailwind') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection