<div
class="modal-layout hidden"
id="modal-photo"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-lg tracking-tighter text-theme-text">
        Foto Nasabah
      </h2>
    </div>
    <button data-dismiss-id="modal-photo">
      <iconify-icon
        icon="iconamoon:close-bold"
        class="text-2xl"
      ></iconify-icon>
    </button>
  </div>
  <div class="modal-body">
    <img id="content" src="{{ asset('img/no-image.jpg') }}" alt="">
  </div>
  <div class="modal-footer justify-end">
    <button
      class="btn-cancel"
      data-dismiss-id="modal-photo"
    >
      Tutup
    </button>
  </div>
</div>
</div>
@push('script-inject')
<script>
  $(document).on('click', '.btn-file-preview', function() {
    console.log('tes')
    const title = $(this).data('title')
    const filepath = $(this).data('filepath')
    $('#modal-photo #title h2').html(title)
    $('#modal-photo #content').attr('src', filepath)
    $('#modal-photo').removeClass('hidden')
  })
</script>
@endpush