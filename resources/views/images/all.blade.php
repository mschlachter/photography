@extends('layouts.external')
@section('page-title', 'All Photos — Photography | Matthew Schlachter')
@section('meta-description', 'See the photos I\'ve posted from my adventures in photography')

@section('scripts')
@parent
<style type="text/css">
    .hero-image {
        background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
            url(<?= (App\Image::inRandomOrder()->first())->getFirstMediaUrl('image') ?>);
    }

</style>
@endsection

@section('content')
<div class="tiles-section">
    <h2>
        All Photos
    </h2>
    <div class="image-tiles">
        @foreach($images as $image)
        <a id="image-{{ $image->id }}" href="{{ route('images.show', compact('image')) }}" class="image-tile" style="background-image: url({{ $image->getFirstMediaUrl('image', 'thumb') }});">
            <span class="image-title">
                {{ $image->title }}
            </span>
            <span class="image-date">
                {{ $image->date }}
            </span>
        </a>
        @endforeach
    </div>
    <div class="row">
        <div class="col-auto mx-auto">
            {!! $images->links() !!}
        </div>
    </div>
</div>
@endsection
