@extends("layouts.main")

@section("content")
<div class="text-left mb-2">
    <h3 class="mt-4">{{ $article->headline }}</h3>
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
        <span class="badge badge-secondary ml-1">{{ $tag->name }}</span>
    @endforeach
    @endif
</div>
@if($article->hero_url)
<div class="jumbotron jumbotron-fluid p-0">
    <div class="container p-0">
        <img class="img-fluid" src="{{ $article->hero_url }}">
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
        <div class="col pt-4 article-container">
            {{ $article->html }}
        </div>
    </div>
    <hr class="hero-hr my-5">
    <a name="disqus_thread"></a>
    <div id="disqus_thread"></div>
</div>
@endsection

@section("scripts")
{!! (new App\Disqus($article))->comments() !!}
@endsection
