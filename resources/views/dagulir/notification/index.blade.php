@extends('layouts.tailwind-template')

@push('script-inject')
<script>
    $('#page_length').on('change', function() {
        $('#form').submit()
    })
</script>
@endpush

@section('modal')
    @include('dagulir.modal.notification.hapus')
    @include('dagulir.modal.notification.detail')
@endsection

@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins mb-5">
      <div
        class="layout lg:flex grid grid-cols-1 lg:mt-0 justify-between w-full gap-5"
      >
        <div class="left-button gap-2 flex lg:justify-end">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                 SIPDe
                </p>
                <h2 id="title-table" class="font-bold tracking-tighter text-2xl text-theme-text">
                  Notifikasi
                </h2>
              </div>
        </div>
      </div>
    </div>
    <div class="body-pages">
        <div class="table-wrapper border bg-white">
            <form id="form" method="get">
                <div
                class="layout-wrapping p-3 lg:flex grid grid-cols-1 justify-center lg:justify-between"
                >
                <div
                    class="left-layout lg:w-auto w-full lg:block flex justify-center"
                >
                    <div class="flex gap-5 p-2">
                    <span class="mt-[10px] text-sm">Show</span>
                    <select
                        name="page_length"
                        class="border border-gray-300 rounded appearance-none text-center px-4 py-2 outline-none"
                        id="page_length"
                    >
                        <option value="1"
                            @isset($_GET['page_length']) {{ $_GET['page_length'] == 10 ? 'selected' : '' }} @endisset>
                            1</option>
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
                    <input
                        type="search"
                        placeholder="Cari kata kunci... "
                        name="q" id="q"
                        class="w-full px-8 outline-none text-sm p-3 border"
                        value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}"
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
                <div class="table-responsive pl-5 pr-5">
                <table class="tables">
                    <thead>
                    <tr>
                        <th class="w-5">No.</th>
                        <th>Pesan</th>
                        <th>Waktu</th>
                        <th>Status</th>
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
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{!! $item->message !!}</td>
                            <td>{{date('d-m-Y H:i:s', strtotime($item->created_at))}}</td>
                            <td id="row-read{{ $item->id }}">{{ $item->is_read ? 'Dibaca' : 'Belum Dibaca' }}</td>
                            <td>
                                <button data-id="{{ $item->id }}" data-target="#modal-detail" class="btn text-white bg-theme-secondary btnDetail" type="button">Detail</button>
                                <button data-id="{{ $item->id }}" data-target="#modal-hapus" class="btn text-white bg-theme-primary btnHapus" type="button">Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Belum ada notifikasi.</td>
                        </tr>
                        @endforelse
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });

    $(".btnDetail").on("click", function(){
        var id = $(this).data('id');
        var targetModal = $(this).data('target');
        $.ajax({
            url: "{{ route('dagulir.notification.getDetail') }}",
            type: "POST",
            data: {
                id: id
            },
            success: function(res){
                $(`#row-read${id}`).html('Dibaca')
                if (res.data.skema_kredit == 'Dagulir') {
                    $("#field-kode_sipde").html(res.data.kode_pendaftaran)
                } else {
                    $("#kode_sipde").addClass('hidden')
                }
                $("#field-nama").html(res.data.nama)
                $("#field-tanggal_pengajuan").html(res.data.tanggal_pengajuan)
                $("#field-jenis_usaha").html(res.data.jenis_usaha)
                $("#field-tipe_pengajuan").html(res.data.tipe_pengajuan)
                $("#field-plafon").html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(res.data.nominal));
                $("#field-tenor").html(res.data.jangka_waktu + " Bulan")

                $(targetModal).removeClass('hidden');
            }
        })
    })

    $(".btnHapus").on("click", function(){
        var id = $(this).data('id');
        var targetModal = $(this).data('target');

        $("#id-hapus").val(id);
        $(targetModal).removeClass('hidden')
    })
</script>
@endpush
