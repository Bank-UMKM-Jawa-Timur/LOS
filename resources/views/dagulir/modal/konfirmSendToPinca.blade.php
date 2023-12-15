<div class="modal-layout hidden" id="confirmationModal">
    <div class="modal modal-sm bg-white">
        <form action="{{ route('dagulir.check.pincab') }}" method="POST">
            @csrf
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi Data.
                    </h2>
                </div>
                <button data-dismiss-id="confirmationModal" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <p>Apakah anda yakin ingin melanjutkan pengajuan <b><span id="nama_pengajuan"></span></b> ke Pincab?
                    </p>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="confirmationModal">
                    Batal
                </button>
                <button type="submit" class="btn-submit">iya</button>
            </div>
        </form>
    </div>
</div>
