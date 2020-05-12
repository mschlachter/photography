<?php

function getCanonical($url = null) {
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
