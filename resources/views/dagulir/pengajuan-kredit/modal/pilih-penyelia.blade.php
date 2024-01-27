<form id="form-pilih-penyelia" action="" method="post" style="display: none;">
    @csrf
    <input name="id_pengajuan" id="id_pengajuan">
    <input name="select_penyelia" id="select_penyelia">
</form>
@push('script-inject')
    <script>
        function showTindakLanjut(id, tipe) {

            $.ajax({
                type: "GET",
                url: "{{ url('/user-json') }}/" + tipe,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#preload-data').removeClass('hidden');
                },
                success: function(response) {
                    const inputOptions = {};
                    const data = response['data'];

                    data.forEach(option => {
                        console.log(option);
                        inputOptions[option['id']] = option['nip'] + " | " + option['name'];
                    });

                    $('#id_pengajuan').val(id)

                    if (tipe == 'penyelia kredit') {
                        var url = "{{ route('dagulir.pengajuan.check.penyeliakredit') }}";
                        $('#form-pilih-penyelia').attr("action", url);

                        swal.fire({
                            title: 'Tindak Lanjut Penyelia',
                            input: 'select',
                            inputOptions: inputOptions,
                            inputPlaceholder: 'Pilih Penyelia',
                            showCancelButton: true,
                            confirmButtonColor: '#112042',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Lanjutkan',
                            cancelButtonText: 'Batal',
                            inputValidator: (value) => {
                                return !value && 'Pilih Penyelia';
                            },
                            allowOutsideClick: false,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const selectedOption = result.value;
                                $("#select_penyelia").val(selectedOption);
                                $('#preload-data').removeClass('hidden');
                                $("#form-pilih-penyelia").submit();
                            }
                        });
                    }
                },
                error: function(e) {
                    console.log(e);
                    $('#preload-data').addClass('hidden');
                },
                complete: function() {
                    $('#preload-data').addClass('hidden');
                }
            });

        }
    </script>
@endpush
