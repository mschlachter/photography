@extends('layouts.external', ['showHero' => false, 'canonicalURL' => getCanonical(route('albums.image.show', ['album' => $image->album, 'image' => $image]))])
@section('page-title', $image->title . ' — Photography | Matthew Schlachter')
@section('meta-description', $image->alt)

@section('styles')
@parent
<meta property="og:site_name" content="Photography | Matthew Schlachter">
<meta property="og:image" content="{{ $image->getFirstMediaUrl('image') }}">
<meta name="twitter:image:alt" content="{{ $image->alt }}">
@endsection

@section('content')
<div class="image-viewer">
    <x-picture :image="$image" class="current-image"></x-picture>

    <a class="back-link" href="{{ route('images.all') }}#image-{{ $image->id }}">
        <i class="far fa-times-circle fa-3x align-middle mr-2"></i>Back to Images
    </a>
    @if($previous !== null)
    <a class="prev-link" href="{{ route('images.show', ['image' => $previous]) }}">
        <i class="far fa-arrow-alt-circle-left fa-3x align-middle mr-2"></i>Previous
    </a>
    @endif
    @if($next !== null)
    <a class="next-link" href="{{ route('images.show', ['image' => $next]) }}">
        Next<i class="far fa-arrow-alt-circle-right fa-3x align-middle ml-2"></i>
    </a>
    @endif
</div>
<div class="container container-fluid image-details">
    <h2>
        Meta info
    </h2>
    <p>
        Title: {{ $image->title }}
    </p>
    <p>
        Date: {{ $image->date }}
    </p>
    <p>
        Album: 
        <a href="{{ route('albums.show', ['album' => $image->album]) }}#image-{{ $image->id }}">{{ $image->album->title }}</a>
    </p>
    <x-comments :pageId="'photography/images/' . $image->id"></x-comments>
</div>
@endsection
