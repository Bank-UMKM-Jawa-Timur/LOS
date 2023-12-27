<div
class="modal-layout hidden"
id="modal-photo"
>
<div class="modal modal-sm bg-white">
  <div class="modal-head">
    <div class="title">
      <h2 class="font-bold text-lg tracking-tighter text-theme-text" id="titleText">
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
    <img id="image" src="{{ asset('img/no-image.jpg') }}" alt="" class="hidden">
    <iframe id="pdf" src="" width="100%" height="60%"></iframe>
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
    let title = $(this).data('title')
    let filepath = $(this).data('filepath')
    let extension = $(this).data('extension');
    console.log(extension);
    $('#modal-photo #titleText').html(title)
    if(extension != 'pdf'){
        $('#modal-photo #image').attr('src', filepath)
        $('#modal-photo #image').removeClass('hidden');
        $("#modal-photo #pdf").addClass('hidden')
    } else{
        $("#modal-photo #pdf").attr('src', filepath)
        $("#modal-photo #pdf").removeClass('hidden')
        $("#modal-photo #image").addClass('hidden')
    }
    $('#modal-photo').removeClass('hidden')
  })
</script>
@endpush