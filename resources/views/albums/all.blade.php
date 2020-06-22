@extends('layouts.external')
@section('page-title', buildPageTitle('All Albums'))
@section('meta-description', 'I photograph flowers, wildlife, and snippets of my daily life in Montreal, Canada. Explore the photo albums containing the images that I\'ve taken.')

@section('scripts')
@parent
<style type="text/css">
    .hero-image {
        background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
            url(<?= getRandomMediaUrl() ?>);
    }

</style>
@endsection

@section('content')
<div class="tiles-section">
    <h2>
        All Albums
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
    </div>
    <div class="row">
        <div class="col-auto mx-auto">
            {!! $albums->links() !!}
        </div>
    </div>
</div>
@endsection
