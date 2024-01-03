@foreach ($data_pengajuan as $item)
    @if ($item->posisi != 'Selesai' || $item->posisi != 'Ditolak')
        @if ($item->id_pbp != null)
            <div class="modal-layout hidden" id="modalKembalikan-{{ $item->id }}">
                <div class="modal modal-sm bg-white">
                    <div class="modal-head">
                        <div class="title">
                            <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                                Kembalikan ke PBP
                            </h2>
                        </div>
                        <button type="button" data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group-2 mb-4">
                                <div class="input-box">
                                    <label for="">Alasan</label>
                                    <textarea name="alasan" class="form-input" id="" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-end">
                        <button class="btn-cancel" type="button" data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            Batal
                        </button>
                        <button type="submit" class="btn-submit" data-dismiss-id="modalKembalikan-{{ $item->id }}"
                            id="btn_filter">Filter</button>
                    </div>
                </div>
            </div>
        @elseif ($item->id_pbp == null && $item->id_pbo != null)
            <div class="modal-layout hidden" id="modalKembalikan-{{ $item->id }}">
                <div class="modal modal-sm bg-white">
                    <div class="modal-head">
                        <div class="title">
                            <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                                Kembalikan ke PBO
                            </h2>
                        </div>
                        <button type="button" data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group-2 mb-4">
                                <div class="input-box">
                                    <label for="">Alasan</label>
                                    <textarea name="alasan" class="form-input" id="" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-end">
                        <button class="btn-cancel" type="button"
                            data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            Batal
                        </button>
                        <button type="submit" class="btn-submit" data-dismiss-id="modalKembalikan-{{ $item->id }}"
                            id="btn_filter">Filter</button>
                    </div>
                </div>
            </div>
        @elseif($item->posisi == 'Review Penyelia')
            <div class="modal-layout hidden" id="modalKembalikan-{{ $item->id }}">
                <div class="modal modal-sm bg-white">
                    <div class="modal-head">
                        <div class="title">
                            <h2 class="font-bold text-lg tracking-tighter text-theme-text" >
                                Kembalikan ke <span id="text_backto">Staff</span>
                            </h2>
                        </div>
                        <button type="button" data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group-2 mb-4">
                                <div class="input-box">
                                    <label for="">Alasan</label>
                                    <textarea name="alasan" class="form-input" id="" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-end">
                        <button class="btn-cancel" type="button"
                            data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            Batal
                        </button>
                        <button type="submit" class="btn-submit" data-dismiss-id="modalKembalikan-{{ $item->id }}"
                            id="btn_filter">Filter</button>
                    </div>
                </div>
            </div>
        @else
            <div class="modal-layout hidden" id="modalKembalikan-{{ $item->id }}">
                <div class="modal modal-sm bg-white">
                    <div class="modal-head">
                        <div class="title">
                            <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                                Kembalikan ke Penyelia
                            </h2>
                        </div>
                        <button type="button" data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan-kredit.kembalikan-ke-posisi-sebelumnya') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group-2 mb-4">
                                <div class="input-box">
                                    <label for="">Alasan</label>
                                    <textarea name="alasan" class="form-input" id="" cols="30" rows="10"></textarea>
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-end">
                        <button class="btn-cancel" type="button"
                            data-dismiss-id="modalKembalikan-{{ $item->id }}">
                            Batal
                        </button>
                        <button type="submit" class="btn-submit"
                            data-dismiss-id="modalKembalikan-{{ $item->id }}" id="btn_filter">Filter</button>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endforeach
