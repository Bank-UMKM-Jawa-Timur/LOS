@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
               Upload Pembayaran
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Upload Pembayaran
            </h2>
        </div>
    </div>
    <div class="body-pages">
        <div class="table-wrapper border bg-white mt-3 p-5">
            <form action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group-2">
                    <div class="input-box">
                        <label for="">File Txt</label>
                        <input type="file" name="file_txt" class="form-input" id="">
                    </div>
                    <div class="input-box">
                        <label for="">Dictionary</label>
                        <input type="file" name="file_dic" class="form-input" id="">
                    </div>
                </div>
                <div class="flex justify-end my-5 py-4">
                    <button class="px-5 py-2 border rounded bg-theme-primary text-white">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
