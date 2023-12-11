@extends('layouts.tailwind-template')

@section('content')
    <section class="">
        <nav class="w-full bg-white p-3  top-[4rem] border sticky">
            <div class="owl-carousel owl-theme tab-wrapper">
                <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold">0% Dagulir</button>
                <button data-toggle="tab" data-tab="data-umum" class="btn btn-tab font-semibold">0% Data Umum</button>
                <button data-toggle="tab" data-tab="data-po" class="btn btn-tab font-semibold">0% Data PO</button>
                <button data-toggle="tab" data-tab="aspek-management" class="btn btn-tab  font-semibold">0% Aspek Management</button>
                <button data-toggle="tab" data-tab="aspek-hukum" class="btn btn-tab  font-semibold">0% Aspek Hukum</button>
                <button data-toggle="tab" data-tab="aspek-jaminan" class="btn btn-tab  font-semibold">0% Aspek Jaminan</button>
                <button data-toggle="tab" data-tab="aspek-teknis-dan-produksi" class="btn btn-tab  font-semibold">0% Aspek Teknis & Produksi</button>
                <button data-toggle="tab" data-tab="aspek-pemasaran" class="btn btn-tab  font-semibold">0% Aspek Pemasaran</button>
                <button data-toggle="tab" data-tab="aspek-keuangan" class="btn btn-tab  font-semibold">0% Aspek Keuangan</button>
                <button data-toggle="tab" data-tab="pendapat-dan-usulan" class="btn btn-tab  font-semibold">0% Pendapat dan usulan</button>
            </div>
            {{-- <button class="lg:hidden block absolute left-0 btn-owl top-2 bg-white z-40">
        <iconify-icon icon="uil:angle-left" class="transform mt-1 text-2xl"></iconify-icon>
    </button>
    <button class="lg:hidden block absolute right-5 btn-owl top-2 bg-white z-40">
        <iconify-icon icon="uil:angle-left" class="transform mt-1 rotate-180 text-2xl"></iconify-icon>
    </button> --}}
        </nav>
        <div class="p-3">
            <div class="body-pages">

                <div class="mt-3 container mx-auto ">
                    <div id="dagulir-tab" class="is-tab-content active">
                        @include('dagulir.pengajuan.dagulir')
                    </div>
                    <div id="data-umum-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.data-umum')
                    </div>
                    <div id="data-po-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.data-po')
                    </div>
                    <div id="aspek-management-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-management')
                    </div>
                    <div id="aspek-hukum-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-hukum')
                    </div>
                    <div id="aspek-jaminan-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-jaminan')
                    </div>
                    <div id="aspek-teknis-dan-produksi-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-teknis-dan-produksi')
                    </div>
                    <div id="aspek-pemasaran-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-pemasaran')
                    </div>
                    <div id="aspek-keuangan-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.aspek-keuangan')
                    </div>
                    <div id="pendapat-dan-usulan-tab" class="is-tab-content">
                        @include('dagulir.pengajuan.pendapat-dan-usulan')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
        // tab
        $(".tab-wrapper .btn-tab").click(function(e) {
            e.preventDefault();
            var tabId = $(this).data("tab");

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

            if ($nextContent.length) {
                $activeContent.removeClass("active");
                $nextContent.addClass("active");
            }
        });

        $(".prev-tab").on("click", function() {
            const $activeContent = $(".is-tab-content.active");
            const $prevContent = $activeContent.prev();

            if ($prevContent.length) {
                $activeContent.removeClass("active");
                $prevContent.addClass("active");
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
