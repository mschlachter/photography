@extends('layouts.external')
@section('page-title', buildPageTitle($album->title))
@section(
    'meta-description', 
    __(
        config('settings.album_details_meta_description', 'View the ":albumTitle" album, with photos taken by :authorName'),
        [
            'albumTitle' => $album->title,
            'authorName' => config('settings.author_name', 'Author Name'),
        ]
    )
)

@php
$image = $album !== null && $album->defaultImage !== null ?
        $album->defaultImage : null;
@endphp

@if($image)
@section('styles')
@parent
<meta property="og:site_name" content="{{ config('settings.site_name', 'Photography | Author Name') }}">
<meta property="og:image" content="{{ $image->getFirstMediaUrl('image') }}">
<meta name="twitter:image:alt" content="{{ $image->alt }}">
@endsection
@endif

<x-header-image-background :album="$album"/>

@section('content')
<div class="tiles-section">
    <a href="{{ route('albums.all') }}">
        <svg style="width:.625em;vertical-align:-.125em;" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left fa-w-10 mr-2" role="img" viewBox="0 0 320 512"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"/></svg>Back to all albums
    </a>
    <div style="float: right;">
        <x-share/>
    </div>
    <h2>
        {{ $album->title }}
    </h2>
    <div class="image-tiles">
        @foreach($album->images as $image)
        <a id="image-{{ $image->id }}" href="{{ route('albums.image.show', compact('album', 'image')) }}" class="image-tile" style="background-image: url('{{ getMediaUrlForSize($image) }}');">
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
