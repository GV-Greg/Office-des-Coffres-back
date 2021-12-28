<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-gray-800">
        @include('sweetalert::alert')
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="shadow">
                <div class="w-full h-13 mb-1 p-4 flex items-center justify-center left-16 sm:left-0">
                    <h2 class="font-semibold text-2xl leading-none -mb-4">
                        {{ $header }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                @include('layouts.sidebar')
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
