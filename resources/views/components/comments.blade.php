@if(config('settings.enable_comments', false))
<h2>Comments</h2>
<label class="sr-only" for="commento-textarea-root">
    Add a comment
</label>
<div id="commento"></div>
<noscript>Please enable JavaScript to view the comments.</noscript>

@section('scripts')
    @parent
    <script src="https://cdn.comments.schlachter.xyz/js/commento.js" defer="defer" data-no-fonts="true" @if(isset($pageId)) data-page-id="{{ $pageId }}" @endif></script>
@endsection
@endif