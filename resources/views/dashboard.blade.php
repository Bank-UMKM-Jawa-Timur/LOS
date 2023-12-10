@extends('layouts.template')
@section('modal')
@endsection
@section('content')
    <section class="p-5 overflow-y-auto">
        <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Overview
                </p>
                <h2 class="font-semibold tracking-tighter text-lg text-theme-text">
                    Dashboard
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5">
                <div class="button-wrapper gap-2 flex lg:justify-end">
                    <button data-modal-id="modal-filter"
                        class="open-modal px-7 py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary">
                        <span class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="lg:w-[24px] w-[19px]" viewBox="-2 -2 24 24">
                                <path fill="currentColor"
                                    d="m2.08 2l6.482 8.101A2 2 0 0 1 9 11.351V18l2-1.5v-5.15a2 2 0 0 1 .438-1.249L17.92 2H2.081zm0-2h15.84a2 2 0 0 1 1.561 3.25L13 11.35v5.15a2 2 0 0 1-.8 1.6l-2 1.5A2 2 0 0 1 7 18v-6.65L.519 3.25A2 2 0 0 1 2.08 0z" />
                            </svg>
                        </span>
                        <span class="ml-3 text-sm"> Filter </span>
                    </button>
                    <button data-modal-id="modal-filter-export"
                        class="open-modal px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white">
                        <span class="lg:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="lg:w-[24px] w-[19px]" viewBox="-2 -2 256 256">
                                <path fill="currentColor"
                                    d="M220 112v96a20 20 0 0 1-20 20H56a20 20 0 0 1-20-20v-96a20 20 0 0 1 20-20h24a12 12 0 0 1 0 24H60v88h136v-88h-20a12 12 0 0 1 0-24h24a20 20 0 0 1 20 20ZM96.49 72.49L116 53v83a12 12 0 0 0 24 0V53l19.51 19.52a12 12 0 1 0 17-17l-40-40a12 12 0 0 0-17 0l-40 40a12 12 0 1 0 17 17Z" />
                            </svg>
                        </span>
                        <span class="ml-2 text-sm"> Export </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-4 lg:gap-2 justify-center mt-5">
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-[#9334EA]/20">
                            <iconify-icon icon="pajamas:chart" class="text-3xl mt-1 text-[#9334EA]"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-theme-text text-3xl font-bold tracking-tighter">
                            5200
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Total Pengajuan
                        </p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-[#39B568]/20">
                            <iconify-icon icon="icon-park-outline:check-one" class="text-3xl mt-1 text-[#39B568]">
                            </iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-theme-text text-3xl font-bold tracking-tighter">
                            3200
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Disetujui
                        </p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-[#DC3545]/20">
                            <iconify-icon icon="uil:file-times-alt" class="text-3xl mt-1 text-[#DC3545]"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-theme-text text-3xl font-bold tracking-tighter">
                            1000
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">Ditolak</p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-[#E8A525]/20">
                            <iconify-icon icon="ps:clock" class="text-3xl mt-1 text-[#E8A525]"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-theme-text text-3xl font-bold tracking-tighter">
                            200
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">Diproses</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:flex relative gap-2 mt-3">
            <div class="card bg-white p-0 lg:w-2/4 w-full rounded-md box-border border">
                <div class="p-3 pl-5 pt-5">
                    <h2 class="font-poppins font-semibold tracking-tighter text-lg text-theme-text">
                        Data Pengajuan
                    </h2>
                </div>
                <div id="chart-total-pengajuan" class="w-full"></div>
            </div>
            <div class="card bg-white p-5 lg:mt-0 mt-4 lg:w-2/4 border rounded-md w-full">
                <div class="head flex justify-between gap-5">
                    <div class="title">
                        <h2 class="font-semibold tracking-tighter text-lg text-theme-text">
                            Ranking Cabang
                        </h2>
                    </div>
                    <div class="legend-wrapper flex gap-5">
                        <div class="legend-1 flex gap-3">
                            <div>
                                <iconify-icon icon="material-symbols-light:circle" class="text-green-500 text-lg">
                                </iconify-icon>
                            </div>
                            <div>
                                <h3 class="font-semibold tracking-tighter text-sm text-theme-text">
                                    Tertinggi
                                </h3>
                            </div>
                        </div>
                        <div class="legend-2 flex gap-3">
                            <div>
                                <iconify-icon icon="material-symbols-light:circle" class="text-red-500 text-lg">
                                </iconify-icon>
                            </div>
                            <div>
                                <h3 class="font-semibold tracking-tighter text-sm text-theme-text">
                                    Terendah
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="body-card w-full box">
                    <div class="lg:flex grid grid-cols-1 gap-5 w-full mt-5 box-border">
                        <div class="card-wrapper space-y-2 w-full box-border">
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-green-400">
                                    <h2 class="text-lg font-bold text-white">1</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Surabaya
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">001</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">24</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-green-400">
                                    <h2 class="text-lg font-bold text-white">2</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Malang
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">008</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">221</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-green-400">
                                    <h2 class="text-lg font-bold text-white">3</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Pemekasan
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">002</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">200</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-green-400">
                                    <h2 class="text-lg font-bold text-white">4</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Banyuwangi
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">004</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">120</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-green-400">
                                    <h2 class="text-lg font-bold text-white">5</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Blitar
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">010</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">80</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-wrapper w-full space-y-2 box-border">
                            <div class="card border flex gap-4 p-2 w-full box-border">
                                <button class="px-5 py-2 rounded bg-red-500">
                                    <h2 class="text-lg font-bold text-white">1</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Jember
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">024</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">20</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full box-border">
                                <button class="px-5 py-2 rounded bg-red-500">
                                    <h2 class="text-lg font-bold text-white">2</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Probolinggo
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">006</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">31</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-red-500">
                                    <h2 class="text-lg font-bold text-white">3</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Bondowoso
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">029</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">12</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-red-500">
                                    <h2 class="text-lg font-bold text-white">4</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Situbondo
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">027</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">21</h2>
                                </div>
                            </div>
                            <div class="card border flex gap-4 p-2 w-full">
                                <button class="px-5 py-2 rounded bg-red-500">
                                    <h2 class="text-lg font-bold text-white">5</h2>
                                </button>
                                <div class="content w-full">
                                    <h2 class="text-lg font-semibold text-theme-secondary">
                                        Lumajang
                                    </h2>
                                    <p class="text-sm font-semibold text-gray-400">005</p>
                                </div>
                                <div class="total pr-3">
                                    <h2 class="text-theme-secondary font-bold mt-3">22</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 lg:gap-2 gap-4 justify-center mt-3">
            <div class="card p-5 w-full border bg-white">
                <div class="head">
                    <h2 class="text-lg text-theme-text font-semibold tracking-tighter">
                        Posisi Pengajuan
                    </h2>
                </div>
                <div class="flex justify-center lg:mt-0 mt-5">
                    <div id="posisi-pengajuan"></div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white">
                <div class="head">
                    <h2 class="text-lg text-theme-text font-semibold tracking-tighter">
                        Skema Kredit
                    </h2>
                </div>
                <div class="flex justify-center lg:mt-0 mt-5">
                    <div id="skema-kredit"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
var options = {
    series: [
        {
        name: "Disetujui",
        data: [31, 40, 28, 51, 42, 45, 58, 60, 72, 80, 109, 100],
        },
        {
        name: "Ditolak",
        data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 80, 85],
        },
        {
        name: "Diproses",
        data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 40, 65],
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
    series: [44, 55, 41, 17, 15],
    chart: {
        type: "donut",
        width: 400,
    },
    labels: ["Pincab", "PBP", "PBO", "Penyelia", "Staff"],
    colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"],
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
    series: [44, 55, 41, 17, 15],
    chart: {
        type: "donut",
        width: 400,
    },
    labels: ["PKPJ", "KKB", "Talangan", "Prokesra", "Kusuma"],
    colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9"],
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
