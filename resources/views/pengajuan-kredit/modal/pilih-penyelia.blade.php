<!-- Modal -->
<div class="modal fade" id="pilihPenyeliaModal" tabindex="-1" aria-labelledby="pilihPenyeliaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form-pilih-penyelia" action="" method="post">
                @csrf
                <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                <div class="modal-header">
                    <h5 class="modal-title">Tindak Lanjut Penyelia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="select-penyelia" for="">Pilih Penyelia</label>
                        <select name="select_penyelia" id="select_penyelia"
                            class="form-control select2 @error('select_penyelia') is-invalid @enderror" required>
                        </select>
                        @error('select_penyelia')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
    </div>
</div>
</div>
@push('custom-script')
<script>
    $('.tindak-lanjut-penyelia-link').on('click', function() {
        const id = $(this).data('id')
        const tipe = $(this).data('tipe')
        $('#id_pengajuan').val(id)

        $.ajax({
            type: "GET",
            url: "{{ url('/user-json') }}/"+tipe,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#select_penyelia").empty()
                if (response.status == 'success') {
                    if (tipe == 'penyelia kredit') {
                        var url = "{{ route('pengajuan.check.penyeliakredit') }}";
                        $('#form-pilih-penyelia').attr("action", url);
                        $("#select_penyelia").append('<option value="">-- Pilih Penyelia --</option>');
                    }
                    else if (tipe == 'pbp') {
                        var url = "{{url('/pengajuan-kredit/pincab')}}/"+id
                        $('#form-pilih-penyelia').attr("action", url);
                        $('#form-pilih-penyelia').attr("method", "get");
                        $('.modal-title').html('Tindak Lanjut PBP')
                        $('.select-penyelia').html('Pilih PBP')
                        $("#select_penyelia").append('<option value="">-- Pilih PBP --</option>');
                    }
                    else {
                        alert('Terjadi kesalahan');
                    }
                    if (response.data) {
                        if (response.data.length > 0) {
                            for (let i = 0; i < response.data.length; i++) {
                                console.log('data : '+response.data[i].email)
                                var mySelect = $("#select_penyelia").append('<option value="'+response.data[i].id+'">'+response.data[i].nip+' - '+response.data[i].name+'</option>');
                            }
                        }
                    }
                    $('#pilihPenyeliaModal').modal('show')
                } else {
                    console.log(response.message)
                }
            },
            error: function(e) {
                console.log(e)
            }
        })

    })
</script>
@endpush