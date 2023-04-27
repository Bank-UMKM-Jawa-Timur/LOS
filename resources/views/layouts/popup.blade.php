<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">SKEMA KREDIT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body">
            <form>
            <div class="form-group">
                <label for="skema">Pilih Skema Kredit</label>
                <select class="form-control" id="skema">
                    <option value="">- Pilih Skema Kredit -</option>
                    <option value="pkjp">PKJP</option>
                    <option value="kkb">KKB</option>
                    <option value="talangan umroh">Talangan Umroh</option>
                    <option value="prokesra">Prokesra</option>
                    <option value="kusuma">Kusuma</option>
                </select>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="$('#exampleModal').modal('hide')">Simpan</button>
        </div>
        </div>
    </div>
</div>