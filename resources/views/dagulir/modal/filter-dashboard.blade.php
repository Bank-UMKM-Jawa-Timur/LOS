<div class="modal-layout hidden" id="modal-filter">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Filter data
                </h2>
            </div>
            <button data-dismiss-id="modal-filter">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="modal-body">
            <form id="form-filter" action="" method="GET">
                <div class="form-group-2 mb-4">
                    <div class="input-box">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="tAwal" id="tAwal" class="form-input"
                            value="{{ Request()->query('tAwal') }}" required="required">
                        <small id="reqAwal" class="form-text text-theme-primary hidden">Tanggal Awal Tidak Boleh
                            Kosong!</small>
                    </div>
                    <div class="input-box">
                        <label for="tAkhir">Tanggal Akhir</label>
                        <input type="date" name="tAkhir" id="tAkhir" class="form-input"
                            value="{{ Request()->query('tAkhir') }}" required="required">
                        <small id="errorAkhir" class="form-text text-theme-primary hidden">Tanggal akhir tidak boleh
                            kurang
                            dari tanggal awal</small>
                        <small id="reqAkhir" class="form-text text-theme-primary hidden">Tanggal Akhir Tidak Boleh
                            Kosong!</small>
                    </div>
                </div>
                <div class="form-group-2 mb-4">
                    @if (auth()->user()->role == 'Administrator' || auth()->user()->role == 'Kredit Umum' || auth()->user()->role == 'Direksi')
                    <div class="input-box">
                        <label for="">Cabang</label>
                        <select name="cbg" class="form-select" id="cabang">
                            <option value="" selected>-- Pilih Cabang --</option>
                            @foreach ($cabangs as $item)
                                    <option value="{{ $item->kode_cabang }}" {{ Request()->query('cbg') == $item->kode_cabang ? 'selected' : '' }}>{{ $item->cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="input-box">
                        <label for="">Skema Kredit</label>
                        <select name="skema" class="form-select" id="">
                            <option value="" selected>-- Pilih Score --</option>
                            <option value="PKPJ" {{ Request()->query('skema') == "PKPJ" ? 'selected' : '' }}>PKPJ</option>
                            <option value="KKB" {{ Request()->query('skema') == "KKB" ? 'selected' : '' }}>KKB</option>
                            <option value="Umroh" {{ Request()->query('skema') == "Umroh" ? 'selected' : '' }}>Umroh</option>
                            <option value="Prokesra" {{ Request()->query('skema') == "Prokesra" ? 'selected' : '' }}>Prokesra</option>
                            <option value="Kusuma" {{ Request()->query('skema') == "Kusuma" ? 'selected' : '' }}>Kusuma</option>
                            <option value="Dagulir" {{ Request()->query('skema') == "Dagulir" ? 'selected' : '' }}>Dagulir</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="">Posisi</label>
                        <select name="pss" class="form-select" id="pss">
                            <option value="" selected>-- Pilih Posisi --</option>
                            <option value="Proses Input Data" {{ Request()->query('pss') == "Proses Input Data" ?
                                'selected' : ''
                                }}>Proses Input Data</option>
                            <option value="Review Penyelia" {{ Request()->query('pss') == "Review Penyelia" ? 'selected'
                                : ''
                                }}>Review Penyelia</option>
                            <option value="PBO" {{ Request()->query('pss') == "PBO" ? 'selected' : '' }}>PBO</option>
                            <option value="PBP" {{ Request()->query('pss') == "PBP" ? 'selected' : '' }}>PBP</option>
                            <option value="Pincab" {{ Request()->query('pss') == "Pincab" ? 'selected' : '' }}>Pincab
                            </option>
                            <option value="Selesai" {{ Request()->query('pss') == "Selesai" ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="Ditolak" {{ Request()->query('pss') == "Ditolak" ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                    {{-- <div class="input-box">
                        <label for="">Score</label>
                        <select name="score" class="form-select" id="">
                            <option value="" selected>-- Pilih Score --</option>
                            <option value="1" {{ Request()->query('score') == "1" ? 'selected' : '' }}>1</option>
                            <option value="2" {{ Request()->query('score') == "2" ? 'selected' : '' }}>2</option>
                            <option value="3" {{ Request()->query('score') == "3" ? 'selected' : '' }}>3</option>
                            <option value="4" {{ Request()->query('score') == "4" ? 'selected' : '' }}>4</option>
                        </select>
                    </div> --}}
                    <div class="input-box">
                        <label for="">Status</label>
                        <select name="sts" class="form-select" id="sts">
                            <option value="">-- Pilih Status --</option>
                            <option value="Selesai" {{ Request()->query('sts') == "Selesai" ? 'selected' : ''
                                }}>Disetujui</option>
                            <option value="Proses Input Data" {{ Request()->query('sts') == "Proses Input Data" ?
                                'selected' :
                                '' }}>Diproses</option>
                            <option value="Ditolak" {{ Request()->query('sts') == "Ditolak" ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-end">
            <button class="btn-cancel" data-dismiss-id="modal-filter">
                Batal
            </button>
            <button type="submit" id="btn-filter" class="btn-submit">Filter</button>
        </div>
    </div>
</div>