@extends('layouts.template')
@section('content')
<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }

</style>
<div class="form-wizard active" data-index='0' data-done='false'>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Usaha Dilakukan Sejak</label>
            <input type="text" class="form-control" placeholder="Contoh: 2020">
        </div>
        <div class="col-md-6">
            <label for="">Badan Usaha</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Badan Usaha ---</option>
                <option value="">Perseorangan</option>
                <option value="">Persero</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label class="info" for="">Permodalan Dipenuhi Dari</label>
        </div>
    </div>
    <div class="row form-group pl-3 sub">
        <div class="col-md-6">
            <label for="">Modal (awal) sendiri</label>
            <input type="text" class="form-control" placeholder="Input label 1">
        </div>
        <div class="col-md-6">
            <label for="">Modal Pinjaman</label>
            <input type="text" class="form-control" placeholder="Input label 1">
        </div>
    </div>
</div>
<div class="form-wizard" data-index='1' data-done="false">
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 5</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Select---</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Label 6</label>
            <input type="text" class="form-control" placeholder="Input label 6">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 5</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Select---</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Label 6</label>
            <input type="text" class="form-control" placeholder="Input label 6">
        </div>
    </div>
</div>
<div class="form-wizard" data-index='2' data-done="false">
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Label 5</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Select---</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="">Label 6</label>
            <input type="text" class="form-control" placeholder="Input label 6">
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col text-right">
        <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
        <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
    </div>
</div>
@endsection

@push('custom-script')
<script>

    function cekBtn(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()

        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".btn-prev").show()
        }
    }
    function cekWizard(isNext=false){
        var indexNow = $(".form-wizard.active").data('index')
        if(isNext){
            $(".side-wizard li").removeClass('active')
        }
        
        $(".side-wizard li").removeClass('selected')
        
        for (let index = 0; index <= parseInt(indexNow); index++) {
            var selected = index==parseInt(indexNow) ? ' selected' : ''
            $(".side-wizard li[data-index='"+index+"']").addClass('active'+selected)
            $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa-ban')
            $(".side-wizard li[data-index='"+index+"'] a span i").addClass('fa-check')
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

    $(".btn-next").click(function(){
        var indexNow = $(".form-wizard.active").data('index')
        var next = parseInt(indexNow) + 1

        if($(".form-wizard[data-index='"+next+"']").length==1){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+next+"']").addClass('active')
            $(".form-wizard[data-index='"+indexNow+"']").attr('data-done','true')
        }

        cekWizard()
        cekBtn(true)
    })
    $(".btn-prev").click(function(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+prev+"']").addClass('active')
        }
        cekWizard()
        cekBtn()        
    })
</script>
@endpush