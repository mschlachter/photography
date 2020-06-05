{!! '<?xml version="1.0" encoding="UTF-8" ?>' !!}
{!! '<?xml-stylesheet href="xsl/rss.xsl" type="text/xsl" media="screen"?>' !!}
<rss version="2.0">
    <channel>
        <title>Photography | Matthew Schlachter</title>
        <link>{{ url('/') }}</link>
        <description>Photography by Matthew Schlachter</description>
        <language>en</language>
        <pubDate>{{ App\Image::orderByDesc('updated_at')->pluck('updated_at')->first()->toAtomString() }}</pubDate>
        <lastBuildDate>{{ App\Image::orderByDesc('updated_at')->pluck('updated_at')->first()->toAtomString() }}</lastBuildDate>
        @foreach($albums as $album)
        <item>
            <title>{{ $album->title }}</title>
            <link>{{ route('albums.show', compact('album')) }}</link>
            <description><![CDATA[
@foreach($album->images as $image)
@php
$media = $image->getFirstMedia('image');
$webp = $media->hasGeneratedConversion('webp') && $media->getGeneratedConversions()['webp'];
@endphp
<a href="{{ route('albums.image.show', compact('album', 'image')) }}" style="display: inline-block; max-width: 300px;">
    <figure>
        <picture>
            @if($webp !== false)
            <source srcset="{{ $media->getSrcset('webp') }}" type="image/webp" sizes="300px">
            @endif
            <source srcset="{{ $media->getSrcset() }}" type="{{ $media->mime_type }}" sizes="300px">
            <img src="{{ $media->getUrl() }}" alt="{{ $image->alt }}" style="max-width: 100%;" />
        </picture>
        <figcaption>
            {{ $image->title }}
        </figcaption>
    </figure>
</a>
@endforeach
]]></description>
        <pubDate>{{ $album->created_at->toAtomString() }}</pubDate>
        </item>
        @endforeach
    </channel>
</rss>
