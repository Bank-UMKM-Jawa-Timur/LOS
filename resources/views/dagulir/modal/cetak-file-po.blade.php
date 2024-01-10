<div class="modal-layout hidden" id="uploadPOModal">
    <div class="modal modal-sm bg-white">
        <form id="form-po" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="token">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Upload PO
                    </h2>
                </div>
                <button data-dismiss-id="uploadPOModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <a class="x-7 py-2 p-2 rounded items-center font-semibold bg-theme-primary border text-white"
                        target="_blank" id="btn-cetak-file">Cetak file PO
                    </a>
                <br>
                @csrf
                <input type="hidden" name="tipe_file" value="PO">
                    <div class="form-group">
                        <label for="po">No PO</label>
                        <input type="text" name="no_po" id="no_po" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="po">File PO</label>
                        <input type="file" name="po" id="po" class="form-input file" required>
                        <span class="text-red-500 m-0 mt-2 hidden">Besaran file tidak boleh lebih dari 5 MB.</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="uploadPOModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit simpan-po">Simpan</button>
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

        $('#form-po .btn-submit').on('click', function(e) {
            e.preventDefault()
            var file = $('#po').val()
            var no_po = $('#no_po').val()

            if (file == '' && no_po != '') {
                $('#po').next().html('Harus diisi.')
                $('#po').next().removeClass('hidden')
            } else if (no_po == '' && file != ''){
                $('#no_po').next().html('Harus diisi.')
                $('#no_po').next().removeClass('hidden')
            } else {
                $('#po').next().addClass('hidden')
                $('#no_po').next().addClass('hidden')
                $('#uploadPOModal #form-po').submit()
            }
        })
    </script>
@endpush
