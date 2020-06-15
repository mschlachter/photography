@extends('layouts.external')
@section('page-title', 'All Photos — Photography | Matthew Schlachter')
@section('meta-description', 'See the photos I\'ve posted from my adventures in photography')

@section('scripts')
@parent
<style type="text/css">
    .hero-image {
        background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
            url(<?= getRandomMediaUrl() ?>);
    }

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.css" rel="stylesheet" defer>
@endsection

@section('content')
<div class="tiles-section">
    <h2>
        All Photos
    </h2>
    <form class="photo-search-form" action="{{ route('images.all') }}" method="get">
        <label for="slct-tag">
            Filter by Tag
        </label>
        <select id="slct-tag" name="tag[]" multiple="multiple">
            @foreach(App\TagCategory::orderBy('name')->with(['tags'])->get() as $tagCategory)
            <optgroup label="{{ $tagCategory->name }}"></optgroup>
                @foreach($tagCategory->tags as $tag)
                <option @if(is_array(request('tag')) && in_array($tag->name, request('tag'))) selected="selected" @endif>{{ $tag->name }}</option>
                @endforeach
            @endforeach
            @foreach(App\Tag::whereNull('tag_category_id')->orderBy('name')->get() as $tag)
            <option @if(is_array(request('tag')) && in_array($tag->name, request('tag'))) selected="selected" @endif>{{ $tag->name }}</option>
            @endforeach
        </select>
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

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.26.0/slimselect.min.js"></script>
<script src="{{ mix('js/image-search.js') }}"></script>
@endsection