@extends('layouts.template')
@section('content')
@include('components.notification')
<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }

</style>
<form action="{{ route('pengajuan-kredit.store') }}" method="post">
    @csrf

    <div class="row form-group">
        <div class="col text-right">
            <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
            <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
            {{-- <button class="btn btn-info ">Simpan <span class="fa fa-chevron-right"></span></button> --}}
        </div>
    </div>
</form>



@endsection

@push('custom-script')
<script>
    $('#kabupaten').change(function(){
    var kabID = $(this).val();
    if(kabID){
        $.ajax({
           type:"GET",
           url:"/getkecamatan?kabID="+kabID,
           dataType: 'JSON',
           success:function(res){
            //    console.log(res);
            if(res){
                $("#kecamatan").empty();
                $("#desa").empty();
                $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#kecamatan").empty();
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#kecamatan").empty();
        $("#desa").empty();
    }
   });

   $('#kecamatan').change(function(){
    var kecID = $(this).val();
    // console.log(kecID);
    if(kecID){
        $.ajax({
           type:"GET",
           url:"/getdesa?kecID="+kecID,
           dataType: 'JSON',
           success:function(res){
            //    console.log(res);
            if(res){
                $("#desa").empty();
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#desa").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#desa").empty();
    }
   });
</script>
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
