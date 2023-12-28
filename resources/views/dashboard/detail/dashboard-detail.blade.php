@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto">
    <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Dagulir
            </p>
            <h2 id="title-page" class="font-bold tracking-tighter text-lg text-theme-text">
                Detail Posisi
            </h2>
        </div>
    </div>
    <div class="mt-4">
        <div class="tab-table-wrapper p-0">
            <button data-tab="posisi" id="pincetar-button" class="tab-button tab-button-start {{ Request::route()->getName() == "dashboard-detail-skema" ? '' : 'active' }} ">
                <iconify-icon icon="material-symbols-light:shelf-position-outline" class="mt-[4px]"></iconify-icon> Posisi
            </button>
            <button data-tab="skema" id="sipde-button" class="tab-button tab-button-end {{ Request::route()->getName() == "dashboard-detail-skema" ? 'active' : '' }}">
                <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> Skema
            </button>
        </div>
    </div>
    <div class="table-wrapper-tab bg-white p-5 border">
        {{-- dagulir --}}
        <div id="tab-posisi" class="tab-content {{ Request::route()->getName() == "dashboard-detail-skema" ? '' : 'active' }}">
            <table class="tables border">
                <thead>
                    <th></th>
                    <th>Total Pengajuan</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                    <th>Diproses</th>
                </thead>
                <tbody>
                    @foreach ($dataDetailPosisi as $key => $item)
                    <tr>
                        <td class="title-table">{{ $key }}</td>
                        <td>{{ $item['total_pengajuan'] }}</td>
                        <td>{{ $item['total_selesai'] }}</td>
                        <td>{{ $item['total_ditolak'] }}</td>
                        <td>{{ $item['diproses'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="tab-skema" class="tab-content {{ Request::route()->getName() == "dashboard-detail-skema" ? 'active' : '' }}">
            <table class="tables border">
                <thead>
                    <th></th>
                    <th>Total Pengajuan</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                    <th>Diproses</th>
                </thead>
                <tbody>
                    @foreach ($dataDetailSkema as $key => $item)
                    <tr>
                        <td class="title-table">{{ $key }}</td>
                        <td>{{ $item['total_pengajuan'] }}</td>
                        <td>{{ $item['total_selesai'] }}</td>
                        <td>{{ $item['total_ditolak'] }}</td>
                        <td>{{ $item['diproses'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
        if(tabID == "posisi"){
            $('#title-page').html('Detail Posisi')
        }else{
            $('#title-page').html('Detail Skema')
        }
    });
</script>
@endpush
