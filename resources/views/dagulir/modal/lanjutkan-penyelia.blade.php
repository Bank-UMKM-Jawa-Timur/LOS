<div class="modal-layout hidden" id="confirmationModalPenyelia">
    <div class="modal modal-sm bg-white">
        <form action="{{ route('dagulir.pengajuan.check.penyeliakredit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi Data.
                    </h2>
                </div>
                <button data-dismiss-id="confirmationModalPenyelia" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <p>Apakah anda yakin ingin melanjutkan pengajuan <b id="nama"></b> ke penyelia?
                    </p>
                </div>
            </div>
            <input type="hidden" id="id-pengajuan" name="id_pengajuan">
            <input type="hidden" id="id-penyelia" name="select_penyelia">
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="confirmationModalPenyelia">
                    Batal
                </button>
                <button type="submit" class="btn-submit">iya</button>
            </div>
        </form>
    </div>
</div>
