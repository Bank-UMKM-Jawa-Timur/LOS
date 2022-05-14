$(document).ready(function() {

    $('#opsi').hide();
    $('#dapat_dikomentari').hide();
    $('#opsi_jawaban option').each(function() {
        var option = $('#opsi_jawaban option:selected').val();
        if (option == 'input text') {
            $('#opsi_jawaban').prop('disabled', true);

        } else if (option == 'option') {
            $('#opsi_jawaban').prop('disabled', true);
        } else {
            $('#opsi_jawaban').prop('disabled', true);

        }
    })
    $('#level option').each(function() {
        var id_level = $("#level option:selected").val()
        if (id_level == 1) {
            $('#itemTurunan1').prop('disabled', true);
            $('#itemTurunan2').prop('disabled', true);
            $('#opsi_name').prop('disabled', true);
            $('#skor').prop('disabled', true);
            $('#opsi').hide();
            $('#dapat_dikomentari').hide();
        }

        if (id_level == "1") {
            $('#itemTurunan1').prop('disabled', false);
            $('#itemTurunan2').prop('disabled', true);
            $('#opsi_name').prop('disabled', true);
            $('#skor').prop('disabled', true);
            $('#opsi').hide();
            $('#dapat_dikomentari').hide();
        } else {
            $('#itemTurunan1').prop('disabled', true);
            $('#itemTurunan2').prop('disabled', false);
            $('#opsi_name').prop('disabled', false);
            $('#skor').prop('disabled', false);
            $('#opsi').show();
            $('#dapat_dikomentari').show();
        }
        if (id_level == "2") {} else if (id_level == "3") {

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
        $.ajax({
            type: "get",
            url: url,
            data: { biggestNo: biggestNo },
            success: function(response) {
                $(".row-detail[data-no='" + thisNo + "']").after(response);

                $(".addDetail[data-no='" + next + "']").click(function(e) {
                    e.preventDefault()
                    addOption($(this));
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