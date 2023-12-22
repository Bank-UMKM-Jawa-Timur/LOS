@include('dagulir.master.user.modal.create')
@include('dagulir.master.user.modal.edit')
@include('dagulir.master.user.modal.delete')
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
                Master User
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                User
            </h2>
        </div>
        <div class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5">
            <div class="button-wrapper gap-2 flex lg:justify-end">
                <button data-modal-id="modal-add-user"
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Kantor Cabang</th>
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
                                    <td>{{ $item->nip ?? '-' }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>{{ $item->cabang->cabang }}</td>
                                    <td>
                                        <div class="flex">
                                            <div class="dropdown-tb">
                                                <button type="button"
                                                    class="dropdown-tb-toggle border rounded px-4 py-2 hover:bg-gray-100 hover:text-gray-500">
                                                    <iconify-icon icon="ph:dots-three-outline-vertical-fill"
                                                        class="mt-2"></iconify-icon>
                                                </button>
                                                <ul class="dropdown-tb-menu hidden">
                                                    {{-- <a href="{{ route('user.edit', $item->id) }}"
                                                        class="dropdown-item">
                                                        Edit
                                                    </a> --}}
                                                    <a class="w-full cursor-pointer" href="javascript:void(0)"
                                                        data-id_user="{{$item->id}}"
                                                        data-nip="{{$item->nip ?? '-'}}"
                                                        data-nama="{{$item->name}}"
                                                        data-email="{{$item->email}}"
                                                        data-role="{{$item->role}}"
                                                        data-cabang="{{$item->cabang->cabang}}" id="edit-user">
                                                        <li class="item-tb-dropdown">
                                                            Edit
                                                        </li>
                                                    </a>
                                                    @if (auth()->user()->id != $item->id)
                                                    <a class="w-full cursor-pointer" href="javascript:void(0)"
                                                        data-id_user="{{$item->id}}"
                                                        data-nama="{{$item->name}}"
                                                        id="hapus-user">
                                                        <li class="item-tb-dropdown">
                                                            Hapus
                                                        </li>
                                                    </a>
                                                    @endif
                                                    <a class="w-full cursor-pointer reset-password"
                                                        href="javascript:void(0)">
                                                        <li class="item-tb-dropdown">
                                                            Reset Password
                                                        </li>
                                                    </a>
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
    function resetPassword(name, id) {
        Swal.fire({
            title: 'Perhatian!!',
            text: "Apakah anda yakin mereset password " + name + " ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#112042',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'ResetPassword',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resetPasswordForm" + id).submit()
            }
        })
    }

    $('#edit-user').on('click', function(){
        var id_user = $(this).data("id_user");
        var nip = $(this).data("nip");
        var nama = $(this).data("nama");
        var email = $(this).data("email");
        var role = $(this).data("role");
        var cabang = $(this).data("cabang");

        $('.id-user').val(id_user);
        $('.nip-edit').val(nip);
        $('.name-edit').val(nama);
        $('.email-edit').val(email);

        $('#modal-edit-user').removeClass('hidden')
    });

    $('.hapus-user').on('click', function(){
        console.log('masuk coy');
        var id_user = $(this).data("id_user");
        var nama = $(this).data("nama");

        $('#id-user-delete').val(id_user);
        $('#nama').val(nama);
        $('#modal-hapus-user').removeClass('hidden')
    });
</script>
@endpush
