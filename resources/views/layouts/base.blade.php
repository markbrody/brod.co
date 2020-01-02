<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        @if (isset($open_graph))
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $open_graph->title ?? config('app.name') }}">
        <meta property="og:url" content="{{ $open_graph->url ?? url('') }}">
        <meta property="og:image" content="{{ $open_graph->image ?? asset('/images/og-wide.png') }}">
        <meta property="og:description" content="{{ $open_graph->description ?? 'Musings of development, computing, astronomy, and life.' }}">
        @else
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ config('app.name') }}">
        <meta property="og:url" content="{{ url('') }}">
        <meta property="og:image" content="{{ asset('/images/og-wide.png') }}">
        <meta property="og:description" content="Musings of development, computing, astronomy, and life.">
        @endif
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
        {!! GoogleAnalytics::show() !!}
    </body>
</html>

