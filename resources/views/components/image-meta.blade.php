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
            Download image
        </a>
    </p>
    <p><x-share/></p>
    <x-comments pageId="photography/images/{{ $image->id }}"/>
</div>