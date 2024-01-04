<div class="modal-layout hidden" id="modal-photo">
    <div class="modal modal-sm bg-white">
        <div class="modal-head">
            <div class="title">
                <h2 class="font-bold text-lg tracking-tighter text-theme-text" id="title_modal">
                    Foto Nasabah
                </h2>
            </div>
            <button data-dismiss-id="modal-photo">
                <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="modal-body">
            <div class="image">
                <img id="image-content" src="{{ asset('img/no-image.jpg') }}" alt="">
                <iframe
                    id="pdf-content" class="w-full" height="600px"></iframe>
            </div>
        </div>
        <div class="modal-footer justify-end">
            <button class="btn-cancel" data-dismiss-id="modal-photo">
                Tutup
            </button>
        </div>
    </div>
</div>
@push('script-inject')
    <script>
        $(document).on('click', '.btn-file-preview', function() {
            const title = $(this).data('title')
            const filepath = $(this).data('filepath')
            const type = $(this).data('type')
            console.log(filepath);
            $('#modal-photo #title_modal').html(title)

            if (type == 'image') {
                $('#modal-photo #pdf-content').addClass('hidden')
                $('#modal-photo #image-content').removeClass('hidden')
                $('#modal-photo #image-content').attr('src', filepath)
            } else {
                $('#modal-photo #image-content').addClass('hidden')
                $('#modal-photo #pdf-content').removeClass('hidden')
                $('#modal-photo #pdf-content').attr('src', filepath)
            }
            $('#modal-photo').removeClass('hidden')
        })
    </script>
@endpush
