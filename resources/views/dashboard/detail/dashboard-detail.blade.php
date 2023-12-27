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
            <button data-tab="posisi" id="pincetar-button" class="tab-button tab-button-start active">
                <iconify-icon icon="material-symbols-light:shelf-position-outline" class="mt-[4px]"></iconify-icon> Posisi
            </button>
            <button data-tab="skema" id="sipde-button" class="tab-button tab-button-end ">
                <iconify-icon icon="file-icons:scheme" class="mt-[2px]"></iconify-icon> Skema
            </button>
        </div>
    </div>
    <div class="table-wrapper-tab bg-white p-5 border">
        {{-- dagulir --}}
        <div id="tab-posisi" class="tab-content active">
            <table class="tables border">
                <thead>
                    <th></th>
                    <th>Total Pengajuan</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                    <th>Diproses</th>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td class="title-table">Pincab</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">PBP</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">PBO</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Penyelia</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Staf</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr> --}}
                    <tr>
                        <td class="title-table">{{ $dataDetailPosisi['user'] }}</td>
                        <td>{{ $dataDetailPosisi['total'] }}</td>
                        <td>{{ $dataDetailPosisi['selesai'] }}</td>
                        <td>{{ $dataDetailPosisi['ditolak'] }}</td>
                        <td>{{ $dataDetailPosisi['proses'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="tab-skema" class="tab-content">
            <table class="tables border">
                <thead>
                    <th></th>
                    <th>Total Pengajuan</th>
                    <th>Disetujui</th>
                    <th>Ditolak</th>
                    <th>Diproses</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="title-table">PKPJ</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">KKB</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Talangan</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Prokesra</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Kusuma</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td class="title-table">Dagulir</td>
                        <td>30</td>
                        <td>40</td>
                        <td>20</td>
                        <td>10</td>
                    </tr>
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