<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coming Soon! </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-poppins">
<div class="flex justify-center mt-[20vh]">
    <div class="max-auto max-w-7xl space-y-5">
        <img src="{{ asset('img/undraw_under_construction.svg') }}" class="mx-auto max-w-[500px]" alt="">
        <div class="content text-center space-y-5">
            <h2 class="font-bold lg:text-5xl text-3xl text-theme-primary tracking-tighter">Coming Soon!</h2>
            <p class="text-sm max-w-lg text-gray-400 mx-auto">Halaman sedang dalam tahap pengembangan, mohon tunggu beberapa saat</p>
            <a href="{{ route('dashboard') }}" class="mt-5" >
                <button class="px-5 py-2 bg-theme-primary rounded font-semibold text-white">Kembali ke Dashboard</button>
            </a>
        </div>
    </div>
</div>
</body>
</html>