@foreach ($dataAspek as $key => $value)
                        @php
                            $title_id = str_replace('&', 'dan', strtolower($value->nama));
                            $title_id = str_replace(' ', '-', strtolower($title_id));
                            $title_tab = "$title_id-tab";
                            if ($dataUmumNasabah->skema_kredit == 'KKB')
                                $key += ($dataIndex + 1);
                            else
                                $key += $dataIndex;

                            // check level 2
                            $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable', 'is_hide', 'is_rupiah')
                                ->where('level', 2)
                                ->where('id_parent', $value->id)
                                ->get();

                            $levTiga = \App\Models\ItemModel::select('id','nama','level','sequence','id_parent','opsi_jawaban')
                                    ->where('level', 3)
                                    ->where('sequence', 4)
                                    ->get();
                            // check level 4
                            $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable', 'is_hide')
                                ->where('level', 4)
                                ->where('id_parent', $value->id)
                                ->get();
                            $pendapatStafPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                ->whereNotNull('id_staf')
                                ->where('id_aspek', $value->id)
                                ->first();
                            $pendapatPenyeliaPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                ->whereNotNull('id_penyelia')
                                ->where('id_aspek', $value->id)
                                ->first();
                        @endphp
                        {{-- level level 2 --}}
                        <div id="{{ $title_tab }}" class="is-tab-content">
                            <div class="pb-10 space-y-3">
                                <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">{{$value->nama}}</h2>
                            </div>
                            <div class="self-start bg-white w-full border">
                                <div
                                    class="p-5 w-full space-y-5"
                                    id="{{$title_id}}">
                                    <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                                        @foreach ($dataLevelDua as $item)
                                            @if ($item->opsi_jawaban != 'option')
                                                @if (!$item->is_hide)
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama', 'item.opsi_jawaban')
                                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                            ->where('jawaban_text.id_jawaban', $item->id)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($dataDetailJawabanText as $itemTextDua)
                                                            @if ($item->opsi_jawaban == 'file')
                                                                <b class="m-2">{{ $item->nama }} : </b>
                                                                    @php
                                                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                                    @endphp
                                                                    @if ($file_parts['extension'] == 'pdf')
                                                                            <iframe
                                                                                class="border-4 border-gray-800 m-2"
                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                                width="100%" height="800px"></iframe>
                                                                    @else
                                                                        <img class="m-2" src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                            alt="" width="800px">
                                                                    @endif
                                                            @elseif ($item->opsi_jawaban == 'number' && $item->id != 143)
                                                            @else
                                                                @if ($item->id == 136 || $item->id == 138 || $item->id == 140 || $item->id == 143)
                                                                    <div class="field-review pl-0">
                                                                        <div class="field-name">
                                                                            <label for="">{{ $item->nama }}</label>
                                                                        </div>
                                                                        <div class="field-answer">
                                                                            @if ($item->id == 79)
                                                                            <p>{{ $itemTextDua->opsi_text }} :  {{ $item->id }}</p>
                                                                            @else
                                                                                @if ($item->opsi_jawaban == 'persen' || $item->nama == "Repayment Capacity")
                                                                                    <p> {{ $item->opsi_jawaban == 'persen' ?  round(floatval($itemTextDua->opsi_text),2) : str_replace('_', ' ', $itemTextDua->opsi_text) }} {{ $item->opsi_jawaban == 'persen' ? '%' : '' }}</p>
                                                                                @else
                                                                                    <p>Rp. {{ number_format((int) $itemTextDua->opsi_text, 0, ',', '.') }}</p>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach
                                        @foreach ($dataLevelDua as $item)
                                            @if ($item->opsi_jawaban != 'option')
                                                @if (!$item->is_hide)
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                            ->where('jawaban_text.id_jawaban', $item->id)
                                                            ->get();
                                                    @endphp
                                                    @if ($item->nama == 'Ijin Usaha' && $countIjin == 0)
                                                        <div class="field-review">
                                                            <div class="field-name">
                                                                <label for="">Ijin Usaha</label>
                                                            </div>
                                                            <div class="field-answer">
                                                                <p> Tidak ada legalitas usaha </p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @foreach ($dataDetailJawabanText as $itemTextDua)
                                                            <div class="row
                                                                    {{ $itemTextDua->opsi_text === 'nib' ? 'hidden' : '' }}
                                                                    {{ $item->opsi_jawaban == 'file' ? 'col-span-1 order-2' : '' }}

                                                                    {{ $item->nama == "NPWP" ||  $item->nama == "Ijin Usaha" ? 'col-span-1 order-2' : '' }}
                                                                    {{ $item->nama === "Kebutuhan Kredit" ||
                                                                        $item->nama === "Persentase Net Income" ||
                                                                        $item->nama === "Installment" || $item->nama === "Repayment Capacity" ?
                                                                        'col-span-1 order-3' : ''  }}
                                                                        {{ $item->nama === 'Perhitungan Installment' ?  'col-span-2 order-2' : '' }}
                                                                    {{ $item->nama === "Jumlah Orang yang menjalankan usaha" ?  'col-span-1 order-3' : '' }}">
                                                                <div class="col-md-12 space-y-4 order">
                                                                    @if ($item->opsi_jawaban == 'file')
                                                                        <b class="m-2">{{ $item->nama }} : </b>
                                                                        @php
                                                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                                        @endphp
                                                                        @if ($file_parts['extension'] == 'pdf')
                                                                                <iframe
                                                                                    class="border-4 border-gray-800 m-2"
                                                                                    src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                                    width="100%" height="800px"></iframe>
                                                                        @else
                                                                            <img class="m-2" src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                                alt="" width="800px">
                                                                        @endif
                                                                    @elseif ($item->opsi_jawaban == 'number' && $item->id != 143)
                                                                            <div class="field-review">
                                                                                <div class="field-name">
                                                                                    <label for="">{{ $item->nama }}</label>
                                                                                </div>
                                                                                <div class="field-answer">
                                                                                    @if ($item->is_rupiah == 1)
                                                                                        <p>Rp. {{ number_format((int) $itemTextDua->opsi_text, 0, ',', '.') }}</p>
                                                                                    @else
                                                                                        <p>{{ $itemTextDua->opsi_text }}</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @if ($itemTextDua->is_commentable)
                                                                            <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                                            @if (Auth::user()->role != 'Pincab')
                                                                                <div class="input-k-bottom">
                                                                                    <input type="text" class="form-input komentar"
                                                                                        name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @if ($item->id == 136 || $item->id == 138 || $item->id == 140 || $item->id == 143)
                                                                        @else
                                                                            <div class="field-review">
                                                                                <div class="field-name">
                                                                                    <label for="">{{ $item->nama }}</label>
                                                                                </div>
                                                                                <div class="field-answer">
                                                                                    @if ($item->id == 79)
                                                                                        <p class="npwp">{{$dataUmumNasabah->npwp}}</p>
                                                                                    @elseif($item->is_rupiah)
                                                                                        <p>Rp. {{ number_format((int) $itemTextDua->opsi_text, 0, ',', '.') }}</p>
                                                                                    @else
                                                                                        <p> {{ str_replace('_', ' ', $itemTextDua->opsi_text) }} {{ $item->opsi_jawaban == 'persen' ? '%' : '' }}</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if ($itemTextDua->is_commentable)
                                                                            @if (Auth::user()->role != 'Pincab')
                                                                                <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                                                <div class="input-k-bottom">
                                                                                    <input type="text" class="form-input komentar"
                                                                                        name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <input type="text" hidden class="form-input mb-3" placeholder="Masukkan komentar"
                                                                name="komentar_penyelia" value="{{ $itemTextDua->nama }}" disabled>
                                                            <input type="text" hidden class="form-input mb-3" placeholder="Masukkan komentar"
                                                                name="komentar_penyelia" value="{{ $itemTextDua->opsi_text }}" disabled>
                                                            <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextDua->id }}">
                                                            <input type="hidden" name="id[]" value="{{ $itemTextDua->id_item }}">
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endif
                                            @php
                                                $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                                    ->where('id_item', $item->id)
                                                    ->get();
                                                $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                                    ->where('id_item', $item->id)
                                                    ->get();

                                                $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                                    ->where('id_pengajuan', $dataUmum->id)
                                                    ->where('id_item', $item->id)
                                                    ->where('id_user', Auth::user()->id)
                                                    ->first();
                                                // check level 3
                                                $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable', 'is_hide', 'is_rupiah')
                                                    ->where('level', 3)
                                                    ->where('id_parent', $item->id)
                                                    ->get();
                                            @endphp
                                            @foreach ($dataOption as $itemOption)
                                                @if ($itemOption->option == '-')
                                                    @if (!$item->is_hide)
                                                        @if ($item->nama != "Ijin Usaha")
                                                            <div class="row col-span-2">
                                                                <div class="form-group-1">
                                                                    {{-- INI --}}
                                                                    <div class="form-group-1 col-span-2 pl-2">
                                                                        <div>
                                                                            <div class="p-2 border-l-8 border-theme-primary bg-gray-100">
                                                                                <h2 class="font-semibold text-lg tracking-tighter text-theme-text">
                                                                                    {{ $item->nama }} :
                                                                                </h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if ($item->nama == 'Ijin Usaha' && $countIjin == 0)
                                                                    <div class="bg-blue-50 border-b border-gray-500 text-gray-700 px-4 py-3 flex items-center" role="alert">
                                                                        <span class="text-sm font-semibold text-gray-400 mx-3">Jawaban : </span>
                                                                        <h4 class="font-bold">Tidak ada legalitas usaha</h4>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach

                                            @if (count($dataJawaban) != 0)
                                                @if (!$item->is_hide)
                                                    {{-- <div class="col-span-2">
                                                    </div> --}}
                                                @endif
                                                {{-- <div class="row"> --}}
                                                    @foreach ($dataJawaban as $key => $itemJawaban)
                                                        @php
                                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->get();
                                                            $count = count($dataDetailJawaban);
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                            }
                                                            $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->where('id_jawaban', $itemJawaban->id)
                                                                ->first();
                                                        @endphp
                                                        @if (in_array($itemJawaban->id, $data))
                                                            @if (isset($data))
                                                            <div class="row {{ $item->is_hide ? 'hidden' : ''}} {{ $item->nama === "Jumlah Kompetitor" ||  $item->nama === "Cara Penjualan" || $item->nama === "Sistem Pemasaran"   ? 'col-span-2' : ''}} {{ $item->nama === "Strategi Pemasaran" ? 'form-group-1' : '' }} {{ $item->nama === "Hubungan Dengan Supplier" ? 'col-span-2' : ''}} {{ $item->nama === "Usaha Dilakukan Sejak" ? 'col-span-2' : '' }} {{ $item->nama === "Badan Usaha" ? 'col-span-1' : ''  }}">
                                                                <div class="col-md-12 {{ $item->is_commentable == 'Ya' ? 'border p-3 bg-gray-50' : ''}}">
                                                                    @if (!$item->is_hide)
                                                                    <div class="{{ $item->nama === "Badan Usaha" || $item->nama === "Jumlah Orang yang menjalankan usaha" || $item->nama === "Strategi Pemasaran"  ? 'form-group-1' : 'form-group-2'}}">
                                                                        <div class="field-review">
                                                                            <div class="field-name">
                                                                                <label for="">{{$item->nama}}</label>
                                                                            </div>
                                                                            <div class="field-answer">
                                                                                <p>{{ $itemJawaban->option }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                        <div class="input-group input-b-bottom mt-3">
                                                                            @if ($item->is_commentable == 'Ya')
                                                                                <input type="hidden" name="id_item[]"
                                                                                    value="{{ $item->id }}">
                                                                                <input type="hidden" name="id_option[]"
                                                                                    value="{{ $itemJawaban->id }}">
                                                                                <div class="flex pl-2">
                                                                                        <div class="flex-1 w-64 space-y-3">
                                                                                            <label for="" class="text-sm font-semibold">Komentar</label>
                                                                                            <input type="text" class="w-full bg-transparent px-4 py-3 border-b-2 focus:border-red-500 border-gray-400 outline-none  komentar"
                                                                                                name="komentar_penyelia[]" placeholder="Masukkan Komentar"
                                                                                                value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                        </div>
                                                                                        <div class="flex-3 w-5"></div>
                                                                                        <div class="flex-2 w-16 space-y-3">
                                                                                            @php
                                                                                                $skorInput2 = null;
                                                                                                $skorInput2 = $getSkorPenyelia->skor_penyelia ? $getSkorPenyelia->skor_penyelia : $itemJawaban->skor;
                                                                                            @endphp
                                                                                            <label for="" class="text-sm font-semibold">Skor</label>
                                                                                            <input type="number" class="w-full font-bold appearance-none border rounded-md px-3 py-3 bg-transparent border-gray-400 outline-none  focus:border-red-500" placeholder=""
                                                                                                name="skor_penyelia[]"
                                                                                                min="0"
                                                                                                max="4"
                                                                                                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                                                                                                {{ $item->status_skor == 0 ? 'readonly' : '' }}
                                                                                                value="{{ $skorInput2 || $skorInput2 > 0 ? $skorInput2 : null }}">
                                                                                        </div>
                                                                                        <div class="flex-3 w-5"></div>
                                                                                </div>
                                                                            @else
                                                                                <input type="hidden" name="id_item[]"
                                                                                    value="{{ $item->id }}">
                                                                                <input type="hidden" name="id_option[]"
                                                                                    value="{{ $itemJawaban->id }}">
                                                                                <input type="hidden" name="komentar_penyelia[]"
                                                                                    value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                <input type="hidden" name="skor_penyelia[]"
                                                                                    value="null">
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div class="input-group input-b-bottom mt-3">
                                                                            @if ($item->is_commentable == 'Ya')
                                                                                <input type="hidden" name="id_item[]"
                                                                                    value="{{ $item->id }}">
                                                                                <input type="hidden" name="id_option[]"
                                                                                    value="{{ $itemJawaban->id }}">
                                                                                <input type="hidden" name="komentar_penyelia[]" value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                <div>
                                                                                    @php
                                                                                        $skorInput2 = null;
                                                                                        $skorInput2 = $getSkorPenyelia->skor_penyelia ? $getSkorPenyelia->skor_penyelia : $itemJawaban->skor;
                                                                                    @endphp
                                                                                    <input type="hidden"
                                                                                        name="skor_penyelia[]"
                                                                                        value="{{ $skorInput2 || $skorInput2 > 0 ? $skorInput2 : null }}">
                                                                                </div>
                                                                            @else
                                                                                <input type="hidden" name="id_item[]"
                                                                                    value="{{ $item->id }}">
                                                                                <input type="hidden" name="id_option[]"
                                                                                    value="{{ $itemJawaban->id }}">
                                                                                <input type="hidden" name="komentar_penyelia[]"
                                                                                    value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                <input type="hidden" name="skor_penyelia[]"
                                                                                    value="null">
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                                <input type="text" hidden class="form-input mb-3"
                                                                    placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                    value="{{ $itemJawaban->option }}" disabled>
                                                                <input type="text" hidden class="form-input mb-3"
                                                                    placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                    value="{{ $itemJawaban->skor }}" disabled>
                                                                <input type="hidden" name="id[]" value="{{ $item->id }}">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                {{-- </div> --}}
                                            @endif
                                            @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                                @if (!$itemTiga->is_hide)
                                                    @if ($itemTiga->opsi_jawaban != 'option')
                                                        @php
                                                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                                                ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                                ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                                ->where('jawaban_text.id_jawaban', $itemTiga->id)
                                                                ->get();
                                                            // dump($dataDetailJawabanText);
                                                                $jumlahDataDetailJawabanText = $dataDetailJawabanText ? count($dataDetailJawabanText) : 0;
                                                        @endphp
                                                        {{-- @foreach ($dataDetailJawabanText as $itemTextTiga)
                                                            @if ($itemTextTiga->nama != 'Ratio Tenor Asuransi')
                                                                @if ($itemTiga->opsi_jawaban == 'file')
                                                                    @if ($itemTextTiga->nama == "Dokumen NIB" || $itemTextTiga->nama == "Dokumen NPWP" || $itemTextTiga->nama == "Dokumen Surat Keterangan Usaha")
                                                                        <b>{{ $itemTextTiga->nama }} 121212 :</b>
                                                                        @php
                                                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text);
                                                                        @endphp
                                                                        @if ($file_parts['extension'] == 'pdf')
                                                                            <iframe
                                                                                style="border: 5px solid #dc3545;"
                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}"
                                                                                width="100%" height="800px"></iframe>
                                                                        @else
                                                                            <img style="border: 5px solid #dc3545;" src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}"
                                                                                alt="" width="800px">
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach --}}
                                                        @php
                                                            $no_foto = 0;
                                                        @endphp
                                                        @foreach ($dataDetailJawabanText as $itemTextTiga)
                                                            @if ($itemTextTiga->nama != 'Ratio Tenor Asuransi')
                                                                <div class="{{ $itemTiga->opsi_jawaban !== 'file' || str_contains($itemTextTiga->nama, 'Foto Usaha') ? 'col-span-1 p-2 order' : 'col-span-1 p-2 order-3' }}
                                                                            {{ $itemTextTiga->nama === "NIB" ?'form-group-2 col-span-1' : '' }}
                                                                            {{-- {{ str_contains($itemTextTiga->nama, 'Dokumen NPWP') ? 'col-span-1 p-2 order' : '' }} --}}
                                                                            {{ $itemTextTiga->nama === "Modal (awal) Sendiri" ||
                                                                            $itemTextTiga->nama === "Modal Pinjaman" ? 'col-span-1 form-group-1' : '' }}
                                                                            ">
                                                                    <div class="space-y-5">
                                                                            @if ($itemTiga->opsi_jawaban == 'file')
                                                                                @php
                                                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text);
                                                                                @endphp

                                                                                @if ($file_parts['extension'] == 'pdf')
                                                                                    <b>{{ $itemTextTiga->nama }} :</b>
                                                                                @else
                                                                                    @php
                                                                                        $no_foto++;
                                                                                    @endphp
                                                                                    <b>{{ $itemTextTiga->nama }} {{ $no_foto }} : </b>
                                                                                @endif
                                                                                @if ($file_parts['extension'] == 'pdf')
                                                                                    <iframe
                                                                                        class="border-2 border-gray-500"
                                                                                        src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}"
                                                                                        width="100%" height="800px"></iframe>
                                                                                @else
                                                                                    <img  class="border-2 border-gray-500" class="object-contain" src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemTiga->id . '/' . $itemTextTiga->opsi_text }}"
                                                                                        alt=""  width="100%" height="800px">
                                                                                @endif
                                                                                {{-- Rupiah data tiga --}}
                                                                            @elseif ($itemTiga->opsi_jawaban == 'number')
                                                                                <div class="bg-blue-50 border-b border-gray-500 text-gray-700 px-4 py-3 flex items-center" role="alert">
                                                                                    <span class="text-sm font-semibold text-gray-400 mx-3">Jawaban : </span>
                                                                                    <h4 class="font-bold">Rp. {{ number_format((int) $itemTextTiga->opsi_text, 0, ',', '.') }}</h4>
                                                                                </div>

                                                                                @if ($item->is_commentable == 'Ya')
                                                                                    @if (Auth::user()->role != 'Pincab')
                                                                                        <div class="input-k-bottom">
                                                                                            <input type="hidden" name="id_item[]"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="text" class="form-input komentar"
                                                                                                name="komentar_penyelia[]"
                                                                                                placeholder="Masukkan Komentar">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                @if ($itemTextTiga->opsi_text == "Tanah" || $itemTextTiga->opsi_text == "Kendaraan Bermotor" || $itemTextTiga->opsi_text == "Tanah dan Bangunan")
                                                                                @else
                                                                                    <div class="field-review">
                                                                                        <div class="field-name">
                                                                                            <label for="">{{ $itemTextTiga->nama }}</label>
                                                                                        </div>
                                                                                        <div class="field-answer">
                                                                                            @if ($itemTiga->is_rupiah == 1)
                                                                                                <p>Rp. {{ number_format((int) $itemTextTiga->opsi_text, 0, ',', '.') }}</p>
                                                                                            @else
                                                                                                <p>{{ $itemTiga->opsi_jawaban == 'persen' ?  round(floatval($itemTextTiga->opsi_text),2) : $itemTextTiga->opsi_text  }}{{ $itemTiga->opsi_jawaban == 'persen' ? '%' : '' }}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if ($item->is_commentable == 'Ya')
                                                                                    @if (Auth::user()->role != 'Pincab')
                                                                                        <div class="input-k-bottom">
                                                                                            <input type="hidden" name="id_item[]"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="text" class="form-input komentar"
                                                                                                name="komentar_penyelia[]"
                                                                                                placeholder="Masukkan Komentar">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" class="form-input mb-3" placeholder="Masukkan komentar"
                                                                    name="komentar_penyelia" value="{{ $itemTextTiga->nama }}" disabled>
                                                                <input type="hidden" class="form-input mb-3" placeholder="Masukkan komentar"
                                                                    name="komentar_penyelia" value="{{ $itemTextTiga->opsi_text }}" disabled>

                                                                <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextTiga->id }}">
                                                                <input type="hidden" name="id[]" value="{{ $itemTextTiga->id_item }}">
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
                                                        $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                                            ->where('id_pengajuan', $dataUmum->id)
                                                            ->where('id_item', $itemTiga->id)
                                                            ->first();
                                                        // check level empat
                                                        $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable', 'is_hide', 'is_rupiah')
                                                            ->where('level', 4)
                                                            ->where('id_parent', $itemTiga->id)
                                                            ->get();
                                                        // check jawaban kelayakan
                                                        $checkJawabanKelayakan = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                            ->where('id_pengajuan', $dataUmum->id)
                                                            ->whereIn('id_jawaban', ['183', '184'])
                                                            ->first();
                                                    @endphp

                                                    {{-- @foreach ($dataOptionTiga as $itemOptionTiga)
                                                        @if (!$itemTiga->is_hide)
                                                            @if ($itemOptionTiga->option == '-')
                                                                @if (isset($checkJawabanKelayakan))
                                                                @else
                                                                    <div class="row">
                                                                        <div class="form-group-1">
                                                                            <h5> {{ $itemTiga->nama }}lev3</h5>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endforeach --}}
                                                    @foreach ($dataOptionTiga as $itemOptionTiga)
                                                        @if ($itemOptionTiga->option == '-')
                                                            @if ($itemTiga->id != 110)
                                                                <div class="form-group-1 col-span-2 pl-2">
                                                                    <div>
                                                                        <div class="p-2 border-l-8 border-theme-primary bg-gray-100">
                                                                            <h2 class="font-semibold text-lg tracking-tighter text-theme-text">
                                                                                {{$itemTiga->nama}} :
                                                                            </h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach

                                                    @if (count($dataJawabanLevelTiga) != 0)
                                                        @if ($itemTiga->nama == 'Ratio Tenor Asuransi Opsi')
                                                        @else
                                                            <div class="form-group-2 col-span-2 {{ $item->is_commentable == 'Ya' || $itemTiga->is_commentable == 'Ya' ? 'border p-3 bg-gray-50' : ''}}">
                                                                @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                                                    @php
                                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                            ->where('id_pengajuan', $dataUmum->id)
                                                                            ->get();

                                                                        $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                            ->where('id_pengajuan', $dataUmum->id)
                                                                            ->where('id_jawaban', $itemJawabanLevelTiga->id)
                                                                            ->first();
                                                                        $count = count($dataDetailJawaban);
                                                                        for ($i = 0; $i < $count; $i++) {
                                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                        }
                                                                    @endphp
                                                                    @if (in_array($itemJawabanLevelTiga->id, $data))
                                                                        @if (isset($data))
                                                                            <div class="">
                                                                                @if ($itemTiga->nama != 'Ratio Coverage Opsi')
                                                                                    <div class="row">
                                                                                        <div class="field-review">
                                                                                            <div class="field-name">
                                                                                                    <label for="">{{ $itemTiga->nama }}</label>
                                                                                            </div>
                                                                                            <div class="field-answer">
                                                                                                <p>{{ $itemJawabanLevelTiga->option }}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <input type="text" hidden class="form-input mb-3"
                                                                                placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                                value="{{ $itemJawabanLevelTiga->option }}" disabled>
                                                                            <input type="text" hidden class="form-input mb-3"
                                                                                placeholder="Masukkan komentar" name="skor_penyelia"
                                                                                value="{{ $itemJawabanLevelTiga->skor }}" disabled>
                                                                            <input type="hidden" name="id[]"
                                                                                value="{{ $itemTiga->id }}">
                                                                        @endif
                                                                    @endif
                                                                    @if ($getSkorPenyelia)
                                                                        @if ($itemTiga->is_commentable == 'Ya')
                                                                            <input type="hidden" name="id_item[]"
                                                                                value="{{ $itemTiga->id }}">
                                                                            <input type="hidden" name="id_option[]"
                                                                                value="{{ $itemJawabanLevelTiga->id }}">
                                                                            @php
                                                                                $skorInput3 = null;
                                                                                $skorInput3 = $getSkorPenyelia?->skor ? $getSkorPenyelia?->skor : $itemJawabanLevelTiga->skor;
                                                                            @endphp
                                                                            <div class="row col-span-2">
                                                                                <div class="input-group-1">
                                                                                    <div class="flex pl-2">
                                                                                        <div class="flex-1 w-64">
                                                                                            <label for="">Komentar </label>
                                                                                            <input type="text" class="w-full bg-transparent px-4 py-3 border-b-2 focus:border-red-500 border-gray-400 outline-none  komentar"
                                                                                                name="komentar_penyelia[]" placeholder="Masukkan Komentar"
                                                                                                value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                        </div>
                                                                                        <div class="flex-3 w-5"></div>
                                                                                        <div class="flex-2 w-16">
                                                                                            <label for="">Skor</label>
                                                                                            <input type="number" class="w-full font-bold appearance-none border rounded-md px-3 py-3 bg-transparent border-gray-400 outline-none  focus:border-red-500"
                                                                                                min="0"
                                                                                                max="4"
                                                                                                name="skor_penyelia[]"
                                                                                                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                                                                                                {{ $itemTiga->status_skor == 0 ? 'readonly' : '' }}
                                                                                                value="{{ $skorInput3 || $skorInput3 > 0 ? $skorInput3 : null }}">
                                                                                        </div>
                                                                                        <div class="flex-3 w-5"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="field-answer">
                                                                                    <p>{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}</p>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <input type="hidden" name="id_item[]"
                                                                                value="{{ $itemTiga->id }}">
                                                                            <input type="hidden" name="id_option[]"
                                                                                value="{{ $itemJawabanLevelTiga->id }}">
                                                                            <input type="hidden" name="komentar_penyelia[]"
                                                                                value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                            <input type="hidden" name="skor_penyelia[]"
                                                                                value="null">
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                    {{-- INI --}}
                                                    @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                                    @if (!$itemEmpat->is_hide)
                                                        @if ($itemEmpat->opsi_jawaban != 'option')
                                                            @php
                                                                $dataDetailJawabanTextEmpat = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                                                    ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                                    ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                                    ->where('jawaban_text.id_jawaban', $itemEmpat->id)
                                                                    ->orderBy('id_jawaban')
                                                                    ->get();
                                                            @endphp
                                                            @if ($itemEmpat->id == 148)
                                                                @php
                                                                    $gridClass = 'grid-cols-1';
                                                                    if (count($dataDetailJawabanTextEmpat) > 1) {
                                                                        $gridClass = 'grid-cols-2';
                                                                    }
                                                                    if (count($dataDetailJawabanTextEmpat) > 2) {
                                                                        $gridClass = 'grid-cols-3';
                                                                    }
                                                                @endphp
                                                                <div class="row grid col-span-2 {{$gridClass}}">
                                                                    @foreach ($dataDetailJawabanTextEmpat as $itemTextEmpat)
                                                                        <div class="foto">
                                                                            @if (intval($itemTextEmpat->opsi_text) > 1)
                                                                                <b class="pl-2">{{ $itemTextEmpat->nama }}</b>
                                                                                @php
                                                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                                                @endphp
                                                                                @if ($file_parts['extension'] == 'pdf')
                                                                                    <div class="pl-2">
                                                                                        <iframe
                                                                                            src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                            width="100%" height="400"></iframe>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="pl-2">
                                                                                        <img style="border: 5px solid #c2c7cf"
                                                                                            src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                            alt="" class="w-full">
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                @php
                                                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                                                @endphp
                                                                                @if ($file_parts['extension'] == 'pdf')
                                                                                    <div class="pl-2">
                                                                                        <iframe
                                                                                            src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                            width="100%" height="500px"></iframe>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="pl-2">
                                                                                        <img style="border: 5px solid #c2c7cf"
                                                                                            src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                            alt="" width="500px">
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @foreach ($dataDetailJawabanTextEmpat as $itemTextEmpat)
                                                                <div class="row">
                                                                    <div class="foto">
                                                                        @if ($itemEmpat->id != 148)
                                                                            @if ($itemEmpat->opsi_jawaban == 'file')
                                                                                @if (intval($itemTextEmpat->opsi_text) > 1)
                                                                                    <b class="pl-2">{{ $itemTextEmpat->nama }}</b>
                                                                                    @php
                                                                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                                                    @endphp
                                                                                    @if ($file_parts['extension'] == 'pdf')
                                                                                        <div class="pl-2">
                                                                                            <iframe
                                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                                width="100%" height="400"></iframe>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="pl-2">
                                                                                            <img style="border: 5px solid #c2c7cf"
                                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                                alt="" class="w-full">
                                                                                        </div>
                                                                                    @endif
                                                                                @else
                                                                                    @php
                                                                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                                                    @endphp
                                                                                    @if ($file_parts['extension'] == 'pdf')
                                                                                        <div class="pl-2">
                                                                                            <iframe
                                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                                width="100%" height="500px"></iframe>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="pl-2">
                                                                                            <img style="border: 5px solid #c2c7cf"
                                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                                                alt="" width="500px">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            {{-- Rupiah data empat --}}
                                                                            @elseif ($itemEmpat->opsi_jawaban == 'number' && $itemEmpat->id != 130)
                                                                                <div class="jawaban-responsive border-b p-2 font-medium">
                                                                                    <div class="bg-blue-50 border-b border-gray-500 text-gray-700 px-4 py-3 flex items-center" role="alert">
                                                                                        <span class="text-sm font-semibold text-gray-400 mx-3">Jawaban: </span>
                                                                                        <h4 class="font-bold">Rp. {{ number_format((int) $itemTextEmpat->opsi_text, 0, ',', '.') }}</h4>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($itemTextEmpat->is_commentable == 'Ya')
                                                                                    @if (Auth::user()->role != 'Pincab')
                                                                                        <div class="input-k-bottom">
                                                                                            <input type="hidden" name="id_item[]"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="text"
                                                                                                class="form-input komentar"
                                                                                                name="komentar_penyelia[]"
                                                                                                placeholder="Masukkan Komentar">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                <div class="field-review">
                                                                                    <div class="field-name">
                                                                                        <label for="">{{ $itemTextEmpat->nama }}</label>
                                                                                    </div>
                                                                                    <div class="field-answer">
                                                                                        <p>
                                                                                            @if ($itemEmpat->is_rupiah == 1)
                                                                                                Rp. {{ number_format((int) $itemTextEmpat->opsi_text, 0, ',', '.') }}
                                                                                            @else
                                                                                                {{ $itemEmpat->opsi_jawaban == 'persen' ? round(floatval($itemTextEmpat->opsi_text),2) : $itemTextEmpat->opsi_text }}
                                                                                            @endif

                                                                                            @if ($itemEmpat->opsi_jawaban == 'persen')
                                                                                                %
                                                                                            @elseif($itemEmpat->id == 130)
                                                                                                Bulan
                                                                                            @else
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                @if ($itemTextEmpat->is_commentable == 'Ya')
                                                                                    @if (Auth::user()->role != 'Pincab')
                                                                                        <div class="input-k-bottom">
                                                                                            <input type="hidden" name="id_item[]"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="text"
                                                                                                class="form-input komentar"
                                                                                                name="komentar_penyelia[]"
                                                                                                placeholder="Masukkan Komentar">
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" class="form-input mb-3"
                                                                    placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                    value="{{ $itemTextEmpat->nama }}" disabled>
                                                                <input type="hidden" class="form-input mb-3"
                                                                    placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                    value="{{ $itemTextEmpat->opsi_text }}" disabled>
                                                                <input type="hidden" name="id_jawaban_text[]"
                                                                    value="{{ $itemTextEmpat->id }}">
                                                                <input type="hidden" name="id[]" value="{{ $itemTextEmpat->id_item }}">
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
                                                            $isJawabanExist = \App\Models\OptionModel::join('jawaban', 'jawaban.id_jawaban', 'option.id')
                                                                ->where('jawaban.id_pengajuan', $dataUmum->id)
                                                                ->where('id_item', $itemEmpat->id)
                                                                ->count();

                                                            $getKomentar = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->where('id_item', $itemEmpat->id)
                                                                ->first();
                                                            // echo "<pre>";
                                                            // print_r ($dataOptionEmpat);
                                                            // echo "</pre>";
                                                            // ;
                                                        @endphp
                                                        @if ($itemEmpat->opsi_jawaban == 'option' && $isJawabanExist > 0)
                                                            @if ($itemEmpat->nama != "Tidak Memiliki Jaminan Tambahan")
                                                                {{-- <div class="row">
                                                                    <div class="form-group-1 mb-0">
                                                                        <label for="">{{ $itemEmpat->nama }}</label>
                                                                    </div>
                                                                </div> --}}
                                                            @endif
                                                        @endif

                                                        {{-- Data jawaban Level Empat --}}
                                                        @if (count($dataJawabanLevelEmpat) != 0)
                                                            <div class="row col-span-2">
                                                                @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                                    @php
                                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                            ->where('id_pengajuan', $dataUmum->id)
                                                                            ->get();
                                                                        $count = count($dataDetailJawaban);
                                                                        for ($i = 0; $i < $count; $i++) {
                                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                                        }
                                                                        $getSkorPenyelia = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                            ->where('id_pengajuan', $dataUmum->id)
                                                                            ->where('id_jawaban', $itemJawabanLevelEmpat->id)
                                                                            ->first();
                                                                    @endphp
                                                                    @if (in_array($itemJawabanLevelEmpat->id, $data))
                                                                        @if (isset($data))
                                                                            <div class="form-group-1">
                                                                                @if ($itemEmpat->nama != "Tidak Memiliki Jaminan Tambahan")
                                                                                    <div class="row form-group-2">
                                                                                        <div class="col-md-12">
                                                                                            <div class="field-review">
                                                                                                <div class="field-name">
                                                                                                    <label for="">{{ $itemEmpat->nama }}</label>
                                                                                                </div>
                                                                                                <div class="field-answer">
                                                                                                    <p>{{ $itemJawabanLevelEmpat->option }}</p>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- <div class="bg-blue-50 border-b border-gray-500 text-gray-700 px-4 py-3 flex items-center" role="alert">
                                                                                                <span class="text-sm font-semibold text-gray-400 mx-3">Jawaban : OYY</span>
                                                                                                <h4 class="font-bold"> {{ $itemJawabanLevelEmpat->option }}</h4>
                                                                                            </div> --}}

                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                <div class="input-group input-b-bottom mt-3">
                                                                                    @if ($itemEmpat->is_commentable == 'Ya')
                                                                                        <input type="hidden" name="id_item[]"
                                                                                            value="{{ $itemEmpat->id }}">
                                                                                        <input type="hidden" name="id_option[]"
                                                                                            value="{{ $itemJawabanLevelEmpat->id }}">
                                                                                        <div class="flex pl-2">
                                                                                            <div class="flex-1 w-64">
                                                                                                <label for="">Komentar</label>
                                                                                                <input type="text" class="w-full px-4 py-2 border-b-2 border-gray-400 outline-none  focus:border-gray-400 komentar"
                                                                                                    name="komentar_penyelia[]" placeholder="Masukkan Komentar"
                                                                                                    value="{{ isset($getKomentar->komentar) ? $getKomentar->komentar : '' }}">
                                                                                            </div>
                                                                                            <div class="flex-3 w-5"></div>
                                                                                            <div class="flex-2 w-16">
                                                                                                <label for="">Skor</label>
                                                                                                @php
                                                                                                    $skorInput4 = null;
                                                                                                    $skorInput4 = $getSkorPenyelia?->skor_penyelia ? $getSkorPenyelia?->skor_penyelia : $itemJawabanLevelEmpat->skor;
                                                                                                @endphp
                                                                                                <input type="number" class="w-full px-3 py-2 border-b-2 border-gray-400 outline-none  focus:border-gray-400"
                                                                                                    placeholder="" name="skor_penyelia[]"
                                                                                                    min="0"
                                                                                                    max="4"
                                                                                                    onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                                                                                                    {{ $itemEmpat->status_skor == 0 ? 'readonly' : '' }}
                                                                                                    value="{{ $skorInput4 || $skorInput4 > 0 ? $skorInput4 : null }}">
                                                                                            </div>
                                                                                            <div class="flex-3 w-5"></div>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" class="form-input mb-3"
                                                                                placeholder="Masukkan komentar" name="komentar_penyelia"
                                                                                value="{{ $itemJawabanLevelEmpat->option }}" disabled>
                                                                            <input type="hidden" name="id[]"
                                                                                value="{{ $itemEmpat->id }}">
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                        {{-- @foreach ($dataLevelDua as $item)
                                            @if ($item->opsi_jawaban != 'option')
                                                @if (!$item->is_hide)
                                                    @php
                                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                            ->where('jawaban_text.id_jawaban', $item->id)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($dataDetailJawabanText as $itemTextDua)
                                                        <div class="row">
                                                        <div class="col-md-12">
                                                                @if ($item->opsi_jawaban == 'file')
                                                                    <b>{{ $item->nama }} 9999 :</b>
                                                                    @php
                                                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                                    @endphp
                                                                    @if ($file_parts['extension'] == 'pdf')
                                                                            <iframe
                                                                                src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                                width="100%" height="800px"></iframe>
                                                                    @else
                                                                        <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}"
                                                                            alt="" width="800px">
                                                                    @endif
                                                                @elseif ($item->opsi_jawaban == 'number' && $item->id != 143)
                                                                        <div class="field-review">
                                                                            <div class="field-name">
                                                                                <label for="">{{ $item->nama }}</label>
                                                                            </div>
                                                                            <div class="field-answer">
                                                                                <p>{{ number_format((int) $itemTextDua->opsi_text, 2, ',', '.') }}</p>
                                                                            </div>
                                                                        </div>
                                                                    @if ($itemTextDua->is_commentable)
                                                                        <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                                        @if (Auth::user()->role != 'Pincab')
                                                                            <div class="input-k-bottom">
                                                                                <input type="text" class="form-input komentar"
                                                                                    name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <div class="field-review">
                                                                        <div class="field-name">
                                                                            <label for="">{{ $item->nama }} 7777</label>
                                                                        </div>
                                                                        <div class="field-answer">
                                                                            @if ($item->id == 79)
                                                                                <p>{{$itemTextDua->opsi_text}}</p>
                                                                            @else
                                                                                <p> {{ str_replace('_', ' ', $itemTextDua->opsi_text) }} {{ $item->opsi_jawaban == 'persen' ? '%' : '' }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    @if ($itemTextDua->is_commentable)
                                                                        @if (Auth::user()->role != 'Pincab')
                                                                            <input type="hidden" name="id_item[]" value="{{ $item->id }}">
                                                                            <div class="input-k-bottom">
                                                                                <input type="text" class="form-input komentar"
                                                                                    name="komentar_penyelia[]" placeholder="Masukkan Komentar">
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <input type="text" hidden class="form-input mb-3" placeholder="Masukkan komentar"
                                                            name="komentar_penyelia" value="{{ $itemTextDua->nama }}" disabled>
                                                        <input type="text" hidden class="form-input mb-3" placeholder="Masukkan komentar"
                                                            name="komentar_penyelia" value="{{ $itemTextDua->opsi_text }}" disabled>
                                                        <input type="hidden" name="id_jawaban_text[]" value="{{ $itemTextDua->id }}">
                                                        <input type="hidden" name="id[]" value="{{ $itemTextDua->id_item }}">
                                                    @endforeach
                                                @endif
                                            @endif
                                        @endforeach --}}
                                    </div>
                                    @if (Auth::user()->role == 'PBP')
                                        @php
                                            $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                                ->where('id_aspek', $value->id)
                                                ->where('id_pbp', Auth::user()->id)
                                                ->first();
                                        @endphp
                                        <div class="form-group-1 pl-3">
                                            <h4 class="font-semibold text-base" for="">Pendapat dan Usulan {{ $value->nama }}</h4>
                                            <input type="hidden" name="id_aspek[]" value="{{ $value->id }}">
                                            <textarea name="pendapat_per_aspek[]" class="form-textarea @error('pendapat_per_aspek') is-invalid @enderror"
                                                id="pendapat_per_aspek[]" cols="30" rows="4" placeholder="Pendapat Per Aspek">
                                                {{ old('pendapat_per_aspek', isset($getPendapatPerAspek->pendapat_per_aspek) ? $getPendapatPerAspek->pendapat_per_aspek : '') }}
                                            </textarea>
                                            @error('pendapat_per_aspek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <hr>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Staf Kredit</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatStafPerAspek->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Penyelia</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatPenyeliaPerAspek->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($dataUmumNasabah->id_pbo)
                                            <div class="form-group-1">
                                                <h4 class="font-semibold text-base" for="">Pendapat dan Usulan PBO</h4>
                                                <p>{{ $pendapatDanUsulanPBO->komentar_pbo }}</p>
                                            </div>
                                        @endif
                                    @elseif (Auth::user()->role == 'PBO')
                                        @php
                                            $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                                ->where('id_aspek', $value->id)
                                                ->where('id_pbo', Auth::user()->id)
                                                ->first();
                                        @endphp
                                        <div class="form-group-1">
                                            <h4 class="font-semibold text-base" for="">Pendapat dan Usulan {{ $value->nama }}</h4>
                                            <input type="hidden" name="id_aspek[]" value="{{ $value->id }}">
                                            <textarea name="pendapat_per_aspek[]" class="form-textarea @error('pendapat_per_aspek') is-invalid @enderror"
                                                id="pendapat_per_aspek[]" cols="30" rows="4" placeholder="Pendapat Per Aspek">{{ isset($getPendapatPerAspek->pendapat_per_aspek) ? $getPendapatPerAspek->pendapat_per_aspek : '' }}</textarea>
                                            @error('pendapat_per_aspek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <hr>
                                        <hr>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Staf Kredit</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatStafPerAspek->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Penyelia</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatPenyeliaPerAspek->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif (Auth::user()->role == 'Pincab')
                                        @php
                                            $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                                ->where('id_aspek', $value->id)
                                                ->where('id_pbp', Auth::user()->id)
                                                ->first();
                                        @endphp
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Staf Kredit</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatStafPerAspek->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Penyelia</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatPenyeliaPerAspek?->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($dataUmumNasabah->id_pbo)
                                            <div class="form-group-1">
                                                <label for="">Pendapat dan Usulan PBO</label>
                                                <p class="border-b p-2">{{ $pendapatDanUsulanPBO->komentar_pbo }}</p>
                                            </div>
                                        @endif
                                    @else
                                        @php
                                            $getPendapatPerAspek = \App\Models\PendapatPerAspek::where('id_pengajuan', $dataUmum->id)
                                                ->where('id_aspek', $value->id)
                                                ->where('id_penyelia', Auth::user()->id)
                                                ->first();
                                        @endphp
                                        <div class="form-group-1 pl-3">
                                            <h4 class="font-semibold text-base" for="">Pendapat dan Usulan {{ $value->nama }}</h4>
                                            <input type="hidden" name="id_aspek[]" value="{{ $value->id }}">
                                            <textarea name="pendapat_per_aspek[]" class="form-textarea @error('pendapat_per_aspek') is-invalid @enderror"
                                                id="pendapat_per_aspek[]" cols="30" rows="4" placeholder="Pendapat Per Aspek">{{ isset($getPendapatPerAspek->pendapat_per_aspek) ? $getPendapatPerAspek->pendapat_per_aspek : '' }}</textarea>
                                            @error('pendapat_per_aspek')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <hr>
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Staf Kredit</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>{{ $pendapatStafPerAspek?->pendapat_per_aspek }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <button type="button"
                                          class="px-5 py-2 border rounded bg-white text-gray-500"
                                        >
                                          Kembali
                                        </button>
                                        <div>
                                          <button type="button"
                                          class="px-5 prev-tab py-2 border rounded bg-theme-secondary text-white"
                                        >
                                          Sebelumnya
                                        </button>
                                        <button type="button"
                                          class="px-5 next-tab py-2 border rounded bg-theme-primary text-white"
                                        >
                                          Selanjutnya
                                        </button>
                                        <button type="submit" class="px-5 py-2 border rounded bg-green-600 text-white btn-simpan hidden" id="submit">Simpan </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
