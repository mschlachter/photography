@if(!config('graph-assets-loaded', false) && !config()->set('graph-assets-loaded', true))
	@push('css')
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltips@0.0.17/dist/chartist-plugin-tooltip.min.css" defer>
	@endpush
	@push('js')
		<script src="https://cdn.jsdelivr.net/npm/chartist-plugin-tooltips@0.0.17/dist/chartist-plugin-tooltip.min.js" integrity="sha256-BdDMib6f/EOwrxY3YE9bfqySmqixP5zvookyxS1khtY=" crossorigin="anonymous"></script>
	@endpush
@endif