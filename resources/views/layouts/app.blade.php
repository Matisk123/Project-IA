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
    </head>
    <body class="font-sans antialiased text-slate-300 bg-slate-950 min-h-screen relative overflow-x-hidden selection:bg-indigo-500 selection:text-white">
        <!-- Ambient Background (reused from welcome) -->
        <div class="blob top-[-10%] left-[-5%] pointer-events-none fixed"></div>
        <div class="blob-2 pointer-events-none fixed"></div>
        <div class="fixed inset-0 bg-slate-950/70 z-[-1] pointer-events-none"></div>
        <div class="fixed inset-0 bg-pattern z-[-2] opacity-50 pointer-events-none"></div>

        <div class="relative z-10 min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="glass-nav relative z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white font-bold">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow w-full">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
