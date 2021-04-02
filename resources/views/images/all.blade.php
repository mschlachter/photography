@extends('layouts.external')
@section('page-title', buildPageTitle('All Photos'))
@section(
    'meta-description',
    __(
        config('settings.all_images_meta_description', 'See all photos taken by :authorName'),
        [
            'authorName' => config('settings.author_name', 'Author Name'),
        ]
    )
)

@section('preconnect')
    @parent
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.js" as="script">
    <link rel="preload" href="{{ mix('js/image-search.js') }}" as="script">
@endsection

@section('styles')
@parent
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.css" rel="stylesheet">
@endsection

<x-header-image-background/>

@section('content')
<div class="tiles-section">
    <h2>
        All Photos
    </h2>
    <form class="photo-search-form" action="{{ route('images.all') }}" method="get">
        <label for="slct-tag">
            Filter by Tag
        </label>
        <!-- Scripts inline to remove dropdown flicker (preloaded above so should already be loaded) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.js"></script>
        <select id="slct-tag" name="tag[]" multiple="multiple">
            @foreach($tags as $tag)
            <option @if(is_array(request('tag')) && in_array($tag, request('tag'))) selected="selected" @endif>{{ $tag }}</option>
            @endforeach
        </select>
        <script src="{{ mix('js/image-search.js') }}"></script>
        <noscript>
            <button type="submit">
                Search
            </button>
        </noscript>
    </form>
    <div id="image-section">
        @include('images/ajaxContent')
    </div>
</div>
@endsection
