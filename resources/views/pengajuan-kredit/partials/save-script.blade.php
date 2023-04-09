<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });

    $('.btn-next').click(function(e) {
        if($('#wizard-data-umum').hasClass('active')) saveDataUmum();
    });

    $('body').on('change', 'input[type=file]', function(e) {
        const url = `{{ route('pengajuan-kredit.temp.file') }}`;
        const inputData = $(this);
        const formData = new FormData();
        const answerId = inputData.attr('name').replace(/\D/g, '');

        formData.append('file', e.target.files[0]);
        formData.append('file_id', inputData.data('id'));
        formData.append('answer_id', answerId);

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
            }
        });
    });

    function saveDataUmum() {
        const data = {};

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
        let data = {};
        let form = $(".form-wizard[data-index='" + i + "']");

        $(".form-wizard[data-index='" + i + "'] input, .form-wizard[data-index='" + i + "'] select, .form-wizard[data-index='" + i + "'] textarea").each(function(){
            let input = $(this)
            // console.log('test');

            data[input.attr('name')] = input.val();
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

    setTimeout(() => {
        $('#kecamatan').trigger('change');
    }, 4000);
</script>
