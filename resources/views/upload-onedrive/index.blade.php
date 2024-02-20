<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload OneDrive</title>
</head>
<body>
    <form action="{{route('upload-onedrive.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">Pilih Berkas</label>
        <input type="file" name="file" id="file" required>
        <input type="submit" value="Upload">
    </form>
</body>
</html>