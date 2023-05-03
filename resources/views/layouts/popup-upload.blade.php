@foreach ($data_pengajuan as $item)    
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
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file-sppk">Upload File SPPK</label>
                        <input type="file" name="file-sppk" id="file-sppk" class="form-control-file" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="file-po">Upload File PO</label>
                        <input type="file" name="file-po" id="file-po" class="form-control-file" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="file-pk">Upload File PK</label>
                        <input type="file" name="file-pk" id="file-pk" class="form-control-file" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a type="button" href="" class="btn btn-info text-white">Simpan</a>
            </div>
            </div>
        </div>
    </div>
@endforeach