@extends('layouts.external')
@section('page-title', buildPageTitle('All Albums'))
@section(
    'meta-description',
    __(
        config('settings.all_albums_meta_description', 'See photo albums by :authorName'),
        [
            'authorName' => config('settings.author_name', 'Author Name'),
        ]
    )
)


<x-header-image-background/>

@section('content')
<div class="tiles-section">
    <h2>
        All Albums
    </h2>
    <div class="image-tiles">
        @foreach($albums as $album)
        <a id="album-{{ $album->id }}" href="{{ route('albums.show', compact('album')) }}" class="image-tile" style="background-image: url('{{ getMediaUrlForSize($album->defaultImage) }}');">
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
