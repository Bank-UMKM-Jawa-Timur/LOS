<script>
    function fillTempFile(selector) {
        const xhr = new XMLHttpRequest();
        xhr.onload = function() {
            const container = new DataTransfer();
            const file = new File([xhr.response], 'filled.png', {
                type: 'image/png',
                lastModified: (new Date().getTime()),
            }, 'utf-8');

            container.items.add(file);
            $(selector).each((i, el) => el.files = container.files);
        }

        xhr.open('GET', '/assets/img/no-image.png');
        xhr.responseType = 'blob';
        xhr.send();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });

    $('.btn-next').click(function(e) {
        if($('#wizard-data-umum').hasClass('active')) saveDataUmum();
        let dataIndex = $(".form-wizard.active").attr("data-index");
        const skema = $('#skema_kredit').val();
        console.log('skema : '+skema)
        if (skema == 'KKB') {
            if (dataIndex == 1) {
                const id_data_po_temp = $('#id_data_po_temp').val();
                if (id_data_po_temp == null || id_data_po_temp == '') {
                    saveDataPO();
                }
            }
        }
        if(dataIndex > 0){
            /*$(".form-wizard[data-index="+dataIndex+"] input[type=file]").each(function(){
                const inputFile = $(this);
                if(inputFile.prop('files')[0] != null){
                    saveTempFile(inputFile);
                }
            })*/
        }

        cekValueKosong(dataIndex);
    });

    function sendFile(dataIndex){
        
    }

    function saveDataPO() {
        const url = `{{ route('pengajuan-kredit.save-data-po') }}`;
        const id_calon_nasabah = $("#id_nasabah").val()
        const merk = $("#merk").val()
        const tipe = $("#tipe_kendaraan").val()
        const tahun = $("#tahun").val()
        const warna = $("#warna").val()
        const pemesanan = $("#pemesanan").val()
        const sejumlah = $("#sejumlah").val()
        const harga = $("#harga").val()

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'id_calon_nasabah': id_calon_nasabah,
                'merk': merk,
                'tipe_kendaraan': tipe,
                'tahun': tahun,
                'warna': warna,
                'pemesanan': pemesanan,
                'sejumlah': sejumlah,
                'harga': harga,
            },
            success: (res) => {
                console.log('------save data po temp-------')
                console.log(res)
                if (res) {
                    if (res.data.id) {
                        $('#id_data_po_temp').val(res.data.id)
                    }
                }
            }
        });
    }

    function saveTempFile(inputFile){
        const url = `{{ route('pengajuan-kredit.temp.file') }}`;
        const inputData = inputFile;
        const formData = new FormData();
        const answerId = inputData.attr('name').replace(/\D/g, '');

        formData.append('file', inputData.prop('files')[0]);
        formData.append('file_id', inputData.attr('data-id'));
        formData.append('answer_id', answerId);
        formData.append('id_calon_nasabah', $("#id_nasabah").val());

        $.ajax({
            url,
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: (res) => {
                inputData.val('');
                inputData.siblings('.filename').html(res.data.filename);
                inputData.attr('data-id', res.data.file_id);
                fillTempFile(inputFile + `input[data-id="${res.data.file_id}"]`);
            }
        });
    } 

    function saveDataUmum(){
        let idNasabah = null
        if($("#id_nasabah").val() != null || $("#id_nasabah").val() != ""){
            idNasabah = $("#id_nasabah").val()
        } else {
            idNasabah = null
        }
        const data = {
            id_nasabah: idNasabah,
        };
        $('#wizard-data-umum input, #wizard-data-umum select, #wizard-data-umum textarea').each(function() {
            const input = $(this);
            data[input.attr('name')] = input.val();
        });

        if (idNasabah == null || idNasabah == "") {
            $.ajax({
                url: '{{ route('pengajuan-kredit.temp.nasabah') }}',
                method: 'POST',
                data: data,
                success(res) {
                    ////console.log('-----temp nasabah-----');
                    ////console.log(res);
                    $("#id_nasabah").val(res.data.id);
                    $("#wizard-data-umum input[type=file]").each(function() {
                        const inputFile = $(this);
                        if(inputFile.prop('files')[0] != null){
                            saveTempFile(inputFile);
                        }
                    })
                }
            });
        }
    }
    function saveDataTemporary(i){
        ////console.log('---saveDataTemporary---')
        ////console.log('id_nasabah : '+$("#id_nasabah").val())
        let data = {
            idCalonNasabah: $("#id_nasabah").val(),
        };
        let form = $(".form-wizard[data-index='" + i + "']");

        $(".form-wizard[data-index='" + i + "'] input, .form-wizard[data-index='" + i + "'] select, .form-wizard[data-index='" + i + "'] textarea").each(function(){
            let input = $(this)
            // ////console.log('test');

            data[input.attr('name')] = input.val();
            data['idCalonNasabah'] = $("#id_nasabah").val();
        });

        ////console.log(data);
        $.ajax({
            url: '{{ route('pengajuan-kredit.temp.jawaban') }}',
            method: 'POST',
            data: data,
            success(res) {
                ////console.log('------temp jawaban------')
                ////console.log(res);
            }
        });
    }

    // Fill temporary file with empty picture
    const selectors = [];

    $('span.filename').each((i, el) => {
        const filename = $(el);
        const input = filename.parent().find('input[type="file"]');

        if(filename.text().trim().length < 1) return;
        selectors.push(`input[data-id="${input.data('id')}"]`);
    });

    fillTempFile(selectors.join(','));
</script>