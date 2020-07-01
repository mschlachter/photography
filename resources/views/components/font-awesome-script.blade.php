@if(!config('font-awesome-script-added', false) && !config()->set('font-awesome-script-added', true))
	@section('preconnect')
		@parent
		<link rel="preconnect" href="https://kit-free.fontawesome.com" crossorigin />
	@endsection
	@section('scripts')
		@parent
		<script src="https://kit.fontawesome.com/4d7bccd5f5.js" crossorigin="anonymous" async></script>
	@endsection
@endif