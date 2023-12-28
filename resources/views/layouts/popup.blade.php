<div class="modal-layout-no-backdrop hidden" data-modal-backdrop="static"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal modal-sm bg-white" role="document">
        <form action="" >
            <div class="modal-content">
                <div class="modal-head">
                    <div class="title">
                      <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                        Skema Kredit
                      </h2>
                    </div>
                    <button type="button" data-dismiss-id="modal-filter">
                      <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group-1">
                        <div class="input-box">
                            <label for="skema">Pilih Skema Kredit</label>
                            <select class="form-select" id="skema" name="skema">
                                <option value="">- Pilih Skema Kredit -</option>
                                <option value="PKPJ" {{$skema == 'PKPJ' ? 'selected' : ''}}>PKPJ</option>
                                <option value="KKB" {{$skema == 'KKB' ? 'selected' : ''}}>KKB</option>
                                <option value="Talangan Umroh" {{$skema == 'Talangan Umroh' ? 'selected' : ''}}>Talangan Umroh</option>
                                <option value="Prokesra" {{$skema == 'Prokesra' ? 'selected' : ''}}>Prokesra</option>
                                <option value="Kusuma" {{$skema == 'Kusuma' ? 'selected' : ''}}>Kusuma</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-end">
                    <button type="submit" class="btn-submit" id="btnSkema" onclick="$('#exampleModal').modal('hide')">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
