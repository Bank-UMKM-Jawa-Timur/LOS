// require("./bootstrap");

// require("alpinejs");

$(".dropdown-account").on("click", function (e) {
    $(".dropdown-account-menu").toggleClass("hidden");
    e.stopPropagation();
});

$(".toggle-dp-menu").on("click", function (e) {
    $(".dropdown-menu-link").toggleClass("hidden");
    e.stopPropagation();
});

$(".toggle-menu").on("click", function (e) {
    $(".sidebar").toggleClass("hidden");
    e.stopPropagation();
});

$(".dropdown-tb-toggle").on("click", function (e) {
    $(".dropdown-tb-menu").not(this).addClass("hidden");
    $(this).next(".dropdown-tb-menu").toggleClass("hidden");
    e.stopPropagation();
});

$(document).click(function (e) {
    if (e.target.closest(".dropdown-tb-menu")) return;
    $(".dropdown-tb-menu").addClass("hidden");
});

$(document).click(function (e) {
    if (e.target.closest(".dropdown-account-menu")) return;
    $(".dropdown-account-menu").addClass("hidden");
});
$(document).click(function (e) {
    if (e.target.closest(".sidebar")) return;
    $(".sidebar").addClass("hidden");
});

// modal
$(".open-modal").on("click", function () {
    $(".modal").css("animation", "swipe-in 0.4s ease-in-out");
    $(".modal-layout").css(
        "animation",
        "opacity-in 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
    );
    const modalId = $(this).data("modal-id");
    $("#" + modalId).removeClass("hidden");
});

$(".modal-layout").click(function (e) {
    if (e.target.closest(".modal")) return;
    setTimeout(function () {
        $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
        $(".modal-layout").css(
            "animation",
            "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
        );
    }, 200);
    setTimeout(function () {
        $(".modal-layout").addClass("hidden");
    }, 400);
});

$(document).keyup(function (e) {
    if (e.key === "Escape") {
        setTimeout(function () {
            $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
            $(".modal-layout").css(
                "animation",
                "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)t"
            );
        }, 200);
        setTimeout(function () {
            $(".modal-layout").addClass("hidden");
        }, 400);
    }
});

$("[data-dismiss-id]").on("click", function () {
    const dismissId = $(this).data("dismiss-id");
    setTimeout(function () {
        $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
        $(".modal-layout").css(
            "animation",
            "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)"
        );
    }, 200);
    setTimeout(function () {
        $("#" + dismissId).addClass("hidden");
    }, 400);
});
// ==================================================================
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
        stacked: true,
        type: "bar",
        toolbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
        fontFamily: "'Poppins', sans-serif",
    },
    plotOptions: {
        bar: {
            dataLabels: {
                position: "top",
            },
        },
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

// ====================================================================

Highcharts.chart("posisi-pengajuan", {
    chart: {
        type: "pie",
        width: 500,
        height: 400,
    },
    title: {
        verticalAlign: "middle",
        floating: true,
        text: `<span class="font-bold font-poppins text-5xl flex">
                    <p class="mt-20 left-14"><br /> <br />789<br><br></p>
            </span>`,
    },
    tooltip: {
        headerFormat: "",
        pointFormat:
            '<span style="color:{point.color}">\u25CF</span> <b> {point.name} </b><br/><span class="text-gray-400" >{point.y}</span>',
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            borderWidth: 5,
            cursor: "pointer",
            dataLabels: {
                enabled: true,
                format: "<b>{point.name}</b><br>{point.z}",
                distance: 20,
            },
        },
    },
    series: [
        {
            minPointSize: 20,
            innerSize: "70%",
            zMin: 0,
            name: "countries",
            borderRadius: 0,
            data: [
                {
                    name: "Pincab",
                    y: 505992,
                    z: 92,
                },
                {
                    name: "PBP",
                    y: 551695,
                    z: 119,
                },
                {
                    name: "PBO",
                    y: 312679,
                    z: 121,
                },
                {
                    name: "Penyelia",
                    y: 78865,
                    z: 136,
                },
                {
                    name: "Staff",
                    y: 301336,
                    z: 200,
                },
            ],
            colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"],
        },
    ],
});
Highcharts.chart("skema-kredit", {
    chart: {
        type: "pie",
        width: 500,
        height: 400,
    },
    title: {
        verticalAlign: "middle",
        floating: true,
        text: `<span class="font-bold font-poppins text-5xl flex">
                <p class="mt-20"><br /> <br />789<br><br></p>
        </span>`,
    },
    tooltip: {
        headerFormat: "",
        pointFormat:
            '<span style="color:{point.color}">\u25CF</span> <b> {point.name} </b><br/><span class="text-gray-400" >{point.y}</span>',
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            borderWidth: 5,
            cursor: "pointer",
            dataLabels: {
                enabled: true,
                format: "<b>{point.name}</b><br>{point.z}",
                distance: 20,
            },
        },
    },
    series: [
        {
            minPointSize: 20,
            innerSize: "70%",
            zMin: 0,
            name: "countries",
            borderRadius: 0,

            data: [
                {
                    name: "PKPJ",
                    y: 505992,
                    z: 92,
                },
                {
                    name: "KKB",
                    y: 551695,
                    z: 119,
                },
                {
                    name: "Talangan",
                    y: 312679,
                    z: 121,
                },
                {
                    name: "Prokesra",
                    y: 78865,
                    z: 136,
                },
                {
                    name: "Kusuma",
                    y: 301336,
                    z: 200,
                },
            ],
            colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9"],
        },
    ],
});
