@extends('layouts.external')
@section('page-title', $album->title . ' — Photography | Matthew Schlachter')
@section('meta-description', 'See the ' . $album->title . ' album, full of photos from my adventures in photography')

@section('scripts')
@parent
<style type="text/css">
    .hero-image {
        background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
            url(<?= getRandomMediaUrl($album) ?>);
    }

</style>
@endsection

@section('content')
<div class="tiles-section">
    <a href="{{ route('albums.all') }}">
        <i class="fas fa-chevron-left mr-2"></i>Back to all albums
    </a>
    <h2>
        {{ $album->title }}
    </h2>
    <div class="image-tiles">
        @foreach($album->images as $image)
        <a id="image-{{ $image->id }}" href="{{ route('albums.image.show', compact('album', 'image')) }}" class="image-tile" style="background-image: url({{ getMediaUrlForSize($image) }});">
            <span class="image-title">
                {{ $image->title }}
            </span>
            <span class="image-date">
                {{ $image->date }}
            </span>
        </a>
        @endforeach
    </div>
</div>
@endsection
