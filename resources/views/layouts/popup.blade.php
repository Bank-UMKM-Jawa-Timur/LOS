<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form action="" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SKEMA KREDIT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="skema">Pilih Skema Kredit</label>
                    <select class="form-control" id="skema" name="skema">
                        <option value="">- Pilih Skema Kredit -</option>
                        <option value="PKPJ" {{$skema == 'PKPJ' ? 'selected' : ''}}>PKPJ</option>
                        <option value="KKB" {{$skema == 'KKB' ? 'selected' : ''}}>KKB</option>
                        <option value="Talangan Umroh" {{$skema == 'Talangan Umroh' ? 'selected' : ''}}>Talangan Umroh</option>
                        <option value="Prokesra" {{$skema == 'Prokesra' ? 'selected' : ''}}>Prokesra</option>
                        <option value="Kusuma" {{$skema == 'Kusuma' ? 'selected' : ''}}>Kusuma</option>
                    </select>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSkema" onclick="$('#exampleModal').modal('hide')">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>