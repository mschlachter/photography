        <div class="image-tiles">
            @foreach($images as $image)
            <a id="image-{{ $image->id }}" href="{{ route('images.show', compact('image')) }}" class="image-tile" style="background-image: url({{ getMediaUrlForSize($image) }});">
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