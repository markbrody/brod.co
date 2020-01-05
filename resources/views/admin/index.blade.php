@extends("layouts.main")

@section("content")
<div class="d-flex justify-content-between text-left border-bottom pb-2">
    <div class="flex-grow">
        <h3 id="page-title">Admin</h3>
    </div>
    <div class="flex-shrink">
        <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#new-article-modal">Add New</button>
        <a class="btn btn-outline-secondary" href="{{ route('assets') }}">Manage Assets</a>
    </div>
</div>
<div class="row">
@foreach($articles as $article)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card mt-3">
            <img class="card-img-top" src="{{ $article->hero_url }}">
            <div class="card-body pt-1">
                <div class="form-row mt-2">
                    <div class="col-12">
                        <span style="font-size:1.1rem">{{ $article->headline }}</span>
                        <div class="d-flex">
                            <small class="text-muted mr-auto">by {{$article->user->name }} on {{ $article->created }}</small>
                        @if ($article->is_published)
                            <small class="article-status-icon cursor-pointer ml-1 mdi mdi-earth text-primary"
                                data-id="{{ $article->id }}" data-name="is_published" data-value="{{ (int) $article->is_published }}"
                                data-toggle="tooltip" data-placement="top" title="Published"></small>
                        @else
                            <small class="article-status-icon cursor-pointer ml-1 mdi mdi-earth-off text-darkgray"
                                data-id="{{ $article->id }}" data-name="is_published" data-value="{{ (int) $article->published }}"
                                data-toggle="tooltip" data-placement="top" title="Unpublished"></small>
                        @endif
                        </div>
                        <hr>
                        {{-- <span style="font-size:.9rem" class="my-2">{{ preg_replace("/^[\W]+/S", "", $article->description) }}</span> --}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-lg-6 col-12 mt-2">
                        <a class="btn btn-sm btn-block btn-primary" href='{{ route("admin") . "/$article->id" }}'>Edit</a>
                    </div>
                    <div class="col-lg-6 col-12 mt-2">
                        <a class="btn btn-sm btn-block btn-outline-secondary" href='{{ url("preview/$article->slug") }}'>Preview</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection

@section("modal")
<div class="modal fade" id="new-article-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between text-left border-bottom mb-2 pb-2" data-toggle="modal" data-target="#new-article-modal">
                    <div class="flex-grow">
                        <h3>New Article</h3>
                    </div>
                    <div class="flex-shrink">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="headline-input">Headline</label>
                            <input type="text" class="form-control form-control-lg" id="headline-input" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="subheading-input">Subheading</label>
                            <input type="text" class="form-control form-control-lg" id="subheading-input" value="">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="markdown-textarea">Body</label>
                        <a target="_blank" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">(markdown)</a>
                        <textarea id="markdown-textarea" class="form-control text-monospace" rows="20"></textarea>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-12 text-center">
                        <input type="hidden" id="csrf-token-input" value="{{ csrf_token() }}">
                        <button type="button" class="btn btn-lg btn-primary btn-block" id="add-article-button">Add Article</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
    $("body").tooltip({
        selector: "[data-toggle='tooltip']",
    });

    $("#add-article-button").on("click", function() {
        $.ajax_api({
            type: "POST",
            url: "/api/articles",
            dataType: "json",
            data: {
                headline: $("#headline-input").val(),
                subheading: $("#subheading-input").val(),
                markdown: $("#markdown-textarea").val(),
            },
            success: function(response) {
                if (response.id) {
                    $("#order-modal").modal("toggle");
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                }
                else
                    alert(response.message);
            },
            error: function(response) {
                alert(response.responseText || "An error occurred.");
                console.log(response);
            },
        });
    });

    $(".article-status-icon").on("click", function() {
        $.ajax_api({
            type: "PUT",
            url: "/api/articles/" + $(this).data("id"),
            data: {
                [$(this).data("name")]: $(this).data("value") ? 0 : 1, // toggle
            },
            success: function(response) {
                window.location.reload();
            },
        });
    });
</script>
@endsection
