{{-- <h1>Helloworld</h1> --}}
{{-- <form action="" method="get" class="row ">
    <div class="col-sm-4">
        <label>Tanggal Awal Pengajuan</label>
        <input type="date" name="tAwal" class="form-control @error('kabupaten') is-invalid @enderror"
            placeholder="Dari" value="{{ Request()->query('tAwal') }}" required>
    </div>
    <div class="col-sm-4">
        <label>Tanggal Akhir Pengajuan</label>
        <input type="date" name="tAkhir" class="form-control @error('kabupaten') is-invalid @enderror"
            placeholder="Sampai" value="{{ Request()->query('tAkhir') }}" required>
    </div>
    <div class="col-sm-4">
        <label>Status</label>
        <select class="custom-select" id="inputGroupSelect01" required name="sts">
            @if (Request()->query('sts') != null)
                <option selected disabled value="{{ Request()->query('sts') }}">
                    @if (Request()->query('sts') == 'hijau')
                        Disetujui
                    @elseif(Request()->query('sts') == 'kuning')
                        On Progress
                    @elseif(Request()->query('sts') == 'merah')
                        Ditolak
                    @endif
                </option>
            @else
                <option selected disabled value="">Pilih Status</option>
            @endif

            <option value="hijau">Disetujui</option>
            <option value="kuning">On Progress</option>
            <option value="merah">Ditolak</option>
        </select>
    </div>
    <div class="col-sm-6">
        <button class="btn btn-primary mt-2"><i class="fa fa-filter"></i> Filter</button>
        @if (Request()->query('tAkhir') != null)
            <a href="{{ url()->current() }}" class="btn btn-warning mt-2"><i class="fa fa-undolar"></i> Reset Filter</a>
        @endif

    </div>
</form>
<hr> --}}
