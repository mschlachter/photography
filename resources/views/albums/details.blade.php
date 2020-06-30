@extends('layouts.external')
@section('page-title', buildPageTitle($album->title))
@section('meta-description', 'I photograph flowers, wildlife, and snippets of my daily life in Montreal, Canada. See the [' . $album->title . '] album, full of photos I\'ve taken during my adventures in photography')

@php
$image = $album !== null && $album->defaultImage !== null ?
        $album->defaultImage : null;
@endphp

@if($image)
@section('styles')
@parent
<meta property="og:site_name" content="Photography | Matthew Schlachter">
<meta property="og:image" content="{{ $image->getFirstMediaUrl('image') }}">
<meta name="twitter:image:alt" content="{{ $image->alt }}">
@endsection
@endif

<x-header-image-background :album="$album"/>

@section('content')
<div class="tiles-section">
    <a href="{{ route('albums.all') }}">
        <i class="fas fa-chevron-left mr-2"></i>Back to all albums
    </a>
    <div style="float: right;">
        <x-share/>
    </div>
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
