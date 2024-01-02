{{-- modal restore --}}
<div class="modal-layout hidden" id="modalRestore" tabindex="-1" role="dialog" aria-labelledby="modalRestoreLabel" aria-hidden="true">
    <div class="modal modal-sm bg-white" role="document">
        <div class="modal-head title">
            <h5 class="font-bold text-lg tracking-tighter text-theme-text" id="modalRestoreLabel">Konfirmasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="content">

            </div>
        </div>
        <div class="modal-footer justify-end">
            <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
            <form action="{{ route('restore-pengajuan-kredit') }}" id="restoreForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="idPengajuan" id="idPengajuan">
                <button type="submit" id="btn-restore" class="btn btn-submit restore">Kembalikan</button>
            </form>
        </div>
    </div>
</div>
