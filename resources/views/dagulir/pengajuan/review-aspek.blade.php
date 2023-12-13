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
      {{--  Level 2  --}}
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
          {{--  Level 3  --}}
          @if ($item->childs)
            <div class="form-group-2">
              @foreach ($item->childs as $child)
                <div class="input-box">
                  <label for="">{{$child->nama}}</label>
                  @include('dagulir.components.review', [
                    'item' => $child,
                    'id_pengajuan' => $pendapat_staf->id_pengajuan
                ])
                </div>
              @endforeach
            </div>
          @endif
        @else
          @if (isset($childs[$key+1]) && !$open_tab)
            <div class="form-group-2">
          @endif
          <div class="input-box">
            <label for="">{{$item->nama}}</label>
            @include('dagulir.components.review', [
                'item' => $item,
                'id_pengajuan' => $pendapat_staf->id_pengajuan
            ])
          </div>
          @if (isset($childs[$key+1]))
            @if ($childs[$key+1]->opsi_jawaban == 'kosong')
              </div>
            @endif
          @endif
          @if (($key + 1) == count($childs) && $open_tab)
            </div>
          @endif
          @php
            if (isset($childs[$key+1])) {
              $open_tab = true;
              $prev_key = $key;
            }
            if (isset($childs[$key+1])) {
              if (($childs[$key+1]->opsi_jawaban == 'kosong')) {
                $open_tab = false;
              }
            }
          @endphp
        @endif
      @endforeach
      <hr>

      <div class="form-group-1">
        <div class="input-box">
          <label for=""
            >Pendapat dan usulan {{$title}}</label
          >
          <input type="text" name="id_aspek[]" value="{{ $id }}" hidden>
          <textarea
            name="pendapat_usulan[]"
            class="form-textarea"
            placeholder="Pendapat per aspek"
            id=""
          ></textarea>
        </div>
      </div>
      <div class="form-group-1">
        <div class="input-box">
          <label for=""
            >Pendapat dan Usulan Staf Kredit</label
          >
          <input type="text" name="id_aspek[]" value="{{ $id }}" hidden>
          <textarea
            readonly
            name="pendapat_usulan[]"
            class="form-textarea"
            placeholder="Pendapat per aspek"
            id=""
          >{{ $pendapat_staf->pendapat_per_aspek }}</textarea>
        </div>
      </div>
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
