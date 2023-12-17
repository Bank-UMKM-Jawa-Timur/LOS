<div class="modal-layout hidden" id="modal-kembalikan">
    <div class="modal modal-sm bg-white">
        <form action="{{route('dagulir.pengajuan-kredit.kembalikan-ke-posisi-sebelumnya')}}" method="POST">
            @csrf
            <input type="hidden" name="id_pengajuan" id="id_pengajuan">
            <input type="hidden" name="backto" id="backto">
            <div class="modal-head">
                <div class="title">
                    <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                        Konfirmasi
                    </h2>
                </div>
                <button data-dismiss-id="modal-kembalikan">
                    <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="modal-body space-y-5">
                <div class="space-y-3">
                    <p>Anda yakin akan mengembalikan data ini?</p>
                </div>
                <div class="space-y-3">
                    <div class="input-box">
                        <label for="alasan">Alasan</label>
                        <textarea class="form-textarea"
                        name="alasan" id="alasan" cols="30" rows="5" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" type="button" data-dismiss-id="modal-kembalikan">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Setujui</button>
            </div>
        </form>
    </div>
</div>