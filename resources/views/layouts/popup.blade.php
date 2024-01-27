<div class="modal-layout-no-backdrop hidden" data-modal-backdrop="static"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal modal-sm bg-white" role="document">
        <form action="" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PRODUK & SKEMA KREDIT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="produk">Pilih Produk Kredit</label>
                    <select class="form-control" id="produk" name="produk">
                        <option value="">- Pilih Produk Kredit -</option>
                        @foreach ($produkKredit as $item)
                            <option value="{{$item->id}}" {{$produk == $item->name ? 'selected' : ''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="skema">Pilih Skema Kredit</label>
                    <select class="form-control" id="skema" name="skema">
                        <option value="">- Pilih Skema Kredit -</option>
                        @foreach ($skemaKredit as $item)
                            <option value="{{$item->id}}" {{$skema == $item->name ? 'selected' : ''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="limit">Pilih Limit</label>
                    <select class="form-control" id="limit" name="limit">
                        <option value="">- Pilih Limit -</option>
                        @foreach ($limitKredit as $item)
                            <option value="{{$item->id}}">{{number_format($item->from,0,',','.')}} {{$item->operator}} {{number_format($item->to,0,',','.')}}</option>
                        @endforeach
                    </select>
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
