<div
class="modal-layout hidden"
id="modal-approval"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
        Approval
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
      <p>Anda yakin akan melakukan approval untuk data ini?</p>
    </div>
  </div>
  <div class="modal-footer justify-end">
    <a id="btn-dec" type="button" href="" class="btn bg-red-500 text-white" >Ditolak</a>
    <a id="btn-acc" type="button" href="" class="btn bg-green-500 text-white">Disetujui</a>
  </div>
</div>
</div>

@push('script-inject')
    <script>
        $('.approval').on('click', function() {
            const id = $(this).data('id');
            const acc_url = $(this).data('acc-url');
            const dec_url = $(this).data('dec-url');
            $('#modal-approval #btn-acc').attr("href", acc_url)
            $('#modal-approval #btn-dec').attr("href", dec_url)
            $('#modal-approval').removeClass('hidden')
        })
    </script>
@endpush
