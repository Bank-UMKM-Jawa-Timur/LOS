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

        cekValueKosong(dataIndex);
    });

    $('body').on('change', 'input[type=file]', function(e) {
        const url = `{{ route('pengajuan-kredit.temp.file') }}`;
        const inputData = $(this);
        const formData = new FormData();
        const answerId = inputData.attr('name').replace(/\D/g, '');

        formData.append('file', e.target.files[0]);
        formData.append('file_id', inputData.attr('data-id'));
        formData.append('answer_id', answerId);
        formData.append('id_calon_nasabah', {{ $duTemp->id }});

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

        $('#wizard-data-umum input, #wizard-data-umum select, #wizard-data-umum textarea').each(function() {
            const input = $(this);
            data[input.attr('name')] = input.val();
        });
        console.log(data);

        $.ajax({
            url: '{{ route('pengajuan-kredit.temp.nasabah') }}',
            method: 'POST',
            data,
            success(res) {
                console.log(res);
            }
        });
    }

    function saveDataTemporary(i){
        let data = {
            idCalonNasabah: {{ $duTemp?->id ?? null}},
        };
        let form = $(".form-wizard[data-index='" + i + "']");

        $(".form-wizard[data-index='" + i + "'] input, .form-wizard[data-index='" + i + "'] select, .form-wizard[data-index='" + i + "'] textarea").each(function(){
            let input = $(this)
            // console.log('test');

            data[input.attr('name')] = input.val();
            data['id_nasabah'] = {{ $duTemp->id }};
        });

        console.log(data);
        $.ajax({
            url: '{{ route('pengajuan-kredit.temp.jawaban') }}',
            method: 'POST',
            data: data,
            success(res) {
                console.log(res);
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
