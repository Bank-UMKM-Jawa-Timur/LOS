<div class="modal-layout hidden" id="modalhapusdesa">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Konfirmasi Penghapusan
                </h2>
            </div>
            <button data-dismiss-id="modalhapusdesa">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{route('dagulir.master.desa.destroy', 1)}}" method="POST">
            @csrf
            @method('delete')
            <input type="hidden" name="id_desa" id="id">
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modalhapusdesa">
                    Batal
                </button>
                <button type="submit" class="btn btn-submit">Hapus</button>
            </div>
        </form>
    </div>
</div>
