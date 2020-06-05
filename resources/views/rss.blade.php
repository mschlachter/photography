{!! '<?xml version="1.0" encoding="UTF-8" ?>' !!}
{!! '<?xml-stylesheet href="/xsl/rss.xsl" type="text/xsl" media="screen"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Photography | Matthew Schlachter</title>
        <link>{{ url('/') }}</link>
        <atom:link href="{{ route('rss') }}" rel="self" type="application/rss+xml" />
        <description>Photography by Matthew Schlachter</description>
        <language>en</language>
        <pubDate>{{ App\Image::orderByDesc('updated_at')->pluck('updated_at')->first()->toRssString() }}</pubDate>
        <lastBuildDate>{{ App\Image::orderByDesc('updated_at')->pluck('updated_at')->first()->toRssString() }}</lastBuildDate>
        @foreach($albums as $album)
        <item>
            <guid>{{ route('albums.show', compact('album')) }}</guid>
            <title>{{ $album->title }}</title>
            <link>{{ route('albums.show', compact('album')) }}?utm_source=feed&amp;utm_medium=RSS</link>
            <description><![CDATA[
@foreach($album->images as $image)
@php
$media = $image->getFirstMedia('image');
$webp = $media->hasGeneratedConversion('webp') && $media->getGeneratedConversions()['webp'];
@endphp
<a href="{{ route('albums.image.show', compact('album', 'image')) }}?utm_source=feed&utm_medium=RSS" style="display: inline-block; width: 300px;">
    <figure>
        <picture>
            @if($webp !== false)
            <source srcset="{{ $media->getSrcset('webp') }}" type="image/webp" sizes="220px">
            @endif
            <source srcset="{{ $media->getSrcset() }}" type="{{ $media->mime_type }}" sizes="220px">
            <img src="{{ $media->getUrl() }}" alt="{{ $image->alt }}" style="width: 100%;" />
        </picture>
        <figcaption>
            {{ $image->title }}
        </figcaption>
    </figure>
</a>
@endforeach
]]></description>
        <pubDate>{{ $album->created_at->toRssString() }}</pubDate>
        </item>
        @endforeach
    </channel>
</rss>
