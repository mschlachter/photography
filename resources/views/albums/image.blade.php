@extends('layouts.external', ['showHero' => false])
@section('page-title', buildPageTitle($image->title))
@section(
    'meta-description', 
    __(
        config('settings.image_viewer_meta_description', '":imageTitle" by :authorName: :imageAlt'),
        [
            'imageTitle' => $image->title,
            'imageAlt' => $image->alt,
            'albumTitle' => $image->album->title,
            'authorName' => config('settings.author_name', 'Author Name'),
        ]
    )
)

<x-font-awesome-script/>

@section('styles')
@parent
<meta property="og:site_name" content="{{ config('settings.site_name', 'Photography | Author Name') }}">
<meta property="og:image" content="{{ $image->getFirstMediaUrl('image') }}">
<meta name="twitter:image:alt" content="{{ $image->alt }}">
<meta name="keywords" content="{{ implode(', ', $image->tags->pluck('name')->toArray()) }}">
@endsection

@section('content')
<div class="image-viewer">
    <x-picture :image="$image" class="current-image"></x-picture>

    <a class="back-link" href="{{ route('albums.show', compact('album')) }}#image-{{ $image->id }}">
        <i class="far fa-times-circle fa-3x align-middle mr-2"></i>Back to Album
    </a>
    @if($previous !== null)
    <a class="prev-link" href="{{ route('albums.image.show', ['album' => $album, 'image' => $previous]) }}">
        <i class="far fa-arrow-alt-circle-left fa-3x align-middle mr-2"></i>Previous
    </a>
    @endif
    @if($next !== null)
    <a class="next-link" href="{{ route('albums.image.show', ['album' => $album, 'image' => $next]) }}">
        Next<i class="far fa-arrow-alt-circle-right fa-3x align-middle ml-2"></i>
    </a>
    @endif
</div>
<x-image-meta :image="$image"/>
@endsection
