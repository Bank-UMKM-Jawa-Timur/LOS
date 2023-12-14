@if ($item->opsi_jawaban == 'input text')
    <input name="input_text[{{ $item->id }}][{{ $item->skor }}]" type="hidden"
        class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini"
        readonly
        value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
        <div class="p-2 bg-white border-b">
            <span>{{ $item->jawaban ? $item->jawaban : '-' }}</span>
        </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex gap-4">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'option')
    <select name="input_option[{{ $item->id }}][{{ $item->skor }}]" class="form-select" id="" disabled>
        <option value="">-- Pilih Opsi --</option>
        @foreach ($item->option as $opt)
            <option value="{{ $opt->id }}-{{ $opt->skor }}" @if($opt->jawaban) @if($opt->jawaban->id_jawaban == $opt->id) selected @endif @endif>{{ $opt->option }}</option>
        @endforeach
    </select>
    @foreach ($item->option as $opt)
        <div class="p-2 bg-white border-b">
            <span>
                @if($opt->jawaban) @if($opt->jawaban->id_jawaban == $opt->id) {{$opt->option}} @endif @endif
            </span>
        </div>
    @endforeach
    @if ($item->is_commentable == 'Ya')
        <div class="flex gap-4">
            <input type="hidden" value="{{ $item->id }}" name="option[]">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'number')
    <input readonly name="input_number[{{ $item->id }}][{{ $item->skor }}]" type="hidden" class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini" value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
    <div class="p-2 bg-white border-b">
        <span>{{ $item->jawaban ? $item->jawaban->opsi_text : '-' }}</span>
    </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="hidden" value="{{ $item->id }}" name="option[]">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'persen')
    <div class="input-grouped">
        <input readonly type="hidden" name="input_number[{{ $item->id }}][{{ $item->skor }}]" class="form-input"
            placeholder="Masukan informasi disini" id="" value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
        <div class="p-2 bg-white border-b">
            <span>{{ $item->jawaban ? $item->jawaban->opsi_text.'%' : '-' }}</span>
        </div>
    </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="hidden" value="{{ $item->id }}" name="option[]">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'long text')
    <textarea readonly name="input_text_long[{{ $item->id }}][{{ $item->skor }}]" class="form-textarea"
        placeholder="Masukan informasi disini" id="">{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}</textarea>
    <div class="p-2 bg-white border-b">
        <span>{{ $item->jawaban ? $item->jawaban->opsi_text : '-' }}</span>
    </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="hidden" value="{{ $item->id }}" name="option[]">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'file')
    @php
        if ($item->jawaban) {
            $file_parts = pathinfo(asset('..') . '/upload/' . $id_pengajuan . '/' . $item->id . '/' . $item->jawaban->opsi_text);
        }
    @endphp
    <div class="flex gap-4">
        @if ($item->jawaban)
            @if ($file_parts['extension'] == 'pdf')
                <iframe
                src="{{ asset('..') . '/upload/' . $id_pengajuan . '/' . $item->id . '/' . $item->jawaban->opsi_text }}"
                width="100%" height="800px"></iframe>
            @else
                <img src="{{ asset('..') . '/upload/' . $id_pengajuan . '/' . $item->id . '/' . $item->jawaban->opsi_text }}"
                alt="" width="800px">
            @endif
        @endif
        @if ($item->is_multiple)
            <div class="flex gap-2">
                <button class="btn-add">
                    <iconify-icon icon="fluent:add-16-filled" class="mt-2"></iconify-icon>
                </button>
                <button class="btn-minus">
                    <iconify-icon icon="lucide:minus" class="mt-2"></iconify-icon>
                </button>
            </div>
        @endif
    </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="hidden" value="{{ $item->id }}" name="option[]">
            <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            {{--  @php
                $role = auth()->user()->role;
                $skor = null;
                if ($role == 'Penyelia Kredit') {
                    $skor = $item->jawaban->skor;
                }
                if ($role == 'PBO') {
                    $skor = $item->jawaban->skor_penyelia;
                }
                if ($role == 'PBP') {
                    $skor = $item->jawaban->skor_pbo;
                }
                if ($role == 'Pincab') {
                    $skor = $item->jawaban->skor_pbp;
                }
            @endphp  --}}
            <input
                type="hidden"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
                {{--  value="{{$skor}}"  --}}
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'kosong' && count($item->childs) > 0 && $item->level == 3)
    @foreach ($item->childs as $opt)
        <div class="p-2 bg-white border-b">
            <span>@if($opt->jawaban) @if($opt->jawaban->id_jawaban == $opt->id) {{$opt->nama}} @endif @endif</span>
        </div>
    @endforeach
@if ($item->is_commentable == 'Ya')
    <div class="flex">
        <input type="hidden" value="{{ $item->id }}" name="option[]">
        <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
        @php
            $role = auth()->user()->role;
            $skor = null;
            if ($role == 'Penyelia Kredit') {
                $skor = $item->jawaban->skor;
            }
            if ($role == 'PBO') {
                $skor = $item->jawaban->skor_penyelia;
            }
            if ($role == 'PBP') {
                $skor = $item->jawaban->skor_pbo;
            }
            if ($role == 'Pincab') {
                $skor = $item->jawaban->skor_pbp;
            }
        @endphp
        <input
            type="hidden"
            name="skor_penyelia[]"
            class="form-input"
            id=""
            placeholder="Masukkan Skor"
            min="0"
            max="4"
            onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            {{--  value="{{$skor}}"  --}}
        >
    </div>
@endif
@if ($item->is_commentable == 'Ya')
    <div class="flex">
        <input type="hidden" value="{{ $item->id }}" name="option[]">
        <input type="hidden" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
        @php
            $role = auth()->user()->role;
            $skor = null;
            if ($role == 'Penyelia Kredit') {
                $skor = $item->jawaban->skor;
            }
            if ($role == 'PBO') {
                $skor = $item->jawaban->skor_penyelia;
            }
            if ($role == 'PBP') {
                $skor = $item->jawaban->skor_pbo;
            }
            if ($role == 'Pincab') {
                $skor = $item->jawaban->skor_pbp;
            }
        @endphp
        <input
            type="hidden"
            name="skor_penyelia[]"
            class="form-input"
            id=""
            placeholder="Masukkan Skor"
            min="0"
            max="4"
            onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            {{--  value="{{$skor}}"  --}}
        >
    </div>
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
