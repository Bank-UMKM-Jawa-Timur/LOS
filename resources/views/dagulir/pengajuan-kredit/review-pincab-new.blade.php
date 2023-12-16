@extends('layouts.tailwind-template')
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="container mx-auto mb-5">
            <div class="head space-y-5 w-full font-poppins">
                <div class="heading flex-auto">
                    <p class="text-theme-primary font-semibold font-poppins text-xs">
                        Dagulir
                    </p>
                    <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                        Review
                    </h2>
                </div>
            </div>
        </div>
        <div class="body-pages">
            <div class="container mx-auto p-3 bg-white">
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                    <div class="flex justify-between gap-3">
                    <div class="flex justify-start gap-3">
                        <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                            <h2 class="text-lg">1</h2>
                        </button>
                        <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                    </div>
                        <div class="transform accordion-icon mr-2 mt-1">
                            <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                        </div>
                    </div>
                </div>
                <div class="accordion-content p-3">
                    @include('dagulir.pengajuan-kredit.review.data-umum')
                </div>
            </div>
            @php
                $no_aspek = 1;
            @endphp
            @foreach ($dataAspek as $itemAspek)
                @php
                    $no_aspek++;
                    // check level 2
                    $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemAspek->id)
                        ->get();
                    // check level 4
                    $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 4)
                        ->where('id_parent', $itemAspek->id)
                        ->get();
                @endphp
                <div class="accordion-section">
                    <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                        <div class="flex justify-between gap-3">
                        <div class="flex justify-start gap-3">
                            <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                                <h2 class="text-lg">{{$no_aspek}}</h2>
                            </button>
                            <h3 class="font-bold text-lg tracking-tighter mt-[6px]">{{ $itemAspek->nama }}</h3>
                        </div>
                            <div class="transform accordion-icon mr-2 mt-1">
                                <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-content p-3">
                        <div class="p-5 space-y-5">
                            @foreach ($dataLevelDua as $item)
                                @if ($item->opsi_jawaban != 'option')
                                    @php
                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.status_skor', 'item.is_commentable')
                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                            ->where('jawaban_text.id_jawaban', $item->id)
                                            ->get();
                                    @endphp
                                    @foreach ($dataDetailJawabanText as $itemTextDua)
                                        @php
                                            $getKomentar = \App\Models\DetailKomentarModel::select('detail_komentar.id', 'detail_komentar.id_komentar', 'detail_komentar.id_user', 'detail_komentar.id_item', 'detail_komentar.komentar')
                                                ->where('detail_komentar.id_item', $itemTextDua->id_item)
                                                ->get();
                                        @endphp

                                        @if ($itemTextDua->opsi_text != "tidak_ada_legalitas_usaha")
                                            <div class="form-group">
                                                <div class="field-review">
                                                    <div class="field-name">
                                                        <label for="">{{ $item->nama }}</label>
                                                    </div>
                                                    <div class="field-answer">
                                                        @if ($item->opsi_jawaban == 'file')
                                                            @php
                                                                $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                            @endphp
                                                            @if ($file_parts['extension'] == 'pdf')
                                                                <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="700px"></iframe>
                                                            @else
                                                                <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="700px">
                                                            @endif
                                                            @elseif ($item->opsi_jawaban == 'number' && $item->id != 143)
                                                            <p class="">
                                                                Rp. {{ number_format((int) $itemTextDua->opsi_text, 2, ',', '.') }}
                                                            </p>
                                                        @else
                                                            @if (is_numeric($itemJawaban->option) && strlen($itemJawaban->option) > 3)
                                                                <p class="">{{ $itemTextDua->opsi_text }}</p>
                                                            @else
                                                                <p class="">{{ $itemTextDua->opsi_text }} {{$itemTextDua->opsi_jawaban == 'persen' ? '%' : ''}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($itemTextDua->status_skor == 1)
                                            <div class="form-group">
                                                <div class="field-review">
                                                    <div class="field-name">
                                                        <label for="">{{ $item->nama }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-3">
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col">
                                                        <div class="form-group row">
                                                            <label for="slik" class="col-sm-4 col-form-label">Skor</label>
                                                            <label for="slik" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">
                                                                        :
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <p class="badge badge-info text-lg"><b>
                                                                {{ $itemTextDua->skor_penyelia }}</b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($itemTextDua->is_commentable != null)
                                                    @foreach ($getKomentar as $itemKomentar)
                                                        <div class="row form-group sub pl-4">
                                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                                <div class="d-flex justify-content-end">
                                                                    <div style="width: 20px">

                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <div class="col">
                                                                <div class="d-flex">
                                                                    <div style="width: 15%">
                                                                        <p class="p-0 m-0"><strong>Komentar : </strong>
                                                                        </p>
                                                                    </div>
                                                                    <h6 class="font-italic">{{ $itemKomentar->komentar ?? '' }}
                                                                    </h6>
                                                                    {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        @if ($item->nama == 'Repayment Capacity')
                                        @else
                                            @if ($itemTextDua->opsi_text != "tidak_ada_legalitas_usaha")
                                                <hr>
                                            @endif
                                        @endif
                                    @endforeach
                                    @if ($item->nama == 'Ijin Usaha' && $countIjin == 0)
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">Ijin Usaha</label>
                                                </div>
                                                <div class="field-answer">
                                                    <p>Tidak ada legalitas usaha</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @php
                                    $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                        ->where('id_item', $item->id)
                                        ->get();
                                    $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                        ->where('id_item', $item->id)
                                        ->get();

                                    // check level 3
                                    $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'is_hide')
                                        ->where('level', 3)
                                        ->where('id_parent', $item->id)
                                        ->get();
                                @endphp
                                @if ($item->id_parent == 10 && $item->nama != 'Hubungan Dengan Supplier')
                                    <div class="row form-group sub pl-4">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    </div>
                                    <hr>
                                @endif
                                @if (count($dataJawaban) != 0)
                                    @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi' || $item->nama == 'Repayment Capacity Opsi')

                                    @else
                                        <div class="form-group-2">
                                            <div class="field-review">
                                                <div class="field-name">
                                                    <label for="">{{ $item->nama }}</label>
                                                </div>
                                                <div class="field-answer">
                                                    @foreach ($dataJawaban as $key => $itemJawaban)
                                                        @php
                                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->get();
                                                            $count = count($dataDetailJawaban);
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                            }
                                                        @endphp
                                                        @if (in_array($itemJawaban->id, $data))
                                                            @if (isset($data))
                                                                @if (is_numeric($itemJawaban->option) && strlen($itemJawaban->option) > 3)
                                                                    <p>{{ $itemJawaban->option }}</p>
                                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                @else
                                                                    <p>{{ $itemJawaban->option }}</p>
                                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi')

                                    @else
                                        {{--  skor  --}}
                                    @endif
                                @endif
                                @php
                                    $no = 0;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                    <div class="flex justify-between gap-3">
                    <div class="flex justify-start gap-3">
                        <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                            <h2 class="text-lg">{{$no_aspek+1}}</h2>
                        </button>
                        <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Pendapat dan Usulan</h3>
                    </div>
                        <div class="transform accordion-icon mr-2 mt-1">
                            <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                        </div>
                    </div>
                </div>
                <div class="accordion-content hidden p-3">
                    <div class="divide-y-2 divide-red-800">
                        <div class="p-4">
                            <div class="form-group-2">
                                <div class="field-review">
                                    <div class="field-name">
                                        <label for="">Pendapat & Usulan
                                            (Staff)</label>
                                    </div>
                                    <div class="field-answer">
                                        <p>OKE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="p-4">
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Pendapat & Usulan
                                        (Penyelia)</label>
                                </div>
                                <div class="field-answer">
                                    <p>OKE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Pendapat & Usulan
                                        (Penyelia)</label>
                                </div>
                                <div class="field-answer">
                                    <p>0864929</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Pendapat & Usulan Pimpinan Cabang</label>
                                </div>
                                <div class="field-answer">
                                    <textarea class="form-textarea w-full" placeholder="isi pendapat..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Pendapat & Usulan Pimpinan Cabang</label>
                                </div>
                                <div class="field-answer">
                                    <input type="text" class="form-input" placeholder="isi pendapat dan usulan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button id="btn-dec"
                    class="px-5 next-tab py-2 border rounded bg-theme-primary text-white">Tolak</button>
                <button id="btn-acc"
                    class="px-5 py-2 border rounded bg-green-600 text-white btn-simpan">Setujui</button>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
        $(".accordion-header").click(function() {
            // Toggle the visibility of the next element with class 'accordion-content'
            $(this).next(".accordion-content").slideToggle();
            // $(this).find(".accordion-icon").toggleClass("rotate-180");
        });
    </script>
@endpush
