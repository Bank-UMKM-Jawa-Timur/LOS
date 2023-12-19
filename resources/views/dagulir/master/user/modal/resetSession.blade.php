<div class="modal-layout hidden" id="resetSessionModal">
    <form id="form-reset-session" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="token">
        <div class="modal modal-sm bg-white">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi Reset Session
                    </h2>
                </div>
                <button data-dismiss-id="resetSessionModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <p>Apakah anda yakin ingin reset session ini?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="resetSessionModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
@push('script-inject')
    <script>
        $('#form-reset-session .btn-submit').on('click', function(e) {
            $('#resetSessionModal #form-reset-session').submit()
        })
    </script>
@endpush
