<div class="modal-layout hidden" id="resetApiSessionModal">
    <form id="form-reset-api-session" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="token_api">
        <div class="modal modal-sm bg-white">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi Reset Mobile Session
                    </h2>
                </div>
                <button data-dismiss-id="resetApiSessionModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <p>Apakah anda yakin ingin reset mobile session ini?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="resetApiSessionModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
@push('script-inject')
    <script>
        $('#form-reset-api-session .btn-submit').on('click', function(e) {
            $('#resetApiSessionModal #form-reset-api-session').submit()
        })
    </script>
@endpush
