@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto">
    <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Dashboard
            </p>
            <h2 id="title-page" class="font-bold tracking-tighter text-lg text-theme-text">
                Detail Chart Posisi
            </h2>
        </div>
    </div>
    <div class="table-wrapper-tab bg-white p-5 border mt-4">
        <div id="tab-cabang" class="tab-content {{ Request::route()->getName() == "dashboard-detail-cabang" ? '' : 'active' }}">
            <table class="tables border">
                <thead>
                    <th>Cabang</th>
                    <th>Staff</th>
                    <th>Review Penyelia</th>
                    <th>PBO</th>
                    <th>PBP</th>
                    <th>Pincab</th>
                </thead>
                <tbody>
                    @foreach ($cabang as $item)
                    <tr>
                        <td>{{ $item->cabang }}</td>
                        <td>{{ $item->staf }}</td>
                        <td>{{ $item->penyelia }}</td>
                        <td>{{ $item->pbo }}</td>
                        <td>{{ $item->pbp }}</td>
                        <td>{{ $item->pincab }}</td>
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
