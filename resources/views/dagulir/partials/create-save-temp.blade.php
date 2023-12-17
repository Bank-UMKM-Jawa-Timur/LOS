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
        if(dataIndex > 0){
            $(".form-wizard[data-index="+dataIndex+"] input[type=file]").each(function(){
                const inputFile = $(this);
                if(inputFile.prop('files')[0] != null){
                    saveTempFile(inputFile);
                }
            })
        }

        cekValueKosong(dataIndex);
    });

    function sendFile(dataIndex){
        
    }

    function saveTempFile(inputFile){
        const url = `{{ route('dagulir.temp.file') }}`;
        const inputData = inputFile;
        const formData = new FormData();
        const answerId = inputData.attr('name').replace(/\D/g, '');

        formData.append('file', inputData.prop('files')[0]);
        formData.append('file_id', inputData.attr('data-id'));
        formData.append('answer_id', answerId);
        formData.append('id_dagulir_temp', $("#id_dagulir_temp").val());

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
        let id_dagulir_temp = null
        if($("#id_dagulir_temp").val() != null || $("#id_dagulir_temp").val() != ""){
            id_dagulir_temp = $("#id_dagulir_temp").val()
        } else {
            id_dagulir_temp = null
        }
        const data = {
            id_dagulir_temp: id_dagulir_temp,
        };
        $('#dagulir-tab input, #dagulir-tab select, #dagulir-tab textarea').each(function() {
            const input = $(this);
            data[input.attr('name')] = input.val();
        });
        $.ajax({
            url: '{{ route('dagulir.temp.dagulir') }}',
            method: 'POST',
            data: data,
            success(res) {
                ////console.log('-----temp nasabah-----');
                ////console.log(res);
                $("#id_dagulir_temp").val(res.data.id);
                $("#dagulir-tab input[type=file]").each(function() {
                    const inputFile = $(this);
                    if(inputFile.prop('files')[0] != null){
                        saveTempFile(inputFile);
                    }
                })
            }
        });
    }
    function saveDataTemporary(id){
        ////console.log('---saveDataTemporary---')
        ////console.log('id_nasabah : '+$("#id_nasabah").val())
        let data = {
            id_dagulir_temp: $("#id_dagulir_temp").val(),
        };
        let form = $(`${id}`);

        $(`#${id} input, #${id} select, #${id} textarea`).each(function(){
            let input = $(this)
            console.log(input);

            data[input.attr('name')] = input.val();
            data['id_dagulir_temp'] = $("#id_dagulir_temp").val();
        });

        console.log(data);
        $.ajax({
            url: '{{ route('dagulir.temp.jawaban') }}',
            method: 'POST',
            data: data,
            success(res) {
                console.log('------temp jawaban------')
                console.log(res);
            }
        });
        $(`#${id} input[type=file]`).each(function(){
            const inputFile = $(this);
            console.log(inputFile);
            if(inputFile.prop('files')[0] != null){
                saveTempFile(inputFile);
            }
        })
    }

    $('#kabupaten').trigger('change');

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