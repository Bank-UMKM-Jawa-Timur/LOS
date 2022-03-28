<form action="{{ route('master-item.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-4">
            <label>Level</label>
            <select name="level" id="level" class="form-control">
                <option value="0"> --- Pilih Level --- </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Item Turunan 1</label>
            <select name="item_turunan" id="itemTurunan1" class="form-control" >
                <option value="0"> ---Pilih Turunan ---</option>
               {{-- @foreach ($itemsatu as $item)
                <option value="{{ $item->id }}">{{ $item->id.'. '.$item->nama }}</option>
               @endforeach --}}
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Item Turunan 2</label>
            <select name="item_turunan_dua" id="itemTurunan2" class="form-control" >
                <option value="0"> ---Pilih Turunan ---</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <hr>
    <div id="opsi">
        <p><strong>Opsi atau Jawaban</strong></p>
        <table class="table opsi-jawaban">
            <thead>
                <tr>
                    <th>Opsi</th>
                    <th>Skor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="id_opsi">
            @if (old('opsi') != "")
                @foreach (old('opsi') as $key => $value)
                <div class="countVar" data-count="{{ count(old('opsi')) }}"></div>
                <tr data-id={{ ($key == 0)?$key+1:$key }}>
                    <td>
                        <div class="form-group col-md-12">
                            {{-- <label>Opsi</label> --}}
                            <input type="text" id="opsi_name" name="opsi[{{ $key }}][opsi_name]" class="form-control @error('opsi.'.$key.'.opsi_name') is-invalid @enderror" placeholder="Nama Opsi" value="{{ old('opsi.'.$key.'.opsi_name') }}">
                            @error('opsi.'.$key.'.opsi_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div class="form-group col-md-12">
                            {{-- <label>Skor</label> --}}
                            <input type="number" id="skor" name="opsi[{{$key}}][skor]" class="form-control @error('opsi.'.$key.'.skor') is-invalid @enderror" placeholder="Skor" value="{{ old('opsi.$key.skor') }}">
                            @error('opsi.'.$key.'.skor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </td>
                    <td>
                        @if ($key == 0)
                        <div class="">
                            <button type="button" class="btn btn-success plus"> <i class="fa fa-plus"></i> </button>
                            {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
                        </div>

                        @else
                            <div class="">
                                <button type="button" class="btn btn-success plus"> <i class="fa fa-plus"></i> </button>
                                <button type="button" class="btn btn-danger minus"> <i class="fa fa-minus"></i> </button>
                                {{-- <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a> --}}
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            @else
            <div id="countVar" data-count = "0"></div>
            <tr data-id="1">
                <td>
                    <div class="">
                        {{-- <label>Opsi</label> --}}
                        <input type="text" id="opsi_name" name="opsi[1][opsi_name]" class="form-control " placeholder="Nama Opsi" >
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
                        <input type="number" id="skor" name="opsi[1][skor]" class="form-control" placeholder="Skor" >
                        @error('opsi.1.skor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </td>
                <td>
                    <div class="">
                        <button type="button" class="btn btn-success plus"> <i class="fa fa-plus"></i> </button>
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
        $('#opsi').hide();
        $("#level").change(function(){
            var id_level = $(this).val()
            if(id_level == "1") {
                $('#itemTurunan1').prop('disabled', true);
                $('#itemTurunan2').prop('disabled', true);
                $('#opsi_name').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#opsi').hide();
            } else {
                $('#itemTurunan1').prop('disabled', false);
                $('#itemTurunan2').prop('disabled', false);
                $('#opsi_name').prop('disabled', false);
                $('#skor').prop('disabled', false);
                $('#opsi').show();
            }
            if (id_level === "2") {
                $('#itemTurunan2').prop('disabled', true);
                if (id_level == "2") {
                    turunanSatu(id_level)
                    addOption()
                }else{
                    $('#itemTurunan1').empty();
                }

            }else if (id_level == "3"){
                turunanSatu(id_level);
                $('#itemTurunan1').change(function(e) {
                    e.preventDefault();
                    var id_turunan = $(this).val();
                    turunanDua(id_turunan);
                })
                addOption()
                // $('#itemTurunan1').empty();
                // $("#itemTurunan1").append('<option value="0">---Pilih Item Turunan---</option>');
            }else{
                turunanSatu(id_level);
                $('#itemTurunan1').change(function(e) {
                    e.preventDefault();
                    var id_turunan_empat = $(this).val();
                    turunanDua(id_turunan_empat);
                    addOption()

                })
            }
        });
        // tambah ajax 1
        function turunanSatu(id_level) {
            $.ajax({
                type: "GET",
                url: "/data-item-satu?itemSatu="+id_level,
                dataType: 'JSON',
                success:function(res){
                    // console.log(res);
                    if (res) {
                        $('#itemTurunan1').empty();
                        $("#itemTurunan1").append('<option value="0">---Pilih Item Turunan---</option>');
                        var count=Object.keys(res).length;
                        for (let i = 0; i <= count; i++) {
                            $("#itemTurunan1").append('<option value="'+ res[i].id +'">'+res[i].level+". "+res[i].nama+'</option>');

                        }
                        // $.each(res,function(data){

                        // });

                    }else{
                        $('#itemTurunan1').empty();
                    }
                }
            })
        }
        // ajax 2
        function turunanDua(id_turunan) {
            $.ajax({
                type: "GET",
                url: "/data-item-tiga?itemTiga="+id_turunan,
                dataType: 'JSON',
                success:function(res){
                    console.log(res);
                    if (res) {
                        $('#itemTurunan2').empty();
                        $("#itemTurunan2").append('<option value="0">---Pilih Item Turunan---</option>');
                        var count=Object.keys(res).length;
                        for (let i = 0; i <= count; i++) {
                            $("#itemTurunan2").append('<option value="'+ res[i].id +'">'+res[i].level+". "+res[i].nama+'</option>');
                        }
                    }else{
                        $('#itemTurunan2').empty();
                    }
                }
            })
        }
        // ajax 3
        function turunanTiga(id_turunan_empat) {
            $.ajax({
                type: "GET",
                url: "/data-item-empat?itemEmpat="+id_turunan_empat,
                dataType: 'JSON',
                success:function(res){
                    console.log(res);
                    if (res) {
                        $('#itemTurunan2').empty();
                        $("#itemTurunan2").append('<option value="0">---Pilih Item Turunan---</option>');
                        var count=Object.keys(res).length;
                        for (let i = 0; i <= count; i++) {
                            $("#itemTurunan2").append('<option value="'+ res[i].id +'">'+res[i].level+". "+res[i].nama+'</option>');
                        }
                    }else{
                        $('#itemTurunan2').empty();
                    }
                }
            })
        }

        function addOption() {
            $('body').on('click','.plus',function() {
                var i = $("#opsi tr:last").data('id');
                i = i + 1;
                $('#id_opsi').append('<tr data-id="'+ i +'">\
                    <td>\
                            <input type="text" id="id_opsi" name="opsi['+ i +'][opsi_name]" class="form-control" placeholder="Nama Opsi">\
                    </td>\
                    <td>\
                        <input type="number" id="skor" name="opsi['+ i +'][skor]" class="form-control" placeholder="Skor" >\
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
    </script>
@endpush
