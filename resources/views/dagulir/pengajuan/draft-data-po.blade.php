
<div id="data-po-tab" class="is-tab-content">
    <div class="pb-10 space-y-3">
        <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Data PO</h2>
        <p class="font-semibold text-gray-400">Edit Pengajuan</p>
    </div>
    <div class="self-start bg-white w-full border">
        <div class="p-5 border-b">
            <h2 class="font-bold text-lg tracking-tighter">
                Data PO
            </h2>
        </div>

        <div class="p-5 w-full space-y-5"
            id="data-po"
        >
            <input type="hidden" name="id_data_po_temp" id="id_data_po_temp">
            <div class="form-group-1 col-span-2">
                <div>
                    <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                        <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                            Jenis Kendaraan Roda 2 :
                        </h2>
                    </div>
                </div>
            </div>
            <div class="form-group-2">
                <div class="form-group">
                    <div class="input-box">
                        <label>Merk Kendaraan</label>
                        <input type="text" name="merk" id="merk" class="form-input @error('merk') is-invalid @enderror"
                            placeholder="Merk kendaraan" value="{{$dataPO?->merk}}">
                        @error('merk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <label>Tipe Kendaraan</label>
                        <input type="text" name="tipe_kendaraan" id="tipe_kendaraan"
                            class="form-input @error('tipe_kendaraan') is-invalid @enderror" placeholder="Tipe kendaraan" value="{{$dataPO->tipe}}">
                        @error('tipe_kendaraan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <label for="">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-input @error('tahun') is-invalid @enderror"
                            placeholder="Tahun Kendaraan" value="{{ $dataPO->tahun_kendaraan ?? '' }}" min="2000">
                        @error('tahun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <label for="">Warna</label>
                        <input type="text" maxlength="25" name="warna" id="warna"
                            class="form-input @error('warna') is-invalid @enderror" placeholder="Warna Kendaraan" value="{{ $dataPO?->warna ?? '' }}">
                        @error('warna')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group-1 col-span-2">
                <div>
                    <div class="p-2 border-l-4 border-theme-primary bg-gray-100">
                        <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                            Keterangan :
                        </h2>
                    </div>
                </div>
            </div>
            <div class="form-group-2">
                <div class="form-group">
                    <div class="input-box">
                        <label for="">Pemesanan</label>
                        <input type="text" maxlength="255" name="pemesanan" id="pemesanan"
                            class="form-input @error('pemesanan') is-invalid @enderror" placeholder="Pemesanan Kendaraan"
                            value="{{ $dataPO?->keterangan ?? '' }}">
                        @error('pemesanan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <label for="">Sejumlah</label>
                        <input type="number" name="sejumlah" id="sejumlah"
                            class="form-input @error('sejumlah') is-invalid @enderror" placeholder="Jumlah Kendaraan"
                            value="{{ $dataPO?->jumlah ?? '' }}">
                        @error('sejumlah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-box">
                        <label for="">Harga</label>
                        <input type="text" name="harga" id="harga"
                            class="form-input rupiah @error('harga') is-invalid @enderror" placeholder="Harga Kendaraan"
                            value="{{ $dataPO?->harga ?? '' }}">
                        @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
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
                <button type="button"
                class="px-5 py-2 next-tab border rounded bg-theme-primary text-white"
                >
                Selanjutnya
                </button>
            </div>
        </div>
    </div>
</div>
