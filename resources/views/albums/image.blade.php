@extends('layouts.external', ['showHero' => false])
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
<div class="container container-fluid image-details">
    <h2>
        Meta info
    </h2>
    <p>
        Title: {{ $image->title }}
    </p>
    <p>
        Date: {{ $image->date }}
    </p>
    <p>
        Album: 
        <a href="{{ route('albums.show', ['album' => $image->album]) }}#image-{{ $image->id }}">{{ $image->album->title }}</a>
    </p>
    <p>
        Tags:
        @foreach($image->tags->pluck('name')->toArray() as $tag)
            <a href="{{ route('images.all', ['tag[]' => $tag]) }}">{{ $tag }}</a>@if(!$loop->last),@endif
        @endforeach
    </p>
    <p>
        <a href="{{ route('download', ['image' => $image]) }}" target="_blank">
            Download full-size version
        </a>
    </p>
    <p><x-share/></p>
    <x-comments :pageId="'photography/images/' . $image->id"></x-comments>
</div>
@endsection
