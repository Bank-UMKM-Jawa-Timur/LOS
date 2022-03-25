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
            <select name="item-turunan" id="itemTurunan1" class="form-control" >
                <option value="0"> ---Pilih Turunan ---</option>
               @foreach ($itemsatu as $item)
                <option value="{{ $item->id }}">{{ $item->id.'. '.$item->nama }}</option>
               @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Item Turunan 2</label>
            <select name="" id="itemTurunan2" class="form-control" >
                <option value="1">1-Aspek Management</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
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
        <div class="row">
            <div class="form-group col-md-4">
                <label>Opsi</label>
                <input type="text" id="id_opsi" name="opsi" class="form-control @error('opsi') is-invalid @enderror" placeholder="Nama Opsi" value="{{old('Opsi')}}">
                @error('opsi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-5">
                <label>Skor</label>
                <input type="number" id="skor" name="skor" class="form-control @error('skor') is-invalid @enderror" placeholder="Skor" value="{{old('skor')}}">
                @error('skor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group col-md-3" >
                <div class="d-flex">
                    <div class="py-4">
                        <a class="addDetail" class="btn p-3" href=""><i class="fa fa-plus-square text-primary p-3" style="font-size: 24px"></i></a>
                    </div>
                    {{-- @if ($hapus) --}}
                    <div class="p-3 py-4">
                        <a class="deleteDetail"  href=""><i class="fa fa-minus-square text-danger py-3" style="font-size: 24px"></i></a>
                    </div>
                    {{-- @endif --}}
                     {{-- @if($hapus) --}}
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
@push('custom-script')
    <script>
        $("#level").change(function(){
            var id_level = $(this).val()
            if(id_level == "1") {
                $('#itemTurunan1').prop('disabled', true);
                $('#itemTurunan2').prop('disabled', true);
                $('#id_opsi').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#opsi').hide();
            } else {
                $('#itemTurunan1').prop('disabled', false);
                $('#itemTurunan2').prop('disabled', false);
                $('#id_opsi').prop('disabled', false);
                $('#skor').prop('disabled', false);
                $('#opsi').show();
            }
            if (id_level == "2") {
                $('#itemTurunan2').prop('disabled', true);

            }else{
                console.log('bukan dua');
            }
        });
        // tambah detail
        function addDetail(param) {
            var biggestNo = 0; //setting awal No/Id terbesar
            $(".row-detail").each(function() {
                var currentNo = parseInt($(this).attr("data-no"));
                if (currentNo > biggestNo) {
                    biggestNo = currentNo;
                }
            }); //cari no terbesar

            var next = parseInt(biggestNo) + 1;
            var thisNo = param.data("no");
            var url = $("#urlAddDetail").data('url')
            // console.log(url);
            $.ajax({
                type: "get",
                url: url,
                data: { biggestNo: biggestNo },
                beforeSend: function() {
                    $(".loader-bg").addClass("show");
                },
                success: function(response) {
                    console.log(response);
                    $(".loader-bg").removeClass("show");
                    $(".row-detail[data-no='" + thisNo + "']").after(response);
                    $(".select2").select2();

                    $(".addDetail[data-no='" + next + "']").click(function(e) {
                        e.preventDefault()
                        addDetail($(this));
                    })

                    $(".deleteDetail").click(function(e) {
                        e.preventDefault()
                        deleteDetail($(this));
                    });
                    // $(".getSubtotal").keyup(function() {
                    //     getSubtotal($(this));
                    // });

                    // $(".getHargaSatuan").keyup(function() {
                    //     // getSubtotal($(this));
                    //     getHargaSatuan($(this));
                    // });

                    // $('.kode_barang').change(function() {
                    //     kodeBarang($(this))
                    // });
                    $(".getTotalKas").keyup(function() {
                        getTotalKas($(this));
                    });

                }
            })

        }
        $(".addDetail").click(function(e) {
            e.preventDefault();
            addDetail($(this));
        });
    </script>
@endpush
