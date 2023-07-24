<form id="pengajuan_kredit" action="{{ route('pengajuan-kredit.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_item_file[148][]" value="148" id="">
    <input type="file" name="upload_file[148][]" id="" data-id=""
        placeholder="Masukkan informasi"
        class="form-control limit-size file-usaha" accept="image/*">
    <input type="hidden" name="id_item_file[148][]" value="148" id="">
    <input type="file" name="upload_file[148][]" id="" data-id=""
        placeholder="Masukkan informasi"
        class="form-control limit-size file-usaha" accept="image/*">
        <button type="submit">Kirim</button>
</form>