@if ($item->opsi_jawaban == 'input text')
    <input name="input[{{ $item->id }}][{{ $item->skor }}]" type="text"
        class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini" />
@elseif ($item->opsi_jawaban == 'option')
    <select name="input[{{ $item->id }}][{{ $item->skor }}]" class="form-select" id="">
        <option value="">-- Pilih Opsi --</option>
        @foreach ($item->option as $opt)
            <option value="input[{{ $opt->id }}][{{ $opt->skor }}]">{{ $opt->option }}</option>
        @endforeach
    </select>
@elseif ($item->opsi_jawaban == 'number')
    <input name="input[{{ $item->id }}][{{ $item->skor }}]" type="number" class="form-input {{$item->is_rupiah ? 'rupiah' : ''}}"
        placeholder="Masukan informasi disini" />
@elseif ($item->opsi_jawaban == 'persen')
    <div class="input-grouped">
        <input type="number" name="input[{{ $item->id }}][{{ $item->skor }}]" class="form-input"
            placeholder="Masukan informasi disini" id="" />
        <span class="group-text">
            <p>%</p>
        </span>
    </div>
@elseif ($item->opsi_jawaban == 'long text')
    <textarea name="input[{{ $item->id }}][{{ $item->skor }}]" class="form-textarea"
        placeholder="Masukan informasi disini" id=""></textarea>
@elseif ($item->opsi_jawaban == 'file')
    <div class="flex gap-4">
        <input type="file" class="form-input" />
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
@else
    <div>
        <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
            <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                {{$item->nama}} :
            </h2>
        </div>
    </div>
@endif
