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
              Data Disetujui
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
            <p class="text-gray-500 text-sm tracking-tighter">Data Ditolak</p>
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
            <p class="text-gray-500 text-sm tracking-tighter">Data Diproses</p>
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
          <span>Data Pengajuan - <span class="date-pengajuan">{{date('Y')}}</span></span>
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
              <span class="date-rank">Ranking Cabang - <span class="date-ranking-cabang">{{date('M Y')}}</span></span>
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
            <div class="alert-empty border  gap-4 p-2 w-full hidden">
              <h2 class="">Tidak ada data di bulan ini.</h2>
            </div>
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
            Proses Kredit - <span class="date-proses-skema-kredit">{{date('M Y')}}</span>
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
            Skema Kredit - <span class="date-skema-kredit">{{date('M Y')}}</span>
          </h2>
        </div>
        <div class="flex justify-center lg:mt-0 mt-5">
          <div id="skema-kredit"></div>
        </div>
      </div>
    </div>
    </div>
  </section>
  
@endsection
@push('script-injection')
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

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

      function yearChartPengajuan(disetujui, ditolak, diproses, keseluruhan) {
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
              {
                  name: "Total Pengajuan",
                  data: [
                    keseluruhan.January, 
                    keseluruhan.February, 
                    keseluruhan.March, 
                    keseluruhan.April, 
                    keseluruhan.May, 
                    keseluruhan.June, 
                    keseluruhan.July, 
                    keseluruhan.August, 
                    keseluruhan.September, 
                    keseluruhan.October, 
                    keseluruhan.November, 
                    keseluruhan.December
                  ],
              },
          ],
          colors: ["#00FF61", "#DC3545", "#F7C35C", "#9334EA"],
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
      function chartProses(pincab, pbp, pbo, penyelia, staf, disetujui, ditolak, total) {

        let positionY = total > 100 ? 30 : 30;

        Highcharts.chart("posisi-pengajuan", {
          chart: {
              type: "pie",
          },
          title: {
              verticalAlign: "middle",
              align: "center",
              y: positionY,
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
          exporting: {
            buttons: {
                  contextButton: {
                    enabled: false
                  },
                }
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
                      {
                          name: "Disetujui",
                          y: disetujui,
                          z: disetujui,
                      },
                      {
                          name: "Ditolak",
                          y: ditolak,
                          z: ditolak,
                      },
                  ],
                  colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"],
              },
          ],
        });
      }

      function chartProsesSkemaKredit(pincab, pbp, pbo, penyelia, staf, total) { 

        $('#posisi-pengajuan').empty();

        let positionY = total > 100 ? 30 : 30;
        
        Highcharts.chart("posisi-pengajuan", {
          chart: {
              type: "pie",
          },
          title: {
            verticalAlign: "middle",
            align: "center",
            y: positionY,
              text: `<span class="font-bold font-poppins text-5xl flex">
                        <p class="mt-[80%]">${total}</p>
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
          exporting: {
              buttons: {
                  contextButton: {
                    enabled: false
                  },
                }
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

        let positionY = total > 100 ? 40 : 55;

        return Highcharts.chart("skema-kredit", {
          chart: {
              type: "pie",
          },
          title: {
            verticalAlign: "middle",
            align: "center",
            y: positionY,
              text: `<span class="font-bold font-poppins text-5xl flex">
                        <p class="mt-[80%]">${total}</p>
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
          exporting: {
              buttons: {
                  contextButton: {
                    enabled: false
                  },
                }
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

      var currentDate = new Date();
      var firstDateOfYear = "2023-01-01";
      var lastDateOfYear = "2023-12-31";

      var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
      var lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
      var formattedFirstDay = firstDayOfMonth.toISOString().split('T')[0]; 
      var formattedLastDay = lastDayOfMonth.toISOString().split('T')[0];
      var firstDate = dayjs().format('YYYY-MM');
      var yearNow = dayjs().format('YYYY');

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
      var url_sum_cabang = `api/v1/get-sum-cabang?tanggal_awal=${firstDate}-01&tanggal_akhir=${formattedLastDay}`;
      var url_count_year_pengajuan = `api/v1/get-count-year-pengajuan`;
      var url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${firstDate}-01&tanggal_akhir=${formattedLastDay}`;
      var url_count_pengajuan = "api/v1/get-count-pengajuan?tAwal="+yearNow+"-01-01&tAkhir="+lastDateOfYear

      $('#btnFilter').on('click', function () { 
        $('#ranking_tertinggi').empty()
        $('#ranking_terendah').empty()

        let tAwal = document.getElementById("tgl_awal");
        let tAkhir = document.getElementById("tgl_akhir");
        let fSkemaKredit = document.getElementById('skema-kredit-filter');
        let fCabang = document.getElementById("cabang-filter")
        var dateAwal = dayjs(tAwal.value).format('MMM');
        var dateAkhir = dayjs(tAkhir.value).format('MMM');
        var dateTahun = dayjs(tAwal.value).format('YYYY')

        $('.date-pengajuan').html(`(${dateAwal} - ${dateAkhir} ${dateTahun})`);
        $('.date-proses-skema-kredit').html(`(${dateAwal} - ${dateAkhir} ${dateTahun})`);
        $('.date-skema-kredit').html(`(${dateAwal} - ${dateAkhir}  ${dateTahun})`);
        $('.date-ranking-cabang').html(`(${dateAwal} - ${dateAkhir} ${dateTahun})`);

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
            getProses()

        if (tAwal.value != "" && tAkhir.value != "") {
            url_sum_cabang = `api/v1/get-sum-cabang?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}`;
            getDataPengajuan();

            if(fSkemaKredit.value != "all_skema" && fCabang.value != ""){
              // Pilih skeme & pilih cabang
              url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&skema=${fSkemaKredit.value}&cabang=${fCabang.value}`;

              $('#proses-skema-kredit').removeClass('hidden')
              $('#skema-kredit-layout').addClass('hidden')
              $('#ranking-cabang').addClass('hidden')
              $('#proses-layout').addClass('hidden')
            }else if(fSkemaKredit.value != "all_skema" && fCabang.value == ""){
              // Pilih skeme & semua cabang
              url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&skema=${fSkemaKredit.value}`;

              $('#proses-skema-kredit').removeClass('hidden')
              $('#skema-kredit-layout').addClass('hidden')
              $('#ranking-cabang').removeClass('hidden')
              $('#proses-layout').addClass('hidden')
            }else if(fSkemaKredit.value == "all_skema" && fCabang.value != ""){
              // semua skeme & pilih cabang
              url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}&cabang=${fCabang.value}`;

              $('#skema-kredit-layout').removeClass('hidden')
        
              $('#ranking-cabang').addClass('hidden')
              $('#proses-layout').removeClass('hidden')
              // di proses
              getProses();
            }else if(fSkemaKredit.value == "all_skema" && fCabang.value == ""){
              // semua skeme & semua cabang
              url_sum_skema = `api/v1/get-sum-skema?tanggal_awal=${tAwal.value}&tanggal_akhir=${tAkhir.value}`;
              url_count_pengajuan = `api/v1/get-count-pengajuan?tAwal=${tAwal.value}&tAkhir=${tAkhir.value}`;
              $('#skema-kredit-layout').removeClass('hidden')
              $('#ranking-cabang').removeClass('hidden')
              $('#proses-layout').addClass('hidden')
              pengajuanRanking();
            }

          }else{
            url_sum_cabang = `api/v1/get-sum-cabang?tanggal_awal=${firstDate}-01&tanggal_akhir=${formattedLastDay}`;
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

      getDataPengajuan()
      getDataPengajuanYear();
      pengajuanRanking();
      getSkema();
      getProses()
      // getDataPengajuanYear();
      // pengajuanRanking();
      // getSkema();
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
            // console.log(response)
            $('#chart-total-pengajuan').empty();
            yearChartPengajuan(response.data.data_disetujui, response.data.data_ditolak, response.data.data_diproses, response.data.data_keseluruhan)
          }
        });
      }

      function getDataPengajuan() {
        $('#totalPengajuan').empty()
        $('#disetujui').empty()
        $('#ditolak').empty()
        $('#diproses').empty()
        let tAwal = $('#tgl_awal').val() ? $('#tgl_awal').val() : firstDate + "-01" ;
        let tAkhir = $('#tgl_akhir').val() ? $('#tgl_akhir').val() : formattedLastDay;
        let skema = $('#skema-kredit-filter').val() ? $('#skema-kredit-filter').val() : ''
        var skemaParam = skema && skema != 'all_skema' ? `&skema=${skema}` : ''
        let fCabang = document.getElementById("cabang-filter");
        var cabangParam = fCabang.value ? `&cabang=${fCabang.value}` : ''
        url_count_pengajuan = "api/v1/get-count-pengajuan?tAwal="+yearNow+"-01-01&tAkhir="+lastDateOfYear+skemaParam+cabangParam

        console.log(`url_count_pengajuan : ${url_count_pengajuan}`)
        $.ajax({
          type: "GET",
          url: url_count_pengajuan,
          dataType: "json",
          headers: {
            "Content-Type": "application/json",
            "token": staticToken
          },
          success: function (response) {
            $('#totalPengajuan').html(parseInt(response.total_disetujui) + parseInt(response.total_ditolak) + parseInt(response.total_diproses));
            $('#disetujui').html(response.total_disetujui);
            $('#ditolak').html(response.total_ditolak);
            $('#diproses').html(response.total_diproses);
          }
        });
      }

      function getProses() {
        let tAwal = $('#tgl_awal').val() ? $('#tgl_awal').val() : firstDate + "-01" ;
        let tAkhir = $('#tgl_akhir').val() ? $('#tgl_akhir').val() : formattedLastDay;
        let skema = $('#skema-kredit-filter').val() ? $('#skema-kredit-filter').val() : ''
        let fSkemaKredit = document.getElementById('skema-kredit-filter');
        var skemaParam = skema && skema != 'all_skema' ? `&skema=${skema}` : ''
        let fCabang = document.getElementById("cabang-filter");
        var cabangParam = fCabang.value ? `&cabang=${fCabang.value}` : ''
        var url = `api/v1/get-posisi-pengajuan?tAwal=${tAwal}&tAkhir=${tAkhir}${cabangParam}${skemaParam}`
        console.log(`getproses: ${url}`)
        $.ajax({
          type: "GET",
          url: url,
          dataType: "json",
          headers: {
            "Content-Type": "application/json",
            "token": staticToken
          },
          success: function (response) {
            console.log('success proses')
            console.log(response)
            var data = response.data;
            var totalPenyelia = 0;
            var totalPincab = 0;
            var totalPBP = 0;
            var totalPBO = 0;
            var totalStaf = 0;
            var totalDisetujui = 0;
            var totalDitolak = 0;

            for(var i=0; i < data.length; i++) {
              totalPenyelia += data[i].penyelia ? parseInt(data[i].penyelia) : 0;
              totalPincab += data[i].pincab ? parseInt(data[i].pincab) : 0;
              totalPBP += data[i].pbp ? parseInt(data[i].pbp) : 0;
              totalPBO += data[i].pbo ? parseInt(data[i].pbo) : 0;
              totalStaf += data[i].staff ? parseInt(data[i].staff) : 0;
              totalDisetujui += data[i].disetujui ? parseInt(data[i].disetujui) : 0;
              totalDitolak += data[i].ditolak ? parseInt(data[i].ditolak) : 0;
            }
            
            if(fSkemaKredit.value == "all_skema" && fCabang.value != ""){
              console.log("JALANNNNNNNN!!!!!");
              var totalProses = totalPincab + totalPBP + totalPBO + totalPenyelia + totalStaf;
              $('#totalPengajuan').html(totalDisetujui + totalDitolak + totalProses);
              $('#disetujui').html(totalDisetujui);
              $('#ditolak').html(totalDitolak);
              $('#diproses').html(totalProses); 
            }

            var total = parseInt(totalPenyelia) + parseInt(totalPincab) + parseInt(totalPBP) + parseInt(totalPBO) + parseInt(totalStaf) + parseInt(totalDisetujui) + parseInt(totalDitolak);
            chartProses(totalPincab, totalPBP, totalPBO, totalPenyelia, totalStaf, totalDisetujui, totalDitolak, total);

          }
        });
      }

      function pengajuanRanking() {
        let tAwal = $('#tgl_awal').val() ? $('#tgl_awal').val() : firstDate + "-01";
        let tAkhir = $('#tgl_akhir').val() ? $('#tgl_akhir').val() : formattedLastDay;
        var url = `api/v1/get-ranking-cabang?tanggal_awal=${tAwal}&tanggal_akhir=${tAkhir}`
        
        $.ajax({
          type: "GET",
          url: url,
          dataType: "json",
          headers: {
            "Content-Type": "application/json",
            "token": staticToken
          },
          success: function (response) {
            var dataTertinggi = response.tertinggi;
            var dataTerendah = response.terendah;
            var totalCabang = response.total_cabang;
            var numberTerendah = parseInt(totalCabang) - 5
            
            if(dataTertinggi.length === 0 && dataTerendah.length === 0) {
              $('.alert-empty').removeClass('hidden')
            }else{
              $('.alert-empty').addClass('hidden')
            // Data ranking tertinggi
            $.map(dataTertinggi, function (item, index) {
              rankingTertinggi(index, item.cabang, item.kode_cabang, item.total);
            });

            // Data ranking terendah
            $.map(dataTerendah, function (item, index) {
              rankingTerendah(numberTerendah, item.cabang, item.kode_cabang, item.total);
              numberTerendah++;
            });
            }
          }
        });
      }

      function getSkema() {
        let tAwal = $('#tgl_awal').val() ? $('#tgl_awal').val() : firstDate + "-01" ;
        let tAkhir = $('#tgl_akhir').val() ? $('#tgl_akhir').val() : formattedLastDay;
        let fSkemaKredit = document.getElementById('skema-kredit-filter');
        let fCabang = document.getElementById("cabang-filter");
        
        // console.log('getskema')
        // console.log(`url_sum_skema:${url_sum_skema}`)
        $.ajax({
          type: "GET",
          url: url_sum_skema,
          headers: {
            "Content-Type": "application/json",
            "token": staticToken
          },
          success: function (response) {
            var data = response.data;
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
                if(fSkemaKredit.value != "all_skema" && fCabang.value != ""){
                  prosesPincab += parseInt(item.posisi_pincab);
                  prosesPbp += parseInt(item.posisi_pbp);
                  prosesPbo += parseInt(item.posisi_pbo);
                  prosesPenyelia += parseInt(item.posisi_penyelia);
                  prosesStaf += parseInt(item.posisi_staf);
                  tDisetujui += parseInt(item.total_disetujui);
                  tDitolak += parseInt(item.total_ditolak);
                }else if(fSkemaKredit.value != "all_skema" && fCabang.value == ""){
                  prosesPincab += parseInt(item.posisi_pincab);
                  prosesPbp += parseInt(item.posisi_pbp);
                  prosesPbo += parseInt(item.posisi_pbo);
                  prosesPenyelia += parseInt(item.posisi_penyelia);
                  prosesStaf += parseInt(item.posisi_staf);
                  tDisetujui += parseInt(item.total_disetujui);
                  tDitolak += parseInt(item.total_ditolak);
                }else if(fSkemaKredit.value == "all_skema" && fCabang.value != ""){
                  totalKusuma += parseInt(item.Kusuma)
                  totalPkpj += parseInt(item.PKPJ)
                  totalKkb += parseInt(item.KKB)
                  totalTalangan += parseInt(item.Umroh)
                  totalProkesra += parseInt(item.Prokesra)
                }else if(fSkemaKredit.value == "all_skema" && fCabang.value == ""){
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
              //chartProsesSkemaKredit(prosesPincab, prosesPbp, prosesPbo, prosesPenyelia, prosesStaf, totalProses);

              // jika memilih skema dan semua cabang 
              // mengambil ranking dari sum skema
              if(fSkemaKredit.value != "all_skema" && fCabang.value == ""){
                let rankTertinggi = response.ranking.tertinggi;
                let rankTerendah = response.ranking.terendah;
                $.map(rankTertinggi, function (item, index) {
                  rankingTertinggi(index, item.cabang, item.kode_cabang, item.total);
                });
                $.map(rankTerendah, function (item, index) {
                  rankingTerendah(index, item.cabang, item.kode_cabang, item.total);
                });

                // rankTertinggi.every(function (item, index) {
                //   if (item.total == 0) {
                //    emptyRanking('#ranking_tertinggi')
                //   }
                // });
                // rankTerendah.every(function (item, index) {
                //   if (item.total == 0) {
                //     emptyRanking('#ranking_terendah')
                //   }
                // });

                // Total pengajuan
              $('#totalPengajuan').html(tDisetujui + tDitolak + totalProses);
                $('#disetujui').html(tDisetujui);
                $('#ditolak').html(tDitolak);
                $('#diproses').html(totalProses); 
              }else if(fSkemaKredit.value != "all_skema" && fCabang.value != ""){
                // Total pengajuan
                $('#totalPengajuan').html(tDisetujui + tDitolak + totalProses);
                $('#disetujui').html(tDisetujui);
                $('#ditolak').html(tDitolak);
                $('#diproses').html(totalProses); 
              }

            }else{
              for(var i = 0; i < data.length; i++) {
                totalKusuma += data[i].Kusuma ? parseInt(data[i].Kusuma) : 0
                totalPkpj += data[i].PKPJ ? parseInt(data[i].PKPJ) : 0
                totalKkb += data[i].KKB ? parseInt(data[i].KKB) : 0
                totalProkesra += data[i].Prokesra ? parseInt(data[i].Prokesra) : 0
                totalTalangan += data[i].Umroh ? parseInt(data[i].Umroh) : 0
              }
              // console.log(`total pkpj : ${totalPkpj}`)
              // console.log(`total Kkb : ${totalKkb}`)
              // console.log(`total Talangan : ${totalTalangan}`)
              // console.log(`total Prokesra : ${totalProkesra}`)
              // console.log(`total Kusuma : ${totalKusuma}`)
              var dataTotal = totalPkpj + totalKkb + totalTalangan + totalProkesra + totalKusuma;
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
              chartSkemaKredit(totalKusuma, totalPkpj, totalKkb, totalTalangan, totalProkesra, dataTotal)
              //chartSkemaKredit(dataTotal.Kusuma != null ? dataTotal.Kusuma : 0, dataTotal.PKPJ != null ? dataTotal.PKPJ : 0, dataTotal.KKB != null ? dataTotal.KKB : 0, dataTotal.Umroh != null ? dataTotal.Umroh : 0, dataTotal.Prokesra != null ? dataTotal.Prokesra : 0, dataTotal.Prokesra != null ? total : 0);
              chartProsesSkemaKredit(prosesPincab, prosesPbp, prosesPbo, prosesPenyelia, prosesStaf, totalProses);
            }
          }
        });
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
              <p class="text-lg font-semibold text-gray-400">${kode}</p>
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
              <p class="text-lg font-semibold text-gray-400">${kode}</p>
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