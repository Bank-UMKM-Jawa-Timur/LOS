<form id="form-filter" method="get">
<div
class="modal-layout hidden"
id="modal-filter"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title mt-1">
      <h2 class="font-bold text-lg tracking-tighter text-theme-text">
        Filter data
      </h2>
    </div>
    <button type="button" class="p-2 gap-2 flex justify-center" data-dismiss-id="modal-filter">
      <span class="text-gray-500 flex gap-2 "><iconify-icon icon="mdi:keyboard-esc" class="text-2xl"></iconify-icon> to close</span>
      <iconify-icon
        icon="iconamoon:close-bold"
        class="text-2xl text-gray-500"
      ></iconify-icon>
    </button>
  </div>
  <div class="modal-body">
    <form action="">
      <div class="form-group-2 mb-4">
        <div class="input-box">
          <label for="">Tanggal Awal</label>
          <input
            type="date"
            name="tAwal" 
            id="tAwal"
            class="form-input"
            value="{{ Request()->query('tAwal') }}">
        </div>
        <div class="input-box">
          <label for="tAkhir">Tanggal Akhir</label>
          <input
            type="date"
            name="tAkhir" 
            id="tAkhir"
            class="form-input"
            value="{{ Request()->query('tAkhir') }}"
          />
          <small id="errorAkhir" class="form-text text-danger hidden">Tanggal akhir tidak boleh kurang
            dari tanggal awal</small>
        </div>
      </div>
      <div class="form-group-2 mb-4">
        <div class="input-box">
          <label for="">Cabang</label>
          <select name="cbg" class="form-select" id="cabang">
            <option value="">-- Pilih Cabang --</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Posisi</label>
          <select name="pss" class="form-select" id="pss">
            <option value="" selected>-- Pilih Posisi --</option>
            <option value="Proses Input Data" {{ Request()->query('pss') == "Proses Input Data" ? 'selected' : '' }}>Proses Input Data</option>
            <option value="Review Penyelia" {{ Request()->query('pss') == "Review Penyelia" ? 'selected' : '' }}>Review Penyelia</option>
            <option value="PBO" {{ Request()->query('pss') == "PBO" ? 'selected' : '' }}>PBO</option>
            <option value="PBP" {{ Request()->query('pss') == "PBP" ? 'selected' : '' }}>PBP</option>
            <option value="Pincab" {{ Request()->query('pss') == "Pincab" ? 'selected' : '' }}>Pincab</option>
            <option value="Selesai" {{ Request()->query('pss') == "Selesai" ? 'selected' : '' }}>Selesai</option>
            <option value="Ditolak" {{ Request()->query('pss') == "Ditolak" ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Score</label>
          <select name="score" class="form-select" id="">
              <option value="" selected>-- Pilih Score --</option>
              <option value="1" {{ Request()->query('score') == "1" ? 'selected' : '' }}>1</option>
              <option value="2" {{ Request()->query('score') == "2" ? 'selected' : '' }}>2</option>
              <option value="3" {{ Request()->query('score') == "3" ? 'selected' : '' }}>3</option>
              <option value="4" {{ Request()->query('score') == "4" ? 'selected' : '' }}>4</option>
          </select>
        </div>
        <div class="input-box">
          <label for="">Status</label>
          <select name="sts" class="form-select" id="sts">
            <option value="">-- Pilih Status --</option>
            <option value="Selesai" {{ Request()->query('sts') == "Selesai" ? 'selected' : '' }}>Hijau</option>
            {{-- <option value="Proses Input Data" {{ Request()->query('sts') == "Proses Input Data" ? 'selected' : '' }}>Kuning</option> --}}
            <option value="Ditolak" {{ Request()->query('sts') == "Ditolak" ? 'selected' : '' }}>Merah</option>
          </select>
        </div>
      </div>
      <div class="modal-info">
        <p>
          isi form berikut untuk memfilter sebagian data untuk ditampilkan
          tiap perbulan, pertahun atau perhari di setiap cabang dan juga
          lainya.
        </p>
      </div>
    </form>
  </div>
  <div class="modal-footer justify-end">
    <button
      class="btn-cancel"
      type="button"
      data-dismiss-id="modal-filter"
    >
      Batal
    </button>
    <button type="submit" class="btn-submit" data-dismiss-id="modal-filter" id="btn_filter">Filter</button>
  </div>
</div>
</div>
</form>
@push('script-inject')
<script>
    var token = "gTWx1U1bVhtz9h51cRNoiluuBfsHqty5MCdXRdmWthFDo9RMhHgHIwrU9DBFVaNj";

    var cbgValue = '{{ Request()->query('cbg') }}';
    $.ajax({
        type: "GET",
        url: "/api/v1/get-cabang", 
        headers: {
            'token': token,
        },
        success: function (response) {
            $.map(response.data, function (item, i) {
                $('#cabang').append(
                    `<option value="${item.kode_cabang}" ${cbgValue == item.kode_cabang ? 'selected' : ''}>${item.cabang}</option>`
                );
            });
        }
    });
</script>
@endpush