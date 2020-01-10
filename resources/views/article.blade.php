@extends("layouts.main")

@section("content")
<div class="d-flex justify-content-between text-left mb-2 pb-2">
    <div class="flex-grow">
        <h3 id="page-title mt-4">{{ $article->headline }}</h3>
        <small class="text-muted">
            <span class="mr-2">Published {{ $article->created }}</span> &bull;
            <span class="mx-2">{{ $article->read_time }} min read</span> &bull;
            <span class="ml-2">
                <a class="text-lowercase" href="{{ $article->url . '#disqus_thread' }}" data-disqus-identifier="{{ $article->id }}">0 comments</a>
            </span>
        </small>
        <br><br>
        @if($article->tags->count() > 0)
        Tags:
        @foreach($article->tags as $tag)
            <a class="badge badge-secondary ml-1" href="{{ route('tags', $tag->name) }}">{{ $tag->name }}</a>
        @endforeach
        @endif
    </div>
    @if(Auth::check())
    <div class="flex-shrink">
        <a class="btn btn-outline-secondary" target="_new" href="{{ route('edit', $article->id) }}">Edit</a>
    </div>
    @endif
</div>
@if($article->hero_url)
<div class="jumbotron jumbotron-fluid p-0">
    <div class="container p-0">
        <img {!! $article->object_position !!} class="hero w-100 rounded" src="{{ $article->hero_url }}">
    </div>
</div>
@endif
@if($article->subheading)
<div class="container">
    <div class="row">
        <div class="col pb-4">
            <h5>{{ $article->subheading }}</h5>
        </div>
    </div>
</div>
@endif
<div class="container border-top">
    <div class="row">
        <div class="col article-container">
            {{ $article->html }}
        </div>
    </div>
    <a name="disqus_thread"></a>
    <div id="disqus_thread" class="mt-5"></div>
</div>
@endsection

@section("additional")
<div class="container">
    <div class="row">
        <div class="col">
            <h5>More Articles</h5>
        </div>
    </div>
    <div class="row">
        @foreach($article->more as $more)
        <div class="col-12 col-md-6 col-xl-4 mb-4">
            <div class="card">
                @if($more->hero_url)
                <div class="w-100 p-1">
                    <a href="{{ $more->url }}"><img class="w-100 rounded" src="{{ $more->hero_url }}" alt="{{ $more->headline }}"></a>
                </div>
                @endif
                <div class="card-body">
                    <div>
                        {{ $more->headline }}
                    </div>
                    <small class="text-muted">{{ $more->created }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section("scripts")
{!! (new App\Disqus($article))->comments() !!}
@endsection
