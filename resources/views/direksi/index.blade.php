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
    <div class="form-group-2 mt-3">
      <div id="data-pengajuan" class="card bg-white p-0 w-full rounded-md box-border border">
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
      <div id="ranking-cabang" class="card bg-white p-5 lg:mt-0 mt-4  border rounded-md w-full">
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
      <div class="card p-5 w-full border bg-white" id="proses-skema-kredit">
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
      <div class="card p-5 w-full border bg-white" id="skema-kredit-layout">
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
      <div class="card p-5 w-full border bg-white" id="proses-layout">
        <div class="head">
          <h2
            class="text-lg text-theme-text font-semibold tracking-tighter"
          >
            Proses
          </h2>
        </div>
        <div class="flex justify-center lg:mt-0 mt-5">
          <div id="proses"></div>
        </div>
      </div>
    </div>
    </div>
  </section>
  
@endsection
@push('script-injection')
  <script>

    Pusher.logToConsole = true;

    var pusher = new Pusher("fd114c25a90cd2005634", {
        cluster: "ap1",
    });
    let channel = pusher.subscribe("los-monitoring");

    channel.bind('los-event', function(data) {
      run();
    });

    run();

    function run(){

      function yearChartPengajuan(disetujui, ditolak, diproses) {
        var options = {
          series: [
              {
                  name: "Disetujui",
                  data: [
                    disetujui.January, 
                    disetujui.February, 
                    disetujui.March, 
                    disetujui.April, 
                    disetujui.May, 
                    disetujui.June, 
                    disetujui.July, 
                    disetujui.August, 
                    disetujui.September, 
                    disetujui.October, 
                    disetujui.November, 
                    disetujui.December
                  ],
              },
              {
                  name: "Ditolak",
                  data: [
                    ditolak.January, 
                    ditolak.February, 
                    ditolak.March, 
                    ditolak.April, 
                    ditolak.May, 
                    ditolak.June, 
                    ditolak.July, 
                    ditolak.August, 
                    ditolak.September, 
                    ditolak.October, 
                    ditolak.November, 
                    ditolak.December
                  ],
              },
              {
                  name: "Diproses",
                  data: [
                    diproses.January, 
                    diproses.February, 
                    diproses.March, 
                    diproses.April, 
                    diproses.May, 
                    diproses.June, 
                    diproses.July, 
                    diproses.August, 
                    diproses.September, 
                    diproses.October, 
                    diproses.November, 
                    diproses.December
                  ],
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
function chartProses(pincab, pbp, pbo, penyelia, staf, total) { 
  Highcharts.chart("proses", {
    chart: {
        type: "pie",
        width: 500,
        height: 400,
    },
    title: {
        verticalAlign: "middle",
        floating: true,
        text: `<span class="font-bold font-poppins text-5xl flex">
                    <p class="mt-20 left-14"><br /> <br />${total}<br><br></p>
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
                    y: pincab,
                    z: pincab,
                },
                {
                    name: "PBP",
                    y: pbp,
                    z: pbp,
                },
                {
                    name: "PBO",
                    y: pbo,
                    z: pbo,
                },
                {
                    name: "Penyelia",
                    y: penyelia,
                    z: penyelia,
                },
                {
                    name: "Staf",
                    y: staf,
                    z: staf,
                },
            ],
            colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"],
        },
    ],
  });
}

function chartProsesSkemaKredit(pincab, pbp, pbo, penyelia, staf, total) { 
  $('#posisi-pengajuan').empty();
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
                    <p class="mt-20 left-14"><br /> <br />${total}<br><br></p>
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
                    y: pincab,
                    z: pincab,
                },
                {
                    name: "PBP",
                    y: pbp,
                    z: pbp,
                },
                {
                    name: "PBO",
                    y: pbo,
                    z: pbo,
                },
                {
                    name: "Penyelia",
                    y: penyelia,
                    z: penyelia,
                },
                {
                    name: "Staf",
                    y: staf,
                    z: staf,
                },
            ],
            colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"],
        },
    ],
  });
}

function chartSkemaKredit(kusuma, pkpj, kkb, talangan, prokesra, total){
  $('#skema-kredit').empty();
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

function alertMessage(element, visible){
  if(visible == true){
    $(element).removeClass('alert');
    $(element).next('.alert-message').addClass('hidden');
  }else{
    $(element).addClass('alert');
    $(element).next('.alert-message').removeClass('hidden');
  }

}

  var staticToken = "gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj";
  var base_url = "https://pincetar.bankumkm.id";
  var url_sum_cabang = "api/v1/get-sum-cabang";
  var url_count_year_pengajuan = "api/v1/get-count-year-pengajuan";
  var url_sum_skema = "api/v1/get-sum-skema";
  var url_count_pengajuan = "api/v1/get-count-pengajuan";

  $('#btnFilter').on('click', function () { 
    $('#ranking_tertinggi').empty()
    $('#ranking_terendah').empty()
    $('#totalPengajuan').empty()
    $('#disetujui').empty()
    $('#ditolak').empty()
    $('#diproses').empty()

    let tAwal = document.getElementById("tgl_awal");
    let tAkhir = document.getElementById("tgl_akhir");
    let fSkemaKredit = document.getElementById('skema-kredit-filter');
    let fCabang = document.getElementById("cabang-filter")

    if(tAwal.value.trim(" ") == "" || tAkhir.value.trim(" ") == ""){
      alertMessage('#tgl_awal', false)
      alertMessage('#tgl_akhir', false)
    }else if(tAwal.value.trim(" ") == ""){
      alertMessage('#tgl_awal', false)
    }else if(tAkhir.value.trim(" ") == ""){
      alertMessage('#tgl_akhir', false)
    }else{
      alertMessage('#tgl_awal', true)
      alertMessage('#tgl_akhir', true)
  
    if (tAwal.value != "" && tAkhir.value != "") {
      url_sum_cabang = `api/v1/get-sum-cabang?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}`;

      if(fSkemaKredit.value != "all_skema" && fCabang.value != "00"){
        // Pilih skeme & pilih cabang
        url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&skema=${fSkemaKredit.value}&cabang=${fCabang.value}`;

        $('#proses-skema-kredit').removeClass('hidden')
        $('#skema-kredit-layout').addClass('hidden')
        $('#ranking-cabang').addClass('hidden')
        $('#proses-layout').addClass('hidden')
      }else if(fSkemaKredit.value != "all_skema" && fCabang.value == "00"){
        // Pilih skeme & semua cabang
        url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&skema=${fSkemaKredit.value}`;

        $('#proses-skema-kredit').removeClass('hidden')
        $('#skema-kredit-layout').addClass('hidden')
        $('#ranking-cabang').removeClass('hidden')
        $('#proses-layout').addClass('hidden')
      }else if(fSkemaKredit.value == "all_skema" && fCabang.value != "00"){
        // semua skeme & pilih cabang
        url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&cabang=${fCabang.value}`;
        url_count_pengajuan = `api/v1/get-count-pengajuan?tAwal=${tAwal.value}&tAkhir=${tAkhir.value}&cabang=${fCabang.value}`;

        $('#skema-kredit-layout').removeClass('hidden')
        $('#proses-skema-kredit').addClass('hidden')
        $('#ranking-cabang').addClass('hidden')
        $('#proses-layout').removeClass('hidden')
        getDataPengajuan();
        // di proses
        getProses();
      }else if(fSkemaKredit.value == "all_skema" && fCabang.value == "00"){
        // semua skeme & semua cabang
        url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}`;
        url_count_pengajuan = `api/v1/get-count-pengajuan?tAwal=${tAwal.value}&tAkhir=${tAkhir.value}`;

        $('#proses-skema-kredit').addClass('hidden')
        $('#skema-kredit-layout').removeClass('hidden')
        $('#ranking-cabang').removeClass('hidden')
        $('#proses-layout').addClass('hidden')
        pengajuanRanking();
      }

    }else{
      url_sum_cabang = "api/v1/get-sum-cabang";
      url_count_year_pengajuan = "api/v1/get-count-year-pengajuan";
      url_sum_skema = "api/v1/get-sum-skema";
      url_count_pengajuan = "api/v1/get-count-pengajuan";
      $('#skema-kredit-layout').removeClass('hidden')
      $('#proses-skema-kredit').removeClass('hidden')
      $('#proses-layout').addClass('hidden')
      pengajuanRanking();
    }

    getDataPengajuanYear();
    getSkema();
    $(".modal-layout").trigger('click');
    
  }

  })
  
    getDataPengajuanYear();
    pengajuanRanking();
    getSkema();
    $('#proses-layout').addClass('hidden')

    // get data pengajuan 1 year
    function getDataPengajuanYear() { 
      $.ajax({
        type: "GET",
        url: url_count_year_pengajuan,
        dataType: "json",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          $('#chart-total-pengajuan').empty();
          yearChartPengajuan(response.data.data_disetujui, response.data.data_ditolak, response.data.data_diproses)
        }
      });
    }

    function getDataPengajuan() { 
      $.ajax({
        type: "GET",
        url: url_count_pengajuan,
        dataType: "json",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          var data = response.data[0];
          $('#totalPengajuan').append(parseInt(data.total_disetujui) + parseInt(data.total_ditolak) + parseInt(data.total_diproses));
          $('#disetujui').append(data.total_disetujui);
          $('#ditolak').append(data.total_ditolak);
          $('#diproses').append(data.total_diproses);
        }
      });
    }

    function getProses() { 
      let tAwal = document.getElementById("tgl_awal");
      let tAkhir = document.getElementById("tgl_akhir");
      let fCabang = document.getElementById("cabang-filter");
      $.ajax({
        type: "GET",
        url: `api/v1/get-posisi-pengajuan?tAwal=${tAwal.value}&tAkhir=${tAkhir.value}&cabang=${fCabang.value}`,
        dataType: "json",
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          var data = response.data[0];
          var total = parseInt(data.penyelia) + parseInt(data.pbp) + parseInt(data.pincab) + parseInt(data.pbo) + parseInt(data.staff);
          console.log(total);
          chartProses(data.pincab, data.pbp, data.pbo, data.penyelia, data.staff, total);
        }
      });
    }

    function pengajuanRanking() { 
      $('#totalPengajuan').empty()
      $('#disetujui').empty()
      $('#ditolak').empty()
      $('#diproses').empty()

      $.ajax({
        type: "GET",
        url: url_sum_cabang,
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
            rankingTertinggi(index, item.cabang, item.kode_cabang, item.total);
          });

          // Data ranking terendah
          $.map(dataTerendah, function (item, index) {
            rankingTerendah(index, item.cabang, item.kode_cabang, item.total);
          });
        }
      });
    }

    function getSkema() { 
      let tAwal = document.getElementById("tgl_awal");
      let tAkhir = document.getElementById("tgl_akhir");
      let fSkemaKredit = document.getElementById('skema-kredit-filter');
      let fCabang = document.getElementById("cabang-filter");

      $.ajax({
        type: "GET",
        url: url_sum_skema,
        headers: {
          "Content-Type": "application/json",
          "token": staticToken
        },
        success: function (response) {
          // var skema kredit
          var totalKusuma = 0;
          var totalPkpj = 0;
          var totalKkb = 0;
          var totalTalangan = 0;
          var totalProkesra = 0;

          // var Proses skema
          var prosesPincab = 0;
          var prosesPbp = 0;
          var prosesPbo = 0;
          var prosesPenyelia = 0;
          var prosesStaf = 0;
          var tDisetujui = 0;
          var tDitolak = 0;
          var tDiproses = 0;

          if (tAwal.value != "" && tAkhir.value != "") {
            var data = response.data;

            $.map(data, function (item, i) {
              if(fSkemaKredit.value != "all_skema" && fCabang.value != "00"){
                prosesPincab += parseInt(item.posisi_pincab);
                prosesPbp += parseInt(item.posisi_pbp);
                prosesPbo += parseInt(item.posisi_pbo);
                prosesPenyelia += parseInt(item.posisi_penyelia);
                prosesStaf += parseInt(item.posisi_staf);
                tDisetujui += parseInt(item.total_disetujui);
                tDitolak += parseInt(item.total_ditolak);
              }else if(fSkemaKredit.value != "all_skema" && fCabang.value == "00"){
                prosesPincab += parseInt(item.posisi_pincab);
                prosesPbp += parseInt(item.posisi_pbp);
                prosesPbo += parseInt(item.posisi_pbo);
                prosesPenyelia += parseInt(item.posisi_penyelia);
                prosesStaf += parseInt(item.posisi_staf);
                tDisetujui += parseInt(item.total_disetujui);
                tDitolak += parseInt(item.total_ditolak);
              }else if(fSkemaKredit.value == "all_skema" && fCabang.value != "00"){
                totalKusuma += parseInt(item.Kusuma)
                totalPkpj += parseInt(item.PKPJ)
                totalKkb += parseInt(item.KKB)
                totalTalangan += parseInt(item.Umroh)
                totalProkesra += parseInt(item.Prokesra)
              }else if(fSkemaKredit.value == "all_skema" && fCabang.value == "00"){
                totalKusuma += parseInt(item.Kusuma)
                totalPkpj += parseInt(item.PKPJ)
                totalKkb += parseInt(item.KKB)
                totalTalangan += parseInt(item.Umroh)
                totalProkesra += parseInt(item.Prokesra)
              }
            });

            // Chart Skema dan Proses
            var totalSkema = totalKusuma + totalPkpj + totalKkb + totalTalangan + totalProkesra;
            chartSkemaKredit(totalKusuma, totalPkpj, totalKkb, totalTalangan, totalProkesra, totalSkema);
            var totalProses = prosesPincab + prosesPbp + prosesPbo + prosesPenyelia + prosesStaf;
            chartProsesSkemaKredit(prosesPincab, prosesPbp, prosesPbo, prosesPenyelia, prosesStaf, totalProses);

            // jika memilih skema dan semua cabang 
            // mengambil ranking dari sum skema
            if(fSkemaKredit.value != "all_skema" && fCabang.value == "00"){
              let rankTertinggi = response.ranking.tertinggi;
              let rankTerendah = response.ranking.terendah;

              $.map(rankTertinggi, function (item, index) {
                rankingTertinggi(index, item.cabang, item.kode_cabang, item.total);
              });
              $.map(rankTerendah, function (item, index) {
                rankingTerendah(index, item.cabang, item.kode_cabang, item.total);
              });

              console.log(rankTertinggi.length)
              console.log(rankTerendah.length)
            // if(rankTinggi.length < 0 || rankRendah.length < 0){
            //     emptyRanking('#ranking_terendah');
            //     emptyRanking('#ranking_tertinggi');
            // }else if(rankTinggi.length < 0){
            //     emptyRanking('#ranking_tertinggi');
            // }else if(rankTinggi.length < 0){
            //     emptyRanking('#ranking_terendah');
            // }

              // Total pengajuan
              $('#totalPengajuan').append(tDisetujui + tDitolak + totalProses);
              $('#disetujui').append(tDisetujui);
              $('#ditolak').append(tDitolak);
              $('#diproses').append(totalProses);
            }else if(fSkemaKredit.value != "all_skema" && fCabang.value != "00"){
              // Total pengajuan
              $('#totalPengajuan').append(tDisetujui + tDitolak + totalProses);
              $('#disetujui').append(tDisetujui);
              $('#ditolak').append(tDitolak);
              $('#diproses').append(totalProses);
            }

          }else{
            var dataTotal = response.data.total[0];
            var dataPosisi = response.data.posisi;
            var total = parseInt(dataTotal.Kusuma) + parseInt(dataTotal.PKPJ) + parseInt(dataTotal.KKB) + parseInt(dataTotal.Umroh) + parseInt(dataTotal.Prokesra);

            $.map(dataPosisi, function (item, i) {
              prosesPincab += parseInt(item.posisi_pincab);
              prosesPbp += parseInt(item.posisi_pbp);
              prosesPbo += parseInt(item.posisi_pbo);
              prosesPenyelia += parseInt(item.posisi_penyelia);
              prosesStaf += parseInt(item.posisi_staf);
            });

            var totalProses = prosesPincab + prosesPbp + prosesPbo + prosesPenyelia + prosesStaf;
            chartSkemaKredit(dataTotal.Kusuma, dataTotal.PKPJ, dataTotal.KKB, dataTotal.Umroh, dataTotal.Prokesra, total);
            chartProsesSkemaKredit(prosesPincab, prosesPbp, prosesPbo, prosesPenyelia, prosesStaf, totalProses);
          }
        }
      });
    }

    function emptyRanking(element) {
      $(element).append(`
        <div class="card border flex gap-4 p-2 w-full">
          <h2 class="">Data kosong.</h2>
        </div>
      `);
    }
    function rankingTertinggi(no, cabang, kode, total) { 
      return $('#ranking_tertinggi').append(`
        <div class="card border flex gap-4 p-2 w-full">
          <button class="px-5 py-2 rounded bg-green-400">
            <h2 class="text-lg font-bold text-white">${no + 1 }</h2>
          </button>
          <div class="content w-full">
            <h2 class="text-lg font-semibold text-theme-secondary">
              ${cabang}
            </h2>
            <p class="text-sm font-semibold text-gray-400">${kode}</p>
          </div>
          <div class="total pr-3">
            <h2 class="text-theme-secondary font-bold mt-3">${total}</h2>
          </div>
        </div>
      `);
    }

    function rankingTerendah(no, cabang, kode, total) {
      return $('#ranking_terendah').append(`
        <div class="card border flex gap-4 p-2 w-full">
          <button class="px-5 py-2 rounded bg-red-500">
            <h2 class="text-lg font-bold text-white">${no + 1 }</h2>
          </button>
          <div class="content w-full">
            <h2 class="text-lg font-semibold text-theme-secondary">
              ${cabang}
            </h2>
            <p class="text-sm font-semibold text-gray-400">${kode}</p>
          </div>
          <div class="total pr-3">
            <h2 class="text-theme-secondary font-bold mt-3">${total}</h2>
          </div>
        </div>
      `);
    }
}
</script>
@endpush


      