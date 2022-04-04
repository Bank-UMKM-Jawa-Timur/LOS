<form action="{{ route('desa.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Desa</label>
            <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" placeholder="Nama Desa" value="{{old('desa')}}">
                @error('desa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
        </div>

        <div class="form-group col-md-6">
            <label>Kabupaten</label>
            <select name="id_kabupaten" id="id_kabupaten" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Kabupaten</option>
                @foreach ($allKab as $kab)
                    <option value="{{ $kab->id }}" {{ old('id_kabupaten') == $kab->id ? ' selected' : '' }}>{{ $kab->kabupaten }}</option>
                @endforeach
            </select>
            @error('id_kabupaten')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Kecamatan</label>
            <select name="id_kecamatan" id="id_kecamatan" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Kecamatan</option>
                @foreach ($allKec as $kec)
                    <option value="{{ $kec->id }}" {{ old('id_kecamatan') == $kec->id ? ' selected' : '' }}>{{ $kec->kecamatan }}</option>
                @endforeach
            </select>
            @error('id_kecamatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>

@push('custom-script')
    <script>
        const urlGetKecamatan = "{{ url('getkecamatan') }}";
        const urlGetDesa = "{{ url('getkecamatan') }}";
        $(document).ready(function() {
            // level on change
            $('#id_kabupaten').change(function() {
                console.log($(this).val());
                getKecamatanByKabupaten($(this).val())
            });

            function getKecamatanByKabupaten(idKabupaten) {
                $.ajax({
                    type: "get",
                    // url: `${urlGetKecamatan}/${idKabupaten}`,
                    url: "/getkecamatan?kabID="+idKabupaten,
                    dataType: "json",
                    success: function(response) {
                        $('#id_kecamatan option').remove();
                        $('#id_kecamatan').append(`<option value="">Pilih Kecamatan</option>`);
                        // $.each(response, function(index, value) {
                        $.each(response, function(nama,kode) {
                            $("#id_kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                            // let addOption =
                            //     `<option value="${value.id}">${value.kecamatan}</option>`;
                            // $('#id_kecamatan').append(addOption);
                        });
                    }
                });
            }
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endpush
