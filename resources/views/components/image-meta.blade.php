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
    @if(config('settings.enable_download_link', false))
    <p>
        <a href="{{ route('download', ['image' => $image]) }}" target="_blank">
            Download image
        </a>
    </p>
    @endif
    <p><x-share/></p>
    <x-comments pageId="photography/images/{{ $image->id }}"/>
</div>

@section('scripts')
    @parent
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "ImageObject",
            "author": "{{ config('settings.author_name', 'Author Name') }}",
            "contentUrl": "{{ $image->getFirstMediaUrl('image') }}",
            "datePublished": "{{ $image->date }}",
            "description": "{{ $image->alt }}",
            "name": "{{ $image->title }}",
            "representativeOfPage": true,
            "thumbnail": {
                "@type": "ImageObject",
                "contentUrl": "{{ getMediaUrlForSize($image) }}"
            },
            "accessMode": "visual",
            "copyrightHolder": "{{ config('settings.author_name', 'Author Name') }}",
            "copyrightYear": {{ date('Y', strtotime($image->date)) }}
        }
    </script>
@endsection