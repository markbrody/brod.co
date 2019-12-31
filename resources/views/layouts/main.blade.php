@extends("layouts.base")

@section("title")
brod.co
@endsection

@section("template")
<div class="main-container container-fluid pb-4">
    <div class="container">
        @include("layouts.header")
        @yield("content")
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
