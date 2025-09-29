<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Space+Grotesk:wght@400;500;700" onload="this.rel='stylesheet'" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-slate-200">
        <!-- Outer flex container -->
        <div class= "flex flex-col">

            <!-- Header / Navigation -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <main class= "flex-1 overflow-y-auto p-6 lg:p-10">
                
                <!-- Page Heading -->
                @isset($header)
                    <div class="{{ $headerClass ?? 'max-w-7xl' }} mx-auto">
                        {{ $header }}                       
                    </div>
                @endisset

                <!-- Page slot content -->
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
