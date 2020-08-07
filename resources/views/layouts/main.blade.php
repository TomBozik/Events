<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->

        <link href="/css/main.css" rel="stylesheet">
    </head>

    <body>
        <div id="app">
            <main>
                @yield('content')
            </main>
        </div>
        @include('cookieConsent::index')
    </body>
</html>

<script src="/js/app.js"></script>