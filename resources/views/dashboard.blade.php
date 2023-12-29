@extends('layouts.tailwind-template')
@include('dagulir.modal.filter-dashboard')
@section('modal')
@endsection
@section('content')
@if (auth()->user()->role == 'Administrator' || auth()->user()->role == 'Kredit Umum' || auth()->user()->role ==
'Direksi')
@include('dashboard.admin')
@else
@include('dashboard.dagulir')
@endif
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

    // var optionsPosisiPengajuan = {
    // series: [parseInt("{{ $dataPosisi->pincab }}"), parseInt("{{ $dataPosisi->pbp }}"), parseInt("{{ $dataPosisi->pbo }}"), parseInt("{{ $dataPosisi->penyelia }}"), parseInt("{{ $dataPosisi->staf }}"), parseInt("{{ $dataPosisi->disetujui }}"), parseInt("{{ $dataPosisi->ditolak }}")],
    // chart: {
    //     type: "donut",
    //     width: 400,
    // },
    // labels: ["Pincab", "PBP", "PBO", "Penyelia", "Staf", "Selesai", "Ditolak"],
    // colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF", "#25E76E","#FF3649"],
    // dataLabels: {
    //     enabled: false,
    // },
    // responsive: [
    //     {
    //     breakpoint: 480,
    //     options: {
    //         chart: {
    //             width: 200,
    //         },
    //         legend: {
    //             position: "bottom",
    //         },
    //     },
    //     },
    // ],
    // };

    // var donut1 = new ApexCharts(
    //     document.querySelector("#posisi-pengajuan"),
    //     optionsPosisiPengajuan
    // );
    // donut1.render();

    // var optionsSkemaKredit = {
    // series: [parseInt("{{ $dataSkema->PKPJ }}"), parseInt("{{ $dataSkema->KKB }}"), parseInt("{{ $dataSkema->Umroh }}"), parseInt("{{ $dataSkema->Prokesra }}"), parseInt("{{ $dataSkema->Kusuma }}"), parseInt("{{ $dataSkema->Dagulir }}")],
    // chart: {
    //     type: "donut",
    //     width: 400,
    // },
    // labels: ["PKPJ", "KKB", "Talangan", "Prokesra", "Kusuma", "Dagulir"],
    // colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9", "#F7C35C"],
    // dataLabels: {
    //     enabled: false,
    // },
    // responsive: [
    //     {
    //     breakpoint: 480,
    //     options: {
    //         chart: {
    //             width: 200,
    //         },
    //         legend: {
    //             position: "bottom",
    //         },
    //     },
    //     },
    // ],
    // };

    // var donut2 = new ApexCharts(
    //     document.querySelector("#skema-kredit"),
    //     optionsSkemaKredit
    // );
    // donut2.render();


    $('#btn-filter').on('click', function (e) {
        e.preventDefault()
        let tAwal = document.getElementById('tAwal');
        let tAkhir = document.getElementById('tAkhir');
        console.log(tAkhir.value);
        if ($("#form-filter")[0].checkValidity()){
            $('#form-filter').submit()
        }else{
            if(tAwal.value == "" && tAkhir.value == ""){
                $('#form-filter').submit()
            }else if(tAwal.value == ""){
                $("#reqAwal").show();
            }else if(tAkhir.value == ""){
                $("#reqAkhir").show();
            }else{
                $("#reqAkhir").hide();
                $("#reqAwal").hide();
            }
        }
    })

    $("#tAwal").on("change", function() {
        var result = $(this).val();
        if (result != null) {
            $("#tAkhir").prop("required", true)
        }
    });

    // var token = "gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj";
    // var cbgValue = '{{ Request()->query('cbg') }}';

    // $(document).ready(function() {
    //     $("#errorAkhir").hide();

    //     $.ajax({
    //         type: "GET",
    //         url: "/api/v1/get-cabang",
    //         headers: {
    //             'token': token,
    //         },
    //         success: function (response) {
    //             response.data.forEach(element => {
    //                 $('#cabang').append(
    //                     `<option value="${element.kode_cabang}" ${cbgValue == element.kode_cabang ? 'selected' : ''}>${element.cabang}</option>`
    //                 );
    //             });
    //         }
    //     });
    // })

    $("#tAkhir").on("change", function() {
        var tAkhir = $(this).val();
        var tAwal = $("#tAwal").val();
        if (Date.parse(tAkhir) < Date.parse(tAwal)) {
            $("#tAkhir").val('');
            $("#errorAkhir").show();
        } else {
            $("#errorAkhir").hide();
        }
    })

let dataSKemaKredit = {
    pkpj: parseInt("{{ $dataSkema->PKPJ }}"),
    kkb: parseInt("{{ $dataSkema->KKB }}"),
    talangan: parseInt("{{ $dataSkema->Umroh }}"),
    prokesra: parseInt("{{ $dataSkema->Prokesra }}"),
    kusuma: parseInt("{{ $dataSkema->Kusuma }}"),
    dagulir: parseInt("{{ $dataSkema->Dagulir }}"),

}
totalSkemaKredit = dataSKemaKredit.pkpj + dataSKemaKredit.kkb + dataSKemaKredit.talangan + dataSKemaKredit.prokesra + dataSKemaKredit.kusuma + dataSKemaKredit.dagulir;

let positionYSkema = totalSkemaKredit > 100 ? 40 : 55;

Highcharts.chart("skema-kredit", {
  chart: {
      type: "pie",
  },
  title: {
    verticalAlign: "middle",
    align: "center",
    y: positionYSkema,
      text: `<span class="font-bold font-poppins text-5xl flex">
                <p class="mt-[80%]">${isNaN(totalSkemaKredit) ? 0 : totalSkemaKredit}</p>
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
                  y: dataSKemaKredit.pkpj,
                  z: dataSKemaKredit.pkpj,
              },
              {
                  name: "KKB",
                  y: dataSKemaKredit.kkb,
                  z: dataSKemaKredit.kkb,
              },
              {
                  name: "Talangan",
                  y: dataSKemaKredit.talangan,
                  z: dataSKemaKredit.talangan,
              },
              {
                  name: "Prokesra",
                  y: dataSKemaKredit.prokesra,
                  z: dataSKemaKredit.prokesra,
              },
              {
                  name: "Kusuma",
                  y: dataSKemaKredit.kusuma,
                  z: dataSKemaKredit.kusuma,
              },
              {
                  name: "Dagulir",
                  y: dataSKemaKredit.dagulir,
                  z: dataSKemaKredit.dagulir,
              },
          ],
          colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9", "#F7C35C"],
      },
  ],
});




    let dataPosisi = {
        pincab: parseInt("{{ $dataPosisi->pincab }}"),
        pbp: parseInt("{{ $dataPosisi->pbp }}"),
        pbo: parseInt("{{ $dataPosisi->pbo }}"),
        penyelia: parseInt("{{ $dataPosisi->penyelia }}"),
        staf: parseInt("{{ $dataPosisi->staf }}"),
        disetujui: parseInt("{{ $dataPosisi->disetujui }}"),
        ditolak: parseInt("{{ $dataPosisi->ditolak }}"),
    };


    let totalPosisi = dataPosisi.pincab + dataPosisi.pbp + dataPosisi.pbo + dataPosisi.penyelia + dataPosisi.staf + dataPosisi.disetujui + dataPosisi.ditolak

    let positionY = totalPosisi > 100 ? 30 : totalPosisi < 10 ? 55 : 60;

Highcharts.chart("posisi-pengajuan", {
          chart: {
              type: "pie",
          },
          title: {
            verticalAlign: "middle",
            align: "center",
            y: positionY,
              text: `<span class="font-bold font-poppins text-5xl flex">
                        <p class="mt-[80%]">${isNaN(totalPosisi) ? 0 : totalPosisi}</p>
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
                          y: dataPosisi.pincab,
                          z: dataPosisi.pincab,
                      },
                      {
                          name: "PBP",
                          y: dataPosisi.pbp,
                          z: dataPosisi.pbp,
                      },
                      {
                          name: "PBO",
                          y: dataPosisi.pbo,
                          z: dataPosisi.pbo,
                      },
                      {
                          name: "Penyelia",
                          y: dataPosisi.penyelia,
                          z: dataPosisi.penyelia,
                      },
                      {
                          name: "Staf",
                          y: dataPosisi.staf,
                          z: dataPosisi.staf,
                      },
                      {
                          name: "Selesai",
                          y: dataPosisi.disetujui,
                          z: dataPosisi.disetujui,
                      },
                      {
                          name: "Ditolak",
                          y: dataPosisi.ditolak,
                          z: dataPosisi.ditolak,
                      },
                  ],
                  colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF", "#25E76E","#FF3649"],
              },
          ],
        });
    </script>
@endpush
