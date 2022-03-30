    var jumlahData = $('#jumlahData').val();
    console.log(jumlahData);
    function cekBtn(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()
        $(".btn-simpan").hide()

        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".btn-prev").show()
        }
        if (indexNow == jumlahData) {

            $(".btn-next").hide()
            $(".btn-simpan").show()

            // $('#pengajuan_kredit').on('submit',function(e){
            //     e.preventDefault();
            //     let name = $('#nama').val();
            //     console.log(name);
            //     $.ajax({
            //         url: "/pengajuan-kredit",
            //         type:"POST",
            //         data:{
            //             "_token": "{{ csrf_token() }}",
            //         },
            //     })
            //     // console.log('berhasil');
            // });

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
            $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa fa-ban')
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

        var input = $(form+" input")
        var select = $(form+" select")
        var textarea = $(form+" textarea")

        var ttlInput = 0;
        var ttlInputFilled=0;
        $.each(input, function(i,v){
            ttlInput++
            if(v.value!=''){
                ttlInputFilled++
            }
        })
        var ttlSelect = 0;
        var ttlSelectFilled=0;
        $.each(select, function(i,v){
            ttlSelect++
            if(v.value!=''){
                ttlSelectFilled++
            }
        })

        var ttlTextarea = 0;
        var ttlTextareaFilled=0;
        $.each(textarea, function(i,v){
            ttlTextarea++
            if(v.value!=''){
                ttlTextareaFilled++
            }
        })

        var allInput = ttlInput + ttlSelect + ttlTextarea
        var allInputFilled = ttlInputFilled + ttlSelectFilled + ttlTextareaFilled

        var percentage = parseInt(allInputFilled/allInput * 100);
        $(".side-wizard li[data-index='"+formIndex+"'] a span i").html(percentage+"%")
    }

    $(".btn-next").click(function(e){
        e.preventDefault();
        var indexNow = $(".form-wizard.active").data('index')
        var next = parseInt(indexNow) + 1
        // console.log($(".form-wizard[data-index='"+next+"']").length==1);
        console.log($(".form-wizard[data-index='"+  +"']"));
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
