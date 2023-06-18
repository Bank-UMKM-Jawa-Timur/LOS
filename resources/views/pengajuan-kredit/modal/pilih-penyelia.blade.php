<form id="form-pilih-penyelia" action="" method="post" style="display: none;">
    @csrf
    <input name="id_pengajuan" id="id_pengajuan">
    <input name="select_penyelia" id="select_penyelia">
</form>
@push('custom-script')
    <script>
        function showTindakLanjut(id, tipe) {

            $.ajax({
                type: "GET",
                url: "{{ url('/user-json') }}/" + tipe,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    const inputOptions = {};
                    const data = response['data'];

                    data.forEach(option => {
                        console.log(option);
                        inputOptions[option['id']] = option['nip'] + " | " + option['name'];
                    });
                    $('#id_pengajuan').val(id)

                    if (tipe == 'penyelia kredit') {
                        var url = "{{ route('pengajuan.check.penyeliakredit') }}";
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
                            customClass: {
                                input: 'form-control sweetalert-select'
                            },
                            allowOutsideClick: false,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const selectedOption = result.value;
                                $("#select_penyelia").val(selectedOption);
                                $("#form-pilih-penyelia").submit();
                            }
                        });
                    } else if (tipe == 'pbp') {
                        var url = "{{ url('/pengajuan-kredit/pincab') }}/" + id
                        $('#form-pilih-penyelia').attr("action", url);
                        $('#form-pilih-penyelia').attr("method", "get");
                        swal.fire({
                            title: 'Tindak Lanjut PBP',
                            input: 'select',
                            inputOptions: inputOptions,
                            inputPlaceholder: 'Pilih PBP',
                            showCancelButton: true,
                            confirmButtonText: 'Lanjutkan',
                            cancelButtonText: 'Batal',
                            inputValidator: (value) => {
                                return !value && 'Pilih PBP';
                            },
                            customClass: {
                                input: 'form-control sweetalert-select'
                            },
                            allowOutsideClick: false,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const selectedOption = result.value;
                                $("#select_penyelia").val(selectedOption);
                                $("#form-pilih-penyelia").submit();
                            }
                        });
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });

        }

        //     // $('#id_pengajuan').val(id)

        //     // $.ajax({
        //     //     type: "GET",
        //     //     url: "{{ url('/user-json') }}/"+tipe,
        //     //     cache: false,
        //     //     contentType: false,
        //     //     processData: false,
        //     //     success: function(response) {
        //     //         $("#select_penyelia").empty()
        //     //         if (response.status == 'success') {
        //     //             if (tipe == 'penyelia kredit') {
        //     //                 var url = "{{ route('pengajuan.check.penyeliakredit') }}";
        //     //                 $('#form-pilih-penyelia').attr("action", url);
        //     //                 $("#select_penyelia").append('<option value="">-- Pilih Penyelia --</option>');
        //     //             }
        //     //             else if (tipe == 'pbp') {
        //     //                 var url = "{{ url('/pengajuan-kredit/pincab') }}/"+id
        //     //                 $('#form-pilih-penyelia').attr("action", url);
        //     //                 $('#form-pilih-penyelia').attr("method", "get");
        //     //                 $('.modal-title').html('Tindak Lanjut PBP')
        //     //                 $('.select-penyelia').html('Pilih PBP')
        //     //                 $("#select_penyelia").append('<option value="">-- Pilih PBP --</option>');
        //     //             }
        //     //             else {
        //     //                 alert('Terjadi kesalahan');
        //     //             }
        //     //             if (response.data) {
        //     //                 if (response.data.length > 0) {
        //     //                     for (let i = 0; i < response.data.length; i++) {
        //     //                         console.log('data : '+response.data[i].email)
        //     //                         var mySelect = $("#select_penyelia").append('<option value="'+response.data[i].id+'">'+response.data[i].nip+' - '+response.data[i].name+'</option>');
        //     //                     }
        //     //                 }
        //     //             }
        //     //             $('#pilihPenyeliaModal').modal('show')
        //     //         } else {
        //     //             console.log(response.message)
        //     //         }
        //     //     },
        //     //     error: function(e) {
        //     //         console.log(e)
        //     //     }
        //     // })

        // })
    </script>
@endpush
