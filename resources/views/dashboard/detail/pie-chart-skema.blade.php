@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto">
    <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Dagulir
            </p>
            <h2 id="title-page" class="font-bold tracking-tighter text-lg text-theme-text">
                Detail Chart Skema
            </h2>
        </div>
    </div>
    {{-- <div class="mt-4">
        <div class="tab-table-wrapper p-0">
            <button data-tab="skema" id="sipde-button" class="tab-button tab-button-end {{ Request::route()->getName() == "dashboard-detail-skema" ? 'active' : '' }}">
                <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> Cabang
            </button>
        </div>
    </div> --}}
    <div class="table-wrapper-tab bg-white p-5 border mt-3">
        <div id="tab-skema" class="tab-content active">
            <table class="tables border">
                <thead>
                    <th>Skema</th>
                    <th>Staff</th>
                    <th>Penyelia</th>
                    <th>PBO / PBP</th>
                    <th>Pincab</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $item['staf'] }}</td>
                        <td>{{ $item['penyelia'] }}</td>
                        <td>{{ $item['pbo_pbp'] }}</td>
                        <td>{{ $item['pincab'] }}</td>
                        <td>{{ $item['total_selesai'] }}</td>
                        <td>{{ $item['total_ditolak'] }}</td>
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
        if(tabID == "cabang"){
            $('#title-page').html('Detail Cabang')
        }else{
            $('#title-page').html('Detail Skema')
        }
    });
</script>
@endpush
