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
    <input type="text" id="jumlahData" name="jumlahData" hidden value="{{ count($dataAspek) }}">
    @php
        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
    @endphp
    @foreach ($dataDetailJawaban as $itemId)
        <input type="hidden" name="id[]" value="{{ $itemId->id }}">
    @endforeach
    @foreach ($dataAspek as $key => $value)
        @php
            $key;
            // check level 2
            $dataLevelDua = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',2)->where('id_parent',$value->id)->get();

            // check level 4
            $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',4)->where('id_parent',$value->id)->get();
        @endphp
        {{-- level level 2 --}}
        <div class="form-wizard {{ $key === 0 ? 'active' : '' }}" data-index='{{ $key }}' data-done='true'>
            <div class="">

                @foreach ($dataLevelDua as $item)
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
                            <div class="form-group col-md-6">
                                <select name="dataLevelDua[]" id="dataLevelDua" class="form-control mb-3" disabled>
                                    @foreach ($dataJawaban as $key => $itemJawaban)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                            <option value="{{ $itemJawaban->skor."-".$itemJawaban->id }}" {{ in_array($itemJawaban->id,$data) ? 'selected' : '' }} >{{ $itemJawaban->option }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]">
                            </div>
                            <div class="form-group col-md-6">
                                <select name="dataLevelDua[]" id="dataLevelDua" class="form-control mb-3" disabled>
                                    @foreach ($dataJawaban as $key => $itemJawaban)
                                        @php
                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                            $count = count($dataDetailJawaban);
                                            for ($i=0; $i < $count; $i++) {
                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                            }
                                        @endphp
                                            <option value="{{ $itemJawaban->skor."-".$itemJawaban->id }}" {{ in_array($itemJawaban->id,$data) ? 'selected' : '' }} >{{ $itemJawaban->skor }}</option>
                                    @endforeach
                                </select>
                                @foreach ($dataJawaban as $key => $itemJawaban)
                                    @if (in_array($itemJawaban->id,$data))
                                        <input type="number" class="form-control" placeholder="Masukkan Skor" name="skor_penyelia[]" value="{{ old('skor_penyelia',$itemJawaban->skor) }}" >

                                    @endif
                                @endforeach
                            </div>

                        </div>
                    @endif
                    @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                        @php
                            // check  jawaban level tiga
                            $dataJawabanLevelTiga = \App\Models\OptionModel::where('option',"!=","-")->where('id_item',$itemTiga->id)->get();
                            $dataOptionTiga = \App\Models\OptionModel::where('option',"=","-")->where('id_item',$itemTiga->id)->get();
                            // check level empat
                            $dataLevelEmpat = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',4)->where('id_parent',$itemTiga->id)->get();
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
                                <div class="form-group col-md-6">
                                    <label for="">{{ $itemTiga->nama }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select name="dataLevelTiga[]" id="" class="form-control" disabled>
                                        <option value=""> --Pilih Opsi-- </option>
                                        @foreach ($dataJawabanLevelTiga as $itemJawabanTiga)
                                            @php
                                                $dataDetailJawabanTiga = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                                $count = count($dataDetailJawabanTiga);
                                                for ($i=0; $i < $count; $i++) {
                                                    $dataTiga[] = $dataDetailJawabanTiga[$i]['id_jawaban'];
                                                }
                                            @endphp
                                            <option value="{{ $itemJawabanTiga->skor."-".$itemJawabanTiga->id }}" {{ in_array($itemJawabanTiga->id,$dataTiga) ? 'selected' : '' }}>{{ $itemJawabanTiga->option }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]">

                                </div>
                                <div class="form-group col-md-6">
                                    <select name="dataLevelTiga[]" id="" class="form-control" disabled>
                                        <option value=""> --Pilih Opsi-- </option>
                                        @foreach ($dataJawabanLevelTiga as $dataJawabanLevelTiga)
                                            @php
                                                $dataDetailJawabanTiga = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                                $count = count($dataDetailJawabanTiga);
                                                for ($i=0; $i < $count; $i++) {
                                                    $dataTiga[] = $dataDetailJawabanTiga[$i]['id_jawaban'];
                                                }
                                            @endphp
                                            <option value="{{ $itemJawabanTiga->skor."-".$itemJawabanTiga->id }}" {{ in_array($itemJawabanTiga->id,$dataTiga) ? 'selected' : '' }}>{{ $itemJawabanTiga->skor }}</option>
                                        @endforeach
                                    </select>
                                    @foreach ($dataJawabanLevelTiga as $key => $dataJawabanLevelTiga)
                                        @if (in_array($dataJawabanLevelTiga->id,$data))
                                            <input type="number" class="form-control" placeholder="Masukkan Skor" name="skor_penyelia[]" value="{{ old('skor_penyelia',$itemJawabanTiga->skor) }}" >
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        @endif
                        @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
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

                            @if (count($dataJawabanLevelEmpat) != 0)
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">{{ $itemEmpat->nama }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <select name="dataLevelEmpat[]" id="" class="form-control mb-3" disabled>
                                            <option value=""> --Pilih Opsi -- </option>
                                            @foreach ($dataJawabanLevelEmpat as $itemJawabanEmpat)
                                                @php
                                                    $dataDetailJawabanEmpat = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                                    $count = count($dataDetailJawabanEmpat);
                                                    for ($i=0; $i < $count; $i++) {
                                                        $dataEmpat[] = $dataDetailJawabanEmpat[$i]['id_jawaban'];
                                                    }
                                                @endphp
                                                <option value="{{ $itemJawabanEmpat->skor."-".$itemJawabanEmpat->id }}" {{ in_array($itemJawabanEmpat->id,$dataEmpat) ? 'selected' : '' }} >{{ $itemJawabanEmpat->option }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control" placeholder="Masukkan komentar" name="komentar_penyelia[]">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <select name="dataLevelEmpat[]" id="" class="form-control mb-3" disabled>
                                            <option value=""> --Pilih Opsi -- </option>
                                            @foreach ($dataJawabanLevelEmpat as $itemJawabanEmpat)
                                                @php
                                                    $dataDetailJawabanEmpat = \App\Models\JawabanPengajuanModel::select('id','id_jawaban')->where('id_pengajuan',$dataUmum->id)->get();
                                                    $count = count($dataDetailJawabanEmpat);
                                                    for ($i=0; $i < $count; $i++) {
                                                        $dataEmpat[] = $dataDetailJawabanEmpat[$i]['id_jawaban'];
                                                    }
                                                @endphp
                                                <option value="{{ $itemJawabanEmpat->skor."-".$itemJawabanEmpat->id }}" {{ in_array($itemJawabanEmpat->id,$dataEmpat) ? 'selected' : '' }} >{{ $itemJawabanEmpat->skor }}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanEmpat)
                                            @if (in_array($itemJawabanEmpat->id,$data))
                                                <input type="number" class="form-control" placeholder="Masukkan Skor" name="skor_penyelia[]" value="{{ old('skor_penyelia',$itemJawabanEmpat->skor) }}" >
                                            @endif
                                        @endforeach
                                    </div>

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
    for (let index = 0; index < jumlahData; index++) {
        for (let index = 0; index <= parseInt(jumlahData); index++) {
            var selected = index==parseInt(jumlahData) ? ' selected' : ''
            $(".side-wizard li[data-index='"+index+"']").addClass('active'+selected)
            $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa fa-ban')
            if($(".side-wizard li[data-index='"+index+"'] a span i").html()=='' || $(".side-wizard li[data-index='"+index+"'] a span i").html()=='0%'){
                $(".side-wizard li[data-index='"+index+"'] a span i").html('0%')
            }
        }

        var form = ".form-wizard[data-index='"+index+"']"

        var select = $(form+" select")

        var ttlSelect = 0;
        var ttlSelectFilled=0;
        $.each(select, function(i,v){
            ttlSelect++
            if(v.value!=''){
                ttlSelectFilled++
            }
        })

        var allInput =  ttlSelect
        var allInputFilled =  ttlSelectFilled

        var percentage = parseInt(allInputFilled/allInput * 100);
        $(".side-wizard li[data-index='"+index+"'] a span i").html(percentage+"%")
        $(".side-wizard li[data-index='"+index+"'] input.answer").val(allInput);
        $(".side-wizard li[data-index='"+index+"'] input.answerFilled").val(allInputFilled);
        var allInputTotal = 0;
        var allInputFilledTotal = 0;
    }
    $(".side-wizard li input.answer").each(function(){
        allInputTotal += Number($(this).val());
    });
    $(".side-wizard li input.answerFilled").each(function(){
        allInputFilledTotal += Number($(this).val());
    });
    var result = parseInt(allInputFilledTotal/allInputTotal * 100);
    $('.progress').val(result);
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
        console.log(indexNow);
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

        var select = $(form+" select")

        var ttlSelect = 0;
        var ttlSelectFilled=0;
        $.each(select, function(i,v){
            ttlSelect++
            if(v.value!=''){
                ttlSelectFilled++
            }
        })

        var allInput = ttlSelect
        var allInputFilled = ttlSelectFilled

        var percentage = parseInt(allInputFilled/allInput * 100);
        $(".side-wizard li[data-index='"+formIndex+"'] a span i").html(percentage+"%")
        $(".side-wizard li[data-index='"+formIndex+"'] input.answer").val(allInput);
        $(".side-wizard li[data-index='"+formIndex+"'] input.answerFilled").val(allInputFilled);
            var allInputTotal = 0;
            var allInputFilledTotal = 0;
            $(".side-wizard li input.answer").each(function(){
                allInputTotal += Number($(this).val());
            });
            $(".side-wizard li input.answerFilled").each(function(){
                allInputFilledTotal += Number($(this).val());
            });

            var result = parseInt(allInputFilledTotal/allInputTotal * 100);
            $('.progress').val(result);
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
