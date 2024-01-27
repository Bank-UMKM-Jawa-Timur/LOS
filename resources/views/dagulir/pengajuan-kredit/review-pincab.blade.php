@extends('layouts.tailwind-template')
@section('content')
    <div class="p-3 ">
        <div class="container mx-auto mt-20 space-y-5">
            <h2 class="text-theme-primary font-bold text-3xl tracking-tighter">Review Pincab</h2>
            <div class="bg-white p-5 border rounded">
                <div class="accordion-section">
                    <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                        <div class="flex justify-start gap-3">
                            <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                                <h2 class="text-lg">1</h2>
                            </button>
                            <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                        </div>
                        <div class="absolute right-5 top-3">
                            <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                        </div>
                    </div>
                    <div class="accordion-content p-3 ">
                        <div class="p-5 w-full space-y-5 " id="data-umum">
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
                                <div class="input-group">
                                    <label for="">Nama Lengkap</label>
                                    <input type="hidden" disabled name="name" id="nama"
                                        class="form-input @error('name') is-invalid @enderror"
                                        value="{{ old('name', $dataUmumNasabah->nama) }}" placeholder="Nama sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->nama ? $dataUmumNasabah->nama : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="">Email</label>
                                    <input type="hidden" disabled name="email" id="email"
                                        class="form-input @error('email') is-invalid @enderror"
                                        value="{{ old('email', $dataUmumNasabah->email) }}" placeholder="email sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->email ? $dataUmumNasabah->email : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="">Tempat Lahir</label>
                                    <input type="hidden" disabled name="tempat_lahir" id="tempat_lahir"
                                        class="form-input @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir', $dataUmumNasabah->tempat_lahir) }}" placeholder="tempat_lahir sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->tempat_lahir ? $dataUmumNasabah->tempat_lahir : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="">Tanggal Lahir</label>
                                    <input type="hidden" disabled name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-input @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir', $dataUmumNasabah->tanggal_lahir) }}" placeholder="tanggal_lahir sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->tanggal_lahir ? $dataUmumNasabah->tanggal_lahir : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="">Telp</label>
                                    <input type="hidden" disabled name="telp" id="telp"
                                        class="form-input @error('telp') is-invalid @enderror"
                                        value="{{ old('telp', $dataUmumNasabah->telp) }}" placeholder="telp sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->telp ? $dataUmumNasabah->telp : '-' }}</span>
                                    </div>
                                </div>
                                @php
                                    $textJenisUsaha = '';
                                    $valueJenisUsaha = '';
                                @endphp

                                <div class="input-group">
                                    <label for="">Jenis Usaha</label>
                                    <select name="jenis_usaha" id="" hidden class="form-select">
                                        <option value="">Pilih Jenis Usaha</option>
                                        @foreach ($jenis_usaha as $key => $value)
                                            @php
                                                $isSelected = ($dataUmumNasabah->jenis_usaha == $key) ? 'selected' : '';
                                                if ($isSelected) {
                                                    $textJenisUsaha = $value;
                                                    $valueJenisUsaha = $key;
                                                }
                                            @endphp
                                            <option value="{{ $key }}" {{ $isSelected }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $textJenisUsaha }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="ktp_nasabah" id="foto-nasabah">Foto Nasabah</label>
                                    @if($dataUmumNasabah->foto_nasabah)
                                        <img src="{{ asset('..') . '/' . $dataUmumNasabah->id . '/' . $dataUmumNasabah->foto_nasabah }}" alt="">
                                    @else
                                        <div class="border-b p-2 w-full ">Tidak ada foto nasabah</div>
                                    @endif
                                </div>
                                <div class="input-box">
                                    <label for="">Status Pernikahan</label>
                                    @php
                                        $text_status = "";
                                        if ($dataUmumNasabah->status_pernikahan == '1') {
                                            $text_status = "Belum Menikah";
                                        } else if ($dataUmumNasabah->status_pernikahan == '2') {
                                            $text_status = "Menikah";
                                        } else if ($dataUmumNasabah->status_pernikahan == '3') {
                                            $text_status = "Duda";
                                        } else if ($dataUmumNasabah->status_pernikahan == '4') {
                                            $text_status = "Janda";
                                        } else {
                                            $text_status = "-";
                                        }

                                    @endphp
                                    <input type="hidden" name="status" id="status_nasabah" value="{{$dataUmumNasabah->status_pernikahan}}">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $text_status }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">NIK</label>
                                    <input type="hidden" disabled name="nik" id="nik"
                                        class="form-input @error('nik') is-invalid @enderror"
                                        value="{{ old('nik', $dataUmumNasabah->nik) }}" placeholder="nik sesuai dengan KTP">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->nik ? $dataUmumNasabah->nik : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Foto KTP Nasabah</label>
                                    <div class="flex gap-4">
                                        @if($dataUmumNasabah->foto_ktp)
                                            <img src="{{ asset('..') . '/' . $dataUmumNasabah->id . '/' . $dataUmumNasabah->foto_ktp }}" alt="">
                                        @else
                                        <div class="border-b p-2 w-full ">Tidak ada foto KTP nasabah</div>
                                        @endif
                                    </div>
                                </div>
                                @if ($dataUmumNasabah->status_pernikahan == '2')
                                    <div class="input-box">
                                        <label for="">NIK Pasangan</label>
                                        <input type="hidden" disabled name="nik_pasangan" id="nik_pasangan"
                                            class="form-input @error('nik_pasangan') is-invalid @enderror"
                                            value="{{ old('nik_pasangan', $dataUmumNasabah->nik_pasangan) }}" placeholder="nik_pasangan sesuai dengan KTP">
                                        <div class="p-2 bg-white border-b">
                                            <span>{{ $dataUmumNasabah->nik_pasangan ? $dataUmumNasabah->nik_pasangan : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="input-box">
                                        <label for="">Foto KTP Pasangan</label>
                                        <div class="flex gap-4">
                                            @if($dataUmumNasabah->foto_pasangan)
                                                <img src="{{ asset('..') . '/' . $dataUmumNasabah->id . '/' . $dataUmumNasabah->foto_pasangan }}" alt="">
                                            @else
                                            <div class="border-b p-2 w-full ">Tidak ada foto KTP pasangan</div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="input-box">
                                    <label for="">Slik</label>
                                    @php
                                        $slikText = '';
                                        if ($dataUmumNasabah->id_slik == 71) {
                                            $slikText = 'Pernah Macet / Hapus Buku';
                                        }
                                        elseif ($dataUmumNasabah->id_slik == 72) {
                                            $slikText = 'Lancar dan / atau Pernah Menunggak >30 Hari';
                                        }
                                        elseif ($dataUmumNasabah->id_slik == 73) {
                                            $slikText = 'Lancar dan / atau Pernah Menunggak 1 - 30 Hari';
                                        }
                                        elseif ($dataUmumNasabah->id_slik == 74) {
                                            $slikText = 'Lancar';
                                        }
                                        else {
                                            $slikText = 'Slik Kosong / tidak memilih';
                                        }
                                    @endphp
                                    <input type="hidden" name="id_slik" value="{{$dataUmumNasabah->id_slik}}">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $slikText }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">File Slik</label>
                                    @if($dataUmumNasabah->file_slik)
                                        @php
                                            $file_parts = pathinfo(asset('..') . '/' . $dataUmumNasabah->id . '/' . $dataUmumNasabah->id_slik.'/'.$dataUmumNasabah->file_slik);
                                        @endphp
                                    @if (array_key_exists('extension', $file_parts))
                                        @if ($file_parts['extension'] == 'pdf')
                                            <iframe
                                            src="{{ asset('..') . '/upload/'. $dataUmumNasabah->id . '/' .$dataUmumNasabah->id_slik.'/'.$dataUmumNasabah->file_slik }}"
                                            width="100%" height="800px"></iframe>
                                        @else
                                            <img src="{{ asset('..') . '/upload/' . $dataUmumNasabah->id . '/' . $dataUmumNasabah->id_slik.'/'.$dataUmumNasabah->file_slik }}"
                                            alt="" width="800px">
                                        @endif
                                    @endif
                                    @else
                                        <div class="border-b p-2 w-full ">Tidak ada file Slik</div>
                                    @endif
                                </div>
                                @php
                                    $textKotaKab = "";
                                    $textKec = "";
                                @endphp
                                <div class="input-box">
                                    <label for="">Kota / Kabupaten KTP</label>
                                    <select hidden name="kotakab_ktp" id="">
                                        @foreach ($allKab as $item)
                                            @php
                                                if ($dataUmumNasabah->kotakab_ktp == $item->id) {
                                                    $textKotaKab = $item->kabupaten;
                                                }
                                            @endphp
                                            <option value="{{$item->id}}" {{$dataUmumNasabah->kotakab_ktp == $item->id ? 'selected' : ''}}>{{$item->kabupaten}}</option>
                                        @endforeach
                                    </select>
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $textKotaKab }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Kecamatan KTP</label>
                                    <select hidden name="kotakab_ktp" id="">
                                        @foreach ($allKec as $item)
                                            @php
                                                if ($dataUmumNasabah->kec_ktp == $item->id) {
                                                    $textKec = $item->kecamatan;
                                                }
                                            @endphp
                                            <option value="{{$item->id}}" {{$dataUmumNasabah->kec_ktp == $item->id ? 'selected' : ''}}>{{$item->kecamatan}}</option>
                                        @endforeach
                                    </select>
                                    <div class="p-2 bg-white border-b">
                                        {{-- <span>{{ $kecamatan_ktp->kecamatan ? $kecamatan_ktp->kecamatan : '-' }}</span> --}}
                                        <span>{{ $textKec }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-1">
                                <label for="">Alamat Rumah</label>
                                <textarea disabled name="alamat_ktp" class="form-input @error('alamat_ktp') is-invalid @enderror" id=""
                                    cols="30" rows="4" placeholder="Alamat Rumah disesuaikan dengan KTP">{{ old('alamat_ktp', $dataUmumNasabah->alamat_ktp) }}</textarea>
                                <hr>
                            </div>
                            <div class="form-group-2">
                                @php
                                    $textKotaDom = "";
                                    $textKecDom = "";
                                @endphp
                                <div class="input-box">
                                    <label for="">Kota / Kabupaten Domisili</label>
                                    <select hidden name="kotakab_dom" id="">
                                        @foreach ($allKab as $item)
                                            @php
                                                if ($dataUmumNasabah->kotakab_dom == $item->id) {
                                                        $textKotaDom = $item->kabupaten;
                                                }
                                            @endphp
                                            <option value="{{$item->id}}" {{$dataUmumNasabah->kotakab_ktp == $item->id ? 'selected' : ''}}>{{$item->kabupaten}}</option>
                                        @endforeach
                                    </select>
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $textKotaDom }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Kecamatan Domisili</label>
                                    <select hidden name="kec_dom" id="">
                                        @foreach ($allKec as $item)
                                            @php
                                                if ($dataUmumNasabah->kec_dom == $item->id) {
                                                    $textKecDom = $item->kecamatan;
                                                }
                                            @endphp
                                            <option value="{{$item->id}}" {{$dataUmumNasabah->kec_ktp == $item->id ? 'selected' : ''}}>{{$item->kecamatan}}</option>
                                        @endforeach
                                    </select>
                                    <div class="p-2 bg-white border-b">
                                        {{-- <span>{{ $kecamatan_ktp->kecamatan ? $kecamatan_ktp->kecamatan : '-' }}</span> --}}
                                        <span>{{ $textKecDom }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-1">
                                <label for="">Alamat Domisili</label>
                                <textarea disabled name="alamat_dom" class="form-input @error('alamat_dom') is-invalid @enderror" id=""
                                    cols="30" rows="4" placeholder="Alamat Rumah disesuaikan dengan KTP">{{ old('alamat_dom', $dataUmumNasabah->alamat_dom) }}</textarea>
                                <hr>
                            </div>
                            <div class="form-group-2">
                                <div class="input-box">
                                    <label for="">Plafon</label>
                                    <input
                                        type="hidden"
                                        class="form-input-read-only"
                                        placeholder="Masukan Nama"
                                        name="plafon"
                                        value="{{ $dataUmumNasabah->nominal }}"
                                        readonly
                                    />
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->nominal ? number_format($dataUmumNasabah->nominal, 0 , "," ,".") : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Jangka Waktu</label>
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <input
                                                type="hidden"
                                                class="w-full form-input"
                                                placeholder="Masukan Jangka Waktu"
                                                name="jangka_waktu"
                                                aria-label="Jangka Waktu"
                                                aria-describedby="basic-addon2"
                                                value="{{$dataUmumNasabah->jangka_waktu}}"
                                            />
                                            <div class="p-2 bg-white border-b">
                                                <span>{{ $dataUmumNasabah->jangka_waktu ? $dataUmumNasabah->jangka_waktu : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 mt-2.5rem">
                                            <span class="form-input bg-gray-100">Bulan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Tujuan Penggunaan</label>
                                    <input
                                        type="hidden"
                                        class="form-input-read-only"
                                        name="tujuan_penggunaan"
                                        value="{{ $dataUmumNasabah->tujuan_penggunaan }}"
                                        readonly
                                    />
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->tujuan_penggunaan ? $dataUmumNasabah->tujuan_penggunaan : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Tujuan Penggunaan</label>
                                    <input
                                        type="hidden"
                                        class="form-input-read-only"
                                        name="tujuan_penggunaan"
                                        value="{{ $dataUmumNasabah->tujuan_penggunaan }}"
                                        readonly
                                    />
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->tujuan_penggunaan ? $dataUmumNasabah->tujuan_penggunaan : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Jaminan yang disediakan</label>
                                    <input
                                        type="hidden"
                                        class="form-input-read-only"
                                        name="ket_agunan"
                                        value="{{ $dataUmumNasabah->ket_agunan }}"
                                        readonly
                                    />
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->ket_agunan ? strtolower($dataUmumNasabah->ket_agunan) : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Tipe Pengajuan</label>
                                    @php
                                        $tipe = "";
                                        $labelPJ = "";
                                        if ($dataUmumNasabah->tipe == '2') {
                                            $tipe = "Perorangan";
                                        }
                                        elseif ($dataUmumNasabah->tipe == '3') {
                                            $tipe = "Badan Usaha";
                                            $labelPJ = "Nama Panggung jawab";
                                        }
                                        elseif ($dataUmumNasabah->tipe == '4') {
                                            $tipe = "Kelompok Usaha";
                                            $labelPJ = "Nama Ketua";
                                        }
                                    @endphp
                                    <input
                                        type="hidden"
                                        class="form-input-read-only"
                                        name="tipe"
                                        value="{{ $dataUmumNasabah->tipe }}"
                                        readonly
                                    />
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->tipe ? $tipe : '-' }}</span>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label for="">Jenis Badan Hukum</label>
                                    <input type="hidden" name="jenis_badan_hukum" value="{{$dataUmumNasabah->jenis_badan_hukum}}" id="">
                                    <div class="p-2 bg-white border-b">
                                        <span>{{ $dataUmumNasabah->jenis_badan_hukum ? $dataUmumNasabah->jenis_badan_hukum : '-' }}</span>
                                    </div>
                                </div>
                                @if ($dataUmumNasabah->jenis_badan_hukum == 3 || $dataUmumNasabah->jenis_badan_hukum == 4)
                                    <div class="input-box">
                                        <label for="">{{$labelPJ}}</label>
                                        <input type="hidden" name="nama_pj_ketua" value="{{$dataUmumNasabah->nama_pj_ketua}}" id="">
                                        <div class="p-2 bg-white border-b">
                                            <span>{{ $dataUmumNasabah->nama_pj_ketua ? $dataUmumNasabah->nama_pj_ketua : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="input-box">
                                        <label for="">Tempat Berdiri</label>
                                        <input type="hidden" name="tempat_berdiri" value="{{$dataUmumNasabah->tempat_berdiri}}" id="">
                                        <div class="p-2 bg-white border-b">
                                            <span>{{ $dataUmumNasabah->tempat_berdiri ? $dataUmumNasabah->tempat_berdiri : '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="input-box">
                                        <label for="">tanggal Berdiri</label>
                                        <input type="hidden" name="tanggal_berdiri" value="{{$dataUmumNasabah->tanggal_berdiri}}" id="">
                                        <div class="p-2 bg-white border-b">
                                            <span>{{ $dataUmumNasabah->tanggal_berdiri ? $dataUmumNasabah->tanggal_berdiri : '-' }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group-1">
                                <label for="">Hubungan Bank</label>
                                <textarea disabled name="hubungan_bank" class="form-input @error('hubungan_bank') is-invalid @enderror"
                                    id="" cols="30" rows="4" placeholder="Hubungan dengan Bank">{{ old('hubungan_bank', $dataUmumNasabah->hubungan_bank) }}</textarea>
                            </div>
                            <div class="form-group-1">
                                <label for="">Hasil Verifikasi</label>
                                <textarea disabled name="hasil_verifikasi" class="form-input @error('hasil_verifikasi') is-invalid @enderror"
                                    id="" cols="30" rows="4" placeholder="Hasil Verifikasi Karakter Umum">{{ old('hasil_verifikasi', $dataUmumNasabah->hasil_verifikasi) }}</textarea>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $no = 2;
                @endphp
                @foreach ($dataAspek as $itemAspek)
                    @php
                        // check level 2
                        $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                            ->where('level', 2)
                            ->where('id_parent', $itemAspek->id)
                            ->get();
                        // check level 4
                        $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                            ->where('level', 4)
                            ->where('id_parent', $itemAspek->id)
                            ->get();
                    @endphp
                    <div class="accordion-section">
                        <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                            <div class="flex justify-start gap-3">
                                <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                                    <h2 class="text-lg">{{$no++}}</h2>
                                </button>
                                <h3 class="font-bold text-lg tracking-tighter mt-[6px]">{{ $itemAspek->nama }}</h3>
                            </div>
                            <div class="absolute right-5 top-3">
                                <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                            </div>
                        </div>
                        <div class="accordion-content p-3">
                            @foreach ($dataLevelDua as $item)
                                @if ($item->opsi_jawaban != 'option')
                                    @php
                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.status_skor', 'item.is_commentable')
                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                            ->where('jawaban_text.id_jawaban', $item->id)
                                            ->get();
                                    @endphp
                                    @foreach ($dataDetailJawabanText as $itemTextDua)
                                        @php
                                            $getKomentar = \App\Models\DetailKomentarModel::select('detail_komentar.id', 'detail_komentar.id_komentar', 'detail_komentar.id_user', 'detail_komentar.id_item', 'detail_komentar.komentar')
                                                ->where('detail_komentar.id_item', $itemTextDua->id_item)
                                                ->get();
                                        @endphp

                                        @if ($itemTextDua->opsi_text != "tidak_ada_legalitas_usaha")
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail"
                                                    class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col">
                                                    @if ($item->opsi_jawaban == 'file')
                                                    <br>
                                                        @php
                                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                        @endphp
                                                        @if ($file_parts['extension'] == 'pdf')
                                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="700px"></iframe>
                                                        @else
                                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="700px">
                                                        @endif
                                                        @elseif ($item->opsi_jawaban == 'number' && $item->id != 143)
                                                        <p class="badge badge-info text-lg"><b>
                                                                Rp. {{ number_format((int) $itemTextDua->opsi_text, 2, ',', '.') }}
                                                            </b></p>
                                                    @else
                                                        @if (is_numeric($itemJawaban->option) && strlen($itemJawaban->option) > 3)
                                                            {{--  <input type="text" readonly
                                                                class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                value="{{ $itemTextDua->opsi_text }}">  --}}
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}} {{$item->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                            <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                                            value="{{ $itemTextDua->opsi_text }}">
                                                            <p class="form-control-plaintext text-justify">{{ $itemTextDua->opsi_text }}</p>
                                                        @else
                                                            <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                                                id="staticEmail" value="{{ $itemTextDua->opsi_text }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}} {{$item->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                            {{-- <p class="form-control-plaintext text-justify">{{ $itemTextDua->opsi_text }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}} {{$item->opsi_jawaban == 'persen' ? '%' : ''}}</p> --}}
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if ($itemTextDua->status_skor == 1)
                                            <div class="p-3">
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="form-group row">
                                                            <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                            <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <p class="badge badge-info text-lg"><b>
                                                                {{ $itemTextDua->skor_penyelia }}</b></p>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="d-flex">
                                                            <div class="">
                                                                <p><strong>Skor : </strong></p>
                                                            </div>
                                                            <div class="px-2">


                                                                <p class="badge badge-info text-lg"><b>
                                                                        {{ $itemTextDua->skor_penyelia }}</b></p>

                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                @if ($itemTextDua->is_commentable != null)
                                                    @foreach ($getKomentar as $itemKomentar)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="d-flex">
                                                                    <div style="width: 15%">
                                                                        <p class="p-0 m-0"><strong>Komentar : </strong>
                                                                        </p>
                                                                    </div>
                                                                    <h6 class="font-italic">{{ $itemKomentar->komentar ?? '' }}
                                                                    </h6>
                                                                    {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        @if ($item->nama == 'Repayment Capacity')
                                        @else
                                            @if ($itemTextDua->opsi_text != "tidak_ada_legalitas_usaha")
                                                <hr>
                                            @endif
                                        @endif
                                    @endforeach
                                    @if ($item->nama == 'Ijin Usaha' && $countIjin == 0)
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail"
                                                    class="col-sm-3 col-form-label font-weight-bold">Ijin Usaha</label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col">
                                                    <input type="text" readonly
                                                        class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                        value="Tidak ada legalitas usaha">
                                                </div>
                                            </div>
                                        @endif
                                @endif
                                @php
                                    $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                        ->where('id_item', $item->id)
                                        ->get();
                                    $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                        ->where('id_item', $item->id)
                                        ->get();

                                    // check level 3
                                    $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'is_hide')
                                        ->where('level', 3)
                                        ->where('id_parent', $item->id)
                                        ->get();
                                @endphp
                                @if ($item->id_parent == 10 && $item->nama != 'Hubungan Dengan Supplier')
                                    <div class="row form-group sub pl-4">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    </div>
                                    <hr>
                                @endif
                                @if (count($dataJawaban) != 0)
                                    @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi' || $item->nama == 'Repayment Capacity Opsi')

                                    @else
                                        <div class="row form-group sub pl-4">
                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
                                                        :
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col">
                                                @foreach ($dataJawaban as $key => $itemJawaban)
                                                    @php
                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                            ->where('id_pengajuan', $dataUmum->id)
                                                            ->get();
                                                        $count = count($dataDetailJawaban);
                                                        for ($i = 0; $i < $count; $i++) {
                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                        }
                                                    @endphp
                                                    @if (in_array($itemJawaban->id, $data))
                                                        @if (isset($data))
                                                            @if (is_numeric($itemJawaban->option) && strlen($itemJawaban->option) > 3)
                                                            <input type="text" readonly
                                                                class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                value="{{ $itemJawaban->option }}">
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                            @else
                                                            <input type="text" readonly
                                                                class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                value="{{ $itemJawaban->option }}">
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi')

                                    @else
                                        <div class="row form-group sub pl-4">
                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">

                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col">
                                                @foreach ($dataJawaban as $key => $itemJawaban)
                                                    @php
                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                            ->where('id_pengajuan', $dataUmum->id)
                                                            ->get();
                                                        $getKomentarPenyelia = null;
                                                        $getKomentarPBP = null;
                                                        $count = count($dataDetailJawaban);
                                                        for ($i = 0; $i < $count; $i++) {
                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                        }
                                                    @endphp
                                                    @if (in_array($itemJawaban->id, $data))
                                                        @if (isset($data))
                                                            @php
                                                                $dataDetailJawabanskor = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                    ->where('id_pengajuan', $dataUmum->id)
                                                                    ->where('id_jawaban', $itemJawaban->id)
                                                                    ->get();
                                                                $getKomentarPenyelia = \App\Models\DetailKomentarModel::select('detail_komentar.*')
                                                                    ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                    ->where('detail_komentar.id_komentar', $comment->id)
                                                                    ->where('detail_komentar.id_item', $item->id)
                                                                    ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                    ->get();
                                                                if ($dataUmum->id_cabang == 1) {
                                                                    $getKomentarPBP = \App\Models\DetailKomentarModel::select('detail_komentar.*')
                                                                        ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                        ->where('detail_komentar.id_komentar', $comment->id)
                                                                        ->where('detail_komentar.id_item', $item->id)
                                                                        ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                        ->get();
                                                                }
                                                            @endphp
                                                            @foreach ($dataDetailJawabanskor as $item)
                                                                @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                    <div class="form-group row">
                                                                        <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                                        <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                            <div class="d-flex justify-content-end">
                                                                                <div style="width: 20px">
                                                                                    :
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                        <div class="col">
                                                                            <p class="badge badge-info text-lg"><b>
                                                                                    {{ $item->skor_penyelia }}</b></p>
                                                                        </div>
                                                                    </div>
                                                                    {{-- <div class="d-flex">
                                                                        <div class="">
                                                                            <p><strong>Skor : </strong></p>
                                                                        </div>
                                                                        <div class="px-2">
                                                                            <p class="badge badge-info text-lg"><b>
                                                                                    {{ $item->skor_penyelia }}</b></p>
                                                                        </div>
                                                                    </div> --}}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @if (isset($getKomentarPenyelia))
                                            @foreach ($getKomentarPenyelia as $itemKomentarPenyelia)
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="form-group row">
                                                            <label for="slik" class="col-sm-4 col-form-label">Komentar Penyelia</label>
                                                            <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <h6 class="font-italic">{{ $itemKomentarPenyelia->komentar ?? ''}}</h6>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="d-flex">
                                                            <div style="width: 30%">
                                                                <p class="p-0 m-0"><strong>Komentar Penyelia : </strong></p>
                                                            </div>
                                                            <h6 class="font-italic">{{ $itemKomentarPenyelia->komentar ?? ''}}</h6>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if ($dataUmum->id_cabang == 1 && $getKomentarPBP != null)
                                            @foreach ($getKomentarPBP as $itemKomentarPBP)
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="d-flex">
                                                            <div style="width: 30%">
                                                                <p class="p-0 m-0"><strong>Komentar PBP : </strong></p>
                                                            </div>
                                                            <h6 class="font-italic">{{ $itemKomentarPBP->komentar ?? ''}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi')

                                        @else
                                            <hr>
                                        @endif
                                    @endif
                                @endif
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                    @if ($itemTiga->opsi_jawaban != 'option')
                                        @php
                                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.is_commentable', 'item.status_skor', 'item.opsi_jawaban')
                                                ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                ->where('jawaban_text.id_jawaban', $itemTiga->id)
                                                ->get();
                                            $jumlahDataDetailJawabanText = $dataDetailJawabanText ? count($dataDetailJawabanText) : 0;
                                            $getKomentar2 = \App\Models\DetailKomentarModel::select('*')
                                                ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                ->where('detail_komentar.id_item', $itemTiga->id)
                                                ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                ->get();
                                        @endphp
                                        @foreach ($dataDetailJawabanText as $itemTextTiga)
                                            @php
                                                $getKomentar2 = \App\Models\DetailKomentarModel::select('*')
                                                    ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                    ->where('detail_komentar.id_item', $itemTextTiga->id_item)
                                                    ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                    ->get();
                                            @endphp
                                            @if ($itemTextTiga->nama == 'NIB' || $itemTextTiga->nama == 'Surat Keterangan Usaha')
                                                <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">
                                                    @if ($jumlahDataDetailJawabanText > 1)
                                                        {{ $itemTextTiga->nama }} {{$loop->iteration}}
                                                    @else
                                                        {{ $itemTextTiga->nama }}
                                                    @endif
                                                </label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            @else
                                                <div class="row form-group sub pl-5">
                                                <label for="staticEmail" class="col-sm-3 col-form-label">
                                                    @if($jumlahDataDetailJawabanText > 1)
                                                        {{ $itemTextTiga->nama }} {{$loop->iteration}}
                                                    @else
                                                        {{ $itemTextTiga->nama }}
                                                    @endif
                                                </label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label">
                                            @endif
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                @if ($itemTextTiga->nama == 'NIB' || $itemTextTiga->nama == 'Surat Keterangan Usaha')
                                                    <div class="col">
                                                @else
                                                    <div class="col" style="padding: 0px">
                                                @endif
                                                    @if ($itemTextTiga->opsi_jawaban == 'file')
                                                    <br>
                                                        @php
                                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTextTiga->id_jawaban . '/' . $itemTextTiga->opsi_text);
                                                        @endphp
                                                        @if ($file_parts['extension'] == 'pdf')
                                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTextTiga->id_jawaban . '/' . $itemTextTiga->opsi_text }}" width="100%" height="700px"></iframe>
                                                        @else
                                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTextTiga->id_jawaban . '/' . $itemTextTiga->opsi_text }}" alt="" width="700px">
                                                        @endif
                                                    {{-- Rupiah data tiga --}}
                                                        @elseif ($itemTiga->opsi_jawaban == 'number')
                                                            <p class="badge badge-info text-lg"><b>
                                                                    Rp.
                                                                    {{ number_format((int) $itemTextTiga->opsi_text, 2, ',', '.') }}
                                                                </b>
                                                            </p>
                                                        @else
                                                        <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                                            id="staticEmail" value="{{ $itemTextTiga->opsi_text }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($itemTextTiga->status_skor == 1)
                                                <div class="row form-group sub pl-5">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="form-group row">
                                                            <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                            <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <p class="badge badge-info text-lg">
                                                                    <b>{{ $itemTextTiga->skor_penyelia }}</b></p>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="d-flex">
                                                            <div class="">
                                                                <p><strong>Skor : </strong></p>
                                                            </div>
                                                            <div class="px-2">
                                                                <p class="badge badge-info text-lg">
                                                                    <b>{{ $itemTextTiga->skor_penyelia }}</b></p>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($getKomentar2 as $itemKomentar2)
                                                <div class="row form-group sub pl-5">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="form-group row">
                                                            <label for="slik" class="col-sm-4 col-form-label">Komentar</label>
                                                            <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <h6 class="font-italic">{{ $itemKomentar2->komentar ?? '' }}</h6>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="d-flex">
                                                            <div style="width: 15%">
                                                                <p class="p-0 m-0"><strong>Komentar : </strong></p>
                                                            </div>
                                                            <h6 class="font-italic">{{ $itemKomentar2->komentar ?? '' }}</h6>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if ($itemTiga->nama == 'Ratio Coverage')

                                            @else
                                                <hr>
                                            @endif
                                        @endforeach
                                    @endif
                                    @php
                                        // check  jawaban level tiga
                                        $dataJawabanLevelTiga = \App\Models\OptionModel::where('option', '!=', '-')
                                            ->where('id_item', $itemTiga->id)
                                            ->get();
                                        $dataOptionTiga = \App\Models\OptionModel::where('option', '=', '-')
                                            ->where('id_item', $itemTiga->id)
                                            ->get();
                                        // check level empat
                                        $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'is_hide')
                                            ->where('level', 4)
                                            ->where('id_parent', $itemTiga->id)
                                            ->get();
                                    @endphp

                                    @if (count($dataJawabanLevelTiga) != 0)
                                        @if (!$itemTiga->is_hide)
                                            @if ($itemTiga->nama == 'Ratio Tenor Asuransi Opsi')

                                            @else
                                                @if ( $itemTiga->nama == 'Ratio Coverage Opsi')

                                                @else
                                                    <div class="row form-group sub pl-5">
                                                        <label for="staticEmail"
                                                            class="col-sm-3 col-form-label">{{ $itemTiga->nama }}</label>
                                                        <label for="staticEmail" class="col-sm-1 col-form-label">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">
                                                                    :
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col" style="padding: 0px">
                                                            @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                                                @php
                                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                                        ->where('id_pengajuan', $dataUmum->id)
                                                                        ->get();
                                                                    $count = count($dataDetailJawaban);
                                                                    for ($i = 0; $i < $count; $i++) {
                                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                    }
                                                                @endphp
                                                                @if (in_array($itemJawabanLevelTiga->id, $data))
                                                                    @if (isset($data))
                                                                        <input type="text" readonly
                                                                            class="form-control-plaintext font-weight-bold"
                                                                            id="staticEmail" value="{{ $itemJawabanLevelTiga->option }}">
                                                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        @foreach ($dataJawabanLevelTiga as $key => $itemJawabanTiga)
                                                            @php
                                                                $dataDetailJawabanTiga;
                                                                $getKomentarPenyelia3;
                                                                $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                    ->where('id_pengajuan', $dataUmum->id)
                                                                    ->get();
                                                                $count = count($dataDetailJawaban);
                                                                for ($i = 0; $i < $count; $i++) {
                                                                    $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                }
                                                            @endphp
                                                            @if (in_array($itemJawabanTiga->id, $data))
                                                                @if (isset($data))
                                                                    @php
                                                                        $dataDetailJawabanTiga = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                            ->where('id_pengajuan', $dataUmum->id)
                                                                            ->where('id_jawaban', $itemJawabanTiga->id)
                                                                            ->get();
                                                                        $getKomentarPenyelia3 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                            ->where('id_item', $itemJawabanTiga->id_item)
                                                                            ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                            ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                            ->get();
                                                                        $getKomentarPBO3 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                            ->where('id_item', $itemJawabanTiga->id_item)
                                                                            ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                            ->where('detail_komentar.id_user', $comment->id_pbo)
                                                                            ->first();
                                                                    @endphp
                                                                    @foreach ($dataDetailJawabanTiga as $item)
                                                                        @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                            <div class="form-group row">
                                                                                <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                                                <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                                    <div class="d-flex justify-content-end">
                                                                                        <div style="width: 20px">
                                                                                            :
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                                <div class="col">
                                                                                <p class="badge badge-info text-lg"><b>
                                                                                            {{ $item->skor_penyelia }}</b></p>
                                                                                </div>
                                                                            </div>
                                                                            {{-- <div class="d-flex">
                                                                                <div class="">
                                                                                    <p><strong>Skor : </strong></p>
                                                                                </div>
                                                                                <div class="px-2">
                                                                                    <p class="badge badge-info text-lg"><b>
                                                                                            {{ $item->skor_penyelia }}</b></p>
                                                                                </div>
                                                                            </div> --}}
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                            @php
                                                                if ($dataUmum->id_cabang == 1) {
                                                                    $getKomentarPBP3 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                        ->where('detail_komentar.id_item', $itemJawabanTiga->id_item)
                                                                        ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                        ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                        ->get();
                                                                }
                                                            @endphp
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if (isset($getKomentarPenyelia3))
                                                    @foreach ($getKomentarPenyelia3 as $itemKomentar3)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="form-group row">
                                                                    <label for="slik" class="col-sm-4 col-form-label">Komentar Penyelia</label>
                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                        <div class="d-flex justify-content-end">
                                                                            <div style="width: 20px">
                                                                                :
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="col">
                                                                        <h6 class="font-italic">{{ $itemKomentar3->komentar ?? '' }}</h6>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="d-flex">
                                                                    <div style="width: 30%">
                                                                        <p class="p-0 m-0"><strong>Komentar Penyelia: </strong></p>
                                                                    </div>
                                                                    <h6 class="font-italic">{{ $itemKomentar3->komentar ?? '' }}</h6>
                                                                    <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}">

                                                                </div> --}}
                                                                {{-- <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar3->komentar }}"> --}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @if ($userPBO)
                                                    <div class="row form-group sub pl-4">
                                                        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">

                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col">
                                                            <div class="d-flex">
                                                                <div style="width: 30%">
                                                                    <p class="p-0 m-0"><strong>Komentar PBO: </strong></p>
                                                                </div>
                                                                <h6 class="font-italic">{{ $getKomentarPBO3->komentar ?? '' }}</h6>
                                                                {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                            </div>
                                                            {{-- <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar3->komentar }}"> --}}
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($dataUmum->id_cabang == 1 && $getKomentarPBP3 != null)
                                                    @foreach ($getKomentarPBP3 as $itemKomentar3)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="d-flex">
                                                                    <div style="width: 30%">
                                                                        <p class="p-0 m-0"><strong>Komentar PBP: </strong></p>
                                                                    </div>
                                                                    <h6 class="font-italic">{{ $itemKomentar3->komentar ?? '' }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <hr>
                                            @endif
                                        @endif
                                    @endif

                                    @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                        @if (!$itemEmpat->is_hide)
                                            @if ($itemEmpat->opsi_jawaban != 'option')
                                                @php
                                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.opsi_jawaban', 'item.nama', 'item.is_commentable', 'item.status_skor')
                                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                        ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                        ->where('jawaban_text.id_jawaban', $itemEmpat->id)
                                                        ->get();
                                                @endphp
                                                @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                                    @php
                                                        $getKomentar4 = \App\Models\DetailKomentarModel::select('*')
                                                            ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                            ->where('id_item', $itemTextEmpat->id_item)
                                                            ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                            ->get();
                                                    @endphp
                                                    @if ($itemEmpat->id_parent == '95')
                                                        <div class="row form-group sub pl-4">" class="col-sm-3 col-form-label font-weight-bold">Jaminan Utama</label>
                                                            {{-- @elseif ($itemEmpat->id_paret == '110')
                                                            <label for="staticEmail" class="col-sm-3 col-form-label">Jaminan Tambahan</label> --}}
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    @else
                                                        <div class="row form-group sub pl-5">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemEmpat->nama }}</label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label">
                                                    @endif
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">
                                                                    :
                                                                </div>
                                                            </div>
                                                        </label>
                                                        @if ($itemEmpat->id_parent == '95')
                                                            <div class="col">
                                                        @else
                                                            <div class="col" style="padding: 0px">
                                                        @endif
                                                            @if ($itemTextEmpat->opsi_jawaban == 'file')
                                                            <br>
                                                                @php
                                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                                    $filepath = "../upload/$dataUmum->id/$itemTextEmpat->id_jawaban/$itemTextEmpat->opsi_text";
                                                                    @endphp
                                                                @if ($file_parts['extension'] == 'pdf')
                                                                    <iframe src="{{ asset($filepath) }}" width="100%" height="700px"></iframe>
                                                                @else
                                                                    <img src="{{ asset($filepath) }}"
                                                                        alt="" width="700px">
                                                                @endif
                                                                {{-- Rupiah data empat --}}
                                                                @elseif ($itemEmpat->opsi_jawaban == 'number' && $itemEmpat->id != 130)
                                                                    <p class="badge badge-info text-lg"><b>
                                                                            Rp.
                                                                            {{ number_format((int) $itemTextEmpat->opsi_text, 2, ',', '.') }}
                                                                        </b></p>
                                                                @else
                                                                @if ($itemEmpat->id == 101)
                                                                    <input type="text" readonly
                                                                        class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                        value="{{ $itemEmpat->nama . '       : ' . $itemTextEmpat->opsi_text }} {{$itemEmpat->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                @elseif ($itemEmpat->id == 130)
                                                                    <input type="text" readonly
                                                                        class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                        value="{{$itemTextEmpat->opsi_text.' Bulan'}}">
                                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                @else
                                                                    <input type="text" readonly
                                                                        class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                        value="{{ $itemTextEmpat->opsi_text }} {{$itemEmpat->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($itemTextEmpat->status_skor != null && $itemTextEmpat == false)
                                                        <div class="row form-group sub" style="padding-left: 5rem !important">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="form-group row">
                                                                    <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                        <div class="d-flex justify-content-end">
                                                                            <div style="width: 20px">
                                                                                :
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="col">
                                                                        <p class="badge badge-info text-lg"><b>
                                                                                {{ $itemTextEmpat->skor_penyelia }}</b></p>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="d-flex">
                                                                    <div class="">
                                                                        <p><strong>Skor : </strong></p>
                                                                    </div>
                                                                    <div class="px-2">
                                                                        <p class="badge badge-info text-lg"><b>
                                                                                {{ $itemTextEmpat->skor_penyelia }}</b></p>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @foreach ($getKomentar4 as $itemKomentar4)
                                                        <div class="row form-group sub" style="padding-left: 5rem !important">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="d-flex">
                                                                    <div style="width: 15%">
                                                                        <p class="p-0 m-0"><strong>Komentar : </strong></p>
                                                                    </div>
                                                                    <h6 class="font-italic">{{ $itemKomentar4->komentar ?? '' }}
                                                                    </h6>
                                                                    {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                                </div>
                                                                {{-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemKomentar4->komentar }}"> --}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <hr>
                                                @endforeach
                                            @endif
                                            @php
                                                // check level empat
                                                $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option', '!=', '-')
                                                    ->where('id_item', $itemEmpat->id)
                                                    ->get();

                                                $dataOptionEmpat = \App\Models\OptionModel::where('option', '=', '-')
                                                    ->where('id_item', $itemEmpat->id)
                                                    ->get();
                                            @endphp
                                            {{-- Data jawaban Level Empat --}}
                                            @if (count($dataJawabanLevelEmpat) != 0)
                                                @php
                                                    $dataDetailJawabanTest = \App\Models\JawabanPengajuanModel::select('jawaban.id', 'jawaban.id_pengajuan', 'jawaban.id_jawaban', 'item.id as id_item', 'item.nama', 'item.is_commentable', 'item.status_skor')
                                                        ->join('option', 'option.id', 'jawaban.id_jawaban')
                                                        ->join('item', 'option.id_item', 'item.id')
                                                        ->where('jawaban.id_pengajuan', $dataUmum->id)
                                                        ->where('option.id_item', $itemEmpat->id)
                                                        ->get();
                                                @endphp
                                                @if (!$dataDetailJawabanTest->isEmpty())
                                                    <div class="row form-group sub pl-4">
                                                        @if ($itemEmpat->id_parent == '110')
                                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jaminan Tambahan</label>
                                                        @elseif ($itemEmpat->id_parent == '95')
                                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jaminan Utama</label>
                                                        @else
                                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemEmpat->nama }}</label>
                                                        @endif
                                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">
                                                                    :
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col" style="padding: 0px">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label font-weight-bold">{{ $itemEmpat->nama }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group sub pl-4">
                                                        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">

                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col">
                                                            @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                                @php
                                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                                        ->where('id_pengajuan', $dataUmum->id)
                                                                        ->get();
                                                                    $count = count($dataDetailJawaban);
                                                                    for ($i = 0; $i < $count; $i++) {
                                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                    }
                                                                @endphp
                                                                @if (in_array($itemJawabanLevelEmpat->id, $data))
                                                                    @if (isset($data))
                                                                        <input type="text" readonly
                                                                            class="form-control-plaintext font-weight-bold"
                                                                            id="staticEmail"
                                                                            value="{{ $itemJawabanLevelEmpat->option }}">
                                                                        <input type="hidden" name="id[]"
                                                                            value="{{ $itemAspek->id }}">
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row form-group sub pl-4">
                                                        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">

                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col">
                                                            @php
                                                                $getKomentar5 = '';
                                                            @endphp
                                                            @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanEmpat)
                                                                @php
                                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                        ->where('id_pengajuan', $dataUmum->id)
                                                                        ->get();
                                                                    $count = count($dataDetailJawaban);
                                                                    for ($i = 0; $i < $count; $i++) {
                                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                    }
                                                                @endphp
                                                                @if (in_array($itemJawabanEmpat->id, $data))
                                                                    @if (isset($data))
                                                                        @php

                                                                            $dataDetailJawabanEmpat = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                                ->where('id_jawaban', $itemJawabanEmpat->id)
                                                                                ->get();
                                                                            $getKomentarPenyelia5 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                                ->where('detail_komentar.id_item', $itemJawabanEmpat->id_item)
                                                                                ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                                ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                                ->first();
                                                                            $getKomentarPBO5 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                                ->where('detail_komentar.id_item', $itemJawabanEmpat->id_item)
                                                                                ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                                ->where('detail_komentar.id_user', $comment->id_pbo)
                                                                                ->first();
                                                                            if ($dataUmum->id_cabang == 1) {
                                                                                $getKomentarPBP5 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                                ->where('detail_komentar.id_item', $itemJawabanEmpat->id_item)
                                                                                ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                                ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                                ->first();
                                                                            }
                                                                        @endphp
                                                                        @foreach ($dataDetailJawabanEmpat as $item)
                                                                            @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                                <div class="form-group row">
                                                                                    <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                                        <div class="d-flex justify-content-end">
                                                                                            <div style="width: 20px">
                                                                                                :
                                                                                            </div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <div class="col">
                                                                                        <p class="badge badge-info text-lg"><b>
                                                                                                {{ $item->skor_penyelia }}</b></p>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- <div class="d-flex">
                                                                                    <div class="">
                                                                                        <p><strong>Skor : </strong></p>
                                                                                    </div>
                                                                                    <div class="px-2">
                                                                                        <p class="badge badge-info text-lg"><b>
                                                                                                {{ $item->skor_penyelia }}</b>
                                                                                        </p>
                                                                                    </div>
                                                                                </div> --}}
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @if ($getKomentarPenyelia5)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="form-group row">
                                                                    <label for="slik" class="col-sm-4 col-form-label">Komentar Penyelia</label>
                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                        <div class="d-flex justify-content-end">
                                                                            <div style="width: 20px">
                                                                                :
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="col">
                                                                        <h6 class="font-italic">{{ $getKomentarPenyelia5->komentar ?? '' }}</h6>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="d-flex">
                                                                    <div style="width: 30%">
                                                                        <p class="p-0 m-0"><strong>Komentar Penyelia : </strong>
                                                                        </p>
                                                                    </div>
                                                                    <h6 class="font-italic">
                                                                        {{ $getKomentarPenyelia5->komentar ?? '' }}</h6>
                                                                    <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}">

                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($userPBO)
                                                        @if ($getKomentarPBO5)
                                                            <div class="row form-group sub pl-4">
                                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                    <div class="d-flex justify-content-end">
                                                                        <div style="width: 20px">

                                                                        </div>
                                                                    </div>
                                                                </label>
                                                                <div class="col">
                                                                    <div class="form-group row">
                                                                    <label for="slik" class="col-sm-4 col-form-label">Komentar PBO</label>
                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                        <div class="d-flex justify-content-end">
                                                                            <div style="width: 20px">
                                                                                :
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="col">
                                                                        <h6 class="font-italic">
                                                                            {{ $getKomentarPBO5->komentar ?? '' }}</h6>
                                                                    </div>
                                                                </div>
                                                                    {{-- <div class="d-flex">
                                                                        <div style="width: 30%">
                                                                            <p class="p-0 m-0"><strong>Komentar PBO : </strong>
                                                                            </p>
                                                                        </div>
                                                                        <h6 class="font-italic">
                                                                            {{ $getKomentarPBO5->komentar ?? '' }}</h6>
                                                                        <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}">

                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if ($dataUmum->id_cabang == 1 && $getKomentarPBP5 != null)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="form-group row">
                                                                    <label for="slik" class="col-sm-4 col-form-label">Komentar PBP</label>
                                                                    <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                        <div class="d-flex justify-content-end">
                                                                            <div style="width: 20px">
                                                                                :
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <div class="col">
                                                                        <h6 class="font-italic">{{ $getKomentarPBP5->komentar ?? '' }}</h6>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="d-flex">
                                                                    <div style="width: 30%">
                                                                        <p class="p-0 m-0"><strong>Komentar PBP : </strong>
                                                                        </p>
                                                                    </div>
                                                                    <h6 class="font-italic">
                                                                        {{ $getKomentarPBP5->komentar ?? '' }}</h6>
                                                                    <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}">

                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <hr>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach

                            @php
                                $pendapatUsulanStaf = \App\Models\PendapatPerAspek::select('*')
                                    ->where('id_staf', '!=', null)
                                    ->where('id_aspek', $itemAspek->id)
                                    ->where('id_pengajuan', $dataUmum->id)
                                    ->get();
                                $pendapatUsulanPenyelia = \App\Models\PendapatPerAspek::select('*')
                                    ->where('id_penyelia', '!=', null)
                                    ->where('id_pengajuan', $dataUmum->id)
                                    ->get();
                                $userPBO = \App\Models\User::select('id')
                                                            ->where('id_cabang', $dataUmum->id_cabang)
                                                            ->where('role', 'PBO')
                                                            ->first();

                                if ($userPBO) {
                                    $pendapatUsulanPbo = \App\Models\PendapatPerAspek::select('*')
                                        ->where('id_pbo', '!=', null)
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->get();
                                }
                                if ($dataUmum->id_cabang == 1) {
                                    $pendapatUsulanPBP = \App\Models\PendapatPerAspek::select('*')
                                        ->where('id_pbp', '!=', null)
                                        ->where('id_pengajuan', $dataUmum->id)
                                        ->get();
                                }
                            @endphp
                            @foreach ($pendapatUsulanStaf as $item)
                                @if ($item->id_aspek == $itemAspek->id)
                                    <div class="alert alert-success">
                                        <div class="form-group row sub mb-0" style="">
                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                                & Usulan <br> (Staff)</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
                                                        :
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col">
                                                <input type="hidden" readonly class="form-control-plaintext" id="staticEmail"
                                                    value="{{ $item->pendapat_per_aspek }}">
                                                <p class="form-control-plaintext text-justify">{{ $item->pendapat_per_aspek }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($pendapatUsulanPenyelia as $item)
                                @if ($item->id_aspek == $itemAspek->id)
                                    <div class="alert alert-success ">
                                        <div class="form-group row sub mb-0" style="">
                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                                & Usulan <br> (Penyelia)</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
                                                        :
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col">
                                                <input type="hidden" readonly class="form-control-plaintext" id="staticEmail"
                                                    value="{{ $item->pendapat_per_aspek }}">
                                                <p class="form-control-plaintext text-justify">{{ $item->pendapat_per_aspek }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if ($userPBO)
                                @foreach ($pendapatUsulanPbo as $item)
                                    @if ($item->id_aspek == $itemAspek->id)
                                        <div class="alert alert-success ">
                                            <div class="form-group row sub mb-0" style="">
                                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                                    & Usulan <br> (PBO)</label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col">
                                                    <input type="hidden" readonly class="form-control-plaintext" id="staticEmail"
                                                        value="{{ $item->pendapat_per_aspek }}">
                                                    <p class="form-control-plaintext text-justify">{{ $item->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if ($dataUmum->id_cabang == 1)
                                @foreach ($pendapatUsulanPBP as $item)
                                    @if ($item->id_aspek == $itemAspek->id)
                                        <div class="alert alert-success ">
                                            <div class="form-group row sub mb-0" style="">
                                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                                    & Usulan <br> (PBP)</label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col">
                                                    <input type="hidden" readonly class="form-control-plaintext" id="staticEmail"
                                                        value="{{ $item->pendapat_per_aspek }}">
                                                    <p class="form-control-plaintext text-justify">{{ $item->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
                @php
                    $userPBO = \App\Models\User::select('id')
                        ->where('id_cabang', $dataUmum->id_cabang)
                        ->where('role', 'PBO')
                        ->first();

                    $userPBP = \App\Models\User::select('id')
                        ->where('id_cabang', $dataUmum->id_cabang)
                        ->where('role', 'PBP')
                        ->whereNotNull('nip')
                        ->first();
                @endphp

                <div class="accordion-section">
                    <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                    <div class="flex justify-start gap-3">
                        <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                            <h2 class="text-lg">8</h2>
                        </button>
                        <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Pendapat dan usulan</h3>
                    </div>
                    <div class="absolute right-5 top-3">
                        <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                    </div>
                    </div>
                    <div class="accordion-content p-3">
                        <div class="alert alert-success ">
                            <div class="form-group row sub mb-0" style="">
                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                    & Usulan <br> (Staff)</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col">
                                    {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_staff }}">  --}}
                                    <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_staff }}">
                                    <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_staff }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success ">
                            <div class="form-group row sub mb-0" style="">
                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                    & Usulan <br> (Penyelia)</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col">
                                    {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_penyelia }}">  --}}
                                    <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_penyelia }}">
                                    <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_penyelia }}</p>
                                </div>
                            </div>
                        </div>
                        @if ($userPBO)
                            <div class="alert alert-success ">
                                <div class="form-group row sub mb-0" style="">
                                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                        & Usulan <br> (PBO)</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        <div class="d-flex justify-content-end">
                                            <div style="width: 20px">
                                                :
                                            </div>
                                        </div>
                                    </label>
                                    <div class="col">
                                        {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                            value="{{ $pendapatDanUsulan->komentar_pbo }}">  --}}
                                        <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                            value="{{ $pendapatDanUsulan->komentar_pbo }}">
                                        <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_pbo }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($dataUmum->id_cabang == 1)
                            @if ($userPBP)
                                <div class="alert alert-success">
                                    <div class="form-group row sub mb-0">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                            & Usulan <br> (PBP)</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col">
                                            {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                value="{{ $pendapatDanUsulan->komentar_pbp }}">  --}}
                                            <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                                value="{{ $pendapatDanUsulan->komentar_pbp }}">
                                            <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_pbp }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="alert alert-success ">
                            <div class="form-group row">
                                <label for="komentar_pincab" class="col-sm-3 col-form-label">Pendapat & Usulan Pimpinan Cabang</label>
                                <label for="komentar_pincab" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col">
                                    @if (Auth::user()->role == 'Pincab')
                                        <input type="hidden" name="id_pengajuan" id="" value="{{ $dataUmum->id }}">
                                        <textarea name="komentar_pincab" class="form-control" id="komentar_pincab" cols="5" rows="3"
                                            placeholder="Masukkan Pendapat Pemimpin Cabang">{{ $pendapatDanUsulan->komentar_pincab }}</textarea>
                                    @endif
                                    @if (Auth::user()->role == 'SPI' || Auth::user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                                        {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_pincab }}">  --}}
                                        <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_pincab }}">
                                        <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_pincab }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success ">
                            <div class="form-group row">
                                <label for="komentar_pincab" class="col-sm-3 col-form-label">Nominal Realisasi</label>
                                <label for="komentar_pincab" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col">
                                    @if (Auth::user()->role == 'Pincab')
                                        <input type="hidden" name="id_pengajuan" id="" value="{{ $dataUmum->id }}">
                                        <input type="number" class="form-control" id="nominal_realisasi" name="nominal_realisasi" placeholder="Nominal Normalisasi">
                                        {{-- <textarea name="komentar_pincab" class="form-control" id="komentar_pincab" cols="5" rows="3"
                                            placeholder="Masukkan Pendapat Pemimpin Cabang">{{ $pendapatDanUsulan->komentar_pincab }}</textarea> --}}
                                    @endif
                                    @if (Auth::user()->role == 'SPI' || Auth::user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                                        {{--  <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_pincab }}">  --}}
                                        <input type="hidden" class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_pincab }}">
                                        <p class="form-control-plaintext text-justify">{{ $pendapatDanUsulan->komentar_pincab }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-inject')
    <script>
        $(".accordion-header").click(function() {
            // Toggle the visibility of the next element with class 'accordion-content'
            $(this).next(".accordion-content").slideToggle();
        });
    </script>
@endpush
