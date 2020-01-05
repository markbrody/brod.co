@extends("layouts.main")

@section("content")
<div class="d-flex justify-content-between text-left border-bottom mb-4 pb-2">
    <div class="flex-grow">
        <h3 id="page-title">Assets</h3>
    </div>
    <div class="flex-shrink">
        <a class="btn btn-outline-secondary" href="{{ route('admin') }}">Go Back</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <h5>Upload New</h5>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="article-select">Article</label>
                <select id="article-select" class="form-control">
                    @foreach($articles as $article)
                    <option value="{{ $article->id }}">{{ $article->headline }}</option>
                    @endforeach
                </select>
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
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <h5>Gallery</h5>
    </div>
</div>
@endsection

@section("scripts")
<script src="{{ asset('js/drag_and_drop.js') }}"></script>
<script src="{{ asset('js/progress_bar.js') }}"></script>
<script>
    var article_id = "{{ $article->id }}";
    var upload_url = "{{ url('ajax/assets/') }}";
    var csrf = $("meta[name=csrf-token]").attr("content");
    var progressbar_options = {
        bar: "#progress-bar",
        container: "#progressbar-container",
        height: "2px",
        animated: true,
        width: 0,
    };
    let progress_bar = new ProgressBar(progressbar_options);

    $("#article-select").on("change", function() {
        upload_url = "{{ url('ajax/assets') }}/" + $(this).val();
        $.ajax_api({
            type: "GET",
            url: "/api/articles/" + $(this).val() + "/assets",
            success: function(response) {
            }
        });
        $(this).blur();
    });
</script>
@endsection
