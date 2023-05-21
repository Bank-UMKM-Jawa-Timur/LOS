@foreach ($data_pengajuan as $item)    
<form action="{{ route('post-file-kkb', $item->id_pengajuan) }}" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="uploadSPPKModal-{{$item->id_pengajuan}}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: black" id="uploadModalLabel">Upload File SPPK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a target="_blank" href="{{ route('cetak-sppk',$item->id_pengajuan)}}">
                    <button class="btn btn-primary" type="button">Cetak file SPPK</button>
                </a>
                <hr>
                @csrf
                <input type="hidden" name="tipe_file" value="SPPK">
                <div class="form-group">
                    <label for="sppk">File SPPK</label>
                    <input type="file" name="sppk" id="sppk" class="form-control file" required>
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