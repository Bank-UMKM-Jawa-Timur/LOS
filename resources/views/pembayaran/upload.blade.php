@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    {{-- <script>
        // $(document).ready(function () {
        //     $('#checkFile').hide();
        //     $('#fileUploadForm').submit(function (e) {
        //         e.preventDefault();

        //         var form = $(this);
        //         var formData = new FormData(form[0]);
        //         var progressBarContainer = $('#progressBarContainer');
        //         var progressBar = $('.progress-bar');

        //         progressBarContainer.show(); // Show progress bar container
        //         progressBar.css('width', '0%'); // Reset progress bar width

        //         $.ajax({
        //             xhr: function () {
        //                 var xhr = new window.XMLHttpRequest();

        //                 xhr.upload.addEventListener("progress", function (evt) {
        //                     if (evt.lengthComputable) {
        //                         var percentComplete = (evt.loaded / evt.total) * 100;
        //                         progressBar.css('width', percentComplete + '%');
        //                         progressBar.html(percentComplete + '%');
        //                     }
        //                 }, false);

        //                 return xhr;
        //             },
        //             type: form.attr('method'),
        //             url: form.attr('action'),
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function () {
        //                 console.log('File has uploaded');
        //                 $('#uploadButton').hide();
        //                 $('#checkFile').show();
        //             }
        //         });
        //     });
        // });
    </script> --}}
    <script>
        let browseFileTxt =  $('#browseFileTxt');
        let browseFileDic =  $('#browseFileDic');
        let browseFileNomi = $('#browseFileNomi');

        let nameTxt = $('#browseFileTxt').attr('name');
        let nameDic = $('#browseFileDic').attr('name');
        let nameNomi = $('#browseFileNomi').attr('name');

        let resumableTxt = createResumable(browseFileTxt, '{{ route('pembayaran.upload-data') }}',nameTxt);
        let resumableDic = createResumable(browseFileDic, '{{ route('pembayaran.upload-data') }}',nameDic);
        let resumableNomi = createResumable(browseFileNomi, '{{ route('pembayaran.upload-data') }}',nameNomi);

        resumableTxt.on('fileSuccess', function (file, response) {
            console.log(response);
            response = JSON.parse(response);
            $('#check_txt').val(response.filename)
            $('.text-filename-txt').html(`File : ${response.filename}`)
            checkFileInputs();
        });

        resumableDic.on('fileSuccess', function (file, response) {
            console.log(response);
            response = JSON.parse(response);
            $('.text-filename-dic').html(`File : ${response.filename}`)
            $('#check_dic').val(response.filename)
            checkFileInputs();
            // updateInputFileName(browseFileDic, response.filename);

        });

        resumableNomi.on('fileSuccess', function (file, response) {
            response = JSON.parse(response);
            $('.text-filename-nomi').html(`File : ${response.filename}`)
            $('#check_nomi').val(response.filename)
            checkFileInputs();

        });

        function createResumable(element, targetUrl,name) {
            let resumable = new Resumable({
                target: targetUrl,
                query: {
                    _token: '{{ csrf_token() }}',
                    data:name
                },
                chunkSize: 10 * 1024 * 1024,
                headers: {
                    'Accept': 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(element[0]);

            resumable.on('fileAdded', function (file) {
                showProgress(element);
                resumable.upload();
            });

            resumable.on('fileProgress', function (file) {
                updateProgress(element, Math.floor(file.progress() * 100));
            });

            resumable.on('fileError', function (file, response) {
                alert('File uploading error.');
            });

            return resumable;
        }


        function showProgress(element) {
            let progressBarContainer = $('#progressBarContainer');
            progressBarContainer.find('.progress-bar').css('width', '0%');
            progressBarContainer.find('.progress-bar').html('0%');
            progressBarContainer.find('.progress-bar').removeClass('bg-success');
            progressBarContainer.show();
        }

        function updateProgress(element, value) {
            let progressBarContainer = $('#progressBarContainer');
            progressBarContainer.find('.progress-bar').css('width', `${value}%`);
            progressBarContainer.find('.progress-bar').html(`${value}%`);
        }
        // $('#checkFile').hide();
        function checkFileInputs() {
            let fileTxt = $('#check_txt').val() != '' ? true : false;
            let fileDic = $('#check_dic').val() != ''  ? true : false ;
            let fileNomi = $('#check_nomi').val() != '' ? true : false;
            if (fileTxt && fileDic && fileNomi) {
                $('#checkFile').show(); // Show the submit button
                $('#prosesData').hide();
            } else {
                $('#checkFile').hide(); // Hide the submit button
            }
        }

        $('#checkFile').on('click',function() {
            $("#fileUploadForm").submit();
            $('#preload-data').removeClass('hidden');
        })

        // Attach the checkFileInputs function to the change event of file inputs
        // $('#browseFileTxt, #browseFileDic, #browseFileNomi').change(function () {
        //     checkFileInputs();
        // });

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


                <div class="form-group-3">
                    <div class="input-box">
                        <label for="">File Txt</label>
                        <input type="file" name="file_txt" class="form-input" id="browseFileTxt">
                        <input type="hidden" value="" name="check_txt" id="check_txt">
                        <p class="text-filename-txt text-base m-0" style="margin: 2px"> </p>
                    </div>
                    <div class="input-box">
                        <label for="">Dictionary</label>
                        <input type="file" name="file_dic" class="form-input" id="browseFileDic">
                        <input type="hidden" value="" name="check_dic" id="check_dic">
                        <p class="text-filename-dic text-base m-0" style="margin: 2px"> </p>
                    </div>
                    <div class="input-box">
                        <label for="">Nomi</label>
                        <input type="file" name="file_nomi" class="form-input" id="browseFileNomi">
                        <input type="hidden" value="" name="check_nomi" id="check_nomi">
                        <p class="text-filename-nomi text-base m-0" style="margin: 2px"> </p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 my-4" id="progressBarContainer" style="display:none;">
                    <div class="progress-bar bg-blue-600 h-2.5 rounded-full text-xs leading-none text-center text-white" style="width: 0%"></div>
                </div>

                <div class="flex justify-end my-5 py-4">
                    @if ($data != null)
                        <form action="{{ route('pembayaran.proses') }}" method="POST">
                            @csrf
                            <input type="hidden" name="data" value="{{ json_encode($data) }}">
                            <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white" id="prosesData">Proses Data</button>
                        </form>
                    @endif
                    <form id="fileUploadForm" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white" id="checkFile" style="display:none;">Check Data</button>
                    </form>
                </div>
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
                            <th>Keterangan</th>
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
                            <td>{{ $item['HLDESC'] }}</td>
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
