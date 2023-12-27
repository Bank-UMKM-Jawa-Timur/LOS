<div class="space-y-5 row-detail" data-no="{{ $no }}">
    <input type="hidden" name='id_detail[]' class='idDetail' value='{{ $idDetail }}'>
    <div class="form-group-4">
        <div class="input-box">
            <label for="">Opsi</label>
            <input type="text" id="option"
                value="{{ old($fields['option'], isset($edit) ? $edit['option'] : '') }}" name="option[]"
                class="form-input {{ isset($n) && $errors->has('option.' . $n) ? ' is-invalid' : '' }}"
                placeholder="Nama Opsi">
            @if (isset($n) && $errors->has('option.' . $n))
                <div class="invalid-feedback">
                    {{ $errors->first('option.' . $n) }}
                </div>
            @enderror
        </div>
        <div class="input-box">
            <label for="">Skor</label>
            <input type="number" id="skor" value="{{ old($fields['skor'], isset($edit) ? $edit['skor'] : '') }}"
            name="skor[]" class="form-input {{ isset($n) && $errors->has('skor.' . $n) ? ' is-invalid' : '' }}">
            @if (isset($n) && $errors->has('skor.' . $n))
                <div class="invalid-feedback">
                    {{ $errors->first('skor.' . $n) }}
                </div>
            @enderror
        </div>
        <div>
            <a class="btn-add mt-10 addDetail" data-no='{{ $no }}' href="">
                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
            </a>
            @if ($hapus)
                <a class="btn-minus mt-10 deleteDetail addDeleteId" data-no='{{ $no }}' href="">
                    <iconify-icon icon="tabler:minus" class="mt-3"></iconify-icon>
                </a>
            @else
        </div>
    </div>
</div>
