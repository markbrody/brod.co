<?xml version="1.0" encoding="UTF-8"?>
<urlset>
@foreach($urls as $url)
    <url>
        <loc>{{ $url->loc }}</loc>
        <lastmod>{{ $url->lastmod }}</lastmod>
        <priority>{{ $url->priority }}</priority>
        <changefreq>{{ $url->changefreq }}</changefreq>
    </url>
@endforeach
</urlset>
