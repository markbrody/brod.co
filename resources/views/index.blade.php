@extends("layouts.main")

@section("content")
@foreach($articles as $article)
<div class="article-item card shadow-sm mx-auto mb-4">
    @if($article->hero_url)
    <a href="{{ $article->url }}"><img class="w-100" src="{{ $article->hero_url }}" alt="{{ $article->headline }}"></a>
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
@endforeach
<div class="row my-5">
    <div class="col-12 text-right">
        <button class="btn btn-outline-secondary mr-2">
            <span class="mdi mdi-chevron-left"></span>
            Newer
        </button>
        <button class="btn btn-outline-secondary">
            Older
            <span class="mdi mdi-chevron-right"></span>
        </button>
    </div>
</div>
@endsection
