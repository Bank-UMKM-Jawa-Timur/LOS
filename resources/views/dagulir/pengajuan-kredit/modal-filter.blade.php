<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="get">
                <div class="modal-body">
                    <div class="row ">
                        <div class="col-sm-6">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tAwal" id="tAwal" class="form-control"
                                value="{{ Request()->query('tAwal') }}">
                        </div>
                        <div class="col-sm-6">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tAkhir" id="tAkhir" class="form-control"
                                value="{{ Request()->query('tAkhir') }}">
                            <small id="errorAkhir" class="form-text text-danger">Tanggal akhir tidak boleh kurang
                                dari tanggal awal</small>
                        </div>
                        @if (auth()->user()->role == 'Administrator')
                            <div class="col-sm-6 mt-2">
                                <label>Cabang</label>
                                <select class="custom-select" id="inputGroupSelect01" name="cbg">
                                    @if (Request()->query('cbg') != null)
                                        @foreach ($cabang as $items)
                                            @if ($items->id == Request()->query('cbg'))
                                                <option selected value="{{ $items->id }}">
                                                    {{ $items->cabang }}</option>
                                            @break
                                        @endif
                                    @endforeach
                                @else
                                    <option selected disabled value="">Pilih Cabang</option>
                                @endif
                                @foreach ($cabang as $item)
                                    <option value="{{ $item->id }}">{{ $item->cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-sm-6 mt-2">
                        <label>Posisi</label>
                        <select class="custom-select" id="inputGroupSelect01" name="pss">
                            @if (Request()->query('pss') != null)
                                <option selected value="{{ Request()->query('pss') }}">
                                    @if (Request()->query('pss') == 'Selesai')
                                        Selesai
                                    @elseif(Request()->query('pss') == 'Proses Input Data')
                                        Staff
                                    @elseif(Request()->query('pss') == 'Review Penyelia')
                                        Penyelia
                                    @elseif(Request()->query('pss') == 'PBO')
                                        PBO
                                    @elseif(Request()->query('pss') == 'PBP')
                                        PBP
                                    @elseif(Request()->query('pss') == 'Pincab')
                                        Pincab
                                    @endif
                                </option>
                            @else
                                <option selected disabled value="">Pilih Posisi</option>
                            @endif
                            <option value="Selesai">Selesai</option>
                            <option value="Proses Input Data">Staff</option>
                            <option value="Review Penyelia">Penyelia</option>
                            <option value="PBO">PBO</option>
                            <option value="PBP">PBP</option>
                            <option value="Pincab">Pincab</option>

                        </select>
                    </div>
                    {{-- <div class="col-sm-6 mt-2">
                        <label>Score</label>
                        @if (Request()->query('score') == null)
                            <input type="text" name="score" class="form-control" placeholder="Score"
                                value="">
                        @else
                            <input type="text" name="score" class="form-control" placeholder="Score"
                                value="{{ number_format(Request()->query('score'), 2) }}">
                        @endif

                    </div> --}}
                    <div class="col-sm-6 mt-2">
                        <label>Score</label>

                        <select class="custom-select" name="score">
                            @if (Request()->query('score') == null)
                                <option selected disabled value="">Pilih Score</option>
                            @else
                                <option selected value="{{ Request()->query('score') }}">
                                    {{ Request()->query('score') }}</option>
                            @endif

                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        {{-- @else
                            <input type="text" name="score" class="form-control" placeholder="Score"
                                value="{{ number_format(Request()->query('score'), 2) }}">
                        @endif --}}

                    </div>
                    <div class="col-sm-6 mt-2">
                        <label>Status</label>
                        <select class="custom-select" id="inputGroupSelect01" name="sts">
                            @if (Request()->query('sts') != null)
                                <option selected value="{{ Request()->query('sts') }}">
                                    @if (Request()->query('sts') == 'Selesai')
                                        Disetujui
                                    @elseif(Request()->query('sts') == 'Progress')
                                        On Progress
                                    @elseif(Request()->query('sts') == 'Ditolak')
                                        Ditolak
                                    @endif
                                </option>
                            @else
                                <option selected disabled value="">Pilih Status</option>
                            @endif

                            <option value="Selesai">Disetujui</option>
                            <option value="Progress">On Progress</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    {{-- <div class="col-sm-6">
                            <button class="btn btn-primary mt-2"><i class="fa fa-filter"></i> Filter</button>
                            @if (Request()->query('tAkhir') != null)
                                <a href="{{ url()->current() }}" class="btn btn-warning mt-2"><i
                                        class="fa fa-undolar"></i>
                                    Reset Filter</a>
                            @endif

                        </div> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>
</div>

@push('custom-script')
<script>
    $("#tAwal").on("change", function() {
        var result = $(this).val();
        if (result != null) {
            $("#tAkhir").prop("required", true)
        }
    });

    $(document).ready(function() {
        $("#errorAkhir").hide();
    })

    $("#tAkhir").on("change", function() {
        var tAkhir = $(this).val();
        var tAwal = $("#tAwal").val();
        if (Date.parse(tAkhir) < Date.parse(tAwal)) {
            $("#tAkhir").val('');
            $("#errorAkhir").show();
        } else {
            $("#errorAkhir").hide();
        }
    })
</script>
@endpush
