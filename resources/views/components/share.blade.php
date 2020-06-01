@section('styles')
    @parent
    <link rel="stylesheet" href="{{ mix('css/share.css') }}" />
@endsection

<button class="good-share" data-share-url="{{ getShortUrl($url ?? null) }}">Share</button>

@section('scripts')
    @parent
    <script src="{{ mix('js/share.js') }}" defer="defer"></script>
@endsection