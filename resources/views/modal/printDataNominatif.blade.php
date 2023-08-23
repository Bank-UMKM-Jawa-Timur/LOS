<div class="modal fade" id="data_nominatif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Print Data Nominatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('print_data_nominatif') }}" id="formhapus" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="">Kategori</label>
                                <select class="custom-select" name="k_tanggal" id="selectCategory" required>
                                    <option value="kesuluruhan">Keseluruhan</option>
                                    <option value="kustom">Tanggal</option>
                                </select>
                            </div>

                            <!-- Div untuk Tanggal Awal -->
                            <div class="col-sm-6" id="tanggalAwalDiv">
                                <label>Tanggal Awal</label>
                                <input type="date" name="tAwal" id="tAwals" class="form-control">
                            </div>

                            <!-- Div untuk Tanggal Akhir -->
                            <div class="col-sm-6" id="tanggalAkhirDiv">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tAkhir" id="tAkhirs" class="form-control">
                                <small id="errorTakhirModal" class="form-text text-danger">Tanggal akhir tidak boleh
                                    kurang
                                    dari tanggal awal</small>
                            </div>
                            <div class="col-sm-12 ">
                                <label>Cabang</label>
                                <select name="cabang" id="inputGroupSelect01"
                                    class="custom-select select2 selectModal">
                                    <option value="semua" selected>Pilih Semua</option>
                                    @foreach ($cabangs as $c)
                                        <option value="{{ $c->id }}">{{ $c->cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="">Pilih Jenis Export</label>
                                <select class="custom-select" name="export" id="" required>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">EXCEL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inverse waves-effect waves-light"
                        data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Print</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#errorTakhirModal").hide();
    })
    $(document).ready(function() {
        // Sembunyikan input tanggal awal dan tanggal akhir saat halaman pertama kali dimuat
        $('#tanggalAwalDiv').hide();
        $('#tanggalAkhirDiv').hide();

        // Tampilkan/menyembunyikan input tanggal awal dan tanggal akhir berdasarkan pilihan select
        $('select[name="k_tanggal"]').change(function() {
            var optionKategori = $(this).val();
            console.log("s");

            if (optionKategori === 'kustom') {
                $('#tanggalAwalDiv').show();
                $('#tanggalAkhirDiv').show();
                $("#tAwals").prop("required", true);
            } else {
                $('#tanggalAwalDiv').hide();
                $('#tanggalAkhirDiv').hide();
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
                $("#errorTakhirModal").show();
            }else{
            $("#errorTakhirModal").hide();
            }
        })
    });
</script>
