<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pergudangan </title>
        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" />

        @include('layouts.style')
        </head>
    <body>
        @include('layouts.nav')

        <main>
            <div class="mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
            
        </main>
        
        @stack('after-scripts')
    </body>
</html>
