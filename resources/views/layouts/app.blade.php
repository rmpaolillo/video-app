<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Centro di Formazione, Formazione continua professionisti" />
    <meta name="description" content="" />
    <title>
        MGA Consulting Srl | Formazione
    </title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css'])
    <!-- ==== WOW JS ==== -->
    {{-- <script src="assets/js/wow.min.js"></script> --}}

    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body>

    {{ $slot }}

    @livewireScripts
</body>

</html>
