<form action="{{ route('master-item.update',$item->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="idDelete">
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Level</label>
            <select name="level" id="level" class="form-control"  disabled>
                <option value="0"> --- Pilih Level --- </option>
                <option aria-readonly="true" value="1" {{ $item->level == 1 ? "selected" : ""}}>1</option>
                <option value="2" {{ $item->level == 2 ? "selected" : ""}}>2</option>
                <option value="3" {{ $item->level == 3 ? "selected" : ""}}>3</option>
                <option value="4" {{ $item->level == 4 ? "selected" : ""}}>4</option>
            </select>
        </div>
        @if ($item->level != 1)
            <div class="form-group col-md-6">
                <label>Item Turunan</label>
                <input type="text" name="id_turunan" value="{{ $itemTurunan->id }}" hidden>
                <input type="text" name="id_item" value="{{ $item->id }}" hidden>
                <input type="text" name="item_turunan" class="form-control @error('item_turunan') is-invalid @enderror" value="{{old('item_turunan', $itemTurunan->nama )}}" readonly>
                @error('item_turunan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama',$item->nama)}}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <input type="hidden" name="opsi_jawaban" value="{{$item->opsi_jawaban}}">
        <div class="form-group col-md-6" id="form_opsi">
            <label>Opsi Jawaban</label>
            <select id="opsi_jawaban" class="form-control @error('opsi_jawaban') is-invalid @enderror">
                <option value="kosong" {{ $item->opsi_jawaban == 'kosong' ? 'selected' : ''  }}>Pilih Opsi Jawaban</option>
                <option value="input text" {{ $item->opsi_jawaban == 'input text' ? 'selected' : ''  }}>Input Text</option>
                <option value="option" {{ $item->opsi_jawaban == 'option' ? 'selected' : ''  }}>Opsi</option>
            </select>
            {{-- <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}"> --}}
            @error('opsi_jawaban')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

        @if (!$isParent)
            <div class="form-group col-md-6" id="dapat_dikomentari">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="is_commentable" name="is_commentable" {{$item->is_commentable == 'Ya' ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_commentable">
                        Dapat Dikomentari
                    </label>
                </div>
                {{-- <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Item" value="{{old('nama')}}"> --}}
                @error('is_commentable')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>
        @endif

    </div>
    <hr>
    <div class="detail-lawan">
        <div class="" id="urlAddDetail" data-url="{{ url('master-item/addEditItem') }}">
            <p><strong>Opsi atau Jawaban</strong></p>
        @if (!is_null(old('id')))
            @php
                $loop = array();
                foreach(old('id') as $i => $val){
                    $loop[] = array(
                    'option' => old('option.'.$i),
                    'skor' => old('skor.'.$i),
                    'sub_column' => old('sub_column.'.$i),
                    );
                }
            @endphp

        @else
            @php
                $loop = $opsi;
            @endphp
        @endif
        @php $no = 0; $total = 0; @endphp

        @foreach ($loop as $n => $edit)
            @php
                $no++;
                $linkHapus = $no==1 ? false : true;
                $fields = array(
                    'option' => 'option.'.$n,
                    'skor' => 'skor.'.$n,
                    'sub_column' => 'sub_column.'.$n,
                );

                if(!is_null(old('id_item'))){
                    $idDetail = old('id_detail.'.$n);
                }
                else{
                    $idDetail = $edit['id'];
                }
            @endphp
            @include('master-item.editDetail',['hapus' => $linkHapus, 'no' => $no])
                    {{-- @include('pages.transaksi-bank.form-detail-transaksi-bank'); --}}
        @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
@push('custom-script')
    <script src="{{ asset('js/custom2.js') }}"></script>
@endpush
