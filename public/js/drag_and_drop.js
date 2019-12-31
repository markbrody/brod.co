$(function() {
    var append = false;

    var form_data = new FormData();
    form_data.append("_method", "PUT");

    var override = function(evt, callback) {
        evt.preventDefault();
        evt.stopPropagation();
        callback();
    }

    var overlay_on = function() {
        if (!append) {
            append = true;
            $("body").append('<div class="image-upload-overlay"></div>');
        }
    }

    var overlay_off = function() {
        append = false;
        $(".image-upload-overlay").remove();
    }

    var upload = function(form_data) {
        if (progress_bar)
            progress_bar.update(95);
        $.ajax({
            url: upload_url,
            type: "POST",
            dataType: "json",
            data: form_data,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
            },
            success: function(response) {
                if (progress_bar)
                    progress_bar.update(100);
                setTimeout(function() {
                    overlay_off();
                    if (response.id || response.tracking_id)
                        $("#image-upload-thumbnail").attr("src", (response.profile_url || response.thumbnail_url) + "?reload=" + Math.random());
                    else
                        alert(response.error || "An error occurred.");
                }, 500);
            },
            error: function() {
                if (progress_bar)
                    progress_bar.update(100);
                setTimeout(function() {
                    overlay_off();
                    alert("An error occurred.");
                }, 500);
            },
        });
    }

    $("#image-upload-thumbnail, #image-upload-label").on("click", function(){
        $("#hidden-file-input").click();
    });

    $("#hidden-file-input").on("change", function() {
        form_data.append("image", $("#hidden-file-input")[0].files[0]);
        upload(form_data);
    });

    $("html").on("dragenter dragover", function(evt) {
        override(evt, overlay_on);
    });

    $("html").on("dragexit drop", function(evt) {
        override(evt, overlay_off);
    });

    $("#image-upload-target").on("drop", function (evt) {
        override(evt, function() {
            console.log(evt.originalEvent.dataTransfer.files[0]);
            form_data.append("image", evt.originalEvent.dataTransfer.files[0]);
            upload(form_data);
        });
    });

});

