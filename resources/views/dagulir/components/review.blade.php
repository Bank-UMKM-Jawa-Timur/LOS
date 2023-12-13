@if ($item->opsi_jawaban == 'input text')
    <input name="input_text[{{ $item->id }}][{{ $item->skor }}]" type="text"
        class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini"
        readonly
        value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
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
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="text" value="{{ $item->id }}" name="option[]">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'number')
    <input name="input_number[{{ $item->id }}][{{ $item->skor }}]" type="number" class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini" value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="text" value="{{ $item->id }}" name="option[]">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'persen')
    <div class="input-grouped">
        <input type="number" name="input_number[{{ $item->id }}][{{ $item->skor }}]" class="form-input"
            placeholder="Masukan informasi disini" id="" value="{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}" />
        <span class="group-text">
            <p>%</p>
        </span>
    </div>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="text" value="{{ $item->id }}" name="option[]">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'long text')
    <textarea name="input_text_long[{{ $item->id }}][{{ $item->skor }}]" class="form-textarea"
        placeholder="Masukan informasi disini" id="">{{ $item->jawaban ? $item->jawaban->opsi_text : '' }}</textarea>
    @if ($item->is_commentable == 'Ya')
        <div class="flex">
            <input type="text" value="{{ $item->id }}" name="option[]">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
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
            <input type="text" value="{{ $item->id }}" name="option[]">
            <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
            <input
                type="number"
                name="skor_penyelia[]"
                class="form-input"
                id=""
                placeholder="Masukkan Skor"
                min="0"
                max="4"
                onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
            >
        </div>
    @endif
@elseif ($item->opsi_jawaban == 'kosong' && count($item->childs) > 0 && $item->level == 3)
<select name="input_option[{{ $item->id }}][{{ $item->skor }}]" class="form-select" id="">
    <option value="">-- Pilih Opsi --</option>
    @foreach ($item->childs as $opt)
        <option value="{{ $opt->id }}-{{ $opt->status_skor }}" @if($opt->jawaban) @if($opt->jawaban->id_jawaban == $opt->id) selected @endif @endif>{{ $opt->nama }}</option>
    @endforeach
</select>
@if ($item->is_commentable == 'Ya')
    <div class="flex">
        <input type="text" value="{{ $item->id }}" name="option[]">
        <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
        <input
            type="number"
            name="skor_penyelia[]"
            class="form-input"
            id=""
            placeholder="Masukkan Skor"
            min="0"
            max="4"
            onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
        >
    </div>
@endif
@if ($item->is_commentable == 'Ya')
    <div class="flex">
        <input type="text" value="{{ $item->id }}" name="option[]">
        <input type="text" name="komentar_penyelia[]" class="form-input" placeholder="Masukkan Komentar">
        <input
            type="number"
            name="skor_penyelia[]"
            class="form-input"
            id=""
            placeholder="Masukkan Skor"
            min="0"
            max="4"
            onKeyUp="if(this.value>4){this.value='4';}else if(this.value<=0){this.value='1';}"
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
