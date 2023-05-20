@foreach ($data_pengajuan as $item)    
<form action="{{ route('post-file-kkb', $item->id_pengajuan) }}" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="uploadModal-{{$item->id_pengajuan}}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black" id="uploadModalLabel">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="no_po">Nomor PO</label>
                    <input type="text" name="no_po" id="no_po" class="form-control file" required>
                </div>
                <div class="form-group">
                    <label for="sppk">Upload File SPPK</label>
                    <input type="file" name="sppk" id="sppk" class="form-control file" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="po">Upload File PO</label>
                    <input type="file" name="po" id="po" class="form-control file" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="pk">Upload File PK</label>
                    <input type="file" name="pk" id="pk" class="form-control file" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-info text-white" type="submit">Simpan</button>
            </div>
        </div>
    </div>
</div>
</form>
@endforeach