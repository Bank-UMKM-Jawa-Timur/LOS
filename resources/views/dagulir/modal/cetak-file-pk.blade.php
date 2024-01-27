<div class="modal-layout hidden" id="uploadPKModal">
    <div class="modal modal-sm bg-white">
        <form id="form-pk" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="token">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Realisasi Kredit
                    </h2>
                </div>
                <button data-dismiss-id="uploadPKModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <a class="x-7 py-2 p-2 rounded items-center font-semibold bg-theme-primary border text-white mb-4"
                        target="_blank" id="btn-cetak-file">
                        Cetak file PK
                    </a>
                <br>
                @csrf
                <input type="hidden" name="tipe_file" value="PK">
                <input type="hidden" name="kode_pendaftaran" id="kode_pendaftaran" value="">
                    <div class="form-group-1 mt-4">
                        <div class="form-group-1 mt-4" id="div_no_loan">
                            <div class="input-box">
                                <label for="no_loan">No Loan</label>
                                <input type="Text" name="no_loan" id="no_loan" class="form-input" required>
                                <span class="text-red-500 m-0 mt-2 hidden">Harus diisi.</span>
                            </div>
                        </div>
                        <div class="input-box">
                            <label for="no_pk">No PK</label>
                            <input type="Text" name="no_pk" id="no_pk" class="form-input" required>
                            <span class="text-red-500 m-0 mt-2 hidden">Harus diisi.</span>
                        </div>
                    </div>

                    <div class="form-group-1">
                        <div class="input-box">
                            <label for="pk">File PK</label>
                            <input type="file" name="pk" id="pk" class="form-input file limit-size" required>
                            <span class="text-red-500 m-0 mt-2 hidden">Besaran file tidak boleh lebih dari 5 MB.</span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="skema" id="skema">
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="uploadPKModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit simpan-pk">Simpan</button>
            </div>
        </form>
    </div>
</div>
@push('script-inject')
    <script>
        // Limit Upload
        $('.limit-size').on('change', function() {
            var size = (this.files[0].size / 1024 / 1024).toFixed(2)
            if (size > 5) {
                $(this).next().html('Besaran file tidak boleh lebih dari 5 MB.')
                $(this).next().removeClass('hidden');
                this.value = ''
            } else {
                $(this).next().addClass('hidden');
            }
        })

        $('#form-pk .btn-submit').on('click', function(e) {
            e.preventDefault()
            var no_pk = $('#no_pk').val()
            var no_loan = $('#no_loan').val()
            var file = $('#pk').val()
            var skema = $('#skema').val()

            if (no_pk == '') {
                $('#no_pk').next().removeClass('hidden')
            }
            else {
                $('#no_pk').next().addClass('hidden')
            }

            if (no_loan == '') {
                $('#no_loan').next().removeClass('hidden')
            }
            else {
                $('#no_loan').next().addClass('hidden')
            }

            if (file == '') {
                $('#pk').next().html('Harus diisi.')
                $('#pk').next().removeClass('hidden')
            }
            else {
                $('#pk').next().addClass('hidden')
            }

            if (skema == 'Dagulir') {
                if (no_pk != '' && no_loan != '' && file != '') {
                    $('#uploadPKModal #form-pk').submit()
                }
            } else {
                if (no_pk != '' && file != '') {
                    $('#uploadPKModal #form-pk').submit()
                }
            }
        })
    </script>
@endpush
