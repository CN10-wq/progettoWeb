{{-- Layout comune alle pagine visibili agli utenti guest (es. welcome, camere-list, camera-details). 
     Include navbar, font e gestione di librerie esterne --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Back To Beauty Hotel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cookie&family=Lobster&family=Lora:wght@400;600&family=Parisienne&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500&family=Italianno&family=Mulish:wght@400;600&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Flickity CSS & JS: stile carousel per la galleria della welcome-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flickity@2/dist/flickity.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flickity@2/dist/flickity.pkgd.min.js"></script>

        <!-- baguetteBox CSS & JS: crea lightbox per immagini-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js" defer></script>

        <!-- Scripts -->
        @vite(entrypoints: ['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-testo bg-sfondo text-white antialiased">
        <header>
            @if (Route::has('login'))
                @include('partials.guest-navbar')
            @endif
        </header>

        <div>
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
