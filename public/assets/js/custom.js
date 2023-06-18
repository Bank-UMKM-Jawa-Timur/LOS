
$(document).ready(function() {
    var firstLoad = true;
    
    $('.side-wizard').on('click', function () {
        firstLoad = false
        for (let index = 0; index < 7; index++) {
            setPercentage(index);
        }
    })
    var jumlahData = $('#jumlahData').val();
    // setPercentage(0);

    function setPercentage(formIndex) {
        var form = ".form-wizard[data-index='" + formIndex + "']"
        var inputText = $(form + " .row input[type=text]")
        var inputNumber = $(form + " input[type=number]")
        var inputDisabled = $(form + " input:disabled")
        var inputReadonly = $(form + " input").find("readonly")
        var inputHidden = $(form + " input[type=hidden]")
        var inputFile = $(form + " .filename")
        var inputDate = $(form + " input[type=date]")
        var select = $(form + " select")
        var textarea = $(form + " textarea")
        var totalText = inputText ? inputText.length : 0
        var totalNumber = inputNumber ? inputNumber.length : 0
        var totalDisabled = inputDisabled ? inputDisabled.length : 0
        var totalReadonly = inputReadonly ? inputReadonly.length : 0
        var totalHidden = inputHidden ? inputHidden.length : 0
        var totalFile = inputFile ? inputFile.length : 0
        var totalDate = inputDate ? inputDate.length : 0
        var totalSelect = select ? select.length : 0
        var totalTextArea = textarea ? textarea.length : 0

        var subtotalInput = (totalText + totalNumber + totalFile + totalDate + totalSelect + totalTextArea)

        if (formIndex == 2) {
            var ijinUsahaSelect = $(form).find("#ijin_usaha");
            if (ijinUsahaSelect.length > 0) {
                if (ijinUsahaSelect[0].value == 'nib' || ijinUsahaSelect[0].value == 'surat_keterangan_usaha') {
                    if(!$("#isNpwp").attr("checked")){
                        //console.log('test');
                        subtotalInput -= 4;
                    }
                    subtotalInput -= 2;
                }
                if (ijinUsahaSelect[0].value == 'tidak_ada_legalitas_usaha') {
                    subtotalInput -= 6;
                }
            }
        }

        if (formIndex == 3) {
            subtotalInput -= firstLoad ? 2 : 8;
        }

        if (formIndex == 6) {
            subtotalInput -= 1;
        }

        var ttlInputTextFilled = 0;
        $.each(inputText, function(i, v) {
            if (v.value != '') {
                ttlInputTextFilled++
            }
        })
        var ttlInputNumberFilled = 0;
        $.each(inputNumber, function(i, v) {
            if (v.value != '') {
                ttlInputNumberFilled++
            }
        })
        var ttlInputFileFilled = 0;
        $.each(inputFile, function(i, v) {
            if (v.innerHTML != '') {
                ttlInputFileFilled++
            }
        })
        var ttlInputDateFilled = 0;
        $.each(inputDate, function(i, v) {
            if (v.value != '') {
                ttlInputDateFilled++
            }
        })
        var ttlSelectFilled = 0;
        $.each(select, function(i, v) {
            var data = v.value;
            if (data != "" && data != '' && data != null && data != ' --Pilih Opsi-- ' && data != '--Pilih Opsi--') {
                ttlSelectFilled++
            }
        })
        var ttlTextAreaFilled = 0;
        $.each(textarea, function(i, v) {
            if (v.value != '') {
                ttlTextAreaFilled++
            }
        })

        var subtotalFilled = ttlInputTextFilled + ttlInputNumberFilled + ttlInputFileFilled + ttlInputDateFilled + ttlSelectFilled + ttlTextAreaFilled;
        if (formIndex == 0) {
            let value = $("#status").val();
            //console.log('status : '+value)
            if (value == "menikah") {
                // subtotalInput += 2;
                subtotalFilled += 2;
            }
            else {
                // subtotalInput += 1;
                subtotalFilled += 2;
            }
        }
        //console.log("=============index : "+formIndex+"=============")
        //console.log('total input : ' + subtotalInput)
        //console.log('total input filled : ' + subtotalFilled)
        //console.log("===============================================")

        var percentage = parseInt(subtotalFilled / subtotalInput * 100);
        percentage = Number.isNaN(percentage) ? 0 : percentage;
        percentage = percentage > 100 ? 100 : percentage;
        percentage = percentage < 0 ? 0 : percentage;

        $(".side-wizard li[data-index='" + formIndex + "'] a span i").html(percentage + "%")
    }

    function cekBtn() {
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()
        $(".btn-simpan").hide()

        $(".progress").prop('disabled', true);
        if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
            $(".btn-prev").show()
        }

        if (parseInt(indexNow) == parseInt(jumlahData)) {
            $(".btn-simpan").show()
            $(".progress").prop('disabled', false);
            $(".btn-next").hide()
        } else {
            $(".btn-next").show()
            $(".btn-simpan").hide()

        }
    }

    function cekWizard(isNext = false) {
        var indexNow = $(".form-wizard.active").data('index')
            // //console.log(indexNow);
        if (isNext) {
            $(".side-wizard li").removeClass('active')
        }

        $(".side-wizard li").removeClass('selected')

        for (let index = 0; index <= parseInt(indexNow); index++) {
            var selected = index == parseInt(indexNow) ? ' selected' : ''
            $(".side-wizard li[data-index='" + index + "']").addClass('active' + selected)
            $(".side-wizard li[data-index='" + index + "'] a span i").removeClass('fa fa-ban')
            if ($(".side-wizard li[data-index='" + index + "'] a span i").html() == '' || $(".side-wizard li[data-index='" + index + "'] a span i").html() == '0%') {
                $(".side-wizard li[data-index='" + index + "'] a span i").html('0%')
            }
        }

    }
    cekBtn()
    cekWizard()

    $(".side-wizard li a").click(function() {
        var dataIndex = $(this).closest('li').data('index')
        if ($(this).closest('li').hasClass('active')) {
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='" + dataIndex + "']").addClass('active')
            cekWizard()
            cekBtn()
        }
    })
    
    function cekNpwp(indexNow) {
        var isNext = true
        var labelNpwp = "NPWP"
        if(indexNow==2 && $('#npwp').length==1){
            var kredit = $("#jumlah_kredit").val()
            var npwp = $('#npwp').val()
            if(kredit>=50000000 && npwp==''){
                isNext = false
                labelNpwp =  `NPWP <span style='color:red'>Pengajuan >= 50 Juta wajib memiliki NPWP</span>`
            }
        }
        return [isNext,labelNpwp]
    }

    $(".btn-next").click(function(e) {
        e.preventDefault();
        firstLoad = false

        let valSkema = $("#skema").val();
        var indexNow = $(".form-wizard.active").data('index')
        setPercentage(indexNow + 1);

        if(indexNow != 0){
            if(indexNow == 1){
                if(valSkema != 'KKB'){
                    saveDataTemporary(indexNow)
                }
            }
            saveDataTemporary(indexNow)
        }

        if(cekNpwp(indexNow)[0]){
            var next = parseInt(indexNow) + 1
                // //console.log($(".form-wizard[data-index='"+next+"']").length==1);
                // //console.log($(".form-wizard[data-index='"+  +"']"));
            if ($(".form-wizard[data-index='" + next + "']").length == 1) {
                // //console.log(indexNow);
                $(".form-wizard").removeClass('active')
                $(".form-wizard[data-index='" + next + "']").addClass('active')
                $(".form-wizard[data-index='" + indexNow + "']").attr('data-done', 'true')
            }

            cekWizard()
            cekBtn(true)
            setPercentage(indexNow)
        }
        $("#npwp").closest('.form-group').find("label").html(cekNpwp(indexNow)[1])
        cekWizard()
        cekBtn(true)
        setPercentage(indexNow)
    })

    $(".btn-prev").click(function(e) {
        e.preventDefault(e);
        firstLoad = false

        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='" + prev + "']").addClass('active')
        }
        cekWizard()
        cekBtn()
        e.preventDefault();
        setPercentage(indexNow)
    })

    function openWizard(index) {
        $(".side-wizard li[data-index='" + index + "']").addClass('active')
            $(".side-wizard li[data-index='" + index + "'] a span i").removeClass('fa fa-ban')
            if ($(".side-wizard li[data-index='" + index + "'] a span i").html() == '' || $(".side-wizard li[data-index='" + index + "'] a span i").html() == '0%') {
                $(".side-wizard li[data-index='" + index + "'] a span i").html('0%')
        }
    }

    if((new URLSearchParams(window.location.href)).get('continue')) {
        for(i = 0; i <= 7; i++) {
            openWizard(i);
            setPercentage(i);
        }
        $('#kategori_jaminan_tambahan').trigger('change');
    }
});
