{{-- Layout comune per tutte le azioni di autenticazione (login, registrazione, profilo, reset password, verifica email...) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Welcome to Hotel-Museo') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Lobster&family=Lora:wght@400;600&family=Parisienne&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Scripts -->
        @vite(entrypoints: ['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-testo bg-sfondo text-white antialiased">
        <header class="p-4">
            <a href="javascript:history.back()" class="inline-flex items-center text-sm text-white/80 hover:text-white transition px-4 py-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Torna indietro
            </a>
        </header>

        <div>
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
