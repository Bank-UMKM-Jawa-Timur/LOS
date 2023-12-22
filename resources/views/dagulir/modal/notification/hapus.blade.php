<div class="modal-layout hidden" id="modal-hapus" >
    <div class="modal modal-sm bg-white">
        <form action="{{ route('dagulir.notification.delete') }}" method="post" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" value="" id="id-hapus" name="id">
            <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                Hapus
                </h2>
            </div>
            <button data-dismiss-id="modal-hapus">
                <iconify-icon
                icon="iconamoon:close-bold"
                class="text-2xl"
                ></iconify-icon>
            </button>
            </div>
            <div class="modal-body space-y-5">
            <div class="space-y-3">
                <p>Anda yakin akan melakukan hapus untuk data ini?</p>
            </div>
            </div>
            <div class="modal-footer justify-end">
            <button data-dismiss-id="modal-hapus" type="button"  class="btn bg-red-500 text-white" >Batal</button>
            <button type="submit" class="btn bg-green-500 text-white">Hapus</button>
            </div>
        </form>
    </div>
</div>