@if ($item->opsi_jawaban == 'input text')
    <input name="input_text[{{ $item->id }}][{{ $item->skor }}]" type="text"
        class="form-input {{$item->is_rupiah ? 'rupiah' : ''}} @if ($item->readonly) bg-gray-100 @endif" @if($item->nama == 'NPWP' || $item->nama == 'Surat Keterangan Usaha' || $item->nama == 'NIB') hidden" id="{{ str_replace(' ', '-', strtolower($item->nama)) }}" @endif
        placeholder="Masukan informasi disini" @if ($item->readonly) readonly @endif />
    @if ($item->nama == 'NPWP')
        </div>
        <div class="input-box">
            @php
                $itemNPWP = DB::table('item')->where('nama', 'Dokumen NPWP')->first();
            @endphp
            <label for="" class="hidden" id="label-{{ str_replace(' ', '-', strtolower($itemNPWP->nama)) }}">{{$itemNPWP->nama}}</label>
            <div class="flex gap-4">
                <input type="file" name="file[{{ $itemNPWP->id }}]"
                    class="form-input hidden" id="{{ str_replace(' ', '-', strtolower($itemNPWP->nama)) }}"
                    @if ($item->readonly) readonly @endif/>
            </div>
    @endif
@elseif ($item->opsi_jawaban == 'option')
    <select name="input_option[{{ $item->id }}][{{ $item->skor }}]" class="form-select" id=""
        @if ($item->readonly) readonly @endif>
        <option value="">-- Pilih Opsi --</option>
        @foreach ($item->option as $opt)
            <option value="{{ $opt->id }}-{{ $opt->skor }}">{{ $opt->option }}</option>
        @endforeach
    </select>
@elseif ($item->opsi_jawaban == 'number')
    <input name="input_number[{{ $item->id }}][{{ $item->skor }}]" type="number" class="form-input {{$item->is_rupiah ? 'rupiah' : ''}} @if ($item->readonly) bg-gray-100 @endif"
        placeholder="Masukan informasi disini" @if ($item->readonly) readonly @endif />
@elseif ($item->opsi_jawaban == 'persen')
    <div class="input-grouped">
        <input type="number" name="input_number[{{ $item->id }}][{{ $item->skor }}]" class="form-input @if ($item->readonly) bg-gray-100 @endif"
            placeholder="Masukan informasi disini" id="" @if ($item->readonly) readonly @endif />
        <span class="group-text">
            <p>%</p>
        </span>
    </div>
@elseif ($item->opsi_jawaban == 'long text')
    <textarea name="input_text_long[{{ $item->id }}][{{ $item->skor }}]" class="form-textarea @if ($item->readonly) bg-gray-100 @endif"
        placeholder="Masukan informasi disini" id="" @if ($item->readonly) readonly @endif></textarea>
@elseif ($item->opsi_jawaban == 'file')
    <div class="flex gap-4">
        @if ($item->nama == 'Dokumen NPWP' || $item->nama == 'Dokumen Surat Keterangan Usaha' || $item->nama == 'Dokumen NIB')
            <input type="file" name="file[{{ $item->id }}][]" class="form-input hidden" id="{{ str_replace(' ', '-', strtolower($item->nama)) }} @if ($item->readonly) bg-gray-100 @endif"
                @if ($item->readonly) readonly @endif/>
        @else
            <input type="file" name="file[{{ $item->id }}][]" class="form-input {{$item->id}}-{{strtolower(str_replace(' ', '_', $item->nama))}} @if ($item->readonly) bg-gray-100 @endif"
                id="{{$item->id}}-{{strtolower(str_replace(' ', '_', $item->nama))}}"
                @if ($item->readonly) readonly @endif />
        @endif
        @if ($item->is_multiple)
            <div class="flex gap-2 multiple-action">
                <button type="button" class="btn-add" data-item-id="{{$item->id}}-{{strtolower(str_replace(' ', '_', $item->nama))}}">
                    <iconify-icon icon="fluent:add-16-filled" class="mt-2"></iconify-icon>
                </button>
                <button type="button" class="btn-minus hidden" data-item-id="{{$item->id}}-{{strtolower(str_replace(' ', '_', $item->nama))}}">
                    <iconify-icon icon="lucide:minus" class="mt-2"></iconify-icon>
                </button>
            </div>
        @endif
    </div>
@elseif ($item->opsi_jawaban == 'kosong' && count($item->childs) > 0 && $item->level == 3)
    @if ($item->childs[0]->opsi_jawaban == 'option')
        <select name="input_option[{{ $item->id }}][{{ $item->skor }}]" class="form-select" id=""
            @if ($item->readonly) readonly @endif>
            <option value="">-- Pilih Opsi --</option>
            @foreach ($item->childs as $opt)
                <option value="{{ $opt->id }}-{{ $opt->status_skor }}">{{ $opt->nama }}</option>
            @endforeach
        </select>
    @else
        @foreach ($item->childs as $c4)
            @if ($c4->opsi_jawaban == 'input text')
                <div class="input-box">
                    <label for="">{{$c4->nama}}</label>
                    <input name="input_text[{{ $c4->id }}][{{ $c4->skor }}]" type="text"
                        class="form-input {{$c4->is_rupiah ? 'rupiah' : ''}} @if ($c4->readonly) bg-gray-100 @endif" placeholder="Masukan informasi disini"  @if ($c4->readonly) readonly @endif/>
                </div>
            @elseif ($c4->opsi_jawaban == 'number')
                <label for="">{{$c4->nama}}</label>
                <input name="input_number[{{ $c4->id }}][{{ $c4->skor }}]" type="number" class="form-input {{$c4->is_rupiah ? 'rupiah' : ''}} @if ($c4->readonly) bg-gray-100 @endif"
                    placeholder="Masukan informasi disini"  @if ($c4->readonly) readonly @endif/>
            @elseif ($c4->opsi_jawaban == 'persen')
                <div class="input-grouped">
                    <input type="number" name="input_number[{{ $c4->id }}][{{ $c4->skor }}]" class="form-input @if ($c4->readonly) bg-gray-100 @endif"
                        placeholder="Masukan informasi disini" id="" @if ($c4->readonly) readonly @endif/>
                    <span class="group-text">
                        <p>%</p>
                    </span>
                </div>
            @elseif ($c4->opsi_jawaban == 'long text')
                <textarea name="input_text_long[{{ $c4->id }}][{{ $c4->skor }}]" class="form-textarea @if ($c4->readonly) bg-gray-100 @endif"
                    placeholder="Masukan informasi disini" id="" @if ($c4->readonly) readonly @endif></textarea>
            @elseif ($c4->opsi_jawaban == 'file')
                <div class="flex gap-4">
                    @if ($c4->nama == 'Dokumen NPWP' || $c4->nama == 'Dokumen Surat Keterangan Usaha' || $c4->nama == 'Dokumen NIB')
                        <input type="file" name="file[{{ $c4->id }}][]" class="form-input hidden" id="{{ str_replace(' ', '-', strtolower($c4->nama)) }} @if ($c4->readonly) bg-gray-100 @endif"/>
                    @else
                        <input type="file" name="file[{{ $c4->id }}][]" class="form-input {{$c4->id}}-{{strtolower(str_replace(' ', '_', $c4->nama))}} @if ($c4->readonly) bg-gray-100 @endif" id="{{$c4->id}}-{{strtolower(str_replace(' ', '_', $c4->nama))}}" />
                    @endif
                    @if ($c4->is_multiple)
                        <div class="flex gap-2 multiple-action">
                            <button type="button" class="btn-add" data-item-id="{{$c4->id}}-{{strtolower(str_replace(' ', '_', $c4->nama))}}">
                                <iconify-icon icon="fluent:add-16-filled" class="mt-2"></iconify-icon>
                            </button>
                            <button type="button" class="btn-minus hidden" data-item-id="{{$c4->id}}-{{strtolower(str_replace(' ', '_', $c4->nama))}}">
                                <iconify-icon icon="lucide:minus" class="mt-2"></iconify-icon>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    @endif
@else
    <div>
        <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
            <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                {{$item->nama}} :
            </h2>
        </div>
    </div>
@endif
