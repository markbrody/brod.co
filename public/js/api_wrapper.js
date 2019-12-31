$.extend({
    ajax_api: function(args) {
        var options = $.extend({
            dataType: "json",
            cache: false,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
            },
            error: function() {
                alert("An unknown error has occurred.");
            },
        }, args);
        return $.ajax(options);
    }
});

