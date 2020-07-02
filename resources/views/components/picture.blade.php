@php
if (!isset($image)) {
return;
}
$media = $image->getFirstMedia('image');
$webp = $media->hasGeneratedConversion('webp') && $media->getGeneratedConversions()['webp'];
$spatieImage = Spatie\Image\Image::load($image->getFirstMediaPath('image'));
$width = $spatieImage->getWidth();
$height = $spatieImage->getHeight();
@endphp
<picture>
    @if($webp !== false)
    <source srcset="{{ $media->getSrcset('webp') }}" type="image/webp" sizes="1px">
    @endif
    <source srcset="{{ $media->getSrcset() }}" type="{{ $media->mime_type }}" sizes="1px">
    <img @if($id ?? false) id="{{ $id }}" @endif class="{{ $class ?? '' }}" src="{{ $media->getUrl() }}" alt="{{ $image->alt }}" @if(isset($width)) data-width="{{ $width }}" @endif @if(isset($height)) data-height="{{ $height }}" @endif>
</picture>
