{!! '<?xml version="1.0" encoding="utf-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
  <url>
    <loc>{{ route('home') }}</loc>
    <lastmod>{{ date(DateTime::ATOM, File::lastModified(base_path() . '/resources/views/welcome.blade.php')) }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1</priority>
  </url>
  <url>
    <loc>{{ route('albums.all') }}</loc>
    <lastmod>{{ App\Album::orderByDesc('updated_at')->pluck('updated_at')->first()->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
  </url>
  <url>
    <loc>{{ route('images.all') }}</loc>
    <lastmod>{{ App\Image::orderByDesc('updated_at')->pluck('updated_at')->first()->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
  </url>
    @foreach(App\Album::all() as $album)
  <url>
    <loc>{{ route('albums.show', compact('album')) }}</loc>
    <lastmod>{{ $album->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.80</priority>
  </url>
    @endforeach
    @foreach(App\Image::all() as $image)
    @php $album = $image->album @endphp
  <url>
    <loc>{{ route('albums.image.show', compact('album', 'image')) }}</loc>
    <lastmod>{{ $image->updated_at->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1</priority>
    <image:image>
        <image:loc>{{ $image->getFirstMediaUrl('image') }}</image:loc>
        <image:title>{{ $image->title }}</image:title>
    </image:image>
  </url>
    @endforeach
</urlset>