<div class="modal-layout hidden" id="modal-data-nominatif">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text">
                    Filter Print Data Nominatif
                </h2>
            </div>
            <button data-dismiss-id="modal-data-nominatif">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form action="{{ route('print_data_nominatif') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Kategori</label>
                        <select class="form-select" name="k_tanggal" id="selectCategory" required>
                            <option value="kesuluruhan">Keseluruhan</option>
                            <option value="kustom">Tanggal</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-2 mb-4 hidden" id="divTanggal">
                    <div class="input-box">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="tAwal" id="tAwals" class="form-input">
                        <small id="reqAwal" class="form-text text-theme-primary hidden">Tanggal Awal Tidak Boleh
                            Kosong!</small>
                    </div>
                    <div class="input-box">
                        <label for="tAkhir">Tanggal Akhir</label>
                        <input type="date" name="tAkhir" id="tAkhirs" class="form-input">
                        <small id="errorAkhir" class="form-text text-theme-primary hidden">Tanggal akhir tidak boleh
                            kurang
                            dari tanggal awal</small>
                        <small id="reqAkhir" class="form-text text-theme-primary hidden">Tanggal Akhir Tidak Boleh
                            Kosong!</small>
                    </div>
                </div>
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Cabang</label>
                        <select name="cabang" class="form-select" id="cabang">
                            <option value="semua" selected>Pilih semua</option>
                            @foreach ($cabangs as $item)
                                <option value="{{ $item->kode_cabang }}"
                                    {{ Request()->query('cbg') == $item->kode_cabang ? 'selected' : '' }}>
                                    {{ $item->cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-1 mb-4">
                    <div class="input-box">
                        <label for="">Pilih Jenis Export</label>
                        <select class="form-select" name="export" id="" required>
                            <option value="pdf">PDF</option>
                            <option value="excel">EXCEL</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-end">
                <button class="btn-cancel" data-dismiss-id="modal-data-nominatif">
                    Batal
                </button>
                <button type="submit" class="btn-submit">Print</button>
            </div>
        </form>
    </div>
</div>


@push('script-inject')
<script>
    $(document).ready(function() {
        $('select[name="k_tanggal"]').change(function() {
            var optionKategori = $(this).val();

            if (optionKategori === 'kustom') {
                $('#divTanggal').removeClass('hidden');
                $("#tAwals").prop("required", true);
            } else {
                $('#divTanggal').addClass('hidden');
                $('#tanggalAkhirDiv').addClass('hidden');
                $('#tAwals').droppable();
                $('#tAkhirs').droppable();
            }
        });

        $('#selectCategory').on("change", function(){
            $('#tAwals').val(null)
            $('#tAkhirs').val(null)
        });

        $("#tAwals").on("change", function() {
            var result = $(this).val();
            if (result != null) {
                $("#tAkhirs").prop("required", true)
            }
        });



        $("#tAkhirs").on("change", function() {
            var tAkhir = $(this).val();
            var tAwal = $("#tAwals").val();
            if (Date.parse(tAkhir) < Date.parse(tAwal)) {
                $("#tAkhirs").val('');
                $("#reqAkhir").removeClass('hidden');
            }else{
            $("#reqAkhir").addClass('hidden');
            }
        })
    });
</script>
@endpush
