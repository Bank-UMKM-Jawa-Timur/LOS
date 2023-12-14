@extends('layouts.tailwind-template')

@section('content')
    <section class="">
        <nav class="w-full bg-white p-3  top-[4rem] border sticky">
            <div class="owl-carousel owl-theme tab-wrapper">
                <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold">0% Data Umum</button>
                @foreach ($items as $item)
                    @php
                        $title = str_replace('&', 'dan', strtolower($item->nama));
                        $title = str_replace(' ', '-', strtolower($title));
                    @endphp
                    <button data-toggle="tab" data-tab="{{$title}}" class="btn btn-tab font-semibold">0% {{$item->nama}}</button>
                @endforeach
                <button data-toggle="tab" data-tab="pendapat-dan-usulan" class="btn btn-tab font-semibold">Pendapat dan Usulan</button>
            </div>
        </nav>
        <div class="p-3">
            <div class="body-pages">
                <form action="{{ route('dagulir.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mt-3 container mx-auto ">
                        <div id="dagulir-tab" class="is-tab-content active">
                            @include('dagulir.pengajuan.create-dagulir')
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
                                @include('dagulir.pengajuan.create-aspek', [
                                    'id_tab' => $title_id,
                                    'id_aspek' => $item->id,
                                    'title' => $item->nama,
                                    'id' => $id,
                                    'childs' => $item->childs
                                ])
                            </div>
                        @endforeach
                        <div id="pendapat-dan-usulan-tab" class="is-tab-content">
                            <div class="pb-10 space-y-3">
                                <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Pendapat dan Usulan</h2>
                            </div>
                            <div class="self-start bg-white w-full border">
                                <div class="p-5 border-b">
                                  <h2 class="font-bold text-lg tracking-tighter">
                                    Pendapat dan Usulan
                                  </h2>
                                </div>
                                <!-- pendapat-dan-usulan -->
                                <div class="p-5 space-y-5">
                                  <div class="form-group-1">
                                    <div class="input-box">
                                      <label for="">Pendapat dan Usulan</label>
                                      <textarea
                                        name="pendapat"
                                        class="form-textarea"
                                        placeholder="Pendapat dan Usulan"
                                        id=""
                                      ></textarea>
                                    </div>
                                  </div>
                                  <div class="flex justify-between">
                                    <button
                                      class="px-5 py-2 border rounded bg-white text-gray-500"
                                    >
                                      Kembali
                                    </button>
                                    <div>
                                      <button
                                        class="px-5 py-2 border rounded bg-theme-secondary text-white"
                                      >
                                        Sebelumnya
                                      </button>
                                      <button
                                        class="px-5 py-2 border rounded bg-theme-primary text-white"
                                        type="submit"
                                      >
                                        Simpan
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
        // Start Validation
         @if (count($errors->all()))
            Swal.fire({
                icon: 'error',
                title: 'Error Validation',
                html: `
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                @foreach ($errors->all() as $error)
                <ul>
                    <li>{{ $error }}</li>
                </ul>
                @endforeach
            </div>
            `
            });
        @endif

        $(".btn-simpan").on('click', function(e) {
            if ($('#pendapat_usulan').val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Field Pendapat dan usulan harus diisi"
                })
                e.preventDefault()
            }
        })

        // End Validation


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

        $('#status_nasabah').on('change', function(e){
            var status = $(this).val();
            // console.log(status);
            if (status == 2) {
                $('#label-ktp-nasabah').empty();
                $('#label-ktp-nasabah').html('Foto KTP Nasabah');
                $('#nik_pasangan').removeClass('hidden');
                $('#ktp-pasangan').removeClass('hidden');
            } else {
                $('#label-ktp-nasabah').empty();
                $('#label-ktp-nasabah').html('Foto KTP Nasabah');
                $('#nik_pasangan').addClass('hidden');
                $('#ktp-pasangan').addClass('hidden');
            }
        })

        $('#tipe').on('change',function(e) {
            var tipe = $(this).val();
            console.log(tipe);
            if (tipe == '2' || tipe == "0" ) {
                $('#nama_pj').addClass('hidden');
                $('#tempat_berdiri').addClass('hidden');
                $('#tanggal_berdiri').addClass('hidden');
            }else{
                $('#nama_pj').removeClass('hidden');
                $('#tempat_berdiri').removeClass('hidden');
                $('#tanggal_berdiri').removeClass('hidden');
                //badan usaha
                if (tipe == '3') {
                    $('#label_pj').html('Nama penanggung jawab');
                    $('#input_pj').attr('placeholder', 'Masukkan Nama Penanggung Jawab');
                }
                // perorangan
                else if (tipe == '4') {
                    $('#label_pj').html('Nama ketua');
                    $('#input_pj').attr('placeholder', 'Masukkan Nama Ketua');
                }
            }
        })

        function validatePhoneNumber(input) {
            var phoneNumber = input.value.replace(/\D/g, '');

            if (phoneNumber.length > 15) {
                phoneNumber = phoneNumber.substring(0, 15);
            }

            input.value = phoneNumber;
        }

        function validateNIK(input) {
            var nikNumber = input.value.replace(/\D/g, '');

            if (nikNumber.length > 16) {
                nikNumber = nikNumber.substring(0, 16);
            }

            input.value = nikNumber;
        }

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
            console.log($(this).val());
            if ($(this).val() == "nib") {
                $("#nib").removeClass("hidden");
                $("#label-nib").removeClass("hidden");
                $("#dokumen-nib").removeClass("hidden");
                $("#label-dokumen-nib").removeClass("hidden");
                $("#npwp").removeClass("hidden");
                $("#label-npwp").removeClass("hidden");
                $("#dokumen-npwp").removeClass("hidden");
                $("#label-dokumen-npwp").removeClass("hidden");
                $("#have-npwp").addClass("hidden");
                $("#surat-keterangan-usaha").addClass("hidden");
                $("#label-surat-keterangan-usaha").addClass("hidden");
                $("#dokumen-surat-keterangan-usaha").addClass("hidden");
                $("#label-dokumen-surat-keterangan-usaha").addClass("hidden");
            } else if ($(this).val() == "sku") {
                $("#surat-keterangan-usaha").removeClass("hidden");
                $("#label-surat-keterangan-usaha").removeClass("hidden");
                $("#label-dokumen-surat-keterangan-usaha").removeClass("hidden");
                $("#dokumen-surat-keterangan-usaha").removeClass("hidden");
                $("#have-npwp").removeClass("hidden");
                $("#npwp").addClass("hidden");
                $("#label-npwp").addClass("hidden");
                $("#label-dokumen-npwp").addClass("hidden");
                $("#dokumen-npwp").addClass("hidden");
                $("#label-nib").addClass("hidden");
                $("#nib").addClass("hidden");
                $("#label-dokumen-nib").addClass("hidden");
                $("#dokumen-nib").addClass("hidden");
            } else {
                $("#surat-keterangan-usaha").addClass("hidden");
                $("#label-surat-keterangan-usaha").addClass("hidden");
                $("#label-dokumen-surat-keterangan-usaha").addClass("hidden");
                $("#dokumen-surat-keterangan-usaha").addClass("hidden");
                $("#nib").addClass("hidden");
                $("#label-nib").addClass("hidden");
                $("#dokumen-nib").addClass("hidden");
                $("#label-dokumen-nib").addClass("hidden");
                $("#npwp").addClass("hidden");
                $("#label-npwp").addClass("hidden");
                $("#dokumen-npwp").addClass("hidden");
                $("#label-dokumen-npwp").addClass("hidden");
                $("#have-npwp").addClass("hidden");
                $("#sku").addClass("hidden");
                $("#label-sku").addClass("hidden");
                $("#dokumen-sku").addClass("hidden");
                $("#label-dokumen-sku").addClass("hidden");
            }
        });
        // npwp
        $("#is-npwp").on("change", function() {
            if ($(this).is(":checked")) {
                $("#npwp").removeClass("hidden");
                $("#label-npwp").removeClass("hidden");
                $("#dokumen-npwp").removeClass("hidden");
                $("#label-dokumen-npwp").removeClass("hidden");
            } else {
                $("#npwp").addClass("hidden");
                $("#label-npwp").addClass("hidden");
                $("#dokumen-npwp").addClass("hidden");
                $("#label-dokumen-npwp").addClass("hidden");
            }
        });

        $(document).on('click', '.btn-add', function() {
            const item_id = $(this).data('item-id');
            var item_element = $(`.${item_id}`)
            var iteration = item_element.length
            var input = $(this).closest('.input-box')
            var multiple = input.find('.multiple-action')
            var new_multiple = multiple.html().replaceAll('hidden', '')
            input = input.html().replaceAll(multiple.html(), new_multiple);
            var parent = $(this).closest('.input-box').parent()
            parent.append(`<div class="input-box">${input}`)
        })

        $(document).on('click', '.btn-minus', function() {
            const item_id = $(this).data('item-id');
            var item_element = $(`#${item_id}`)
            var parent = $(this).closest('.input-box')
            parent.remove()
        })
    </script>
@endpush
