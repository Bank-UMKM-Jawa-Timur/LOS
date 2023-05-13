    $(document).ready(function() {
        var jumlahData = $('#jumlahData').val();
        // var jumlahData = $('#jumlahData').val();
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
                // $(".btn-next").click(function(e) {
                //     if (parseInt(indexNow) != parseInt(jumlahData)) {
                //         $(".btn-next").show()

                //     }
                $(".btn-simpan").show()
                $(".progress").prop('disabled', false);
                $(".btn-next").hide()
                    // });
                    // $(".btn-next").show()

            } else {
                $(".btn-next").show()
                $(".btn-simpan").hide()

            }
        }

        function cekWizard(isNext = false) {
            var indexNow = $(".form-wizard.active").data('index')
                // console.log(indexNow);
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

        function setPercentage(formIndex) {
            var form = ".form-wizard[data-index='" + formIndex + "']"

            var input = $(form + " input")
            var select = $(form + " select")
            var textarea = $(form + " textarea")
            var hidden = $(form + " input[type=hidden]")

            if (form == ".form-wizard[data-index='2']") {
                var ijin = $(form + " select[name=ijin_usaha]");
                if(ijin.val() == "nib"){
                    var ttlInput = -2
                } else if(ijin.val() == "tidak_ada_legalitas_usaha"){
                    var ttlInput = -6
                    console.log(ttlInput);
                } else if(ijin.val() == "surat_keterangan_usaha"){
                    var ttlInput = -2
                }
            } else if (form == ".form-wizard[data-index='3']") {
                var checkbox = $(form + " input[type=checkbox]:checked").length;
                if ($(form + " select[name=kategori_jaminan_utama]").find(':selected').val() == 'Tanah' || $(form + " select[name=kategori_jaminan_utama]").find(':selected').val() == 'Tanah dan Bangunan') {
                    if ($(form + " select[name=kategori_jaminan_tambahan]").find(':selected').val() == 'Tanah' || $(form + " select[name=kategori_jaminan_tambahan]").find(':selected').val() == 'Tanah dan Bangunan') {
                        if (checkbox == 2) {
                            var ttlInput = -5
                        } else if (checkbox == 3){
                            var ttlInput = -4
                        } else if (checkbox == 4){
                            var ttlInput = -3
                        } else if (checkbox == 5) {
                            var ttlInput = -2
                        } else {
                            if (checkbox == 6) {
                                var ttlInput = -1
                            } else {
                                var ttlInput = -7
                            }
                        }
                    } else {
                        if (checkbox == 1) {
                            var ttlInput = -3;
                        } else if (checkbox == 2) {
                            var ttlInput = -2;
                        } else {
                            if (checkbox == 3) {
                                var ttlInput = -1;
                            } else {
                                var ttlInput = -4;
                            }
                        }
                    }
                    // var ttlInput = -1;
                }
                else {
                    if ($(form + " select[name=kategori_jaminan_tambahan]").find(':selected').val() == 'Tanah' || $(form + " select[name=kategori_jaminan_tambahan]").find(':selected').val() == 'Tanah dan Bangunan') {
                        if (checkbox == 1) {
                            var ttlInput = -2;
                        } else if (checkbox == 2) {
                            var ttlInput = -1;
                        } else {
                            if (checkbox == 3) {
                                var ttlInput = 0;
                            } else {
                                var ttlInput = -3;
                            }
                        }
                    } else {
                        var ttlInput = 0;
                    }
                }
            }
            else if (form == ".form-wizard[data-index='6']"){
                var ttlInput = -1;
            } else {
                var ttlInput = 0;
            }

            var ttlInputFilled = 0;
            $.each(input, function(i, v) {
                ttlInput++
                if (v.value != '') {
                    ttlInputFilled++
                }
            })
            var ttlSelect = 0;
            var ttlSelectFilled = 0;
            $.each(select, function(i, v) {
                ttlSelect++
                if (v.value != '') {
                    ttlSelectFilled++
                }
            })

            var ttlTextarea = 0;
            var ttlTextareaFilled = 0;
            $.each(textarea, function(i, v) {
                ttlTextarea++
                if (v.value != '') {
                    ttlTextareaFilled++
                }
            })

            var ttlHidden = 0;
            var ttlHiddenFilled = 0;
            $.each(hidden, function(i, v) {
                ttlHidden++
                if (v.value != '') {
                    ttlHiddenFilled++
                }
            })

            var allInput = ttlInput + ttlSelect + ttlTextarea - ttlHidden
            var allInputFilled = ttlInputFilled + ttlSelectFilled + ttlTextareaFilled - ttlHiddenFilled

            var percentage = parseInt(allInputFilled / allInput * 100);
            percentage = percentage.isNan ? 0 : percentage;
            $(".side-wizard li[data-index='" + formIndex + "'] a span i").html(percentage + "%")
            $(".side-wizard li[data-index='" + formIndex + "'] input.answer").val(allInput);
            $(".side-wizard li[data-index='" + formIndex + "'] input.answerFilled").val(allInputFilled);
            var allInputTotal = 0;
            var allInputFilledTotal = 0;
            $(".side-wizard li input.answer").each(function() {
                allInputTotal += Number($(this).val());
            });
            $(".side-wizard li input.answerFilled").each(function() {
                allInputFilledTotal += Number($(this).val());
            });

            var result = parseInt(allInputFilledTotal / allInputTotal * 100);
            $('.progress').val(result);
            console.log(allInput);
            console.log(allInputFilled);
            console.log("Input: "+ttlInput + " index: "+formIndex);
            console.log("Input Filled: "+ttlInputFilled + " index: "+formIndex);
            console.log("Select: "+ttlSelect + " index: "+formIndex);
            console.log("Select Filled: "+ttlSelectFilled + " index: "+formIndex);
        }

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
                    // console.log($(".form-wizard[data-index='"+next+"']").length==1);
                    // console.log($(".form-wizard[data-index='"+  +"']"));
                if ($(".form-wizard[data-index='" + next + "']").length == 1) {
                    // console.log(indexNow);
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
            event.preventDefault(e);
            var indexNow = $(".form-wizard.active").data('index')
            var prev = parseInt(indexNow) - 1
            if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
                $(".form-wizard").removeClass('active')
                $(".form-wizard[data-index='" + prev + "']").addClass('active')
            }
            cekWizard()
            cekBtn()
            e.preventDefault();
        })

        function openWizard(index) {
            $(".side-wizard li[data-index='" + index + "']").addClass('active')
                $(".side-wizard li[data-index='" + index + "'] a span i").removeClass('fa fa-ban')
                if ($(".side-wizard li[data-index='" + index + "'] a span i").html() == '' || $(".side-wizard li[data-index='" + index + "'] a span i").html() == '0%') {
                    $(".side-wizard li[data-index='" + index + "'] a span i").html('0%')
            }
        }

        setPercentage(0);

        if((new URLSearchParams(window.location.href)).get('continue')) {
            for(i = 0; i <= 7; i++) {
                openWizard(i);
                setPercentage(i);
            }
            $('#kategori_jaminan_tambahan').trigger('change');
        }
    });
