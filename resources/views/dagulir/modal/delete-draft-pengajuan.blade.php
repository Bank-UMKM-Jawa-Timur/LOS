@foreach ($data_pengajuan as $item)
<div class="modal-layout hidden" id="confirmationModal{{$item->id}}">
    <div class="modal modal-sm bg-white">
        <form action="{{ route('dagulir.temp.deleteDraft', $item->id) }}" method="POST">
            @csrf
            <input type="hidden" name="skema_kredit" id="" value="{{ $item->skema_kredit }}">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi Hapus.
                    </h2>
                </div>
                <button data-dismiss-id="confirmationModal{{$item->id}}" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <p>Apakah anda yakin ingin menghapus data draft <b><span id="nama_pengajuan"></span></b>?
                    </p>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="confirmationModal{{$item->id}}">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Iya</button>
            </div>
        </form>
    </div>
</div>
@endforeach
