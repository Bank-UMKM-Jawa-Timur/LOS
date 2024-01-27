<div class="modal-layout hidden" id="modal-reset-pass">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Reset Password
                </h2>
            </div>
            <button data-dismiss-id="modal-reset-pass">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('dagulir.master.reset-password', 1) }}" method="POST">
            @csrf
            <input type="hidden" name="id_user" class="id-user">
            <div class="modal-body">
                <p>Apakah anda yakin ingin mereset password <span class="nama"></span>?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-reset-pass">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
