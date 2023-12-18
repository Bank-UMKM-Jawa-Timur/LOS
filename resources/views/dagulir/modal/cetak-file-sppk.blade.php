<div class="modal-layout hidden" id="uploadSPPKModal">
    <div class="modal modal-sm bg-white">
        <form id="form-sppk" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="token">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Upload SPPK.
                    </h2>
                </div>
                <button data-dismiss-id="uploadSPPKModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <a class="x-7 py-2 p-2 rounded items-center font-semibold bg-theme-primary border text-white"
                        target="_blank" id="btn-cetak-file">Cetak file SPPK
                    </a>
                <br>
                @csrf
                <input type="hidden" name="tipe_file" value="SPPK">
                    <div class="form-group">
                        <label for="sppk">File SPPK</label>
                        <input type="file" name="sppk" id="sppk" class="form-input file" required>
                        <span class="text-red-500 m-0 mt-2 hidden">Besaran file tidak boleh lebih dari 5 MB.</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="uploadSPPKModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
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

        $('#form-sppk .btn-submit').on('click', function(e) {
            e.preventDefault()
            var file = $('#sppk').val()

            if (file == '') {
                $('#sppk').next().html('Harus diisi.')
                $('#sppk').next().removeClass('hidden')
            }
            else {
                $('#sppk').next().addClass('hidden')
                $('#uploadSPPKModal #form-sppk').submit()
            }
        })
    </script>
@endpush