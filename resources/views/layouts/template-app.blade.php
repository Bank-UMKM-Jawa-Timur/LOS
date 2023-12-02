<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monitoring LOS</title>
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-theme-body font-poppins">
    @yield('modal')
    <div class="layout-wrapper flex justify-center">
        <div class="layout-sidebar flex-auto">
            @include('components.sidebar')
        </div>
        <div class="layout-pages flex-auto w-full h-screen overflow-y-auto">
            {{-- @include('components.header') --}}
            @yield('content')
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('plugins/pusher') }}"></script> --}}
    @stack('script-injection')
</html>