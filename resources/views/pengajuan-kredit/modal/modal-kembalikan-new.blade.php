<div class="modal-layout hidden" id="modalKembalikan">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Kembalikan ke <span id="text_backto">Staff</span>
                </h2>
            </div>
            <button type="button" data-dismiss-id="modalKembalikan">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Alasan</label>
                        <textarea name="alasan" class="form-input" id="" cols="30" rows="10"></textarea>
                        <input type="hidden" name="id" id="id_pengajuan">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modalKembalikan">
                    Batal
                </button>
                <button type="submit" class="btn-submit btn-kembalikan">Kembalikan</button>
            </div>
        </form>
    </div>
</div>
