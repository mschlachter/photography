<?php

function getCanonical($url = null)
{
    if ($url === null) {
        $url = url()->current();
    }

    $bits = parse_url($url);

    // Force HTTPS:
    $newUrl = "https://" .
        $bits["host"] .
        (isset($bits["port"]) && !empty($bits["port"]) ? ":" . $bits["port"] : "" ) .
        (isset($bits["path"]) && !empty($bits["path"]) ? $bits["path"] : "" );

    return $newUrl;
}

function supportsWebp() 
{
    return strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false;
}

function getRandomMediaUrl(\App\Album $album = null)
{
    // Not actually random for albums...
    $image = $album !== null && $album->defaultImage !== null ?
        $album->defaultImage :
        App\Image::inRandomOrder()->first();
    
    if (supportsWebp()) {
        return $image->getFirstMediaUrl('image', 'webp');
    }
    
    return $image->getFirstMediaUrl('image');
}

function getMediaUrlForSize(\App\Image $image, $targetWidth = 300, $targetHeight = 300)
{
    $media = $image->getFirstMedia('image');
    $srcSet = $media->getSrcset(supportsWebp() ? 'webp' : '');
    $sources = explode(', ', $srcSet);
    
    // Get the ratio of the image
    $ratio = getImageRatio($image);
    
    // Get the desired ratio
    $targetRatio = $targetWidth / $targetHeight;
    
    // Get the maximum desired width, based on the ratios
    $desiredWidth = $ratio < $targetRatio ? $targetWidth : $targetHeight * $ratio;
    
    // Find the smallest source that satisfies the desired width
    $source = $media->getUrl(supportsWebp() ? 'webp' : '');
    foreach($sources as $testSource) {
        $split = explode(' ', $testSource); // Uses 'imageURL width'
        if(intVal($split[1]) < $desiredWidth) {
            return $source; // Return previously found source
        }
        $source = $split[0];
    }
    
    // Return the URL for the desired size
    return $source;
}

function getImageRatio(App\Image $image)
{
    return Cache::remember('image|ratio|' . $image->id, 60*60*24*30, function() use ($image) {
        $spatieImage = Spatie\Image\Image::load($image->getFirstMediaPath('image'));
        $width = $spatieImage->getWidth();
        $height = $spatieImage->getHeight();
        return $width / $height;
    });
}
