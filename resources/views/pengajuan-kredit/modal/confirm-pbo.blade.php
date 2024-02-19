<div class="modal-layout hidden" id="confirmPBO">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Lanjutkan Pengajuan
                </h2>
            </div>
            <button type="button" data-dismiss-id="confirmPBO">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group-1 mb-4">
                <p>Apakah anda yakin ingin melanjutkan pengajuan ini ke PBO ?</p>
            </div>
        </div>
        <div class="modal-footer justify-end">
            <button class="btn-cancel" type="button" data-dismiss-id="confirmPBO">
                Batal
            </button>
            <a class=" cursor-pointer btn-submit btn-lanjutkan-pengajuan" id="lanjutkan-pengajuan-pbo">
                Lanjutkan
            </a>
            {{-- <button type="submit" class="btn-submit btn-kembalikan-pengajuan">Kembalikan</button> --}}
        </div>
    </div>
</div>
