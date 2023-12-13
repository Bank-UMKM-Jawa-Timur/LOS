@extends('layouts.tailwind-template')

@section('content')
    <section class="">
        <nav class="w-full bg-white p-3  top-[4rem] border sticky">
            <div class="owl-carousel owl-theme tab-wrapper">
                <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold">Data Umum</button>
                @foreach ($items as $item)
                    @php
                        $title = str_replace('&', 'dan', strtolower($item->nama));
                        $title = str_replace(' ', '-', strtolower($title));
                    @endphp
                    <button data-toggle="tab" data-tab="{{$title}}" class="btn btn-tab font-semibold">{{$item->nama}}</button>
                @endforeach
                <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold">Pendapat dan Usulan</button>
            </div>
        </nav>
        <div class="p-3">
            <div class="body-pages">
                <form action="{{ route('dagulir.updateReviewPincab',$dagulir->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mt-3 container mx-auto ">
                        <div id="dagulir-tab" class="is-tab-content active">
                            @include('dagulir.pengajuan.review-dagulir', ['data' => $dagulir])
                        </div>
                        @foreach ($items as $item)
                            @php
                                $title_id = str_replace('&', 'dan', strtolower($item->nama));
                                $title_id = str_replace(' ', '-', strtolower($title_id));
                                $title_tab = "$title_id-tab";
                                $title_page = "dagulir.pengajuan.$title_id";
                                $id = $item->id;
                            @endphp
                            <div id="{{$title_tab}}" class="is-tab-content">
                                @include('dagulir.pengajuan.review-aspek', [
                                    'id_tab' => $title_id,
                                    'title' => $item->nama,
                                    'childs' => $item->childs,
                                    'id' => $id
                                ])
                            </div>
                        @endforeach
                        <div id="dagulir-tab" class="is-tab-content active">
                            @include('dagulir.pengajuan.pendapat-dan-usulan')
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
        $('#kabupaten').change(function() {
            var kabID = $(this).val();
            if (kabID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('') }}/getkecamatan?kabID=" + kabID,
                    dataType: 'JSON',
                    success: function(res) {
                           console.log(res);
                        if (res) {
                            $("#kecamatan").empty();
                            $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                            $.each(res, function(nama, kode) {
                                $('#kecamatan').append(`
                                    <option value="${kode}">${nama}</option>
                                `);
                            });

                            $('#kecamatan').trigger('change');
                        } else {
                            $("#kecamatan").empty();
                        }
                    }
                });
            } else {
                $("#kecamatan").empty();
            }
        });

        $('#kabupaten_domisili').change(function() {
            var kabID = $(this).val();
            if (kabID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('') }}/getkecamatan?kabID=" + kabID,
                    dataType: 'JSON',
                    success: function(res) {
                           console.log(res);
                        if (res) {
                            $("#kecamatan_domisili").empty();
                            $("#kecamatan_domisili").append('<option>---Pilih Kecamatan---</option>');
                            $.each(res, function(nama, kode) {
                                $('#kecamatan_domisili').append(`
                                    <option value="${kode}">${nama}</option>
                                `);
                            });

                            $('#kecamatan_domisili').trigger('change');
                        } else {
                            $("#kecamatan_domisili").empty();
                        }
                    }
                });
            } else {
                $("#kecamatan_domisili").empty();
            }
        });
        $('#kabupaten_usaha').change(function() {
            var kabID = $(this).val();
            if (kabID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('') }}/getkecamatan?kabID=" + kabID,
                    dataType: 'JSON',
                    success: function(res) {
                           console.log(res);
                        if (res) {
                            $("#kecamatan_usaha").empty();
                            $("#kecamatan_usaha").append('<option>---Pilih Kecamatan---</option>');
                            $.each(res, function(nama, kode) {
                                $('#kecamatan_usaha').append(`
                                    <option value="${kode}">${nama}</option>
                                `);
                            });

                            $('#kecamatan_usaha').trigger('change');
                        } else {
                            $("#kecamatan_usaha").empty();
                        }
                    }
                });
            } else {
                $("#kecamatan_usaha").empty();
            }
        });


        $('#tipe').on('change',function(e) {
            var tipe = $(this).val();
            console.log(typeof(tipe));
            if (tipe == '2' || tipe == "0" ) {
                $('#nama_pj').addClass('hidden');
            }else{
                $('#nama_pj').removeClass('hidden');
            }
        })
        $('.rupiah').keyup(function(e) {
            var input = $(this).val()
            $(this).val(formatrupiah(input))
        });
        function formatrupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
        // tab
        $(".tab-wrapper .btn-tab").click(function(e) {
            e.preventDefault();
            var tabId = $(this).data("tab");
            // console.log(tabId);

            $(".is-tab-content").removeClass("active");
            $(".tab-wrapper .btn-tab").removeClass(
                "active-tab"
            );
            $(".tab-wrapper .btn-tab").removeClass("active-tab");
            $(".tab-wrapper .btn-tab").removeClass("active-tab");
            $(".tab-wrapper .btn-tab").addClass("disable-tab");

            $(this).addClass("active-tab");
            // $(this).addClass("text-gray-600");

            if (tabId) {
                // $(this).removeClass("text-gray-400");
                // $(this).removeClass("text-gray-400");
                $(this).removeClass("disable-tab");
                $(this).removeClass("disable-tab");
            }

            $("#" + tabId + "-tab").addClass("active");
        });

        $(".next-tab").on("click", function(e) {
            const $activeContent = $(".is-tab-content.active");
            const $nextContent = $activeContent.next();

            console.log($nextContent.length);
            if ($nextContent.length) {
                $activeContent.removeClass("active");
                $nextContent.addClass("active");
            }else{
                $(".next-tab").addClass('hidden');
                $('.btn-simpan').removeClass('hidden')
            }

        });

        $(".prev-tab").on("click", function() {
            const $activeContent = $(".is-tab-content.active");
            const $prevContent = $activeContent.prev();

            if ($prevContent.length) {
                $activeContent.removeClass("active");
                $prevContent.addClass("active");
                $(".next-tab").rem('hidden');
                $('.btn-simpan').addClass('hidden')
            }
        });

        $(".toggle-side").click(function(e) {
            $('.sidenav').toggleClass('hidden')
        })
        $('.owl-carousel').owlCarousel({
            margin: 10,
            autoWidth: true,
            dots: false,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 5
                },
                1000: {
                    items: 10
                }
            }
        })

        $("#usaha").on("change", function() {
            if ($(this).val() == "tanah") {
                $("#tanah").removeClass("hidden");
                $("#kendaraan").addClass("hidden");
                $("#tanah-dan-bangunan").addClass("hidden");
                $("#form-tanah").removeClass("hidden");
                $("#form-kendaraan").addClass("hidden");
            } else if ($(this).val() == "kendaraan") {
                $("#tanah").addClass("hidden");
                $("#kendaraan").removeClass("hidden");
                $("#tanah-dan-bangunan").addClass("hidden");
                $("#form-tanah").addClass("hidden");
                $("#form-kendaraan").removeClass("hidden");
            } else if ($(this).val() == "tanah-dan-bangunan") {
                $("#tanah").addClass("hidden");
                $("#kendaraan").addClass("hidden");
                $("#tanah-dan-bangunan").removeClass("hidden");
                $("#form-tanah").removeClass("hidden");
                $("#form-kendaraan").addClass("hidden");
            } else {
                $("#form-tanah").addClass("hidden");
                $("#form-kendaraan").addClass("hidden");
                $("#tanah").addClass("hidden");
                $("#tanah-dan-bangunan").addClass("hidden");
                $("#kendaraan").addClass("hidden");
            }
        });
        $("#is-npwp").on("change", function() {
            if ($(this).is(":checked")) {
                $("#npwp").removeClass("hidden");
            } else {
                $("#npwp").addClass("hidden");
            }
        });
        $("#shm-check").on("change", function() {
            if ($(this).is(":checked")) {
                $("#no-shm-input").removeClass("disabled");
                $("#no-shm-input").prop("disabled", false);
            } else {
                $("#no-shm-input").addClass("disabled");
                $("#no-shm-input").prop("disabled", true);
            }
        });
        $("#shgb-check").on("change", function() {
            if ($(this).is(":checked")) {
                $("#no-shgb-input").removeClass("disabled");
                $("#no-shgb-input").prop("disabled", false);
            } else {
                $("#no-shgb-input").addClass("disabled");
                $("#no-shgb-input").prop("disabled", true);
            }
        });
        // petak
        $("#petak-check").on("change", function() {
            if ($(this).is(":checked")) {
                $("#no-petak-input").removeClass("disabled");
                $("#no-petak-input").prop("disabled", false);
            } else {
                $("#no-petak-input").addClass("disabled");
                $("#no-petak-input").prop("disabled", true);
            }
        });
        // ijin usaha
        $("#ijin-usaha").on("change", function() {
            if ($(this).val() == "nib") {
                $("#nib").removeClass("hidden");
                $("#npwp").removeClass("hidden");
                $("#have-npwp").addClass("hidden");
                $("#sku").addClass("hidden");
            } else if ($(this).val() == "sku") {
                $("#sku").removeClass("hidden");
                $("#have-npwp").removeClass("hidden");
                $("#npwp").addClass("hidden");
                $("#nib").addClass("hidden");
            } else {
                $("#nib").addClass("hidden");
                $("#sku").addClass("hidden");
                $("#npwp").addClass("hidden");
                $("#have-npwp").addClass("hidden");
            }
        });
        // npwp
        $("#is-npwp").on("change", function() {
            if ($(this).is(":checked")) {
                $("#npwp").removeClass("hidden");
            } else {
                $("#npwp").addClass("hidden");
            }
        });
    </script>
@endpush
