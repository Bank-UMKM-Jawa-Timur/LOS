<div class="modal-layout hidden" id="resetSessionModal">
    <form id="form-reset-api-session" method="POST" action="{{ route('dagulir.master.reset-session') }}">
        @csrf
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
                <p>Apakah anda yakin ingin reset api session ini?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="resetSessionModal">
                    Batal
                </button>
                <input type="hidden" id="id" name="id">
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
