<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- meta tags --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analisa Kredit | BANK UMKM JATIM</title>
    {{-- font google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/gif" sizes="16x6" />
    {{-- tailwind configuration css --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/owl-carousel/owl.theme.default.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('') }}vendor/sweetalert-master/dist/sweetalert.css" />
</head>
<body class="bg-theme-body font-poppins" id="app">
    {{-- section modal only --}}
    @yield('modal')
    {{-- wrapping all layout --}}
    <div class="layout-wrapper flex justify-center">
        {{-- sidebar --}}
        <div class="layout-sidebar flex-auto">
            @include('components.new.sidebar')
        </div>
        {{-- pages --}}
        <div class="layout-pages flex-auto w-full h-screen overflow-y-auto">
            {{-- header --}}
            @include('components.new.header')
            @yield('content')
        </div>
    </div>
    @include('components.new.modal.logout');
</body>
    {{-- javascript plugins --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="{{ asset('plugins/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('') }}vendor/sweetalert-master/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="{{asset('assets/js/sweetalert2.js')}}"></script>

    {{-- app.js is custom global js --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- inject javascript from view  --}}
    @stack('script-inject')
</html>
