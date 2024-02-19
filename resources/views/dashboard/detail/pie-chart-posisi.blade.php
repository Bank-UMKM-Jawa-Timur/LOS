@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto">
    <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Dashboard
            </p>
            <h2 id="title-page" class="font-bold tracking-tighter text-lg text-theme-text">
                Detail Staff
            </h2>
        </div>
    </div>
    <div class="mt-4">
        <div class="tab-table-wrapper p-0">
            <button data-tab="staf" id="pincetar-button" class="tab-button tab-button-start {{ Request::route()->getName() == "dashboard-detail-staf" ? '' : 'active' }} ">
                <iconify-icon icon="material-symbols-light:shelf-position-outline" class="mt-[4px]"></iconify-icon> Staf
            </button>

            @if ($role == 'Pincab' || $role == 'pbo/pbp')
                <button data-tab="penyelia" id="sipde-button" class="tab-button {{ Request::route()->getName() == "dashboard-detail-penyelia" ? 'active' : '' }}">
                    <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> Penyelia
                </button>
                <button data-tab="pbp-pbo" id="sipde-button" class="tab-button {{ Request::route()->getName() == "dashboard-detail-pbp-pbo" ? '' : 'actives' }}">
                    <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> PBO/PBP
                </button>
                <button data-tab="pincab" id="sipde-button" class="tab-button tab-button-end {{ Request::route()->getName() == "dashboard-detail-pincab" ? 'active' : '' }}">
                    <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> Pincab
                </button>
            @endif
        </div>
    </div>
    <div class="table-wrapper-tab bg-white p-5 border">
        <div id="tab-staf" class="tab-content {{ Request::route()->getName() == "dashboard-detail-staf" ? '' : 'active' }}">
            <table class="table-posisi">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: center;">Nama</th>
                        <th rowspan="2" style="vertical-align: center;">NIP</th>
                        <th colspan="2" style="vertical-align: center;">Tindak Lanjut</th>
                    </tr>
                    <tr>
                        <th>Sudah</th>
                        <th>Belum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataStaf as $item)
                    <tr>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->sudah }}</td>
                        <td>{{ $item->belum }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <span class="text-center text-theme-primary">Data tidak ada.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($role == 'Pincab' || $role == 'pbo/pbp')
            <div id="tab-penyelia" class="tab-content {{ Request::route()->getName() == "dashboard-detail-penyelia" ? 'active' : '' }}">
                <table class="table-posisi">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: center;">Nama</th>
                            <th rowspan="2" style="vertical-align: center;">NIP</th>
                            <th colspan="2" style="vertical-align: center;">Tindak Lanjut</th>
                        </tr>
                        <tr>
                            <th>Sudah</th>
                            <th>Belum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penyelia as $item)
                        <tr>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->sudah }}</td>
                            <td>{{ $item->belum }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <span class="text-center text-theme-primary">Data tidak ada.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="tab-pbp-pbo" class="tab-content {{ Request::route()->getName() == "dashboard-detail-pbp-pbo" ? 'active' : '' }}">
                <table class="table-posisi">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: center;">Nama</th>
                            <th rowspan="2" style="vertical-align: center;">NIP</th>
                            <th colspan="2" style="vertical-align: center;">Tindak Lanjut</th>
                        </tr>
                        <tr>
                            <th>Sudah</th>
                            <th>Belum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($PBOPBP as $item)
                        <tr>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->sudah }}</td>
                            <td>{{ $item->belum }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <span class="text-center text-theme-primary">Data tidak ada.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="tab-pincab" class="tab-content {{ Request::route()->getName() == "dashboard-detail-pincab" ? 'active' : '' }}">
                <table class="table-posisi">
                    <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: center;">Nama</th>
                            <th rowspan="2" style="vertical-align: center;">NIP</th>
                            <th rowspan="2" style="vertical-align: center;">Disetujui</th>
                            <th rowspan="2" style="vertical-align: center;">Ditolak</th>
                            <th colspan="2" style="vertical-align: center;">Tindak Lanjut</th>
                        </tr>
                        <tr>
                            <th>Sudah</th>
                            <th>Belum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pincab as $item)
                        <tr>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->disetujui }}</td>
                            <td>{{ $item->ditolak }}</td>
                            <td>{{ $item->sudah }}</td>
                            <td>{{ $item->belum }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <span class="text-center text-theme-primary">Data tidak ada.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection

@push('script-inject')
<script>
    $(".tab-table-wrapper .tab-button").click(function(e) {
        e.preventDefault();
        var tabID = $(this).data('tab');
        $(this).addClass('active').siblings().removeClass('active');
        $('#tab-'+tabID).addClass('active').siblings().removeClass('active');
        if(tabID == "cabang"){
            $('#title-page').html('Detail Cabang')
        }else{
            $('#title-page').html('Detail Skema')
        }
    });
</script>
@endpush
