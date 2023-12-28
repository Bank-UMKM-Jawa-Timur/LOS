@include('dagulir.master.kabupaten.modal.create')
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
        $('#page_length').on('change', function() {
            $('#form').submit()
        })
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Item
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Edit item
                </h2>
            </div>
        </div>
        <div class="body-pages">
            <form action="{{ route('dagulir.master.master-item.update',$item->id) }}" method="POST">
            @method('PUT')
            @csrf
                <div class="p-5 bg-white w-full mt-8 border space-y-8">
                    <div class="form-group-2">
                        <div class="input-box">
                            <label for="level">Level</label>
                            <select name="level" class="form-select" id="level" disabled>
                                <option value="0"> --- Pilih Level --- </option>
                                <option aria-readonly="true" value="1" {{ $item->level == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $item->level == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $item->level == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $item->level == 4 ? 'selected' : '' }}>4</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="item_turunan">Item Turunan</label>
                            <input type="text" name="id_turunan" value="{{ $itemTurunan->id }}" hidden>
                            <input type="text" name="id_item" value="{{ $item->id }}" hidden>
                            <input type="text" name="item_turunan"
                                class="form-input @error('item_turunan') is-invalid @enderror"
                                value="{{ old('item_turunan', $itemTurunan->nama) }}" readonly>
                            @error('item_turunan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group-2">
                        <div class="input-box">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-input @error('nama') is-invalid @enderror"
                                placeholder="Nama Item" value="{{ old('nama', $item->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (!$isParent)
                                <div class="flex gap-2">
                                    <input class="form-check" type="checkbox" value="1" id="is_commentable"
                                        name="is_commentable" {{ $item->is_commentable == 'Ya' ? 'checked' : '' }}>
                                    <label for="is-comment">Dapat Dikomentari</label>
                                    @error('is_commentable')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <div class="input-box">
                            <label for="">Opsi Jawaban</label>
                            <select id="opsi_jawaban" class="form-input @error('opsi_jawaban') is-invalid @enderror" disabled>
                                <option value="kosong" {{ $item->opsi_jawaban == 'kosong' ? 'selected' : '' }}>Pilih Opsi
                                    Jawaban</option>
                                <option value="input text" {{ $item->opsi_jawaban == 'input text' ? 'selected' : '' }}>Input
                                    Text</option>
                                <option value="option" {{ $item->opsi_jawaban == 'option' ? 'selected' : '' }}>Opsi</option>
                            </select>
                            @error('opsi_jawaban')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                            {{-- <div class="flex gap-2">
                                <input type="checkbox" name="" class="form-check" id="is-skored" />
                                <label for="is-skored">Perhitungan Skor</label>
                            </div> --}}
                        </div>
                    </div>
                    <hr>
                    <div class="detail-lawan">
                        <div class="" id="urlAddDetail" data-url="{{ url('master-item/addEditItem') }}">
                            @if (!is_null(old('id')))
                                @php
                                    $loop = [];
                                    foreach (old('id') as $i => $val) {
                                        $loop[] = [
                                            'option' => old('option.' . $i),
                                            'skor' => old('skor.' . $i),
                                            'sub_column' => old('sub_column.' . $i),
                                        ];
                                    }
                                @endphp
                            @else
                                @php
                                    $loop = $opsi;
                                @endphp
                            @endif
                            @php
                                $no = 0;
                                $total = 0;
                            @endphp

                            @foreach ($loop as $n => $edit)
                                @php
                                    $no++;
                                    $linkHapus = $no == 1 ? false : true;
                                    $fields = [
                                        'option' => 'option.' . $n,
                                        'skor' => 'skor.' . $n,
                                        'sub_column' => 'sub_column.' . $n,
                                    ];

                                    if (!is_null(old('id_item'))) {
                                        $idDetail = old('id_detail.' . $n);
                                    } else {
                                        $idDetail = $edit['id'];
                                    }
                                @endphp

                                <div class="space-y-5 row-detail" data-no="{{ $no }}">
                                    <input type="hidden" name='id_detail[]' class='idDetail' value='{{ $idDetail }}'>
                                    <div class="form-group-4">
                                        <div class="input-box">
                                            <label for="">Opsi</label>
                                            <input type="text" id="option"
                                                value="{{ old($fields['option'], isset($edit) ? $edit['option'] : '') }}"
                                                name="option[]"
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
                                            <input type="number" id="skor"
                                                value="{{ old($fields['skor'], isset($edit) ? $edit['skor'] : '') }}"
                                                name="skor[]"
                                                class="form-input {{ isset($n) && $errors->has('skor.' . $n) ? ' is-invalid' : '' }}">
                                            @if (isset($n) && $errors->has('skor.' . $n))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('skor.' . $n) }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div>
                                            <button class="btn-add mt-10 addDetail" data-no='{{ $no }}'>
                                                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                                            </button>
                                            @if ($linkHapus)
                                                <button class="btn-minus mt-10 deleteDetail"
                                                    data-no='{{ $no }}'>
                                                    <iconify-icon icon="tabler:minus" class="mt-3"></iconify-icon>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="flex gap-5">
                            <a href="{{ route('dagulir.master.master-item.index') }}"
                                class="px-5 py-2 bg-white border rounded">
                                Batal
                            </a>
                            <button type="submits" class="bg-theme-primary px-5 py-2 text-white rounded">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
