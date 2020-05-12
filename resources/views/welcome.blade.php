@extends('layouts.external', ['largeHero' => true])
@section('page-title', 'Photography | Matthew Schlachter')
@section('meta-description', 'Experience the fruits of my labours from my adventures in photography')

@section('content')
<div class="tiles-section">
    <h2>
        Recent Albums
    </h2>
    <div class="image-tiles">
        @foreach($albums as $album)
        <a id="album-{{ $album->id }}" href="{{ route('albums.show', compact('album')) }}" class="image-tile" style="background-image: url({{ optional($album->defaultImage)->getFirstMediaUrl('image', 'thumb') }});">
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
