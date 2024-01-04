@extends('layouts.tailwind-template')
@push('script-inject')
    {{-- <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script> --}}
    <script>
        $(document).ready(function () {
            $('#checkFile').hide();
            $('#fileUploadForm').submit(function (e) {
                e.preventDefault();

                var form = $(this);
                var formData = new FormData(form[0]);
                var progressBarContainer = $('#progressBarContainer');
                var progressBar = $('.progress-bar');

                progressBarContainer.show(); // Show progress bar container
                progressBar.css('width', '0%'); // Reset progress bar width

                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                progressBar.css('width', percentComplete + '%');
                                progressBar.html(percentComplete + '%');
                            }
                        }, false);

                        return xhr;
                    },
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        console.log('File has uploaded');
                        $('#uploadButton').hide();
                        $('#checkFile').show();
                    }
                });
            });
        });
    </script>
@endpush
@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
               Proses Pembayaran
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Proses Pembayaran
            </h2>
        </div>
    </div>
    <div class="body-pages">
        <div class="table-wrapper border bg-white mt-3 p-5">

            <form id="fileUploadForm" action="{{ route('pembayaran.upload') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group-3">
                    <div class="input-box">
                        <label for="">File Txt</label>
                        <input type="file" name="file_txt" class="form-input" id="browseFile">
                    </div>
                    <div class="input-box">
                        <label for="">Dictionary</label>
                        <input type="file" name="file_dic" class="form-input" id="">
                    </div>
                    <div class="input-box">
                        <label for="">Nomi</label>
                        <input type="file" name="file_nomi" class="form-input" id="">
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 my-4" id="progressBarContainer" style="display:none;">
                    {{-- <div class="progress-bar bg-blue-500" style="width: 20%;"></div> --}}
                    <div class="progress-bar bg-blue-600 h-2.5 rounded-full text-xs leading-none text-center text-white" style="width: 0%"></div>
                </div>

                <div class="flex justify-end my-5 py-4">
                    <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white" id="uploadButton">Upload File</button>
                    <a href="{{ route('pembayaran.store') }}" class="px-5 py-2 border rounded bg-theme-primary text-white" id="checkFile">Check File</a>
                </div>
            </form>
            @if ($data != null)
            <div class="table-responsive pl-5 pr-5">
                <table class="tables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sequence</th>
                            <th>No. Loan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Nominal</th>
                            <th>Kolek</th>
                            <th>Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $key => $item)
                        @php
                            $date = strtotime($item['HLDTVL']);
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['HLSEQN'] }}</td>
                            <td>{{ $item['HLLNNO'] }}</td>
                            <td>{{ date('d-m-Y',$date) }}</td>
                            <td>{{ number_format((int)$item['HLORMT'] / 100,2,",",".") }}</td>
                            <td>{{ $item['kolek'] }}</td>
                            <td>{{ $item['HLACKY'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection
