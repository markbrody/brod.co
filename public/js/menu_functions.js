$(function() {
    $("#main-nav-menu-icon").on("click", function() {
        if ($("#left-nav").is(".slide-left-nav-in, .slide-left-nav-out"))
            $("#left-nav").toggleClass("slide-left-nav-in slide-left-nav-out");
        else
            $("#left-nav").addClass("slide-left-nav-in");
    });
    
    $("#main-nav-search-icon").on("click", function() {
         $("#main-nav-search").addClass("slide-search-down");
         $("#main-nav-search-input").focus();
    });
    
    $("#cancel-search-icon").on("click", function() {
         $("#main-nav-search-input").val("");
         $("#main-nav-search").toggleClass("slide-search-down slide-search-up");
            $("#search-results").hide();
        setTimeout(function() {
            $("#main-nav-search").removeClass("slide-search-up");
        }, 200);
    });

    $(document).keyup(function(e) {
        if (e.key === "Escape" && $("#main-nav-search-input").is(":focus")) {
            $("#main-nav-search-input").val("");
            $("#main-nav-search").toggleClass("slide-search-down slide-search-up");
            $("#search-results").hide();
            setTimeout(function() {
                $("#main-nav-search").removeClass("slide-search-up");
            }, 200);
        }
    });

    $(document).on("keyup", "#main-nav-search-input", function() {
        if ($("#main-nav-search-input").val().length > 2) {
            $("#search-results").show();
            $.ajax_api({
                type: "GET",
                url: "/ajax/search?query=" + $("#main-nav-search-input").val(),
                success: function(response) {
                    if (response.length > 0) {
                        $("#search-results").empty();
                        $("#search-results").show();
                        for (var i=0; i<response.length; i++) {
                            var article = response[i];
                            var template = $($("#search-result-template").html());
                            $(template.find(".template-link")).attr("href", article.url);
                            $(template.find(".template-headline")).text(article.headline);
                            $(template.find(".template-description")).text(article.description);
                            $(template.find(".template-published")).text(article.created);
                            $("#search-results").append(template.html());
                        }
                    }
                    else {
                        $("#search-results").hide();
                    }
                }
            });
        }
        else {
            $("#search-results").hide();
        }
    });
});
