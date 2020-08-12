@php
	if($defaultImage ?? false) {
		$image = \App\Image::find(config('settings.default_header_image')) ?? getRandomImage();
	} else {
		$image = getRandomImage($album ?? null);
	}

	if ($image === null) {
		return;
	}

	$ratio = getImageRatio($image);

	$media = $image->getFirstMedia('image');
	$srcSet = preg_replace('/https?:\/\/[^\/]+\//i', '/', $media->getSrcset(supportsWebp() ? 'webp' : ''));
	$sources = explode(', ', $srcSet);
@endphp

@section('styles')
@parent

<style type="text/css">
	@if(count($sources))
	@php
		$split = explode(' ', $sources[0]); // Uses 'imageURL width'
		$source = $split[0];
		$width = intval($split[1] ?? 0);
		$height = $width / $ratio;
	@endphp
	@media(min-width: {{ $width + 1 }}px), (min-height: {{ $height + 1 }}px) {
		.hero-image {
			background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
			url({{ $image->getFirstMediaUrl('image', supportsWebp() ? 'webp' : '') }});
		}
	}
	@endif

	@foreach($sources as $sourceWidth)
	@php
		$split = explode(' ', $sourceWidth); // Uses 'imageURL width'
		$source = $split[0];
		$width = intval($split[1] ?? 0);
		$height = $width / $ratio;
	@endphp
	@media(max-width: {{ $width }}px) and (max-height: {{ $height }}px) {
		.hero-image {
			background-image: radial-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)),
			url({{ $source }});
		}
	}
	@endforeach
</style>
@endsection