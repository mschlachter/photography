<h2>Comments</h2>
<div id="commento"></div>
<noscript>Please enable JavaScript to view the comments.</noscript>

@section('scripts')
    @parent
    <script defer src="https://cdn.commento.io/js/commento.js" async="async" @if(isset($pageId)) data-page-id="{{ $pageId }}" @endif></script>
@endsection