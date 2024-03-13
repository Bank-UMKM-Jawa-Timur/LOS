<div class="p-5 space-y-5">

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
                <label for="">Nik</label>
            </div>
            <div class="field-answer">
                <p>{{ $dataNasabah->no_ktp ? $dataNasabah->no_ktp : '-' }}</p>
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
                <p>{{ $dataNasabah->no_telp ? $dataNasabah->no_telp : '-' }}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Status Pernikahan</label>
            </div>
            <div class="field-answer">
                @php
                    $text_status = "";
                    if ($dataNasabah->status == 'belum menikah') {
                        $text_status = "Belum Menikah";
                    } else if ($dataNasabah->status == 'menikah') {
                        $text_status = "Menikah";
                    } else if ($dataNasabah->status == 'duda') {
                        $text_status = "Duda";
                    } else if ($dataNasabah->status == 'janda') {
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
                <p>{{ $dataNasabah->alamat_rumah ? $dataNasabah->alamat_rumah : '-' }}</p>
            </div>
        </div>
    </div>
    @php
        $ktpSuami = \DB::table('jawaban_text')
                        ->select('id', 'id_jawaban', 'opsi_text')
                        ->where('id_pengajuan', $dataUmum->id)
                        ->where('id_jawaban', 150)
                        ->first();
        $ktpIstri = \DB::table('jawaban_text')
                        ->select('id', 'id_jawaban', 'opsi_text')
                        ->where('id_pengajuan', $dataUmum->id)
                        ->where('id_jawaban', 151)
                        ->first();
        $ktpNasabah = \DB::table('jawaban_text')
                        ->select('id', 'id_jawaban', 'opsi_text')
                        ->where('id_pengajuan', $dataUmum->id)
                        ->where('id_jawaban', 156)
                        ->first();
    @endphp
    <div class="form-group-2">
        <div class="field-review">
            <div class="field-name">
                <label for=""> {{$dataNasabah->status == 'menikah' ? 'Foto KTP Suami' : 'Foto KTP' }} </label>
            </div>
            <div class="field-answer">
                @if ($dataNasabah->status == 'menikah')
                <a href="{{ $ktpSuami ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpSuami->id_jawaban.'/'.$ktpSuami->opsi_text : asset('img/no-image.png') }}" data-lightbox="{{ $dataNasabah->id }}" data-title="Foto KTP Nasabah : {{ $dataNasabah->nama }}">
                    <img src="{{ $ktpSuami ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpSuami->id_jawaban.'/'.$ktpSuami->opsi_text : asset('img/no-image.png') }}" class="object-contain" width="300" height="400" alt="">
                </a>
                @else
                <a href="{{ $ktpNasabah ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpNasabah->id_jawaban.'/'.$ktpNasabah->opsi_text : asset('img/no-image.png') }}" data-lightbox="{{ $dataNasabah->id }}" data-title="Foto KTP Nasabah : {{ $dataNasabah->nama }}">
                    <img src="{{ $ktpNasabah ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpNasabah->id_jawaban.'/'.$ktpNasabah->opsi_text : asset('img/no-image.png') }}" class="object-contain" width="300" height="400" alt="">
                </a>
                @endif
            </div>
        </div>
        @if ($dataNasabah->status == 'menikah')
        <div class="field-review">
            <div class="field-name">
                <label for="">Foto KTP Istri</label>
            </div>
            <div class="field-answer">
                <a href="{{ $ktpIstri ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpIstri->id_jawaban.'/'.$ktpIstri->opsi_text : asset('img/no-image.png') }}" data-lightbox="{{ $dataUmum->id }}" data-title="Foto Pasangan : {{ $dataNasabah->nama }}">
                    <img src="{{ $ktpIstri ? asset('..').'/upload/'.$dataUmum->id.'/'.$ktpIstri->id_jawaban.'/'.$ktpIstri->opsi_text : asset('img/no-image.png') }}" class="object-contain" width="300" height="400" alt="">
                </a>
            </div>
        </div>
        @endif
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
                <div class="field-review mr-5 mt-5">
                    <div class="field-name">
                        <label for="">Skor </label>
                    </div>
                    <div class="field-answer">
                        <p>
                            <span class="field-skor"> {{ $itemSlik?->skor }}</span>
                        </p>
                    </div>
                </div>
            </div>
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
    <div class="form-group-1">
        <div class="field-review">
            <div class="field-name">
                <label for="">{{ ucwords($itemCatatanSlik->nama) }}</label>
            </div>
            @php
                 $dataDetailJawabanCatatan = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                        ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                        ->where('jawaban_text.id_jawaban', $itemCatatanSlik->id)
                        ->first();
            @endphp
            <div class="field-answer">
                <p>{{ $dataDetailJawabanCatatan?->opsi_text }}</p>
            </div>
        </div>
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
                <p>Rp. {{$dataNasabah->jumlah_kredit ? number_format($dataNasabah->jumlah_kredit, 0, ',', '.') : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tenor</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->tenor_yang_diminta ? $dataNasabah->tenor_yang_diminta : '-'}} Bulan</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Tujuan Penggunaan</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->tujuan_kredit ? $dataNasabah->tujuan_kredit : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Jaminan yang disediakan</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->jaminan_kredit ? strtolower(trans($dataNasabah->jaminan_kredit)) : '-'}}</p>
            </div>
        </div>
        <div class="field-review">
            <div class="field-name">
                <label for="">Jenis Usaha</label>
            </div>
            <div class="field-answer">
                <p>{{$dataNasabah->jenis_usaha ? $dataNasabah->jenis_usaha : '-'}}</p>
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
                <p>{{$dataNasabah->verifikasi_umum ? $dataNasabah->verifikasi_umum : '-'}}</p>
            </div>
        </div>
    </div>
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
            {{-- <div class="form-group-1">
                <div class="form-group-1 mb-0">
                    <label for="">{{ $item->nama }}</label>
                </div>
                <div class="form-group-1">
                    <b>Jawaban:</b>
                    <div class="mt-2">
                    </div>
                </div>
            </div> --}}
            <div class="form-group-1">
                <div class="field-review">
                    <div class="field-name">
                        <label for="">{{ $item->nama }}</label>
                    </div>
                    <div class="field-answer">
                        <p>
                        @if ($file_parts['extension'] == 'pdf')
                            <iframe
                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                width="100%" height="800px"></iframe>
                        @else
                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                alt="" width="800px">
                        @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endforeach
