<div class="p-5 space-y-5">
    @php
        $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable', 'is_hide')
            ->where('level', 2)
            ->where('id_parent', $itemSP->id)
            ->where('nama', 'Surat Permohonan')
            ->get();
    @endphp
    @foreach ($dataLevelDua as $item)
        @if ($item->opsi_jawaban == 'file')
            @php
                $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                    ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                    ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                    ->where('jawaban_text.id_jawaban', $item->id)
                    ->get();
            @endphp
            @foreach ($dataDetailJawabanText as $itemTextDua)
                @php
                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                @endphp
                asdasdsad
                <div class="form-group-1">
                    <div class="form-group-1 mb-0">
                        <label for="">{{ $item->nama }}</label>
                    </div>
                    <div class="form-group-1">
                        <b>Jawaban:</b>
                        <div class="mt-2">
                            @if ($file_parts['extension'] == 'pdf')
                                <iframe
                                    src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                    width="100%" height="800px"></iframe>
                            @else
                                <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                    alt="" width="800px">
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for="">Nama Lengkap</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->nama ? $dataNasabah->nama : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Email</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->email ? $dataNasabah->email : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tempat Lahir</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->tempat_lahir ? $dataNasabah->tempat_lahir : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tanggal Lahir</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->tanggal_lahir ? date('d-m-Y', strtotime($dataNasabah->tanggal_lahir)) : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Telp</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->telp ? $dataNasabah->telp : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Jenis Usaha</label>
            </div>
            <div class="field-answer">
                @foreach ($jenis_usaha as $key => $value)
                    @php
                        $isSelected = ($dataNasabah->jenis_usaha == $key) ? 'selected' : '';
                        if ($isSelected) {
                            $textJenisUsaha = $value;
                            $valueJenisUsaha = $key;
                        }
                    @endphp
                    @if ($isSelected)
                        <p>{{ $dataNasabah->jenis_usaha ? $dataNasabah->jenis_usaha : '-' }}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Foto Nasabah</label>
            </div>
            <div class="field-answer">
                @if($dataNasabah->foto_nasabah)
                    <img src="{{ asset('..') . '/' . $dataNasabah->id . '/' . $dataNasabah->foto_nasabah }}" alt="">
                @else
                    <p>Tidak ada foto nasabah</p>
                @endif
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Status Pernikahan</label>
            </div>
            <div class="field-answer">
                @php
                    $text_status = "";
                    if ($dataNasabah->status_pernikahan == '1') {
                        $text_status = "Belum Menikah";
                    } else if ($dataNasabah->status_pernikahan == '2') {
                        $text_status = "Menikah";
                    } else if ($dataNasabah->status_pernikahan == '3') {
                        $text_status = "Duda";
                    } else if ($dataNasabah->status_pernikahan == '4') {
                        $text_status = "Janda";
                    } else {
                        $text_status = "-";
                    }
                @endphp
                <p>{{ $text_status}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">NIK</label>
            </div>
            <div class="field-answer">
                <span>{{ $dataNasabah->nik ? $dataNasabah->nik : '-' }}</span>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Foto KTP Nasabah</label>
            </div>
            <div class="field-answer">
                <p>Tidak ada foto KTP nasabah</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Slik</label>
            </div>
            <div class="field-answer">
                <p>Tidak ada file Slik</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">File Slik</label>
            </div>
            <div class="field-answer">
                <p>Tidak ada file Slik</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kota / Kabupaten KTP</label>
            </div>
            <div class="field-answer">
                <p>NGAWI</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kecamatan KTP</label>
            </div>
            <div class="field-answer">
                <p>SINE</p>
            </div>
        </div>
    </div>
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for="">Alamat Domisili</label>
            </div>
            <div class="field-answer">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae suscipit earum, consectetur amet maiores temporibus laudantium nihil ratione deleniti ducimus, sed quae facilis quam sapiente libero modi cumque debitis totam.</p>
            </div>
        </div>  
        <div class="field-review">
            <div class="field-name">
                <label for="">Jaminan Tambahan</label>
            </div>
            <div class="field-answer space-y-5">
                <div>
                    <h2 class="font-semibold">Tanah</h2>
                </div>
                <div>
                    <h2 class="font-semibold">Marketable (Mempunyai Nilai)</h2>
                </div>
                <div>
                    <div class="field-review">
                        <div class="field-name">
                            <label for="">Skor</label>
                        </div>
                        <div class="field-answer space-y-5">
                            <p>
                                <span class="field-skor">
                                    4
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>