<div class="modal-layout hidden" id="confirmPembatalan">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Pembatalan Pengajuan
                </h2>
            </div>
            <button type="button" data-dismiss-id="confirmPembatalan">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group-1 mb-4">
                <p>Apakah anda yakin ingin membatalkan pengajuan tersebut ?</p>
            </div>
        </div>
        <div class="modal-footer justify-end">
            <form action="{{ route('dagulir.konfirmasi-pembatalan') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                <button class="btn-cancel" type="button" data-dismiss-id="confirmPembatalan">
                    Batal
                </button>
                <button type="submit" class=" cursor-pointer btn-submit btn-lanjutkan-pengajuan">
                    Iya, Batalkan Pengajuan
                </button>
            </form>
            {{-- <button type="submit" class="btn-submit btn-kembalikan-pengajuan">Kembalikan</button> --}}
        </div>
    </div>
</div>
