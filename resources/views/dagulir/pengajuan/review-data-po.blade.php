
@php
    $keterangan = $dataPO->keterangan;
    $pemesanan = str_replace('Pemesanan ', '', $keterangan);
@endphp
<div id="data-po-tab" class="is-tab-content">
    <div class="pb-10 space-y-3">
        <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Data PO</h2>
        <p class="font-semibold text-gray-400">Edit Pengajuan</p>
    </div>
    <div class="self-start bg-white w-full border">
        {{-- <div class="p-5 border-b">
            <h2 class="font-bold text-lg tracking-tighter">
                Data PO
            </h2>
        </div> --}}

        <div class="p-5 w-full space-y-5"
            id="data-po"
        >
            <input type="hidden" name="id_data_po_temp" id="id_data_po_temp">
            <div class="form-group-1 col-span-2">
                <div>
                    <div class="p-2 border-l-8 border-theme-primary bg-gray-100">
                        <h2 class="font-semibold text-lg tracking-tighter text-theme-text">
                            Jenis Kendaraan Roda 2 :
                        </h2>
                    </div>
                </div>
            </div>
            <div class="form-group-2">
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Merk Kendaraan</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO?->merk ?? '' }}</p>
                    </div>
                </div>
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Tipe Kendaraan</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO?->tipe ?? '' }}</p>
                    </div>
                </div>
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Tahun</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO?->tahun_kendaraan ?? '' }}</p>
                    </div>
                </div>
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Warna</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO?->warna ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="form-group-1 col-span-2">
                <div>
                    <div class="p-2 border-l-8 border-theme-primary bg-gray-100">
                        <h2 class="font-semibold text-lg tracking-tighter text-theme-text">
                            Keterangan :
                        </h2>
                    </div>
                </div>
            </div>
            <div class="form-group-2">
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Pemesanan</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $pemesanan ?? '' }}</p>
                    </div>
                </div>
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Sejumlah</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO?->jumlah ?? '' }}</p>
                    </div>
                </div>
                <div class="field-review">
                    <div class="field-name">
                        <label for="">Harga</label>
                    </div>
                    <div class="field-answer">
                        <p>{{ $dataPO->harga ? 'Rp '. number_format($dataPO->harga, 2, ',', '.') :'' }}</p>
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <a href="{{route('dagulir.pengajuan.index')}}">
                    <button type="button"
                        class="px-5 py-2 border rounded bg-white text-gray-500">
                        Kembali
                    </button>
                </a>
                <div class="">
                    <button type="button"
                        class="px-5 prev-tab py-2 border rounded bg-theme-secondary text-white"
                    >
                        Sebelumnya
                    </button>
                    <button type="button"
                    class="px-5 py-2 next-tab border rounded bg-theme-primary text-white"
                    >
                    Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
