@extends('layouts.tailwind-template')

@section('modal')

@include('dagulir.modal.filter')

@endsection

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
      <div
        class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5"
      >
        <div class="left-button gap-2 flex lg:justify-end">
          <a
            class="px-7 py-2 cursor-pointer  rounded flex justify-center items-center font-semibold bg-theme-primary border text-white"
          >
            <span class="mt-1 mr-3">
              <iconify-icon icon="pajamas:repeat"></iconify-icon>
            </span>
            <span class="ml-1 text-sm"> Reset </span>
          </a>
          <a
            data-modal-id="modal-filter"
            class="open-modal px-7 cursor-pointer py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary"
          >
            <span class="">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="lg:w-[24px] w-[19px]"
                viewBox="-2 -2 24 24"
              >
                <path
                  fill="currentColor"
                  d="m2.08 2l6.482 8.101A2 2 0 0 1 9 11.351V18l2-1.5v-5.15a2 2 0 0 1 .438-1.249L17.92 2H2.081zm0-2h15.84a2 2 0 0 1 1.561 3.25L13 11.35v5.15a2 2 0 0 1-.8 1.6l-2 1.5A2 2 0 0 1 7 18v-6.65L.519 3.25A2 2 0 0 1 2.08 0z"
                />
              </svg>
            </span>
            <span class="ml-3 text-sm"> Filter </span>
          </a>
        </div>
        <div class="right-button gap-2 flex lg:justify-start">
          <a
            href="form/pengajuan-form/data-umum.html"
            class="px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white"
          >
            <span class="mt-1 mr-3">
              <iconify-icon icon="fa6-solid:plus"></iconify-icon>
            </span>
            <span class="ml-1 text-sm"> Tambah pengajuan </span>
          </a>
        </div>
      </div>
    </div>
    <div class="body-pages">
      <div class="table-wrapper border bg-white mt-3">
        <div
          class="layout-wrapping p-3 lg:flex grid grid-cols-1 justify-center lg:justify-between"
        >
          <div
            class="left-layout lg:w-auto w-full lg:block flex justify-center"
          >
            <div class="flex gap-5 p-2">
              <span class="mt-[10px] text-sm">Show</span>
              <select
                name=""
                class="border border-gray-300 rounded appearance-none text-center px-4 py-2 outline-none"
                id=""
              >
                <option value="">10</option>
                <option value="">15</option>
                <option value="">20</option>
              </select>
              <span class="mt-[10px] text-sm">Entries</span>
            </div>
          </div>
          <div class="right-layout lg:w-auto w-full">
            <div class="input-search flex gap-2">
              <input
                type="search"
                placeholder="Cari nama usaha... "
                class="w-full px-8 outline-none text-sm p-3 border"
              />
              <button
                class="px-5 py-2 bg-theme-primary rounded text-white text-lg"
              >
                <iconify-icon
                  icon="ic:sharp-search"
                  class="mt-2 text-lg"
                ></iconify-icon>
              </button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="tables">
            <thead>
              <tr>
                <th>No.</th>
                <th>Kode Pendaftaran</th>
                <th>Tanggal Pengajuan</th>
                <th>No Ktp/Npwp</th>
                <th>Nama Usaha</th>
                <th>Jenis Usaha</th>
                <th>Telp</th>
                <th>Tipe Registrasi</th>
                <th>Status</th>
                <th>Status Penyelia</th>
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
                @foreach ($data as $item)
                <tr>

                    <td>{{ $i++ }}</td>
                    <td>{{ $item->kode_pendaftaran }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->npwp }}</td>
                    <td class="font-semibold uppercase">{{ ucwords($item->nama) }}</td>
                    <td>
                        @if ($item->jenis_usaha == '1')
                            Sektor Pertanian
                        @elseif ($item->jenis_usaha == '2')
                            Sektor Peternakan
                        @elseif ($item->jenis_usaha == '3')
                            Sektor Kelautan dan Perikanan
                        @elseif ($item->jenis_usaha == '4')
                            Sektor Perkebunan
                        @elseif ($item->jenis_usaha == '5')
                        Sektor industri
                        @elseif ($item->jenis_usaha == '6')
                        Sektor Perdagangan
                        @elseif ($item->jenis_usaha == '7')
                        Sektor Makanan dan Minuman
                        @elseif ($item->jenis_usaha == '8')
                        Koperasi
                        @elseif ($item->jenis_usaha == '9')
                        Sektor jasa dan lainnya
                        @elseif ($item->jenis_usaha == '10')
                        Lainnya
                        @else
                        Tidak ada
                        @endif
                    </td>
                    <td>{{ $item->telp }}</td>
                    <td>
                        @if ($item->tipe == '1')
                            Sektor Pertanian
                        @elseif ($item->tipe == '2')
                            Sektor Peternakan
                        @elseif ($item->tipe == '3')
                            Sektor Kelautan dan Perikanan
                        @elseif ($item->tipe == '4')
                        @else
                        Tidak ada
                        @endif
                    </td>
                    <td>
                    <span class="status bg-green-100 text-green-500 border border-green-300">
                        <span>Disetujui</span>
                    </span>
                    </td>
                    <td>
                        <span class="status bg-green-100 text-green-500 border border-green-300">
                        <span>Disetujui</span>
                        </span>
                    </td>
                    <td>
                    <a href="{{ route('dagulir.review') }}">
                        <button class="btn  text-white bg-theme-secondary border-theme-secondary border">
                        <div class="flex gap-3">
                            <span>
                            <iconify-icon icon="uil:edit" class="mt-[3px]"></iconify-icon>
                            </span>
                            <p class="text-sm">Review</p>
                        </div>
                        </button>
                    </a>
                    </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        </div>
        <div class="footer-table p-2">
          <div class="flex justify-between">
            <div class="mt-5 ml-5 text-sm font-medium text-gray-500">
              <p>Showing {{ $start }} - {{ $end }} from {{ $data->total() }} entries</p>
            </div>
            {{ $data->links('pagination::tailwind') }}
            {{-- <div class="pagination">
              <a
                href=""
                class="item-pg item-pg-prev"
              >
                Prev
              </a>
              <a
                href="#"
                class="item-pg active-pg"
              >
                1
              </a>
              <a
                href="#"
                class="item-pg"
              >
                2
              </a>
              <a
                href="#"
                class="item-pg"
              >
                3
              </a>
              <a
                href="#"
                class="item-pg"
              >
                4
              </a>
              <a
                href="#"
                class="item-pg of-the-data"
              >
                of 100
              </a>
              <a
                href=""
                class="item-pg item-pg-next"
              >
                Next
              </a>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


