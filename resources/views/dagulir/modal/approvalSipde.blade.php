<div
class="modal-layout hidden"
id="modal-approval-sipde"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
        Kirim SIPDE
      </h2>
    </div>
    <button data-dismiss-id="modal-logout">
      <iconify-icon
        icon="iconamoon:close-bold"
        class="text-2xl"
      ></iconify-icon>
    </button>
  </div>
  <div class="modal-body space-y-5">
    <div class="space-y-3">
        <form action="{{ route('dagulir.store-sipde') }}" method="POST">
            @csrf

        <div class="form-group-1">
            <input type="hidden" name="id_dagulir" id="id_dagulir" >
            <div class="input-box">
                <label for="">Nominal Realisasi</label>
                <input name="nominal_realisasi" type="text"
                class="form-input rupiah"
                placeholder="Masukan informasi disini" />
            </div>
            <div class="input-box">
                <label for="">Jangka Waktu</label>
                <input name="jangka_waktu" type="number"
                class="form-input"
                placeholder="Masukan informasi disini" />
            </div>

        </div>
    </div>
  </div>
  <div class="modal-footer justify-end">
        <button  type="submit" href="" class="btn bg-green-500 text-white">Simpan</button>
    </form>
  </div>
</div>
</div>

@push('script-inject')
    <script>
        $('.kirimSipde').on('click', function(e) {
            const id = $(this).data('id');
            $('#id_dagulir').val(id);
            $('#modal-approval-sipde').removeClass('hidden')
        })
        $('.rupiah').keyup(function(e) {
            var input = $(this).val()
            $(this).val(formatrupiah(input))
        });
        function formatrupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
    </script>
@endpush
