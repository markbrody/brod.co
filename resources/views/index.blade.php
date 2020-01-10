@extends("layouts.main")

@if(isset($tag_name))
@section("page_title")
<h4 class="mb-3">Articles tagged with: <strong>{{ $tag_name }}</strong></h4>
@endsection
@endif

@section("content")
@forelse($articles as $article)
<div class="article-item card shadow-sm mx-auto mb-4">
    @if($article->hero_url)
    <div class="w-100 p-1">
        <a href="{{ $article->url }}"><img {!! $article->object_position !!} class="hero w-100 rounded" src="{{ $article->hero_url }}" alt="{{ $article->headline }}"></a>
    </div>
    @endif
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h5 class="article-item-title"><a class="text-dark" href='{{ $article->url }}'>{{ $article->headline }}</a></h5>
                <div class="text-muted mb-1">
                    <span class="mr-2">Published {{ $article->created }}</span> &bull;
                    <span class="mx-2">{{ $article->read_time }} min read</span> &bull;
                    <span class="ml-2"><a class="text-lowercase" href="{{ $article->url }}#disqus_thread" data-disqus-identifier="{{ $article->id }}">0 comments</a></span>
                </div>
                <div class="mb-2">{{ $article->description }}</div>
                <a href='{{ $article->url }}'>Read More &rarr;</a>
            </div>
        </div>
    </div>
</div>
@empty
<h3 class="mt-4">No results found</h3>
@endforelse
@endsection
