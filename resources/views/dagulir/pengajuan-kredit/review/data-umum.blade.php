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
        <div class="form-group-1 col-span-2 pl-0">
            <div>
                <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                        Data Diri :
                    </h2>
                </div>
            </div>
        </div>
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
                <label for="">Nik</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->nik ? $dataNasabah->nik : '-' }}</p>
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
                <label for="">Kota / Kabupaten KTP</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKabupaten->kabupaten}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kecamatan KTP</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKecamatan->kecamatan}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Desa KTP</label>
            </div>
            <div class="field-answer">
                <p>{{$dataDesa->desa}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Alamat KTP</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->alamat_ktp ? $dataNasabah->alamat_ktp : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for="">Foto Nasabah</label>
            </div>
            <div class="field-answer">
                <a href="{{ $dataNasabah->foto_nasabah != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_nasabah : asset('img/no-image.png') }}" data-lightbox="{{ $dataUmum->id }}" data-title="Foto Nasabah : {{ $dataNasabah->nama }}">
                    <img src="{{ $dataNasabah->foto_nasabah != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_nasabah : asset('img/no-image.png') }}" class="object-contain" width="200" height="400" alt="">
                </a>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Foto KTP Nasabah</label>
            </div>
            <div class="field-answer">
                <a href="{{ $dataNasabah->foto_ktp != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_ktp : asset('img/no-image.png') }}" data-lightbox="{{ $dataNasabah->id }}" data-title="Foto KTP Nasabah : {{ $dataNasabah->nama }}">
                    <img src="{{ $dataNasabah->foto_ktp != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_ktp : asset('img/no-image.png') }}" class="object-contain" width="200" height="400" alt="">
                </a>
            </div>
        </div>
    </div>
    @if ($dataNasabah->status_pernikahan == '2')
        <hr>
        <div class="form-group-2">
            <div class="field-review">
                <div class="field-name">
                    <label for="">Foto Pasangan</label>
                </div>
                <div class="field-answer">
                    <a href="{{ $dataNasabah->foto_pasangan != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_pasangan : asset('img/no-image.png') }}" data-lightbox="{{ $dataUmum->id }}" data-title="Foto Pasangan : {{ $dataNasabah->nama }}">
                        <img src="{{ $dataNasabah->foto_pasangan != null ? asset('..').'/upload/'.$dataUmum->id.'/'.$dataNasabah->id.'/'.$dataNasabah->foto_pasangan : asset('img/no-image.png') }}" class="object-contain" width="200" height="400" alt="">
                    </a>
                </div>
            </div>
            <div class="field-review">
                <div class="field-name">
                    <label for="">NIK Pasangan</label>
                </div>
                <div class="field-answer">
                    <p>{{ $dataNasabah->nik_pasangan ? $dataNasabah->nik_pasangan : '-' }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Domisili --}}
    <div class="form-group-1 col-span-2 pl-0">
        <div>
            <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                    Domisili :
                </h2>
            </div>
        </div>
    </div>
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for="">Kota / Kabupaten Domisili</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKabupatenDom->kabupaten}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kecamatan Domisili</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKecamatanDom->kecamatan}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Alamat Domisili</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->alamat_dom ?? '-'}}</p>
            </div>
        </div>
    </div>

    {{-- Slik --}}
    <div class="form-group-1 col-span-2 pl-0">
        <div>
            <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                    Slik :
                </h2>
            </div>
        </div>
    </div>
    <div class="form-group-1">
        <div class="field-review">
            <div class="field-name">
                <label for="">{{ $itemSlik?->nama  }}</label>
            </div>
            <div class="field-answer">
                {{-- <p>{{ $dataNasabah->id_slik ? $dataNasabah->id_slik : '-' }}</p> --}}
                <p> {{ $itemSlik?->option }}</p>
            </div>
        </div>
        <div class="field-review">
        </div>
    </div>
    <div class="form-group-1">
        @php
        // check level 2
        $dataLS = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
            ->where('level', 2)
            ->where('id_parent', $itemSP->id)
            ->where('nama', 'Laporan SLIK')
            ->get();
        @endphp
        @foreach ($dataLS as $item)
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
                    <div class="field-review">
                        <div class="field-name">
                            <label for="">{{ $item->nama }}</label>
                        </div>
                        <div class="field-answer">
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
                @endforeach
            @endif
        @endforeach
        {{-- <div class="field-review">
            <div class="field-name">
                <label for="">File Slik</label>
            </div>
            <div class="field-answer">
                <p>Tidak ada file Slik</p>
            </div>
        </div> --}}
    </div>
    {{-- Data Usaha --}}
    <div class="form-group-1 col-span-2 pl-0">
        <div>
            <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                    Data Usaha :
                </h2>
            </div>
        </div>
    </div>
    <div class="form-group-2">
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
                        <p>{{ $dataNasabah->jenis_usaha ? $value : '-' }}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kota / Kabupaten Usaha</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKabupatenUsaha->kabupaten}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Kecamatan Usaha</label>
            </div>
            <div class="field-answer">
                <p>{{$dataKecamatanUsaha->kecamatan}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Alamat Usaha</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->alamat_usaha ?? '-'}}</p>
            </div>
        </div>
        {{-- @if ($dataNasabah->tipe == "2")
            <div class="field-review">
                <div class="field-name">
                    <label for="">Nama Pj</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->nama_pj_ketua ? $dataNasabah->nama_pj_ketua : '-'}}</p>
                </div>
            </div>
            <div class="field-review">
                <div class="field-name">
                    <label for="">Tempat Berdiri</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->tempat_berdiri ? $dataNasabah->tempat_berdiri : '-'}}</p>
                </div>
            </div>
            <div class="field-review">
                <div class="field-name">
                    <label for="">Tanggal Berdiri</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->tanggal_berdiri ? $dataNasabah->tanggal_berdiri : '-'}}</p>
                </div>
            </div>
        @endif --}}
    </div>
    {{-- Data Pengajuan --}}
    <div class="form-group-1 col-span-2 pl-0">
        <div>
            <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                    Data Pengajuan :
                </h2>
            </div>
        </div>
    </div>
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for="">Plafon</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->nominal ? number_format($dataNasabah->nominal, 0, ',', '.') : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tenor</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->jangka_waktu ? $dataNasabah->jangka_waktu : '-'}} Bulan</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tujuan Penggunaan</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->tujuan_penggunaan ? $dataNasabah->tujuan_penggunaan : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Jaminan yang disediakan</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->ket_agunan ? strtolower(trans($dataNasabah->ket_agunan)) : '-'}}</p>
            </div>
        </div>
        @php
            $tipe = "";
            $nama_pj = "";
            if ($dataNasabah->tipe == 2) {
                $tipe = "Perorangan";
            } else if ($dataNasabah->tipe == 3) {
                $tipe = "Badan Usaha";
                $nama_pj = "Nama penanggung jawab";
            } else if ($dataNasabah->tipe == 4){
                $tipe = "Kelompok Usaha";
                $nama_pj = "Nama ketua";
            } else {
                $tipe = "-";
                $nama_pj = "-";
            }
        @endphp
        <div class="field-review">
            <div class="field-name">
                <label for="">Tipe Pengajuan</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->tipe ? $tipe : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Jenis badan hukum</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->jenis_badan_hukum ? $dataNasabah->jenis_badan_hukum : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Hubungan Bank</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->hubungan_bank ? $dataNasabah->hubungan_bank : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Hasil Verifikasi</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->hasil_verifikasi ? $dataNasabah->hasil_verifikasi : '-'}}</p>
            </div>
        </div>
        @if ($dataNasabah->tipe != 2)
            <div class="field-review">
                <div class="field-name">
                    <label for="">{{ $nama_pj }}</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->nama_pj_ketua ? $dataNasabah->nama_pj_ketua : '-'}}</p>
                </div>
            </div>
            <div class="field-review">
                <div class="field-name">
                    <label for="">Tempat Berdiri</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->tempat_berdiri ? $dataNasabah->tempat_berdiri : '-'}}</p>
                </div>
            </div>
            <div class="field-review">
                <div class="field-name">
                    <label for="">Tanggal Berdiri</label>
                </div>
                <div class="field-answer">
                    <p>{{$dataNasabah->tanggal_berdiri ? $dataNasabah->tanggal_berdiri : '-'}}</p>
                </div>
            </div>
        @endif
    </div>
