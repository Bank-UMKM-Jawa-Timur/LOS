<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    });

    $('.btn-next').click(function(e) {
        if($('#wizard-data-umum').hasClass('active')) saveDataUmum();
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
