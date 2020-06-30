@extends('layouts.external', ['largeHero' => true, 'showScrollButton' => true])
@section('page-title', config('settings.site_name', 'Photography | Author Name'))
@section('meta-description', 'I photograph flowers, wildlife, and snippets of my daily life in Montreal, Canada. Experience the results of my adventures in photography.')

<x-header-image-background :defaultImage="true"/>

@section('content')
<div class="tiles-section">
    <h2>
        Recent Albums
    </h2>
    <div class="image-tiles">
        @foreach($albums as $album)
        <a id="album-{{ $album->id }}" href="{{ route('albums.show', compact('album')) }}" class="image-tile" style="background-image: url({{ getMediaUrlForSize($album->defaultImage) }});">
            <span class="image-title">
                {{ $album->title }}
            </span>
            <span class="image-date">
                {{ $album->date }}
            </span>
        </a>
        @endforeach
        <a href="{{ route('albums.all') }}" class="image-tile tile-view-all">
            <span class="image-title">
                View All
            </span>
        </a>
    </div>
</div>
@endsection
