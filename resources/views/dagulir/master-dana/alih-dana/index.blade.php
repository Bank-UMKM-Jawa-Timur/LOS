@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
    $(document).ready(function() {
        $('#page_length').on('change', function() {
            $('#form').submit();
        });

        $('.rupiah').on('input', function(e) {
            var input = $(this).val();
            $(this).val(formatrupiah(input));
        });

        $("#pesan").hide();

        $('#dari_cabang').on('change', function(params) {
            var dari = $(this).val();
            if (dari) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('master-dana.dari') }}",
                    data: {
                        id: dari
                    },
                    success: function(res) {
                        let dana_modal = res.dana_modal;
                        let dana_idle = res.dana_idle;
                        dana_dari_sebelum(dana_modal,dana_idle);
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('master-dana.lawan') }}",
                    dataType: 'JSON',
                    data: {
                        id: dari
                    },
                    success: function(res) {
                        if (res.length > 0) {
                            $("#ke_cabang").empty();
                            $("#ke_cabang").append('<option>---Pilih Cabang---</option>');

                            $.each(res, function(index, cabang) {
                                $('#ke_cabang').append(`
                                    <option value="${cabang.id}">${cabang.cabang}</option>
                                `);
                            });

                            $('#ke_cabang').trigger('change');
                        } else {
                            $("#ke_cabang").empty();
                        }
                    }
                });
            }
        });

        $('#ke_cabang').on('change', function(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('master-dana.ke') }}",
                data: {
                    id: $(this).val(),
                },
                success: function(res) {
                    let dana_modal_ke = res.dana_modal;
                    let dana_idle_ke = res.dana_idle;
                    dana_ke_sebelum(dana_modal_ke,dana_idle_ke);
                }
            });
        });

        $('#jumlah_dana').on('keyup', function() {
            hitung();
        });

        function dana_dari_sebelum(modal, idle) {
            $('#dana_modal_sebelum_dari').val(modal);
            $('#dana_idle_sebelum_dari').val(idle);

            var dana_modal_sebelum_dari = document.getElementById("dana_modal_sebelum_dari");
            dana_modal_sebelum_dari.value = formatrupiah(dana_modal_sebelum_dari.value);

            var dana_idle_sebelum_dari = document.getElementById("dana_idle_sebelum_dari");
            dana_idle_sebelum_dari.value = formatrupiah(dana_idle_sebelum_dari.value);
        }

        function dana_ke_sebelum(modal, idle) {
            $('#dana_modal_sebelum_ke').val(modal);
            var dana_modal_sebelum_ke = document.getElementById("dana_modal_sebelum_ke");
            dana_modal_sebelum_ke.value = formatrupiah(dana_modal_sebelum_ke.value);
            $('#dana_idle_sebelum_ke').val(idle);
            var dana_idle_sebelum_ke = document.getElementById("dana_idle_sebelum_ke");
            dana_idle_sebelum_ke.value = formatrupiah(dana_idle_sebelum_ke.value);
        }
        // get total
        function hitung() {
            let jumlah = isNaN(parseInt($('#jumlah_dana').val().replace(/\./g, ''))) ? 0 : parseInt($('#jumlah_dana').val().replace(/\./g, ''));
            // dana dari
            let dana_sebelum = isNaN(parseInt($('#dana_modal_sebelum_dari').val().replace(/\./g, ''))) ? 0 : parseInt($('#dana_modal_sebelum_dari').val().replace(/\./g, ''))
            let dana_sebelum_idle = isNaN(parseInt($('#dana_idle_sebelum_dari').val().replace(/\./g, ''))) ? 0 : parseInt($('#dana_idle_sebelum_dari').val().replace(/\./g, ''))
            // dana ke
            let dana_sebelum_ke = isNaN(parseInt($('#dana_modal_sebelum_ke').val().replace(/\./g, ''))) ? 0 : parseInt($('#dana_modal_sebelum_ke').val().replace(/\./g, ''))
            let dana_sebelum_ke_idle = isNaN(parseInt($('#dana_idle_sebelum_ke').val().replace(/\./g, ''))) ? 0 : parseInt($('#dana_idle_sebelum_ke').val().replace(/\./g, ''))
            // hitung
            // dari
            let total_dana_modal_dari = dana_sebelum - jumlah;
            let total_dana_idle_dari = dana_sebelum_idle - jumlah;
            // ke
            let total_dana_modal_ke = jumlah + dana_sebelum_ke;
            let total_dana_idle_ke = jumlah + dana_sebelum_ke_idle;
            if (total_dana_modal_dari < 0) {
                $("#pesan").show();
                $('#dana_modal_setelah_dari').val(total_dana_modal_dari);
                $('#dana_idle_setelah_dari').val(total_dana_idle_dari);
                $('#dana_modal_setelah_ke').val(0);
                $('#dana_idle_setelah_ke').val(0);
                var dana_modal_setelah_dari = document.getElementById("dana_modal_setelah_dari");
                dana_modal_setelah_dari.value = formatrupiah(dana_modal_setelah_dari.value);
                var dana_idle_setelah_dari = document.getElementById("dana_idle_setelah_dari");
                dana_idle_setelah_dari.value = formatrupiah(dana_idle_setelah_dari.value);
                $('#total_idle_setelah').addClass('hidden');
                $('#total_modal_setelah').addClass('hidden');
                $('#pesan_dana').removeClass('hidden');
            }else{
                $("#pesan").hide();
                $('#dana_modal_setelah_dari').val(total_dana_modal_dari);
                $('#dana_idle_setelah_dari').val(total_dana_idle_dari);
                $('#dana_modal_setelah_ke').val(total_dana_modal_ke);
                $('#dana_idle_setelah_ke').val(total_dana_idle_ke);

                var dana_modal_setelah_dari = document.getElementById("dana_modal_setelah_dari");
                dana_modal_setelah_dari.value = formatrupiah(dana_modal_setelah_dari.value);
                var dana_idle_setelah_dari = document.getElementById("dana_idle_setelah_dari");
                dana_idle_setelah_dari.value = formatrupiah(dana_idle_setelah_dari.value);
                var dana_modal_setelah_ke = document.getElementById("dana_modal_setelah_ke");
                dana_modal_setelah_ke.value = formatrupiah(dana_modal_setelah_ke.value);
                var dana_idle_setelah_ke = document.getElementById("dana_idle_setelah_ke");
                dana_idle_setelah_ke.value = formatrupiah(dana_idle_setelah_ke.value);

                $('#total_idle_setelah').removeClass('hidden');
                $('#total_modal_setelah').removeClass('hidden');
                $('#pesan_dana').addClass('hidden');
            }

        }

        function total(jumlah) {
            let total_ke = parseInt($('#dana_ke').val().replace(/\./g, ''));
            console.log(total_ke);
            let total_akhir = jumlah + total_ke;

            $('#total_dana').val(total_akhir);

            var total_dana = document.getElementById("total_dana");
            total_dana.value = formatrupiah(total_dana.value);
        }

         // formatrupiah();
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
    });
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Dana Dagulir
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Alih Dana Dagulir
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5">

            </div>
        </div>
        <div class="body-pages">
            <div class="table-wrapper border bg-white mt-8">
                <form action="{{ route('master-dana.alih-dana.post') }}" method="POST">
                    @csrf
                    <div class="p-5 w-full space-y-5">
                        <div class="form-group-2 mb-4">

                            <div class="input-box">
                                <label for="">Dari</label>
                                <select name="cabang_dari" id="dari_cabang" class="form-select">
                                    <option value="0">Pilih Cabang</option>
                                    @foreach ($cabang as $item)
                                        <option value="{{ $item->cabang->id }}">{{ $item->cabang->cabang }}</option>
                                    @endforeach
                                </select>
                                @error('dana_idle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label for="">Tujuan</label>
                                <select name="cabang_ke" id="ke_cabang" class="form-select">
                                    <option value="0">Pilih Cabang</option>
                                </select>
                                @error('dana_modal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex flex-nowrap align-middle items-center w-full">
                            <div class="flex-initial w-64">
                                <small class="text-xs font-bold text-red-500">Sebelum Alihkan Dana </small>

                            </div>
                            <div class="w-full">
                                <hr class="w-full h-px my-8 mx-2 border-0 bg-gray-200">
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="input-box">
                                <label for="">Dana Modal</label>
                                <input type="text" name="dana_modal_sebelum_dari"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_modal_sebelum_dari"
                                    readonly
                                >
                            </div>
                            <div class="input-box">
                                <label for="">Dana Modal</label>
                                <input type="text" name="dana_modal_sebelum_ke"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_modal_sebelum_ke"
                                    readonly
                                >
                            </div>
                        </div>
                        <div class="form-group-2 mb-4">
                            <div class="input-box">
                                <label for="">Dana Idle</label>
                                <input type="text" name="dana_idle_sebelum_dari"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_idle_sebelum_dari"
                                    readonly
                                >
                            </div>
                            <div class="input-box">
                                <label for="">Dana Idle</label>
                                <input type="text" name="dana_idle_sebelum_ke"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_idle_sebelum_ke"
                                    readonly
                                >
                            </div>
                        </div>
                        <hr>
                        <div class="form-group-1">
                            <div class="input-box">
                                <label for="">Dana Yang Dipindahkan</label>
                                <input type="text" name="jumlah_dana"
                                    class="form-input @error('jumlah_dana') is-invalid @enderror rupiah" placeholder="Masukkan Nominal Dana"
                                    id="jumlah_dana"
                                    value="{{ old('jumlah_dana') }}">
                                @error('jumlah_dana')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div id="pesan">
                                    <small class="text-red-400">Maaf dana tidak mencukupi</small>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-nowrap align-middle items-center w-full">
                            <div class="flex-initial w-64">
                                <small class="text-xs font-bold text-red-500">Setelah Alihkan Dana </small>

                            </div>
                            <div class="w-full">
                                <hr class="w-full h-px my-8 mx-2 border-0 0 bg-gray-200">
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="input-box">
                                <label for="">Dana Modal</label>
                                <input type="text" name="dana_modal_setelah_dari"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_modal_setelah_dari"
                                    readonly
                                >
                            </div>
                            <div class="input-box" id="total_modal_setelah">
                                <label for="">Dana Modal</label>
                                <input type="text" name="dana_modal_setelah_ke"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_modal_setelah_ke"
                                    readonly
                                >
                            </div>
                            <div class="align-top mt-10 hidden" id="pesan_dana">
                                <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                      <span class="font-medium">Peringatan!</span> Dana tidak mencukupi.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2 mb-4">
                            <div class="input-box">
                                <label for="">Dana Idle</label>
                                <input type="text" name="dana_idle_setelah_dari"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_idle_setelah_dari"
                                    readonly
                                >
                            </div>
                            <div class="input-box" id="total_idle_setelah">
                                <label for="">Dana Idle</label>
                                <input type="text" name="dana_idle_setelah_ke"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_idle_setelah_ke"
                                    readonly
                                >
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-end p-3">
                        <div class="mx-2">
                            <button type="reset" class="px-5 py-2 border rounded bg-white text-gray-500" >Batal</button>
                        </div>
                        <div class="">
                            <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
