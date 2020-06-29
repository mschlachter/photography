@extends('layouts.external', ['showHero' => false, 'canonicalURL' => getCanonical(route('albums.image.show', ['album' => $image->album, 'image' => $image]))])
@section('page-title', buildPageTitle($image->title))
@section('meta-description', 'I photograph flowers, wildlife, and snippets of my daily life in Montreal, Canada. This photo is [' . $image->title . ']: ' . $image->alt)

@section('styles')
@parent
<meta property="og:site_name" content="Photography | Matthew Schlachter">
<meta property="og:image" content="{{ $image->getFirstMediaUrl('image') }}">
<meta name="twitter:image:alt" content="{{ $image->alt }}">
<meta name="keywords" content="{{ implode(', ', $image->tags->pluck('name')->toArray()) }}">
@endsection

@section('content')
<div class="image-viewer">
    <x-picture :image="$image" class="current-image"></x-picture>
    
    <a class="back-link" href="{{ route('images.all', ['tag' => $searchTags]) }}#image-{{ $image->id }}">
        <i class="far fa-times-circle fa-3x align-middle mr-2"></i>Back to Images
    </a>
    @if($previous !== null)
    <a class="prev-link" href="{{ route('images.show', ['image' => $previous, 'searchTags' => $searchTags]) }}">
        <i class="far fa-arrow-alt-circle-left fa-3x align-middle mr-2"></i>Previous
    </a>
    @endif
    @if($next !== null)
    <a class="next-link" href="{{ route('images.show', ['image' => $next, 'searchTags' => $searchTags]) }}">
        Next<i class="far fa-arrow-alt-circle-right fa-3x align-middle ml-2"></i>
    </a>
    @endif
</div>
<x-image-meta :image="$image"/>
@endsection
