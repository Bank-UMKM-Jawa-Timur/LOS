@extends('layouts.tailwind-template')
@section('content')
<section class="p-5 space-y-5">
    <div class="heading flex-auto">
        <p class="text-theme-primary font-semibold font-poppins text-xs">
            Dagulir
        </p>
        <h2 class="font-semibold tracking-tighter text-lg text-theme-text">
            Dashboard
        </h2>
    </div>
<div class="body-pages space-y-5">
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
                        30                    </h2>
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
                        30}
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
                        30
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
                        30
                    </h2>
                    <p class="text-gray-500 text-sm tracking-tighter">Diproses</p>
                </div>
            </div>
        </div>
    </div>
    <div class="lg:flex grid grid-cols-1 gap-5">
        <div class="grid lg:grid-cols-1 md:grid-cols-2 grid-cols-1 gap-5 justify-center w-full">
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-red-100">
                            <iconify-icon icon="healthicons:money-bag-outline" class="text-4xl mt-1 text-red-600"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 id="total-modal" class="text-theme-text text-2xl font-bold tracking-tighter">
                            {{ "Rp.". number_format($total_modal ,2,',','.') }}
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Total Modal
                        </p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-yellow-100">
                            <iconify-icon icon="mdi:cash-clock" class="text-3xl mt-1 text-yellow-600"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 id="total-idle" class="text-theme-text text-2xl font-bold tracking-tighter">
                            {{ "Rp.". number_format($total_idle ,2,',','.') }}
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Total Idle
                        </p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-green-100">
                            <iconify-icon icon="mdi:cash-clock" class="text-3xl mt-1 text-green-600"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 id="total-idle" class="text-theme-text text-2xl font-bold tracking-tighter">
                            Rp.0,00
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Total Akumulatif
                        </p>
                    </div>
                </div>
            </div>
            <div class="card p-5 w-full border bg-white h-[127px]">
                <div class="flex gap-5">
                    <div>
                        <button class="w-20 h-20 p-5 rounded-full bg-purple-100">
                            <iconify-icon icon="solar:wallet-money-linear" class="text-3xl mt-1 text-purple-600"></iconify-icon>
                        </button>
                    </div>
                    <div class="mt-3">
                        <h2 id="total-baket" class="text-theme-text text-2xl font-bold tracking-tighter">
                            {{ "Rp.". number_format($total_baket ,2,',','.') }}
                        </h2>
                        <p class="text-gray-500 text-sm tracking-tighter">
                            Total Baki Debet
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white border w-full p-3 rounded">
            <div class="head p-2">
                <h2 class="font-bold tracking-tighter">Pelimpahan Dana Masing-Masing Cabang</h2>
            </div>
            <div id="total-dana"></div>
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
        name: "Total",
        data: [31, 40, 28, 51, 42, 45, 58, 60, 72, 80, 109, 100],
        },
    ],
    colors: ["#DC3545"],
    chart: {
        width: "100%",
        height: 450,
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
        "Surabaya",
        "Ponorogo",
        "Probolinggo",
        "Sidoarjo",
        "Madiun",
        "Magetan",
        "Lamongan",
        "Bondowoso",
        "Situbondo",
        "Jember",
        "Gresik",
        "Pamekasan",
        ],
    },
    tooltip: {
        x: {
        format: "dd/MM/yy HH:mm",
        },
    },
    };

    var chartTotalPengajuan = new ApexCharts(document.querySelector("#total-dana"), options);
    chartTotalPengajuan.render();

</script>
@endpush