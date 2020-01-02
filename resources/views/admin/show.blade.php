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
        <div class="col-md-6">
            <div class="row">
                <div class="col-12">
                    <label for="tags-input">Tags</label>
                    <div class="position-relative" style="height:60px">
                        <div class="position-absolute w-100">
                            <input id="tags-input" class="form-control form-control-lg" style="top:0;left:0" type="text" placeholder="Search tags">
                        </div>
                        <div id="add-tag-button-container" class="position-absolute p-3" style="top:0;right:0;display:none">
                            <span id="add-tag-button" class="mdi mdi-plus-circle-outline text-muted"></span>
                        </div>
                        <ul id="tag-search-results" class="list-group" style="display:none;padding-top:50px"></ul>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div id="tags-container" class="col-12">
                @foreach ($article->tags as $tag)
                <button type="button" class="btn btn-sm btn-light m-1">
                    <span class="mx-1">{{ $tag->name }}</span>
                    <span class="mdi mdi-close delete-tag" data-id="{{ $tag->id }}"></span>
                </button>
                @endforeach
                </div>
            </div>
        </div>
        <div id="image-upload-target" class="col-md-6 bg-white rounded" style="z-index:20;">
            <label for="">Image (recommended 1200x400)</label>
            <div style="position:relative;background-color:#fff;border-style:dashed!important" class="text-center mr-4 mb-3 ml-4 pt-3 pb-2 border">
                <input type="file" name="image" id="hidden-file-input" class="hidden-file-input">
                <div id="thumbnail-container" style="position:relative;width:260px;height:65px;margin:auto;cursor:pointer;">
                    <img style="width:260px;height:65px" class="hero-thumbnail bg-light border" id="image-upload-thumbnail" src="{{ $article->thumbnail_url }}">
                    <div id="image-upload-label" class="image-upload-label" style="display:none">Upload New</div>
                </div>
                <div style="width:250px;height:2px;margin:auto" id="progressbar-container" class="progress mt-2 bg-white">
                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width:0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
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
    var article_id = "{{ $article->id }}";
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

    $("#tags-input").on("keyup", function() {
        $("#tag-search-results").empty();
        if ($(this).val().length > 1)
            $.ajax_api({
                type: "GET",
                url: "/api/tags?search=" + $(this).val(),
                success: function(response) {
                    if (response.length == 0) {
                        $("#add-tag-button-container").show();
                    }
                    else {
                        $("#add-tag-button-container").hide();
                        $("#tag-search-results").show();
                        for (var i=0; i<response.length; i++) {
                            var html = '<li class="tag-search-result list-group-item list-group-item-action" '
                                     + 'data-id="' + response[i].id + '" '
                                     + 'data-name="' + response[i].name + '">' + response[i].name + '</li>';
                            $("#tag-search-results").append(html);
                            
                        }
                    }
                }
            });
    });

    $("#add-tag-button").on("click", function() {
        if ($("#tags-input").val().length > 1) {
            $.ajax_api({
                type: "POST",
                url: "/api/tags",
                data: {
                    name: $("#tags-input").val(),
                },
                success: function(response) {
                    var tag = {
                        id: response.id,
                        name: response.name,
                    };
                    $.ajax_api({
                        type: "POST",
                        url: "/api/articles/" + article_id + "/tags",
                        data: {
                            id: tag.id,
                        },
                        success: function() {
                            var html = '<button type="button" class="btn btn-sm btn-light m-1">'
                                     + '<span class="mx-1">' + tag.name + '</span>'
                                     + '<span class="mdi mdi-close delete-tag" data-id="' + tag.id + '"></span>'
                                     + '</button>';
                            $("#tags-container").append(html);
                            $("#tags-input").val("");
                            $("#add-tag-button-container").hide();
                        },
                    });
                },
            });
        }
    });

    $(document).on("click", ".tag-search-result", function() {
        var tag = {
            id: $(this).data("id"),
            name: $(this).data("name"),
        };
        $.ajax_api({
            type: "POST",
            url: "/api/articles/" + article_id + "/tags",
            data: {
                id: tag.id,
            },
            success: function() {
                var html = '<button type="button" class="btn btn-sm btn-light m-1">'
                         + '<span class="mx-1">' + tag.name + '</span>'
                         + '<span class="mdi mdi-close delete-tag" data-id="' + tag.id + '"></span>'
                         + '</button>';
                $("#tags-container").append(html);
                $("#tags-input").val("");
                $("#tag-search-results").empty();
                $("#tag-search-results").hide();
            },
        });
    });

    $(document).on("click", ".delete-tag", function() {
        var self = $(this);
        if (confirm("Do you want to delete this tag?"))
            $.ajax_api({
                url: "/api/articles/" + article_id + "/tags/" + $(this).data("id"),
                type: "DELETE",
                success: function(response) {
                    self.closest(".btn").remove();
                },
            });
    });
</script>
@endsection
