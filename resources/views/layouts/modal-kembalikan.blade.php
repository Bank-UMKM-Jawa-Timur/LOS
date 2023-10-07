@foreach ($data_pengajuan as $item)
    @if ($item->posisi != 'Selesai' || $item->posisi != 'Ditolak')
        @if ($item->id_pbp != null)
            <div class="modal fade" id="modalKembalikan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalKembalikanLabel" aria-hidden="true">
                <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKembalikanLabel">Kembalikan ke PBP</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="alasan">Alasan</label>
                                <textarea name="alasan" id="" class="form-control"></textarea>
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        @elseif ($item->id_pbp == null && $item->id_pbo != null)
            <div class="modal fade" id="modalKembalikan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalKembalikanLabel" aria-hidden="true">
                <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKembalikanLabel">Kembalikan ke PBO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="alasan">Alasan</label>
                                <textarea name="alasan" id="" class="form-control"></textarea>
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        @elseif($item->posisi == 'Review Penyelia')
            <div class="modal fade" id="modalKembalikan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalKembalikanLabel" aria-hidden="true">
                <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKembalikanLabel">Kembalikan ke Staff</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="alasan">Alasan</label>
                                <textarea name="alasan" id="" class="form-control"></textarea>
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        @else
            <div class="modal fade" id="modalKembalikan-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalKembalikanLabel" aria-hidden="true">
                <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalKembalikanLabel">Kembalikan ke Penyelia</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="alasan">Alasan</label>
                                <textarea name="alasan" id="" class="form-control"></textarea>
                                <input type="hidden" name="id" value="{{ $item->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        @endif
    @endif
@endforeach