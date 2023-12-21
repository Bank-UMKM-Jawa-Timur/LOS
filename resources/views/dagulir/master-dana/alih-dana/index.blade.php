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
                        console.log(res);
                        $('#dana_dari').val(formatrupiah(res));
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
                        console.log(res);

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
                    console.log(res);
                    $('#dana_ke').val(formatrupiah(res));
                }
            });
        });

        $('#jumlah_dana_dari').on('input', function() {
            hitung();
        });

        // get total
        function hitung() {
            let total_tersedia = parseInt($('#dana_dari').val().replace(/\./g, ''));
            let jumlah = isNaN(parseInt($('#jumlah_dana_dari').val().replace(/\./g, ''))) ? 0 : parseInt($('#jumlah_dana_dari').val().replace(/\./g, ''));

            console.log(`${total_tersedia} - ${jumlah}`);

            if (total_tersedia < jumlah) {
                $("#pesan").show();
                setTimeout(function() {
                    $("#pesan").hide();
                }, 5000);
            } else {
                total(jumlah);
                $("#pesan").hide();
            }
        }

        function total(jumlah) {
            let total_ke = parseInt($('#dana_ke').val().replace(/\./g, ''));
            let total_akhir = jumlah + total_ke;

            $('#total_dana').val(total_akhir);

            var total_dana = document.getElementById("total_dana");
            total_dana.value = formatrupiah(total_dana.value);

        }
        function formatrupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
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
                        <div class="form-group-2 mb-4">
                            <div class="input-box hidden">
                                <label for="">Dana yang tersedia</label>
                                <input type="text" name="dana_dari"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_dari"
                                    readonly
                                >
                                <span id="eror"></span>
                            </div>
                            <div class="input-box hidden">
                                <label for="">Dana yang tersedia</label>
                                <input type="text" name="dana_ke"
                                    class="form-input bg-gray-100 rupiah" placeholder="Dana yang tersedia"
                                    id="dana_ke"
                                    readonly
                                >
                            </div>
                            <div class="input-box">
                                <label for="">Jumlah</label>
                                <input type="text" name="dana_idle"
                                    class="form-input @error('jumlah_dana_dari') is-invalid @enderror rupiah" placeholder="Jumlah Dana"
                                    id="jumlah_dana_dari"
                                    value="{{ old('jumlah_dana_dari') }}">
                                @error('jumlah_dana_dari')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div id="pesan">
                                    <small class="text-red-400">Maaf dana tidak mencukupi</small>
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="">Total Dana</label>
                                <input type="text" name="total_dana"
                                    class="form-input bg-gray-100 @error('total_dana') is-invalid @enderror rupiah" placeholder="Total Dana"
                                    id="total_dana"
                                    readonly
                                    value="{{ old('total_dana') }}">
                                @error('total_dana')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <div class="mx-2">
                            <button type="reset" class="px-5 py-2 border rounded bg-white text-gray-500" >Batal</button>
                        </div>
                        <div>
                            <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white">update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
