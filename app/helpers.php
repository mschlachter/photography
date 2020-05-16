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
