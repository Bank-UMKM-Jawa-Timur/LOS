@extends('layouts.template-app')

@section('modal')
  @include('direksi.modal.filter')
  @include('direksi.modal.export')
@endsection
@section('content')
<section class="p-5 overflow-y-auto">
    <div
      class="lg:flex grid grid-cols-1 justify-between w-full font-poppins"
    >
      <div class="heading flex-auto">
        <p class="text-theme-primary font-semibold font-poppins text-xs">
          Overview
        </p>
        <h2
          class="font-semibold tracking-tighter text-lg text-theme-text"
        >
          Dashboard
        </h2>
      </div>
      <div
        class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5"
      >
        <div class="button-wrapper gap-2 flex lg:justify-end">
          <button
            data-modal-id="modal-filter"
            class="open-modal px-7 py-2 flex font-poppins justify-center items-center rounded font-semibold bg-white border text-theme-secondary"
          >
            <span class="">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="lg:w-[24px] w-[19px]"
                viewBox="-2 -2 24 24"
              >
                <path
                  fill="currentColor"
                  d="m2.08 2l6.482 8.101A2 2 0 0 1 9 11.351V18l2-1.5v-5.15a2 2 0 0 1 .438-1.249L17.92 2H2.081zm0-2h15.84a2 2 0 0 1 1.561 3.25L13 11.35v5.15a2 2 0 0 1-.8 1.6l-2 1.5A2 2 0 0 1 7 18v-6.65L.519 3.25A2 2 0 0 1 2.08 0z"
                />
              </svg>
            </span>
            <span class="ml-3 text-sm"> Filter </span>
          </button>
          <button
            data-modal-id="modal-filter-export"
            class="open-modal px-7 py-2 rounded flex justify-center items-center font-semibold bg-theme-primary border text-white"
          >
            <span class="lg:mt-0">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="lg:w-[24px] w-[19px]"
                viewBox="-2 -2 256 256"
              >
                <path
                  fill="currentColor"
                  d="M220 112v96a20 20 0 0 1-20 20H56a20 20 0 0 1-20-20v-96a20 20 0 0 1 20-20h24a12 12 0 0 1 0 24H60v88h136v-88h-20a12 12 0 0 1 0-24h24a20 20 0 0 1 20 20ZM96.49 72.49L116 53v83a12 12 0 0 0 24 0V53l19.51 19.52a12 12 0 1 0 17-17l-40-40a12 12 0 0 0-17 0l-40 40a12 12 0 1 0 17 17Z"
                />
              </svg>
            </span>
            <span class="ml-2 text-sm"> Export </span>
          </button>
        </div>
      </div>
    </div>
    <div
      class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-4 lg:gap-2 justify-center mt-5"
    >
      <div class="card p-5 w-full border bg-white ">
        <div class="flex gap-5">
          <div>
            <button class="w-14 h-14 p-3 rounded-full bg-[#9334EA]/20">
              <iconify-icon
                icon="pajamas:chart"
                class="text-2xl mt-1 text-[#9334EA]"
              ></iconify-icon>
            </button>
          </div>
          <div class="mt-1">
            <h2
              class="text-theme-text text-2xl font-bold tracking-tighter" id="totalPengajuan">
            </h2>
            <p class="text-gray-500 text-sm tracking-tighter">
              Total Pengajuan
            </p>
          </div>
        </div>
      </div>
      <div class="card p-5 w-full border bg-white ">
        <div class="flex gap-5">
          <div>
            <button class="w-14 h-14 p-3 rounded-full bg-[#39B568]/20">
              <iconify-icon
                icon="icon-park-outline:check-one"
                class="text-2xl mt-1 text-[#39B568]"
              ></iconify-icon>
            </button>
          </div>
          <div class="mt-1">
            <h2
              class="text-theme-text text-2xl font-bold tracking-tighter"
              id="disetujui">
            </h2>
            <p class="text-gray-500 text-sm tracking-tighter">
              Disetujui
            </p>
          </div>
        </div>
      </div>
      <div class="card p-5 w-full border bg-white ">
        <div class="flex gap-5">
          <div>
            <button class="w-14 h-14 p-3 rounded-full bg-[#DC3545]/20">
              <iconify-icon
                icon="uil:file-times-alt"
                class="text-2xl mt-1 text-[#DC3545]"
              ></iconify-icon>
            </button>
          </div>
          <div class="mt-1">
            <h2
              class="text-theme-text text-2xl font-bold tracking-tighter"
              id="ditolak">
            </h2>
            <p class="text-gray-500 text-sm tracking-tighter">Ditolak</p>
          </div>
        </div>
      </div>
      <div class="card p-5 w-full border bg-white ">
        <div class="flex gap-5">
          <div>
            <button class="w-14 h-14 p-3 rounded-full bg-[#E8A525]/20">
              <iconify-icon
                icon="ps:clock"
                class="text-2xl mt-1 text-[#E8A525]"
              ></iconify-icon>
            </button>
          </div>
          <div class="mt-1">
            <h2
              class="text-theme-text text-2xl font-bold tracking-tighter"
              id="diproses">
            </h2>
            <p class="text-gray-500 text-sm tracking-tighter">Diproses</p>
          </div>
        </div>
      </div>
    </div>
    <div class="lg:flex relative gap-2 mt-3">
      <div
        class="card bg-white p-0 lg:w-2/4 w-full rounded-md box-border border"
      >
        <div class="p-3 pl-5 pt-5">
          <h2
            class="font-poppins font-semibold tracking-tighter text-lg text-theme-text"
          >
            Data Pengajuan
          </h2>
        </div>
        <div
          id="chart-total-pengajuan"
          class="w-full"
        ></div>
      </div>
      <div
        class="card bg-white p-5 lg:mt-0 mt-4 lg:w-2/4 border rounded-md w-full"
      >
        <div class="head flex justify-between gap-5">
          <div class="title">
            <h2
              class="font-semibold tracking-tighter text-lg text-theme-text"
            >
              Ranking Cabang
            </h2>
          </div>
          <div class="legend-wrapper flex gap-5">
            <div class="legend-1 flex gap-3">
              <div>
                <iconify-icon
                  icon="material-symbols-light:circle"
                  class="text-green-500 text-lg"
                ></iconify-icon>
              </div>
              <div>
                <h3
                  class="font-semibold tracking-tighter text-sm text-theme-text"
                >
                  Tertinggi
                </h3>
              </div>
            </div>
            <div class="legend-2 flex gap-3">
              <div>
                <iconify-icon
                  icon="material-symbols-light:circle"
                  class="text-red-500 text-lg"
                ></iconify-icon>
              </div>
              <div>
                <h3
                  class="font-semibold tracking-tighter text-sm text-theme-text"
                >
                  Terendah
                </h3>
              </div>
            </div>
          </div>
        </div>
        <div class="body-card w-full box">
          <div class="lg:flex grid grid-cols-1 gap-5 w-full mt-5 box-border">
            <div class="card-wrapper space-y-2 w-full box-border" id="ranking_tertinggi">
            </div>
            <div class="card-wrapper w-full space-y-2 box-border" id="ranking_terendah">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 lg:gap-2 gap-4 justify-center mt-3"
    >
      <div class="card p-5 w-full border bg-white">
        <div class="head">
          <h2
            class="text-lg text-theme-text font-semibold tracking-tighter"
          >
            Proses Skema Kredit
          </h2>
        </div>
        <div class="flex justify-center lg:mt-0 mt-5">
          <div id="posisi-pengajuan"></div>
        </div>
      </div>
      <div class="card p-5 w-full border bg-white">
        <div class="head">
          <h2
            class="text-lg text-theme-text font-semibold tracking-tighter"
          >
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
@push('script-injection')
  <script>
      function yearChartPengajuan(disetujui, ditolak, diproses) { 
        // console.log(ditolak);
        console.log(disetujui);
        var options = {
          series: [
              {
                  name: "Disetujui",
                  // data: $.map(disetujui, function (item, i) {
                  //   item
                  // }),
                  // data: disetujui,
                  data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 80, 85],
              },
              {
                  name: "Ditolak",
                  data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 80, 85],
                  // data: ditolak,
              },
              {
                  name: "Diproses",
                  // data: diproses,
                  data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 40, 65],
              },
          ],
          colors: ["#00FF61", "#DC3545", "#F7C35C"],
          chart: {
              width: "100%",
              height: 380,
              type: 'area',
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
      
        var chartTotalPengajuan = new ApexCharts(document.querySelector("#chart-total-pengajuan"), options);
        chartTotalPengajuan.render();
      }
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
                format: `<b style="font-size: 13px; fontFamily: 'Poppins', sans-serif;">{point.name}</b><br><span style="font-size: 18px; color: #333; fontFamily: 'Poppins', sans-serif;"">{point.z}</span>`,
                distance: 20,
            },
        },
    },
    series: [
        {
            minPointSize: 50,
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

function chartSkemaKredit(kusuma, pkpj, kkb, talangan, prokesra, total){
  return Highcharts.chart("skema-kredit", {
    chart: {
        type: "pie",
        width: 500,
        height: 400,
    },
    title: {
      align: 'center',
      verticalAlign: 'middle',
        text: `
        <br /><br />
        <span class="font-bold font-poppins text-6xl absolute">
                <p class="mt-[50%]"><br /><br />${total} <br /><br></p>
        </span>
        <br />
        `
        ,
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
                format: `<b style="font-size: 13px; fontFamily: 'Poppins', sans-serif;">{point.name}</b><br><span style="font-size: 18px; color: #333; fontFamily: 'Poppins', sans-serif;"">{point.z}</span>`,
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
                    y: parseInt(pkpj),
                    z: pkpj,
                },
                {
                    name: "KKB",
                    y: parseInt(kkb),
                    z: kkb,
                },
                {
                    name: "Talangan",
                    y: parseInt(talangan),
                    z: talangan,
                },
                {
                    name: "Prokesra",
                    y: parseInt(prokesra),
                    z: prokesra,
                },
                {
                    name: "Kusuma",
                    y: parseInt(kusuma),
                    z: kusuma,
                },
            ],
            colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9"],
        },
    ],
});
}

var staticToken = "gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj";
    // get data pengajuan 1 year
    var arr_pengajuan_total_disetujui = [];
    var arr_pengajuan_total_ditolak = [];
    var arr_pengajuan_total_diproses = [];
    for (let i = 1; i <= 12; i++) {
      $.ajax({
        type: "GET",
        url: `https://pincetar.bankumkm.id/api/v1/get-count-pengajuan?tAwal=2023-${i}-01&tAkhir=2023-${i}-30`,
        dataType: "json",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          // console.log(response);
          arr_pengajuan_total_disetujui.push(
            response.total_disetujui
          );
          arr_pengajuan_total_ditolak.push(
            response.total_ditolak
          );
          arr_pengajuan_total_diproses.push(
            response.total_diproses
          );
        }
      });
    }

    // console.log(arr_pengajuan_total_disetujui);
    yearChartPengajuan(arr_pengajuan_total_disetujui, arr_pengajuan_total_ditolak, arr_pengajuan_total_diproses);
    // console.log(arr_pengajuan_total_ditolak);
    // console.log(arr_pengajuan_total_diproses);

      $.ajax({
        type: "GET",
        url: "api/v1/get-sum-cabang",
        dataType: "json",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          // console.log(response);
          $('#totalPengajuan').append(response.total_disetujui + response.total_ditolak + response.total_diproses);
          $('#disetujui').append(response.total_disetujui);
          $('#ditolak').append(response.total_ditolak);
          $('#diproses').append(response.total_diproses);

          var dataTertinggi = response.data.tertinggi;
          var dataTerendah = response.data.terendah;
          
          // Data ranking tertinggi
          $.map(dataTertinggi, function (item, index) {
            $('#ranking_tertinggi').append(`
              <div class="card border flex gap-4 p-2 w-full">
                <button class="px-5 py-2 rounded bg-green-400">
                  <h2 class="text-lg font-bold text-white">${index + 1 }</h2>
                </button>
                <div class="content w-full">
                  <h2 class="text-lg font-semibold text-theme-secondary">
                    ${item.cabang}
                  </h2>
                  <p class="text-sm font-semibold text-gray-400">${item.kode_cabang}</p>
                </div>
                <div class="total pr-3">
                  <h2 class="text-theme-secondary font-bold mt-3">${item.total}</h2>
                </div>
              </div>
            `);
          });

          // Data ranking terendah
          $.map(dataTerendah, function (item, index) {
            $('#ranking_terendah').append(`
              <div class="card border flex gap-4 p-2 w-full">
                <button class="px-5 py-2 rounded bg-red-500">
                  <h2 class="text-lg font-bold text-white">${index + 1 }</h2>
                </button>
                <div class="content w-full">
                  <h2 class="text-lg font-semibold text-theme-secondary">
                    ${item.cabang}
                  </h2>
                  <p class="text-sm font-semibold text-gray-400">${item.kode_cabang}</p>
                </div>
                <div class="total pr-3">
                  <h2 class="text-theme-secondary font-bold mt-3">${item.total}</h2>
                </div>
              </div>
            `);
          });
        }
      });

      $.ajax({
        type: "GET",
        url: "https://pincetar.bankumkm.id/api/v1/get-sum-skema",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          var dataTotal = response.data.total[0];
          var total = parseInt(dataTotal.Kusuma) + parseInt(dataTotal.PKPJ) + parseInt(dataTotal.KKB) + parseInt(dataTotal.Umroh) + parseInt(dataTotal.Prokesra);
          
          chartSkemaKredit(dataTotal.Kusuma, dataTotal.PKPJ, dataTotal.KKB, dataTotal.Umroh, dataTotal.Prokesra, total);
        }
      });

</script>
@endpush
