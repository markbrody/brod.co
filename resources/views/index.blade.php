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
                    <span class="ml-2"><a href="#">8 comments</a></span>
                </div>
                <div class="mb-2">{{ $article->description }}</div>
                <a href='{{ $article->url }}'>Read More &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
