<form action="{{ route('master-item.update',$item->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="idDelete">
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Level</label>
            <select name="level" id="level" class="form-control"  disabled>
                <option value="0"> --- Pilih Level --- </option>
                <option aria-readonly="true" value="1" {{ $item->level == 1 ? "selected" : ""}}>1</option>
                <option value="2" {{ $item->level == 2 ? "selected" : ""}}>2</option>
                <option value="3" {{ $item->level == 3 ? "selected" : ""}}>3</option>
                <option value="4" {{ $item->level == 4 ? "selected" : ""}}>4</option>
            </select>
        </div>
        @if ($item->level != 1)
            <div class="form-group col-md-6">
                <label>Item Turunan</label>
                <input type="text" name="id_turunan" value="{{ $itemTurunan->id }}" hidden>
                <input type="text" name="id_item" value="{{ $item->id }}" hidden>
                <input type="text" name="item_turunan" class="form-control @error('item_turunan') is-invalid @enderror" value="{{old('item_turunan', $itemTurunan->nama )}}" readonly>
                @error('item_turunan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama',$item->nama)}}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="detail-lawan">
        <div class="" id="urlAddDetail" data-url="{{ url('master-item/addEditItem') }}">
            <p><strong>Opsi atau Jawaban</strong></p>
        @if (!is_null(old('id')))
            @php
                $loop = array();
                foreach(old('id') as $i => $val){
                    $loop[] = array(
                    'option' => old('option.'.$i),
                    'skor' => old('skor.'.$i),
                    );
                }
            @endphp

        @else
            @php
                $loop = $opsi;
            @endphp
        @endif
        @php $no = 0; $total = 0; @endphp

        @foreach ($loop as $n => $edit)
            @php
                $no++;
                $linkHapus = $no==1 ? false : true;
                $fields = array(
                    'option' => 'option.'.$n,
                    'skor' => 'skor.'.$n,
                );

                if(!is_null(old('id_item'))){
                    $idDetail = old('id_detail.'.$n);
                }
                else{
                    $idDetail = $edit['id'];
                }
            @endphp
            @include('master-item.editDetail',['hapus' => $linkHapus, 'no' => $no])
                    {{-- @include('pages.transaksi-bank.form-detail-transaksi-bank'); --}}
        @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
@push('custom-script')
    <script>
    $(document).ready(function() {

        $('#opsi').hide();
        $('#level option').each(function() {
            var id_level = $("#level option:selected").val()
            if (id_level == 1){
                $('#itemTurunan1').prop('disabled', true);
                $('#itemTurunan2').prop('disabled', true);
                $('#opsi_name').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#opsi').hide();
            }

            if(id_level == "1") {
                $('#itemTurunan1').prop('disabled', false);
                $('#itemTurunan2').prop('disabled', true);
                $('#opsi_name').prop('disabled', true);
                $('#skor').prop('disabled', true);
                $('#opsi').hide();
            } else {
                $('#itemTurunan1').prop('disabled', true);
                $('#itemTurunan2').prop('disabled', false);
                $('#opsi_name').prop('disabled', false);
                $('#skor').prop('disabled', false);
                $('#opsi').show();
            }
            if (id_level == "2") {
            }else if (id_level == "3"){

                // $('#itemTurunan1').empty();
                // $("#itemTurunan1").append('<option value="0">---Pilih Item Turunan---</option>');
            }

        });
        function addOption(param) {
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
            console.log(url);
            $.ajax({
                type: "get",
                url: url,
                data: { biggestNo: biggestNo },
                success: function(response) {
                    console.log(response);
                    $(".row-detail[data-no='" + thisNo + "']").after(response);

                    $(".addDetail[data-no='" + next + "']").click(function(e) {
                        e.preventDefault()
                        addDetail($(this));
                    })

                    $(".deleteDetail").click(function(e) {
                        e.preventDefault()
                        deleteDetail($(this));
                    });
                }
            })

        }
        $(".addDetail").click(function(e) {
            e.preventDefault();
            addOption($(this));
            console.log(e);
        });

        function deleteDetail(thisParam) {
            var delNo = thisParam.data("no");
            var parent = ".row-detail[data-no='" + delNo + "']";
            var idDetail = $(parent + " .idDetail").val();
            if (thisParam.hasClass("addDeleteId") && idDetail != 0) {
                $(".idDelete").append(
                    "<input type='hidden' name='id_delete[]' value='" +
                    idDetail +
                    "'>"
                );
            }
            $(parent).remove();
        }
        $(".deleteDetail").click(function(e) {
            e.preventDefault();
            deleteDetail($(this));
        });
    });

    </script>
@endpush
