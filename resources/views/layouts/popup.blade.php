<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
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
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSkema" onclick="$('#exampleModal').modal('hide')">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>