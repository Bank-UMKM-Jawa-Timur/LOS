@include('dagulir.master.kabupaten.modal.create')
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
        $('#page_length').on('change', function() {
            $('#form').submit()
        })
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Item
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Tambah item
                </h2>
            </div>
        </div>
        <div class="body-pages">
            <form action="{{ route('dagulir.master.master-item.store') }}" method="POST">
                @csrf
                <div class="p-5 bg-white w-full mt-8 border space-y-8">
                    <div class="form-group-4">
                        <div class="input-box">
                            <label for="">Level</label>
                            <select name="level" id="level" class="form-select">
                                <option value="0"> --- Pilih Level --- </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="input-box" id="itemTurunan1Div">
                            <label for="">Item Turunan 1</label>
                            <select name="item_turunan" id="itemTurunan1" class="select form-select">
                                <option value="0"> ---Pilih Turunan ---</option>
                            </select>
                        </div>
                        <div class="input-box" id="itemTurunan2Div">
                            <label for="">Item Turunan 2</label>
                            <select name="item_turunan_dua" id="itemTurunan2" class="select form-select">
                                <option value="0"> ---Pilih Turunan ---</option>
                            </select>
                        </div>
                        <div class="input-box" id="itemTurunan3Div">
                            <label for="">Item Turunan 3</label>
                            <select name="item_turunan_tiga" id="itemTurunan3" class="select form-select">
                                <option value="0"> ---Pilih Turunan ---</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-2">
                        <div class="input-box">
                            <label for="">Nama</label>
                            <input type="text" name="nama" class="form-input @error('nama') is-invalid @enderror"
                                placeholder="Nama Item" value="{{ old('nama') }}">
                            <div class="flex gap-2" id="komentar">
                                <input type="checkbox" name="is-comment" class="form-check" id="is-comment" />
                                <label for="is-comment">Dapat Dikomentari</label>
                            </div>
                        </div>
                        <div class="input-box" id="opsi_jawaban">
                            <label for="">Opsi Jawaban</label>
                            <select name="opsi_jawaban" id="opsi_jawaban"
                                class="form-select @error('opsi_jawaban') is-invalid @enderror">
                                <option value="kosong">Pilih Opsi Jawaban</option>
                                <option value="input text">Input Text</option>
                                <option value="option">Opsi</option>
                                <option value="number">Number</option>
                                <option value="persen">Persen</option>
                                <option value="long text">Long Text</option>
                                <option value="file">Upload File</option>
                            </select>
                            <div class="flex gap-2">
                                <input class="form-check" type="checkbox" value="1" id="status_skor"
                                    name="status_skor" checked>
                                <label for="status_skor">Perhitungan Skor</label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group-1">
                        <div class="w-full" id="opsi">
                            <table class="table opsi-jawaban w-full">
                                <thead>
                                    <tr>
                                        <th>Opsi</th>
                                        <th>Skor</th>
                                        {{-- <th>Kolom Turunan</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="id_opsi">
                                    @if (old('opsi') != '')
                                        @foreach (old('opsi') as $key => $value)
                                            <div class="countVar" data-count="{{ count(old('opsi')) }}"></div>
                                            <tr data-id={{ $key == 0 ? $key + 1 : $key }}>
                                                <td>
                                                    <div class="form-input">
                                                        {{-- <label>Opsi</label> --}}
                                                        <input type="text" id="opsi_name"
                                                            name="opsi[{{ $key }}][opsi_name]"
                                                            class="form-input @error('opsi.' . $key . '.opsi_name') is-invalid @enderror"
                                                            placeholder="Nama Opsi"
                                                            value="{{ old('opsi.' . $key . '.opsi_name') }}">
                                                        @error('opsi.' . $key . '.opsi_name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-input">
                                                        {{-- <label>Skor</label> --}}
                                                        <input type="number" id="skor" name="opsi[{{ $key }}][skor]"
                                                            class="form-input @error('opsi.' . $key . '.skor') is-invalid @enderror"
                                                            placeholder="Skor" value="{{ old('opsi.$key.skor') }}">
                                                        @error('opsi.' . $key . '.skor')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($key == 0)
                                                        <div class="flex gap-2 items-center">
                                                            <button class="btn-add plus" type="button">
                                                                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                                                            </button>
                                                            {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
                                                        </div>
                                                    @else
                                                        <div class="flex gap-2">
                                                            <button class="btn-add plus">
                                                                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                                                            </button>
                                                            <button class="btn-minus minus">
                                                                <iconify-icon icon="tabler:minus" class="mt-3"></iconify-icon>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <div id="countVar" data-count="0"></div>
                                        <tr data-id="1">
                                            <td>
                                                <div class="">
                                                    {{-- <label>Opsi</label> --}}
                                                    <input type="text" id="opsi_name" name="opsi[1][opsi_name]"
                                                        class="form-input " placeholder="Nama Opsi">
                                                    @error('opsi.1.opsi_name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="">
                                                    {{-- <label>Skor</label> --}}
                                                    <input type="number" id="skor" name="opsi[1][skor]"
                                                        class="form-input skor_option" placeholder="Skor">
                                                    @error('opsi.1.skor')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <div class="">
                                                    <label>Skor</label>
                                                    <input type="text" id="sub_column" name="opsi[1][sub_column]" class="form-input"
                                                        placeholder="Nama Kolom Turunan">
                                                    <span class="text-muted text-danger">*abaikan jika tidak terdapat kolom turunan</span>
                                                    @error('opsi.1.sub_column')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </td> --}}
                                            <td>
                                                <button class="btn-add plus" type="button">
                                                    <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="flex gap-5">
                            <a href="{{ route('dagulir.master.master-item.index') }}"
                                class="px-5 py-2 bg-white border rounded">
                                Batal
                            </a>
                            <button class="bg-theme-primary px-5 py-2 text-white rounded">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('script-inject')
    <script>
        $('#opsi').addClass('hidden');

        $("#level").change(function() {
            var id_level = $(this).val();
            if (id_level == "1") {
                $('#itemTurunan1Div').addClass("hidden");
                $('#itemTurunan2Div').addClass("hidden");
                $('#itemTurunan3Div').addClass("hidden");
                $('#komentar').addClass("hidden");
                $('#opsi_name').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#form_opsi').addClass("hidden");
                $('#dapat_dikomentari').addClass("hidden");
                $('#status_skor_item').addClass("hidden");
                $('#status_skor').attr('disabled', true);
                $('#opsi_jawaban').prop('disabled', true);
                $('#opsi_jawaban').addClass("hidden");
                $('#opsi').addClass("hidden");
                $('#item_turunan_tiga').addClass("hidden");
                $('#item_turunan_tiga').prop('disabled', true)
            }
            $('#opsi_jawaban').change(function(e) {
                e.preventDefault();
                let opsi_jawaban = $(`#opsi_jawaban`).find(":selected").val();
                if (opsi_jawaban == "option") {
                    $('#opsi').removeClass("hidden");
                    $('#status_skor_item').removeClass("hidden");
                    $('#status_skor').removeAttr('disabled');
                    $('#opsi_name').prop('disabled', false);
                    $('#skor').prop('disabled', false);
                } else {
                    $('#status_skor_item').addClass("hidden");
                    $('#status_skor').attr('disabled', true);
                    $('#opsi').addClass("hidden");
                    $('#opsi_name').prop('disabled', true);
                    $('#skor').prop('disabled', true);
                }
            })
            if (id_level == "2" || opsi_jawaban == "option") {
                $('#itemTurunan1Div').removeClass("hidden");
                $('#itemTurunan2Div').addClass("hidden");
                $('#itemTurunan3Div').addClass("hidden");
                $('#komentar').removeClass("hidden");
                $('#opsi').removeClass("hidden");
                $('#opsi_jawaban').removeClass("hidden");
                if (id_level == "2") {
                    turunanSatu(id_level)
                    addOption()
                } else {
                    $('#itemTurunan1').empty();
                }
            } else if (id_level == "3" || opsi_jawaban == "option") {
                $('#itemTurunan1Div').removeClass("hidden");
                $('#itemTurunan2Div').removeClass("hidden");
                $('#itemTurunan3Div').addClass("hidden");
                $('#komentar').removeClass("hidden");
                $('#opsi').removeClass("hidden");
                $('#opsi_jawaban').removeClass("hidden");
                turunanSatu(id_level);
                $('#itemTurunan1').change(function(e) {
                    e.preventDefault();
                    var id_turunan = $(this).val();
                    turunanDua(id_turunan);
                })
                addOption()
            } else if (id_level == "4" || opsi_jawaban == "option") {
                addOption();
                turunanSatu(id_level);
                $('#itemTurunan1Div').removeClass("hidden");
                $('#itemTurunan2Div').removeClass("hidden");
                $('#itemTurunan3Div').removeClass("hidden");
                $('#komentar').removeClass("hidden");
                $('#opsi').removeClass("hidden");
                $('#opsi_jawaban').removeClass("hidden");
                $('#itemTurunan1').change(function(e) {
                    e.preventDefault();
                    var id_turunan = $(this).val();
                    turunanDua(id_turunan)
                })
                $('#itemTurunan2').change(function(e) {
                    e.preventDefault();
                    var id_turunan = $(this).val();
                    console.log(id_turunan);
                    turunanTiga(id_turunan)
                })
            } else {
                $('#itemTurunan1').prop('disabled', false);
                $('#itemTurunan2').prop('disabled', false);
                $('#opsi_name').prop('disabled', false);
                $('#skor').prop('disabled', false);
                $('#opsi').removeClass("hidden");
                $('#form_opsi').removeClass("hidden");
                $('#dapat_dikomentari').removeClass("hidden");
                $('#status_skor_item').removeClass("hidden");
                $('#status_skor').removeAttr('disabled');
                $('#opsi_jawaban').prop('disabled', false);
            }
        });

        // tambah ajax 1
        function turunanSatu(id_level) {
            $.ajax({
                type: "GET",
                url: "{{ route('getItemSatu') }}?itemSatu=" + id_level,
                dataType: 'JSON',
                success: function(res) {
                    // console.log(res);
                    if (res) {
                        $('#itemTurunan1').empty();
                        $("#itemTurunan1").append('<option value="0">---Pilih Item Turunan---</option>');
                        $.each(res, function(nama, id) {
                            // console.log(res);
                            $("#itemTurunan1").append('<option value="' + id + '">' + nama +
                                '</option>');
                        });
                    } else {
                        $('#itemTurunan1').empty();
                    }
                }
            })
        }
        // ajax 2
        function turunanDua(id_turunan) {
            $.ajax({
                type: "GET",
                url: "{{ route('getItemTiga') }}?itemTiga=" + id_turunan,
                dataType: 'JSON',
                success: function(res) {
                    // console.log(res);
                    if (res) {
                        $('#itemTurunan2').empty();
                        $("#itemTurunan2").append('<option value="0">---Pilih Item Turunan---</option>');
                        $.each(res, function(nama, id) {
                            // console.log(res);
                            $("#itemTurunan2").append('<option value="' + id + '">' + nama +
                                '</option>');
                        });
                        // var count=Object.keys(res).length;
                        // for (let i = 0; i <= count; i++) {
                        //     $("#itemTurunan2").append('<option value="'+ res[i].id +'">'+res[i].level+". "+res[i].nama+'</option>');
                        // }
                    } else {
                        $('#itemTurunan2').empty();
                    }
                }
            })
        }
        // ajax 3
        function turunanTiga(id_turunan) {
            $.ajax({
                type: "GET",
                url: "{{ route('getItemEmpat') }}?itemEmpat=" + id_turunan,
                dataType: 'JSON',
                success: function(res) {
                    console.log(res);
                    if (res) {
                        $('#itemTurunan3').empty();
                        $("#itemTurunan3").append('<option value="0">---Pilih Item Turunan---</option>');
                        $.each(res, function(nama, id) {
                            // console.log(res);
                            $("#itemTurunan3").append('<option value="' + id + '">' + nama +
                                '</option>');
                        });
                    } else {
                        $('#itemTurunan3').empty();
                    }
                }
            })
        }

        function addOption() {
            $('body').on('click', '.plus', function() {
                var i = $("#opsi tr:last").data('id');
                i = i + 1;
                $('#id_opsi').append('<tr data-id="' + i + '">\
                            <td>\
                                <input type="text" id="id_opsi" name="opsi[' + i + '][opsi_name]" class="form-input" placeholder="Nama Opsi">\
                            </td>\
                            <td>\
                                <input type="number" id="skor" name="opsi[' + i + '][skor]" class="form-input skor_option" placeholder="Skor" >\
                                </td>\
                            <td class="">\
                                <div class="flex gap-2">\
                                    <button class="btn-add plus" type="button">\
                                        <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>\
                                    </button>\
                                    <button class="btn-minus minus" type="button">\
                                        <iconify-icon icon="tabler:minus" class="mt-3"></iconify-icon>\
                                    </button>\
                                </div>\
                            </td>\
                        </tr>');
            });
            $('body').on('click', '.minus', function() {
                $(this).closest('tr').remove();
            });
        }

        $('#status_skor').change(function(e) {
            if ($(this).is(":checked")) {
                $('.skor_option').removeAttr('readonly').removeClass("bg-gray-100");
            } else {
                $('.skor_option').val('');
                $('.skor_option').attr('readonly', true).addClass("bg-gray-100");
            }
            $('#status_skor').val($(this).is(':checked'));
        });
    </script>
@endpush
