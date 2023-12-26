@extends('layouts.tailwind-template')
@section('modal')
@endsection
@section('content')
    @include('dashboard.admin')
    {{-- @include('dashboard.dagulir') --}}
@endsection

@push('script-inject')
    <script>
    var options = {
        series: [
            {
                name: "Disetujui",
                data: [parseInt("{{ $dataYear['data_disetujui']['January'] }}"), parseInt("{{ $dataYear['data_disetujui']['February'] }}"), parseInt("{{ $dataYear['data_disetujui']['March'] }}"), parseInt("{{ $dataYear['data_disetujui']['April'] }}"), parseInt("{{ $dataYear['data_disetujui']['May'] }}"), parseInt("{{ $dataYear['data_disetujui']['June'] }}"), parseInt("{{ $dataYear['data_disetujui']['July'] }}"), parseInt("{{ $dataYear['data_disetujui']['August'] }}"), parseInt("{{ $dataYear['data_disetujui']['September'] }}"), parseInt("{{ $dataYear['data_disetujui']['October'] }}"), parseInt("{{ $dataYear['data_disetujui']['November'] }}"), parseInt("{{ $dataYear['data_disetujui']['December'] }}")],
            },
            {
                name: "Ditolak",
                data: [parseInt("{{ $dataYear['data_ditolak']['January'] }}"), parseInt("{{ $dataYear['data_ditolak']['February'] }}"), parseInt("{{ $dataYear['data_ditolak']['March'] }}"), parseInt("{{ $dataYear['data_ditolak']['April'] }}"), parseInt("{{ $dataYear['data_ditolak']['May'] }}"), parseInt("{{ $dataYear['data_ditolak']['June'] }}"), parseInt("{{ $dataYear['data_ditolak']['July'] }}"), parseInt("{{ $dataYear['data_ditolak']['August'] }}"), parseInt("{{ $dataYear['data_ditolak']['September'] }}"), parseInt("{{ $dataYear['data_ditolak']['October'] }}"), parseInt("{{ $dataYear['data_ditolak']['November'] }}"), parseInt("{{ $dataYear['data_ditolak']['December'] }}")],
            },
            {
                name: "Diproses",
                data: [parseInt("{{ $dataYear['data_diproses']['January'] }}"), parseInt("{{ $dataYear['data_diproses']['February'] }}"), parseInt("{{ $dataYear['data_diproses']['March'] }}"), parseInt("{{ $dataYear['data_diproses']['April'] }}"), parseInt("{{ $dataYear['data_diproses']['May'] }}"), parseInt("{{ $dataYear['data_diproses']['June'] }}"), parseInt("{{ $dataYear['data_diproses']['July'] }}"), parseInt("{{ $dataYear['data_diproses']['August'] }}"), parseInt("{{ $dataYear['data_diproses']['September'] }}"), parseInt("{{ $dataYear['data_diproses']['October'] }}"), parseInt("{{ $dataYear['data_diproses']['November'] }}"), parseInt("{{ $dataYear['data_diproses']['December'] }}")],
            },
        ],
    colors: ["#00FF61", "#DC3545", "#F7C35C"],
    chart: {    
        width: "100%",
        height: "80%",
        type: "area",
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
        fontFamily: "'Poppins', sans-serif",
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: "smooth",
    },
    legend: {
        position: "top",
        horizontalAlign: "right",
    },
    xaxis: {
        categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Agu",
            "Sep",
            "Okt",
            "Nov",
            "Des",
        ],
    },
    tooltip: {
        x: {
            format: "dd/MM/yy HH:mm",
        },
    },
    };

    var chartTotalPengajuan = new ApexCharts(
        document.querySelector("#chart-total-pengajuan"),
        options
    );
    chartTotalPengajuan.render();

    var optionsPosisiPengajuan = {
    series: [parseInt("{{ $dataPosisi->pincab }}"), parseInt("{{ $dataPosisi->pbp }}"), parseInt("{{ $dataPosisi->pbo }}"), parseInt("{{ $dataPosisi->penyelia }}"), parseInt("{{ $dataPosisi->staf }}"), parseInt("{{ $dataPosisi->disetujui }}"), parseInt("{{ $dataPosisi->ditolak }}")],
    chart: {
        type: "donut",
        width: 400,
    },
    labels: ["Pincab", "PBP", "PBO", "Penyelia", "Staf", "Selesai", "Ditolak"],
    colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF", "#25E76E","#FF3649"],
    dataLabels: {
        enabled: false,
    },
    responsive: [
        {
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
            },
            legend: {
                position: "bottom",
            },
        },
        },
    ],
    };

    var donut1 = new ApexCharts(
        document.querySelector("#posisi-pengajuan"),
        optionsPosisiPengajuan
    );
    donut1.render();

    var optionsSkemaKredit = {
    series: [parseInt("{{ $dataSkema->PKPJ }}"), parseInt("{{ $dataSkema->KKB }}"), parseInt("{{ $dataSkema->Umroh }}"), parseInt("{{ $dataSkema->Prokesra }}"), parseInt("{{ $dataSkema->Kusuma }}"), parseInt("{{ $dataSkema->Dagulir }}")],
    chart: {
        type: "donut",
        width: 400,
    },
    labels: ["PKPJ", "KKB", "Talangan", "Prokesra", "Kusuma", "Dagulir"],
    colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9", "#F7C35C"],
    dataLabels: {
        enabled: false,
    },
    responsive: [
        {
        breakpoint: 480,
        options: {
            chart: {
                width: 200,
            },
            legend: {
                position: "bottom",
            },
        },
        },
    ],
    };

    var donut2 = new ApexCharts(
        document.querySelector("#skema-kredit"),
        optionsSkemaKredit
    );
    donut2.render();
    </script>
@endpush
