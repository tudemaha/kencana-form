<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Kencana Wisata' }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="fi bg-gray-50 text-gray-900 antialiased">
        {{ $slot }}

        @filamentScripts
    </body>
</html>
