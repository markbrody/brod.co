class ProgressBar
{
    constructor(options) {
        this.bar = $(options.bar);
        this.container = options.container;
        this.height = options.height || 5;
        this.animated = options.animated || false;
        this.width = options.width || 0;
        this.init();
    }

    init() {
        $(this.container).height(this.height);
        $(this.bar).width(this.width + "%");
        if (this.animated)
            $(this.bar).addClass("progress-bar-striped progress-bar-animated");
        else
            $(this.bar).removeClass("progress-bar-striped progressbar-animated");
    }

    update(width) {
        this.width = width;
        $(this.bar).width(this.width + "%");
        if (this.width <= 0 || this.width >= 100) {
            var self = this;
            setTimeout(function() {
                $(self.bar).width(0);
                $(self.container).addClass("invisible");
            }, 300);
        }
        else
            $(this.container).removeClass("invisible");
    }
}

