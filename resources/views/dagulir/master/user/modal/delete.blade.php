<div class="modal-layout hidden" id="modal-hapus-user">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Hapus User
                </h2>
            </div>
            <button data-dismiss-id="modal-hapus-user">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.user.destroy', 1) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id_user_delete" class="id-user">
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus user <span class="fw-bold" id="nama"></span>?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-hapus-user">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
