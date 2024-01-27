<div class="modal-layout hidden" id="modalhapuscabang">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Penghapusan
                </h2>
            </div>
            <button data-dismiss-id="modalhapuscabang">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form id="form-delete-cabang" method="POST">
            @method('delete')
            @csrf
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modalhapuscabang">
                    Batal
                </button>
                <button type="submit" class="btn btn-submit">Hapus</button>
            </div>
        </form>
    </div>
</div>
