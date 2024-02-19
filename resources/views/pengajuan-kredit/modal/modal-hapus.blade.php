<div class="modal-layout hidden" id="modalHapusPengajuan">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Hapus Data
                </h2>
            </div>
            <button data-dismiss-id="modalHapusPengajuan">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="modal-body">
            <div id="content"></div>
        </div>
        <div class="modal-footer justify-end">
            <button class="btn-cancel" type="button" data-dismiss-id="modalHapusPengajuan">
                Batal
            </button>
            <form action="{{ route('delete-pengajuan-kredit',0) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="idPengajuan" id="idPengajuan">
                <button type="submit" class="btn btn-submit">Hapus</button>
            </form>
            </div>
    </div>
</div>


