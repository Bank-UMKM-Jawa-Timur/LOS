@foreach ($data as $item)
<div class="modal-layout hidden" id="uploadPPKModal-{{$item->pengajuan->id}}">
    <div class="modal modal-sm bg-white">
        <form action="{{ route('dagulir.post-file-dagulir', $item->pengajuan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Upload PK.
                    </h2>
                </div>
                <button data-dismiss-id="uploadPPKModal-{{$item->pengajuan->id}}" type="button">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <a class="x-7 py-2 p-2 rounded items-center font-semibold bg-theme-primary border text-white" target="_blank" href="{{ route('dagulir.cetak-pk-dagulir', $item->pengajuan->id) }}">Cetak file PK
                    </a>
                <br>
                @csrf
                <input type="hidden" name="tipe_file" value="PK">
                    <div class="form-group">
                        <label for="sppk">File PK</label>
                        <input type="file" name="pk" id="pk" class="form-input file" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="uploadPPKModal-{{$item->pengajuan->id}}">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach
