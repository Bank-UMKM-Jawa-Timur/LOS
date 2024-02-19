<div class="pb-10 space-y-3">
  <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">{{$title}}</h2>
</div>
<div class="self-start bg-white w-full border">
  <div
    class="p-5 w-full space-y-5"
    id="{{$id_tab}}"
  >
  @php
    $prev_key = 0;
    $open_tab = false;
  @endphp
    @foreach ($childs as $key => $item)
      @if ($item->opsi_jawaban == 'kosong')
        <div>
          <div
            class="p-2 border-l-4 border-theme-primary bg-gray-100"
          >
            <h2
              class="font-semibold text-sm tracking-tighter text-theme-text"
            >
              {{$item->nama}} :
            </h2>
          </div>
        </div>
        @if ($item->childs)
          <div class="form-group-2">
            @foreach ($item->childs as $child)
              <div class="input-box">
                <label for="">{{$child->nama}}</label>
                @if ($child->opsi_jawaban == 'input text')
                
                @elseif ($child->opsi_jawaban == 'option')
                  <select
                    name="input[{{$child->id}}][{{$child->skor}}]"
                    class="form-select"
                    id=""
                  >
                    <option value="">-- Pilih Opsi --</option>
                    @foreach ($child->option as $opt)
                      <option value="">-- Pilih Opsi --</option>
                    @endforeach
                  </select>
                @elseif ($child->opsi_jawaban == 'number')
                  <input
                    name="input[$child->id][$child->status_skor]"
                    type="number"
                    class="form-input"
                    placeholder="Masukan informasi Modal (Awal)"
                  />
                @elseif ($child->opsi_jawaban == 'persen')
                @elseif ($child->opsi_jawaban == 'long text')
                @elseif ($child->opsi_jawaban == 'file')
                    
                @endif
              </div>
            @endforeach
          </div>
        @endif
      @else
        @if (isset($childs[$key+1]) && !$open_tab)
          // buka
          <div class="form-group-2">
        @endif
        <div class="input-box">
          <label for="">{{$item->nama}}</label>
          @if ($item->opsi_jawaban == 'input text')
            <input
              name="input[{{$item->id}}][{{$item->skor}}]"
              type="text"
              class="form-input"
              placeholder="Masukan informasi jumlah orang"
            />
          @elseif ($item->opsi_jawaban == 'option')
            <select
              name="input[{{$item->id}}][{{$item->skor}}]"
              class="form-select"
              id=""
            >
              <option value="">-- Pilih Opsi --</option>
              @foreach ($item->option as $opt)
                <option value="input[{{$opt->id}}][{{$opt->skor}}]">{{$opt->option}}</option>
              @endforeach
            </select>
          @elseif ($item->opsi_jawaban == 'number')
          @elseif ($item->opsi_jawaban == 'persen')
          @elseif ($item->opsi_jawaban == 'long text')
          @elseif ($item->opsi_jawaban == 'file')
              
          @endif
        </div>
        @if (isset($childs[$key+1]))
          @if ($childs[$key+1]->opsi_jawaban == 'kosong')
            // tutup1
            </div>
          @endif
        @endif
        @if (($key + 1) == count($childs) && $open_tab)
            // tutup2
          </div>
        @endif
        @php
          if (isset($childs[$key+1])) {
            $open_tab = true;
            $prev_key = $key;
          }
        @endphp
      @endif
    @endforeach
    <div class="form-group-1">
      <div class="input-box">
        <label for=""
          >Pendapat dan usulan {{$title}}</label
        >
        <textarea
          name=""
          class="form-textarea"
          placeholder="Pendapat per aspek"
          id=""
        ></textarea>
      </div>
    </div>
    <div class="flex justify-between">
      <button
        class="px-5 py-2 border rounded bg-white text-gray-500"
      >
        Kembali
      </button>
      <div>
        <button
        class="px-5 prev-tab py-2 border rounded bg-theme-secondary text-white"
      >
        Sebelumnya
      </button>
      <button
        class="px-5 next-tab py-2 border rounded bg-theme-primary text-white"
      >
        Selanjutnya
      </button>
      </div>
    </div>
  </div>
</div>