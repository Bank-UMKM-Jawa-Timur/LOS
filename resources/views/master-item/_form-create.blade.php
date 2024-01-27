<form action="{{ route('master-item.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-3">
            <label>Level</label>
            <select name="level" id="level" class="form-control">
                <option value="0"> --- Pilih Level --- </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Item Turunan 1</label>
            <select name="item_turunan" id="itemTurunan1" class="select form-control">
                <option value="0"> ---Pilih Turunan ---</option>
                {{-- @foreach ($itemsatu as $item)
                <option value="{{ $item->id }}">{{ $item->id.'. '.$item->nama }}</option>
               @endforeach --}}
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Item Turunan 2</label>
            <select name="item_turunan_dua" id="itemTurunan2" class="select form-control">
                <option value="0"> ---Pilih Turunan ---</option>
            </select>
        </div>
        <div class="form-group col-md-3" id="item_turunan_tiga">
            <label>Item Turunan 3</label>
            <select name="item_turunan_tiga" id="itemTurunan3" class="select form-control">
                <option value="0"> ---Pilih Turunan ---</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                placeholder="Nama Item" value="{{ old('nama') }}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group col-md-6" id="form_opsi">
            <label>Opsi Jawaban</label>
            <select name="opsi_jawaban" id="opsi_jawaban"
                class="form-control @error('opsi_jawaban') is-invalid @enderror">
                <option value="kosong">Pilih Opsi Jawaban</option>
                <option value="input text">Input Text</option>
                <option value="option">Opsi</option>
                <option value="number">Number</option>
                <option value="persen">Persen</option>
                <option value="long text">Long Text</option>
                <option value="file">Upload File</option>
            </select>
            {{-- <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}"> --}}
            @error('opsi_jawaban')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>
        <div class="form-group col-md-6" id="dapat_dikomentari">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="is_commentable" name="is_commentable">
                <label class="form-check-label" for="is_commentable">
                    Dapat Dikomentari
                </label>
            </div>
            {{-- <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}"> --}}
            @error('is_commentable')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

        <div class="form-group col-md-6" id="status_skor_item">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="status_skor" name="status_skor" checked>
                <label class="form-check-label" for="status_skor">
                    Perhitungan Skor
                </label>
            </div>
            {{-- <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}"> --}}
            @error('status_skor')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

    </div>
    <hr>
    <div id="opsi" class="w-full">
        <p><strong>Opsi atau Jawaban</strong></p>
        <table class="table opsi-jawaban">
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
                                <div class="form-group col-md-12">
                                    {{-- <label>Opsi</label> --}}
                                    <input type="text" id="opsi_name" name="opsi[{{ $key }}][opsi_name]"
                                        class="form-control @error('opsi.' . $key . '.opsi_name') is-invalid @enderror"
                                        placeholder="Nama Opsi" value="{{ old('opsi.' . $key . '.opsi_name') }}">
                                    @error('opsi.' . $key . '.opsi_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <div class="form-group col-md-12">
                                    {{-- <label>Skor</label> --}}
                                    <input type="number" id="skor" name="opsi[{{ $key }}][skor]"
                                        class="form-control @error('opsi.' . $key . '.skor') is-invalid @enderror"
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
                                    <div class="">
                                        <button type="button" class="btn btn-success plus"> <i
                                                class="fa fa-plus"></i> </button>
                                        {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
                                    </div>
                                @else
                                    <div class="">
                                        <button type="button" class="btn btn-success plus"> <i
                                                class="fa fa-plus"></i> </button>
                                        <button type="button" class="btn btn-danger minus"> <i
                                                class="fa fa-minus"></i> </button>
                                        {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
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
                                <input type="text" id="opsi_name" name="opsi[1][opsi_name]" class="form-control "
                                    placeholder="Nama Opsi">
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
                                <input type="number" id="skor" name="opsi[1][skor]" class="form-control skor_option"
                                    placeholder="Skor">
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
                                <input type="text" id="sub_column" name="opsi[1][sub_column]" class="form-control"
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
                            <div class="">
                                <button type="button" class="btn btn-success plus"> <i class="fa fa-plus"></i>
                                </button>
                                {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
                            </div>
                        </td>

                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
@push('custom-script')
    <script>
        $('#item_turunan_tiga').hide();
        $('#opsi').hide();

        $("#level").change(function() {
            var id_level = $(this).val();
            if (id_level === "1") {
                $('#itemTurunan1').prop('disabled', true);
                $('#itemTurunan2').prop('disabled', true);
                $('#opsi_name').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#form_opsi').hide();
                $('#dapat_dikomentari').hide();
                $('#status_skor_item').hide();
                $('#status_skor').attr('disabled', true);
                $('#opsi_jawaban').prop('disabled', true);
                $('#opsi').hide();
                $('#item_turunan_tiga').hide();
                $('#item_turunan_tiga').prop('disabled', true)

            } else {
                $('#itemTurunan1').prop('disabled', false);
                $('#itemTurunan2').prop('disabled', false);
                $('#opsi_name').prop('disabled', false);
                $('#skor').prop('disabled', false);
                $('#opsi').show();
                $('#form_opsi').show();
                $('#dapat_dikomentari').show();
                $('#status_skor_item').show();
                $('#status_skor').removeAttr('disabled');
                $('#opsi_jawaban').prop('disabled', false);
            }
            $('#opsi_jawaban').change(function(e) {
                e.preventDefault();
                let opsi_jawaban = $(this).val();
                console.log(opsi_jawaban);
                if (opsi_jawaban == "option") {
                    $('#opsi').show();
                    $('#status_skor_item').show();
                    $('#status_skor').removeAttr('disabled');
                    $('#opsi_name').prop('disabled', false);
                    $('#skor').prop('disabled', false);
                } else {
                    $('#status_skor_item').hide();
                    $('#status_skor').attr('disabled', true);
                    $('#opsi').hide();
                    $('#opsi_name').prop('disabled', true);
                    $('#skor').prop('disabled', true);
                }
            })
            if (id_level == "2") {
                $(".select").select2()
                $('#itemTurunan2').prop('disabled', true);
                $('#item_turunan_tiga').prop('disabled', true)
                $('#item_turunan_tiga').hide()
                $('#item_turunan_tiga').prop('disabled', true)
                if (id_level == "2") {
                    turunanSatu(id_level)
                    addOption()
                } else {
                    $('#itemTurunan1').empty();
                }
            } else if (id_level == "3") {
                $(".select").select2()
                $('#item_turunan_tiga').hide()
                $('#item_turunan_tiga').prop('disabled', true)
                turunanSatu(id_level);
                $('#itemTurunan1').change(function(e) {
                    e.preventDefault();
                    var id_turunan = $(this).val();
                    turunanDua(id_turunan);
                })
                addOption()
                // $('#itemTurunan1').empty();
                // $("#itemTurunan1").append('<option value="0">---Pilih Item Turunan---</option>');
            } else if (id_level == 4) {
                $(".select").select2();
                addOption();
                turunanSatu(id_level);
                $('#item_turunan_tiga').show();
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
                    // console.log(res);
                    if (res) {
                        $('#itemTurunan3').empty();
                        $("#itemTurunan3").append('<option value="0">---Pilih Item Turunan---</option>');
                        $.each(res, function(nama, id) {
                            // console.log(res);
                            $("#itemTurunan3").append('<option value="' + id + '">' + nama +
                                '</option>');
                        });
                        // var count=Object.keys(res).length;
                        // for (let i = 0; i <= count; i++) {
                        //     $("#itemTurunan2").append('<option value="'+ res[i].id +'">'+res[i].level+". "+res[i].nama+'</option>');
                        // }
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
                                <input type="text" id="id_opsi" name="opsi[' + i + '][opsi_name]" class="form-control" placeholder="Nama Opsi">\
                        </td>\
                        <td>\
                            <input type="number" id="skor" name="opsi[' + i + '][skor]" class="form-control skor_option" placeholder="Skor" >\
                            </td>\
                        <td class="">\
                            <button type="button" class="btn btn-success plus"> <i class="fa fa-plus"></i> </button>\
                            <button type="button" class="btn btn-danger minus"> <i class="fa fa-minus"></i> </button>\
                        </td>\
                    </tr>');
            });
            $('body').on('click', '.minus', function() {
                $(this).closest('tr').remove();
                // i--;
            });
        }

        $('#status_skor').change(function (e) {
            if($(this).is(":checked")) {
                $('.skor_option').removeAttr('readonly');
            }
            else{
                $('.skor_option').val('');
                $('.skor_option').attr('readonly', true);
            }
            $('#status_skor').val($(this).is(':checked'));
        });
    </script>
@endpush
