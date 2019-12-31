<script>
    var disqus_config = function() {
        this.page.url = "{{ $article->url }}"
        this.page.identifier = "{{ $article->id }}";
    };
    (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://brod-co.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
