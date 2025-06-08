<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Gaya untuk background gambar */
        .background-overlay {
            background: url('{{ asset('images/kantor.jpg') }}') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        /* Overlay Transparan */
        .background-overlay::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(7, 63, 151, 0.85);
            /* #073f97 dengan transparansi 70% */
            z-index: 1;
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
            /* Pastikan konten ada di atas overlay */
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Container Utama -->
    <div class="min-h-screen flex items-center justify-center background-overlay">
        <!-- Wrapper untuk Tengah -->
        <div class="flex items-center justify-center w-3/4 mx-auto content-wrapper">
            <!-- Kontainer Logo (Kiri) -->
            <div class="flex-1 flex justify-center items-center">
                <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="w-3/4 md:w-2/3 lg:w-1/2 h-auto">
            </div>

            <!-- Card Login (Kanan) -->
            <div class="flex-1 flex justify-center">
                <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
