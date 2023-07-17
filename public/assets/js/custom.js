$(document).ready(function () {
    $(".only-number").keyup(function (e) {
        this.value = this.value.replace(/[^\d]/, "");
    });

    var jumlahData = $("#jumlahData").val();
    // setPercentage(0);

    function setPercentage(formIndex) {
        let valSkema = $("#skema").val();

        var form = ".form-wizard[data-index='" + formIndex + "']";
        var inputText = $(form + " .row input[type=text]");
        var inputNumber = $(form + " input[type=number]");
        var inputDisabled = $(form + " input:disabled");
        var inputReadonly = $(form + " input").find("readonly");
        var inputHidden = $(form + " input[type=hidden]");
        var inputFile = $(form + " input[type=file]");
        var inputFilename = $(form).find('.filename');
        var inputDate = $(form + " input[type=date]");
        var select = $(form + " select");
        var textarea = $(form + " textarea");
        var totalText = inputText ? inputText.length : 0;
        var totalNumber = inputNumber ? inputNumber.length : 0;
        var totalDisabled = inputDisabled ? inputDisabled.length : 0;
        var totalReadonly = inputReadonly ? inputReadonly.length : 0;
        var totalHidden = inputHidden ? inputHidden.length : 0;
        var totalFile = inputFile ? inputFile.length : 0;
        var totalDate = inputDate ? inputDate.length : 0;
        var totalSelect = select ? select.length : 0;
        var totalTextArea = textarea ? textarea.length : 0;

        var subtotalInput =
            totalText +
            totalNumber +
            totalFile +
            totalDate +
            totalSelect +
            totalTextArea;

        if (valSkema == "KKB") {
            if (formIndex == 3) {
                // var ijinUsahaSelect = $(form).find("#ijin_usaha");
                var ijinUsahaSelect = $("#ijin_usaha").val();
                console.log("length : " + ijinUsahaSelect);
                if (ijinUsahaSelect != "" || ijinUsahaSelect != null) {
                    if (ijinUsahaSelect == "nib") {
                        subtotalInput -= 2;
                    }
                    if (ijinUsahaSelect == "surat_keterangan_usaha") {
                        if ($("#isNpwp").is(":checked")) {
                            subtotalInput -= 2;
                        } else {
                            subtotalInput -= 4;
                        }
                    }
                    if (ijinUsahaSelect == "tidak_ada_legalitas_usaha") {
                        subtotalInput -= 6;
                    }
                }
            }
    
            if (formIndex == 4) {
                var jaminanTambSel = $("#kategori_jaminan_tambahan").val();
                if (jaminanTambSel == "Tanah dan Bangunan") {
                    subtotalInput -= 5;
                } else if (jaminanTambSel == "Tanah") {
                    subtotalInput -= 5;
                } else {
                    subtotalInput -= 2;
                }
            }
    
            if (formIndex == 7) {
                subtotalInput -= 1;
            }
        }
        else {
            if (formIndex == 2) {
                // var ijinUsahaSelect = $(form).find("#ijin_usaha");
                var ijinUsahaSelect = $("#ijin_usaha").val();
                console.log("length : " + ijinUsahaSelect);
                if (ijinUsahaSelect != "" || ijinUsahaSelect != null) {
                    if (ijinUsahaSelect == "nib") {
                        subtotalInput -= 2;
                    }
                    if (ijinUsahaSelect == "surat_keterangan_usaha") {
                        if ($("#isNpwp").is(":checked")) {
                            subtotalInput -= 2;
                        } else {
                            subtotalInput -= 4;
                        }
                    }
                    if (ijinUsahaSelect == "tidak_ada_legalitas_usaha") {
                        subtotalInput -= 6;
                    }
                }
            }
    
            if (formIndex == 3) {
                var jaminanTambSel = $("#kategori_jaminan_tambahan").val();
                if (jaminanTambSel == "Tanah dan Bangunan") {
                    subtotalInput -= 5;
                } else if (jaminanTambSel == "Tanah") {
                    subtotalInput -= 5;
                } else {
                    subtotalInput -= 2;
                }
            }
    
            if (formIndex == 6) {
                subtotalInput -= 1;
            }
        }

        var ttlInputTextFilled = 0;
        $.each(inputText, function (i, v) {
            if (v.value != "") {
                ttlInputTextFilled++;
            }
        });
        var ttlInputNumberFilled = 0;
        $.each(inputNumber, function (i, v) {
            if (v.value != "") {
                ttlInputNumberFilled++;
            }
        });
        var ttlInputFileFilled = 0;
        $.each(inputFile, function (i, v) {
            var filename = inputFilename[i].innerHTML
            if (v.value != "" || filename != "") {
                ttlInputFileFilled++;
            }
        });
        var ttlInputDateFilled = 0;
        $.each(inputDate, function (i, v) {
            if (v.value != "") {
                ttlInputDateFilled++;
            }
        });
        var ttlSelectFilled = 0;
        $.each(select, function(i, v) {
            /*var data = v.value;
            if (data != "" && data != '' && data != null && data != ' --Pilih Opsi-- ' && data !=
                '--Pilih Opsi--') {
                ttlSelectFilled++
            }*/
            var data = v.value;
            var displayValue = "";
            if (v.id != '')
                displayValue = $('#'+v.id).css('display');

            if (
                data != "" &&
                data != "" &&
                data != null &&
                data != " --Pilih Opsi-- " &&
                data != " --Pilih Status --" &&
                data != "-- Pilih Kategori Jaminan Tambahan --" &&
                data != "---Pilih Kabupaten----" &&
                data != "---Pilih Kecamatan----" &&
                data != "---Pilih Desa----" &&
                displayValue != "" &&
                displayValue != "none"
            ) {
                ttlSelectFilled++;
            }
        })
        var ttlTextAreaFilled = 0;
        $.each(textarea, function (i, v) {
            if (v.value != "") {
                ttlTextAreaFilled++;
            }
        });

        var subtotalFilled =
            ttlInputTextFilled +
            ttlInputNumberFilled +
            ttlInputFileFilled +
            ttlInputDateFilled +
            ttlSelectFilled +
            ttlTextAreaFilled;
        if (formIndex == 0) {
            let value = $("#status").val();
            //console.log('status : '+value)
            if (value == "menikah") {
                // subtotalInput += 2;
                subtotalFilled += 2;
            } else {
                // subtotalInput += 1;
                if (status != "") subtotalFilled += 2;
            }
        }
        // if (formIndex == 0) {
            console.log("=============index : " + formIndex + "=============");
            console.log("total input : " + subtotalInput);
            console.log("total input filled : " + subtotalFilled);
            console.log({
                ttlInputTextFilled,
                ttlInputNumberFilled,
                ttlInputFileFilled,
                ttlInputDateFilled,
                ttlSelectFilled,
                ttlTextAreaFilled,
            });
            console.log("===============================================");
        // }

        var percentage = parseInt((subtotalFilled / subtotalInput) * 100);
        percentage = Number.isNaN(percentage) ? 0 : percentage;
        percentage = percentage > 100 ? 100 : percentage;
        percentage = percentage < 0 ? 0 : percentage;

        $(".side-wizard li[data-index='" + formIndex + "'] a span i").html(
            percentage + "%"
        );
    }

    function cekBtn() {
        var indexNow = $(".form-wizard.active").data("index");
        var prev = parseInt(indexNow) - 1;
        var next = parseInt(indexNow) + 1;

        $(".btn-prev").hide();
        $(".btn-simpan").hide();

        $(".progress").prop("disabled", true);
        if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
            $(".btn-prev").show();
        }

        if (parseInt(indexNow) == parseInt(jumlahData)) {
            $(".btn-simpan").show();
            $(".progress").prop("disabled", false);
            $(".btn-next").hide();
        } else {
            $(".btn-next").show();
            $(".btn-simpan").hide();
        }
    }

    function cekWizard(isNext = false) {
        var indexNow = $(".form-wizard.active").data("index");
        // //console.log(indexNow);
        if (isNext) {
            $(".side-wizard li").removeClass("active");
        }

        $(".side-wizard li").removeClass("selected");

        for (let index = 0; index <= parseInt(indexNow); index++) {
            var selected = index == parseInt(indexNow) ? " selected" : "";
            $(".side-wizard li[data-index='" + index + "']").addClass(
                "active" + selected
            );
            $(
                ".side-wizard li[data-index='" + index + "'] a span i"
            ).removeClass("fa fa-ban");
            if (
                $(
                    ".side-wizard li[data-index='" + index + "'] a span i"
                ).html() == "" ||
                $(
                    ".side-wizard li[data-index='" + index + "'] a span i"
                ).html() == "0%"
            ) {
                $(".side-wizard li[data-index='" + index + "'] a span i").html(
                    "0%"
                );
            }
        }
    }
    cekBtn();
    cekWizard();

    $(".side-wizard li a").click(function () {
        var dataIndex = $(this).closest("li").data("index");
        var indexNow = $(".form-wizard.active").data("index");
        if ($(this).closest("li").hasClass("active")) {
            $(".form-wizard").removeClass("active");
            $(".form-wizard[data-index='" + dataIndex + "']").addClass(
                "active"
            );
            cekWizard();
            cekBtn();
            saveDataTemporary(indexNow);
            setPercentage(dataIndex)
        }
    });

    function cekNpwp(indexNow) {
        var isNext = true;
        var labelNpwp = "NPWP";
        if (indexNow == 2 && $("#npwp").length == 1) {
            var kredit = $("#jumlah_kredit").val();
            var npwp = $("#npwp").val();
            if (kredit >= 50000000 && npwp == "") {
                isNext = false;
                labelNpwp = `NPWP <span style='color:red'>Pengajuan >= 50 Juta wajib memiliki NPWP</span>`;
            }
        }
        return [isNext, labelNpwp];
    }

    $(".btn-next").click(function (e) {
        e.preventDefault();

        let valSkema = $("#skema").val();
        var indexNow = $(".form-wizard.active").data("index");
        // setPercentage(indexNow);

        if (indexNow != 0) {
            if (indexNow == 1) {
                if (valSkema != "KKB") {
                    saveDataTemporary(indexNow);
                }
            } else {
                if (valSkema != "KKB") {
                    saveDataTemporary(indexNow);
                }
            }
            // saveDataTemporary(indexNow);
        }

        if (cekNpwp(indexNow)[0]) {
            var next = parseInt(indexNow) + 1;
            // //console.log($(".form-wizard[data-index='"+next+"']").length==1);
            // //console.log($(".form-wizard[data-index='"+  +"']"));
            if ($(".form-wizard[data-index='" + next + "']").length == 1) {
                // //console.log(indexNow);
                $(".form-wizard").removeClass("active");
                $(".form-wizard[data-index='" + next + "']").addClass("active");
                $(".form-wizard[data-index='" + indexNow + "']").attr(
                    "data-done",
                    "true"
                );
            }

            cekWizard();
            cekBtn();
            // setPercentage(indexNow);
        }
        $("#npwp")
            .closest(".form-group")
            .find("label")
            .html(cekNpwp(indexNow)[1]);
        cekWizard();
        cekBtn();
        setPercentage(indexNow);
    });

    $(".btn-prev").click(function (e) {
        e.preventDefault(e);

        var indexNow = $(".form-wizard.active").data("index");
        var prev = parseInt(indexNow) - 1;
        if ($(".form-wizard[data-index='" + prev + "']").length == 1) {
            $(".form-wizard").removeClass("active");
            $(".form-wizard[data-index='" + prev + "']").addClass("active");
        }
        cekWizard();
        cekBtn();
        e.preventDefault();
        setPercentage(indexNow);
    });

    function openWizard(index) {
        $(".side-wizard li[data-index='" + index + "']").addClass("active");
        $(".side-wizard li[data-index='" + index + "'] a span i").removeClass(
            "fa fa-ban"
        );
        if (
            $(".side-wizard li[data-index='" + index + "'] a span i").html() ==
                "" ||
            $(".side-wizard li[data-index='" + index + "'] a span i").html() ==
                "0%"
        ) {
            $(".side-wizard li[data-index='" + index + "'] a span i").html(
                "0%"
            );
        }
    }

    if (new URLSearchParams(window.location.href).get("continue")) {
        for (i = 0; i <= 7; i++) {
            openWizard(i);
            setPercentage(i);
        }
        $("#kategori_jaminan_tambahan").trigger("change");
    }
});
