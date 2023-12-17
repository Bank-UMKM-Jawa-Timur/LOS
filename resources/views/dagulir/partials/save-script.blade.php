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

    $('body').on('change', 'input[type=file]', function(e) {
        const url = `{{ route('dagulir.temp.file') }}`;
        const inputData = $(this);
        const formData = new FormData();
        const answerId = inputData.attr('name').replace(/\D/g, '');

        formData.append('file', e.target.files[0]);
        formData.append('file_id', inputData.attr('data-id'));
        formData.append('answer_id', answerId);
        formData.append('id_dagulir_temp', {{ $duTemp->id }});

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
                fillTempFile(`input[data-id="${res.data.file_id}"]`);
            }
        });
    });

    function saveDataUmum() {
        const data = {
            id_nasabah: {{ $duTemp->id }},
        };

        $('#dagulir-tab input, #dagulir-tab select, #dagulir-tab textarea').each(function() {
            const input = $(this);
            data[input.attr('name')] = input.val();
        });
        //console.log(data);

        $.ajax({
            url: '{{ route('dagulir.temp.dagulir') }}',
            method: 'POST',
            data,
            success(res) {
                console.log(res);
                $('#id_dagulir_temp').val()
            }
        });
    }

    function saveDatatemporary_dagulir(id){
        let data = {
            id_dagulir_temp: {{ $duTemp?->id ?? null}},
        };
        let form = $($(`#${id} input, #${id} select, #${id} textarea`));

        $(`#${id} input, #${id} select, #${id} textarea`).each(function(){
            let input = $(this)
            // //console.log('test');

            data[input.attr('name')] = input.val();
            data['id_nasabah'] = {{ $duTemp->id }};
        });

        //console.log(data);
        $.ajax({
            url: '{{ route('dagulir.temp.jawaban') }}',
            method: 'POST',
            data: data,
            success(res) {
                //console.log(res);
            }
        });
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