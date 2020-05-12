@php
if (!isset($image)) {
return;
}
$media = $image->getFirstMedia('image');
$webp = $media->hasGeneratedConversion('webp') && $media->getGeneratedConversions()['webp'];
@endphp
<picture>
    @if($webp !== false)
    <source srcset="{{ $media->getSrcset('webp') }}" type="image/webp" sizes="1px" onload="this.onload=null;this.sizes=Math.ceil(this.parentElement.querySelector('img').getBoundingClientRect().width/window.innerWidth*100)+'vw';">
    @endif
    <source srcset="{{ $media->getSrcset() }}" type="image/webp" sizes="1px" onload="this.onload=null;this.sizes=Math.ceil(this.parentElement.querySelector('img').getBoundingClientRect().width/window.innerWidth*100)+'vw';">
    <img @if($id ?? false) id="{{ $id }}" @endif class="{{ $class ?? '' }}" src="{{ $media->getUrl() }}" alt="{{ $image->alt }}" @if(isset($width)) width="{{ $width }}" @endif @if(isset($height)) height="{{ $height }}" @endif onload="this.onload=null;for(child of this.parentElement.children){child.onload && child.onload()}" />
</picture>
