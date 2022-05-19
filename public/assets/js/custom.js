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

            var ttlInput = 0;
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

            var allInput = ttlInput + ttlSelect + ttlTextarea
            var allInputFilled = ttlInputFilled + ttlSelectFilled + ttlTextareaFilled

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
            // $(".side-wizard li[data-index='"+index+"'] input.answerFilled").val(allInputFilled);

            // var a = 0
            // $(".answerFilled").change(function(){
            // $(".answerFilled").each(function(){
            //     var hasil =  a += parseInt($(this).val())
            //     console.log(hasil)
            // })
            // })

            // var allInputTotalFilled = 0;
            // $(".side-wizard li input.answerFilled").change(function(){
            //     $(".side-wizard li input.answerFilled").each(function(){
            //         allInputTotalFilled += Number($(this).val());
            //     });
            //     console.log(allInputTotalFilled);
            // });
            // $(".side-wizard li[data-index='"+formIndex+"'] input:text").val(allInput);
            // var result = 0;
            // var hasil = result + parseInt(test);
            // // result.push(test);

        }



        $(".btn-next").click(function(e) {
            e.preventDefault();
            var indexNow = $(".form-wizard.active").data('index')
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
    });