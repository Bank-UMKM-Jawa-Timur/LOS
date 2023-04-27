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
                    <option value="PKPJ">PKPJ</option>
                    <option value="KKB">KKB</option>
                    <option value="Talangan Umroh">Talangan Umroh</option>
                    <option value="Prokesra">Prokesra</option>
                    <option value="Kusuma">Kusuma</option>
                </select>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnSkema" onclick="$('#exampleModal').modal('hide')">Simpan</button>
        </div>
        </div>
    </div>
</div>