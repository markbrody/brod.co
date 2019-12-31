@extends("layouts.main")

@section("content")
<div class="text-left border-bottom mb-4 pb-2">
    <h3 class="page-title">{{ $article->headline }}</h3>
    <a target="_new" href='{{ url("preview/$article->slug") }}'>{{ url("preview/$article->slug") }}</a>
</div>
<div>
    <form method="POST" action="{{ url()->current() }}">
    @if ($errors->any())
    <div class="row">
        <div class="col">
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        </div>
    </div>
    @endif
    <div class="form-row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="article-headline-input"">Headline</label>
                <input type="text" name="headline" class="form-control form-control-lg @error('headline') is-invalid @enderror" id="article-headline-input" value="{{ $article->headline }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="article-subheading-input"">Subheading</label>
                <input type="text" name="subheading" class="form-control form-control-lg @error('subheading') is-invalid @enderror" id="article-subheading-input" value="{{ $article->subheading }}">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="article-markdown-textarea">Body</label>
            <a target="_blank" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">(markdown)</a>
            <textarea name="markdown" id="article-markdown-textarea" class="form-control text-monospace mb-2 @error('markdown') is-invalid @enderror" rows="20">{{ $article->markdown }}</textarea>
        </div>
    </div>
    <div class="form-row mt-2">
        <div id="image-upload-target" class="col-md-7 bg-white rounded" style="z-index:20;">
            <label for="">Image (recommended 1250x650)</label>
            <div style="position:relative;background-color:#fff;border-style:dashed!important" class="text-center mr-4 mb-3 ml-4 pt-3 pb-2 border">
                <input type="file" name="image" id="hidden-file-input" class="hidden-file-input">
                <div id="thumbnail-container" style="position:relative;width:250px;height:130px;margin:auto;cursor:pointer;">
                    <img style="width:250px;height:130px" class="hero-thumbnail bg-light border" id="image-upload-thumbnail" src="{{ $article->thumbnail_url }}">
                    <div id="image-upload-label" class="image-upload-label" style="display:none">Upload New</div>
                </div>
                <div style="width:250px;height:2px;margin:auto" id="progressbar-container" class="progress mt-2 bg-white">
                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width:0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <label for="">Visibility</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_published" id="is-published-1" value="1" {{ $article->is_published ? "checked" : "" }}>
                <label class="form-check-label" for="is-published-1">Published</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_published" id="is-published-0" value="0" {{ $article->is_published ? "" : "checked" }}>
                <label class="form-check-label" for="is-published-0">Unpublished</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-row mt-2">
        <div class="col-12 text-center">
            <input type="hidden" id="csrf-token-input" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-lg btn-primary btn-block" id="update-article-button">Update</button>
        </div>
    </div>
    </form>
</div>
@endsection

@section("scripts")
<script src="{{ asset('js/drag_and_drop.js') }}"></script>
<script src="{{ asset('js/progress_bar.js') }}"></script>
<script>
    var upload_url = '{{ url("ajax/hero/$article->id") }}';
    var csrf = $("#csrf-token-input").val();
    var progressbar_options = {
        bar: "#progress-bar",
        container: "#progressbar-container",
        height: "2px",
        animated: true,
        width: 0,
    };
    let progress_bar = new ProgressBar(progressbar_options);
    $("#thumbnail-container").on("mouseover mouseout", function() {
        $("#image-upload-label").toggle();
    });
</script>
@endsection
