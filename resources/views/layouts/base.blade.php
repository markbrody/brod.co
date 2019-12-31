<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield("title", config("app.name"))</title>
        <link href="https://fonts.googleapis.com/css?family=Orbitron|Lato&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        @yield("head")
        <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/menu_functions.js') }}"></script>
        <script src="{{ asset('js/api_wrapper.js') }}"></script>
    </head>
    <body>
        @yield("template")
    </body>
</html>

