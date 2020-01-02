@extends("layouts.base")

@section("title")
brod.co
@endsection

@section("template")
<div class="main-container container-fluid pb-4">
    <div class="container">
        @include("layouts.header")
        @yield("page_title")
        @yield("content")
        @if(isset($nav_links))
        <div class="row border-top my-5">
            <div class="col-12 text-right py-5">
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
        <footer class="text-center mt-5">
            <small class="text-muted">Copyright &copy; 2017-{{ date("Y") }} &nbsp; {{ config("app.name") }}</small>
        </footer>
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
@endsection
