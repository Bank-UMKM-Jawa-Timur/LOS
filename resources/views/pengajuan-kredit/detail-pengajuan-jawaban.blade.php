@extends('layouts.template')
@section('content')
@include('components.notification')

<style>
    .sub label:not(.info){
        font-weight: 400;
    }
    h4{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 20px;
        /* border-bottom: 1px solid #dc3545; */
    }
    h5{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 18px;
        /* border-bottom: 1px solid #dc3545; */
    }
    .form-wizard h6{
        color: #c2c7cf;
        font-weight: 600 !important;
        font-size: 16px;
        /* border-bottom: 1px solid #dc3545; */
    }
</style>
<form action="{{ route('pengajuan.insertkomentar') }}" method="POST" >
    @csrf
    <input type="hidden" id="jumlahData" name="jumlahData" hidden value="{{ count($dataAspek) }}">
    <input type="hidden" id="id_pengajuan" name="id_pengajuan" value="{{ $dataUmum->id }}">
    @php
        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
    @endphp
    @foreach ($dataDetailJawaban as $itemJawabanDetail)
        <input type="hidden" name="id_jawaban[]" value="{{ $itemJawabanDetail->id }}" id="">
    @endforeach
     @foreach ($dataAspek as $key => $value)

        @php
            $key;
            // check level 2
            $dataLevelDua = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',2)->where('id_parent',$value->id)->get();

            // check level 4
            $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$value->id)->get();
        @endphp
        {{-- level level 2 --}}

        <div class="form-wizard {{ $key === 0 ? 'active' : '' }}" data-index='{{ $key }}' data-done='true'>
            <div class="">
                @foreach ($dataLevelDua as $item)
                    @if ($item->opsi_jawaban == 'input text')
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','item.id as id_item','item.nama')
                                                                                    ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                    ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$item->id)->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextDua)
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextDua->nama }}" disabled>
                                    {{-- <label for="">{{ $itemTextDua->nama }}</label> --}}
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextDua->opsi_text }}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" placeholder="" name="skor_penyelia_text[]" value="">
                                </div>
                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextDua->id }}">
                                <input type="hidden" name="id[]" value="{{ $value->id }}">

                            </div>
                        @endforeach
                    @endif
                    @php
                        $dataJawaban = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$item->id)->get();
                        $dataOption = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$item->id)->get();

                        // check level 3
                        $dataLevelTiga = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',3)->where('id_parent',$item->id)->get();
                    @endphp
                    @foreach ($dataOption as $itemOption)
                        @if ($itemOption->option == "-")
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h4>{{ $item->nama }}</h4>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if (count($dataJawaban) != 0)
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">{{  $item->nama }}</label>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($dataJawaban as $key => $itemJawaban)
                                @php
                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                    $count = count($dataDetailJawaban);
                                    for ($i=0; $i < $count; $i++) {
                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                    }
                                @endphp
                                @if (in_array($itemJawaban->id,$data))
                                    @if (isset($data))
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemJawaban->option }}" disabled>

                                            <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]" >

                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemJawaban->skor }}" disabled>
                                            <input type="number" class="form-control" placeholder="" name="skor_penyelia[]" value="{{ $itemJawaban->skor != null ? $itemJawaban->skor : 0 }}">
                                        </div>
                                        <input type="hidden" name="id[]" value="{{ $value->id }}">
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                        @if ($itemTiga->opsi_jawaban == 'input text')
                            @php
                                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','item.id as id_item','item.nama')
                                                                                        ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                        ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemTiga->id)->get();
                            @endphp
                            @foreach ($dataDetailJawabanText as $itemTextTiga)
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextTiga->nama }}" disabled>
                                    {{-- <label for="">{{ $itemTextTiga->nama }}</label> --}}
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextTiga->opsi_text }}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" placeholder="Masukkan skor" name="skor_penyelia_text[]" value="">
                                </div>
                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextTiga->id }}">
                                <input type="hidden" name="id[]" value="{{ $value->id }}">

                            </div>
                            @endforeach
                        @endif
                        @php
                            // check  jawaban level tiga
                            $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                            $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                            // check level empat
                            $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','opsi_jawaban','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
                        @endphp

                        @foreach ($dataOptionTiga as $itemOptionTiga)
                          @if ($itemOptionTiga->option == "-")
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h5>{{ $itemTiga->nama }}</h5>
                                </div>
                            </div>
                          @endif
                        @endforeach

                        @if (count($dataJawabanLevelTiga) != 0)
                        <div class="row">
                            @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                @php
                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                    $count = count($dataDetailJawaban);
                                    for ($i=0; $i < $count; $i++) {
                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                    }
                                @endphp
                                @if (in_array($itemJawabanLevelTiga->id,$data))
                                    @if (isset($data))
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemJawabanLevelTiga->option }}" disabled>

                                            <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]" >

                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="skor_penyelia" value="{{ $itemJawabanLevelTiga->skor }}" disabled>
                                            <input type="number" class="form-control" placeholder="" name="skor_penyelia[]" value="{{ $itemJawabanLevelTiga->skor != null ? $itemJawabanLevelTiga->skor : '' }}">
                                        </div>
                                        <input type="hidden" name="id[]" value="{{ $value->id }}">
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        @endif
                        @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                            {{-- @php
                                echo "<pre>";
                                    print($itemEmpat);
                                echo "</pre>";
                            @endphp --}}
                            @if ($itemEmpat->opsi_jawaban == 'input text')
                                @php
                                    $dataDetailJawabanTextEmpat = \App\Models\JawabanTextModel::select('jawaban_text.id','jawaban_text.id_pengajuan','jawaban_text.id_jawaban','jawaban_text.opsi_text','item.id as id_item','item.nama')
                                                                                            ->join('item','jawaban_text.id_jawaban','item.id')
                                                                                            ->where('jawaban_text.id_pengajuan',$dataUmum->id)->where('jawaban_text.id_jawaban',$itemEmpat->id)->get();
                                @endphp
                                {{-- @php
                                    echo "<pre>";
                                        print($dataDetailJawabanTextEmpat);
                                    echo "</pre>";
                                @endphp --}}
                                @foreach ($dataDetailJawabanTextEmpat as $itemTextEmpat)
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextEmpat->nama }}" disabled>
                                        {{-- <label for="">{{ $itemTextEmpat->nama }}</label> --}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemTextEmpat->opsi_text }}" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" placeholder="" name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="number" class="form-control" placeholder="Masukkan skor" name="skor_penyelia_text[]" value="">
                                    </div>
                                    <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextEmpat->id }}">
                                    <input type="hidden" name="id[]" value="{{ $value->id }}">

                                </div>
                                @endforeach
                            @endif
                            @php
                                // check level empat
                                $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemEmpat->id)->get();
                                $dataOptionEmpat = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemEmpat->id)->get();
                            @endphp
                            @foreach ($dataOptionEmpat as $itemOptionEmpat)
                             @if ($itemOptionEmpat->option == "-")
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h6>{{ $itemEmpat->nama }}</h6>
                                    </div>
                                </div>
                             @endif
                            @endforeach

                            {{-- Data jawaban Level Empat --}}
                            @if (count($dataJawabanLevelEmpat) != 0)
                                <div class="row">
                                    @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban','skor')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                        @if (in_array($itemJawabanLevelEmpat->id,$data))
                                            @if (isset($data))
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia" value="{{ $itemJawabanLevelEmpat->option }}" disabled>

                                                    <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]" >

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control mb-3" placeholder="Masukkan komentar" name="komentar_penyelia[]" value="{{ $itemJawabanLevelEmpat->skor }}" disabled>
                                                    <input type="number" class="form-control" placeholder="" name="skor_penyelia[]" value="{{ $itemJawabanLevelEmpat->skor != null ? $itemJawabanLevelEmpat->skor : '' }}">
                                                </div>
                                                <input type="hidden" name="id[]" value="{{ $value->id }}">
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            </div>

        </div>

    @endforeach
    <div class="row form-group">
        <div class="col text-right">
            <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
            <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
            <button type="submit" class="btn btn-info btn-simpan" id="submit">Simpan <span class="fa fa-save"></span></button>
            {{-- <button class="btn btn-info ">Simpan <span class="fa fa-chevron-right"></span></button> --}}
        </div>
    </div>
</form>

@endsection

@push('custom-script')
<script>
    var jumlahData = $('#jumlahData').val();
    for (let index = 0; index < jumlahData + 1; index++) {
        for (let index = 0; index <= parseInt(jumlahData); index++) {
            var selected = index==parseInt(jumlahData) ? ' selected' : ''
            $(".side-wizard li[data-index='"+index+"']").addClass('active'+selected)
            $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa fa-ban')
            if($(".side-wizard li[data-index='"+index+"'] a span i").html()=='' || $(".side-wizard li[data-index='"+index+"'] a span i").html()=='0%'){
                $(".side-wizard li[data-index='"+index+"'] a span i").html('0%')
            }
        }

        var form = ".form-wizard[data-index='"+index+"']"

        var input = $(form+" input:disabled");

        var ttlInput = 0;
        var ttlInputFilled=0;
        $.each(input, function(i,v){
            ttlInput++
            if(v.value!=''){
                ttlInputFilled++
            }
        })
        var allInput = ttlInput
        var allInputFilled = ttlInputFilled

        var percentage = parseInt(allInputFilled/allInput * 100);
            $(".side-wizard li[data-index='"+index+"'] a span i").html(percentage != NaN ? percentage : 0+"%")
        // $(".side-wizard li[data-index='"+index+"'] input.answer").val(allInput);
        // $(".side-wizard li[data-index='"+index+"'] input.answerFilled").val(allInputFilled);
    }
    function cekBtn(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()
        $(".btn-simpan").hide()
        $(".progress").prop('disabled', true);

        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".btn-prev").show()
        }
        if (next == jumlahData) {

            $(".btn-next").click(function(e){

                    $(".btn-simpan").show()
                    // $(".progress").prop('disabled', false);
                    $(".btn-next").hide()
            });
                // $(".btn-next").show()

        }else{
            $(".btn-next").show()
            $(".btn-simpan").hide()

        }
    }
    function cekWizard(isNext=false){
        var indexNow = $(".form-wizard.active").data('index')
        // console.log(indexNow);
        if(isNext){
            $(".side-wizard li").removeClass('active')
        }

        $(".side-wizard li").removeClass('selected')

        for (let index = 0; index <= parseInt(indexNow); index++) {
            var selected = index==parseInt(indexNow) ? ' selected' : ''
            $(".side-wizard li[data-index='"+index+"']").addClass('active'+selected)
            // $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa fa-ban')
            if($(".side-wizard li[data-index='"+index+"'] a span i").html()=='' || $(".side-wizard li[data-index='"+index+"'] a span i").html()=='0%'){
                $(".side-wizard li[data-index='"+index+"'] a span i").html('0%')
            }
        }

    }
    cekBtn()
    cekWizard()

    $(".side-wizard li a").click(function(){
        var dataIndex = $(this).closest('li').data('index')
        if($(this).closest('li').hasClass('active')){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+dataIndex+"']").addClass('active')
            cekWizard()
        }
    })

    function setPercentage(formIndex){
        var form = ".form-wizard[data-index='"+formIndex+"']"
    }

    $(".btn-next").click(function(e){
        e.preventDefault();
        var indexNow = $(".form-wizard.active").data('index')
        var next = parseInt(indexNow) + 1
        // \($(".form-wizard[data-index='"+next+"']").length==1);
        // console.log($(".form-wizard[data-index='"+  +"']"));
        if($(".form-wizard[data-index='"+next+"']").length==1){
            // console.log(indexNow);
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+next+"']").addClass('active')
            $(".form-wizard[data-index='"+indexNow+"']").attr('data-done','true')
        }


        cekWizard()
        cekBtn(true)
        setPercentage(indexNow)
    })
    setPercentage(0)

    $(".btn-prev").click(function(e){
        event.preventDefault(e);
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+prev+"']").addClass('active')
        }
        cekWizard()
        cekBtn()
        e.preventDefault();
    })

</script>
@endpush
