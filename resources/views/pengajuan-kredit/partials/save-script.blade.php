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

        formData.append(inputData.attr('name'), e.target.files[0]);

        $.ajax({
            url,
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: (res) => {
                inputData.val('');
                inputData.siblings('.filename').html(res.filename);
            }
        });
    });

    function saveDataUmum() {
        const data = {};

        $('#wizard-data-umum input, #wizard-data-umum select, #wizard-data-umum textarea').each(function() {
            const input = $(this);

            data[input.attr('name')] = input.val();
        });

        $.ajax({
            url: '{{ route('pengajuan-kredit.temp.nasabah') }}',
            method: 'POST',
            data,
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
