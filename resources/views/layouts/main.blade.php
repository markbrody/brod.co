@extends("layouts.base")

@section("head")
<link rel="stylesheet" href="{{ asset('css/highlight.css') }}">
@if (isset($articles))
    @foreach($articles as $prefetch)
    @if($prefetch->hero_url)
    <link rel="prefetch" href="{{ $prefetch->hero_url }}">
    @endif
    @endforeach
@endif

<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/favicon/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/favicon/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('images/favicon/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('images/favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
@endsection

@section("template")
<div class="main-container container-fluid pb-4">
    <div class="container">
        @include("layouts.header")
        @yield("page_title")
        @yield("content")
        @if(isset($nav_links))
        <div class="row border-top">
            <div class="col-12 text-right pt-5">
                @if($nav_links->newer)
                <a class="btn btn-outline-secondary mr-2" href="{{ $nav_links->newer }}">
                @else
                <a class="btn btn-outline-secondary mr-2 disabled" href="javascript:;" disabled>
                @endif
                    <span class="mdi mdi-chevron-left"></span>
                    Newer
                </a>
                @if($nav_links->older)
                <a class="btn btn-outline-secondary" href="{{ $nav_links->older }}">
                @else
                <a class="btn btn-outline-secondary disabled" href="javascript:;" disabled>
                @endif
                    Older
                    <span class="mdi mdi-chevron-right"></span>
                </a>
            </div>
        </div>
        @endif
        @yield("additional")
        <footer class="text-center mt-5">
            <small class="text-muted">Copyright &copy; 2017-{{ date("Y") }} &nbsp; {{ config("app.name") }}</small>
        </footer>
        <div id="cookie-container" class="cookie-container" style="display:none">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="mt-2">
                            By using this site, you agree to its use of cookies.
                            <br>
                            <a href="{{ route('privacy') }}">Privacy Policy</a>
                        </span>
                        <button id="accept-cookies-button" type="button" class="btn btn-sm btn-outline-secondary ml-4">Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="search-results" class="list-group search-results rounded shadow" style="display:none"></div>
    <template id="search-result-template">
        <div>
            <a href="#" class="template-link list-group-item list-group-item-action flex-column align-items-start">
                <h5 class="template-headline mb-1"></h5>
                <p class="template-description mb-1"></p>
                <div class="d-flex w-100 justify-content-between">
                    <small class="template-published text-muted"></small>
                    <small class="text-primary">Read More &rarr;</small>
                </div>
            </a>
        </div>
    </template>
</div>
@include("layouts.left_nav")
@yield("modal")
@yield("scripts")
{!! App\Disqus::counter() !!}
<script>
$(document).ready(function() {

    var accepts_cookies = function() {
        var cookies = decodeURIComponent(document.cookie).split(";");
        for (var i=0; i<cookies.length; i++) {
            if (cookies[i].indexOf("_cookies") !== -1)
                return true;
        }
        return false;
    }

    if (!accepts_cookies()) {
        setTimeout(function() {
            $("#cookie-container").fadeIn();
        }, 1000);
    }

    $("#accept-cookies-button").on("click", function() {
        $.ajax({
            url: "/ajax/cookies",
            type: "GET",
            dataType: "json",
            success: function(response) {
                $("#cookie-container").fadeOut();
            },
            error: function() {
                alert("An error occurred.");
            },
        });
    });
});
</script>
@endsection
