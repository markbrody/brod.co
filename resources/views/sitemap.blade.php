<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($urls as $url)
    <url>
        <loc>{{ $url->loc }}</loc>
        <lastmod>{{ $url->lastmod }}</lastmod>
        <priority>{{ $url->priority }}</priority>
        <changefreq>{{ $url->changefreq }}</changefreq>
    </url>
@endforeach
</urlset>
