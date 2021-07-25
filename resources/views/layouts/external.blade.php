<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('page-title')</title>
    <meta name="description" content="@yield('meta-description')">
    <meta name="author" content="{{ config('settings.author_name', 'Author Name') }}">
    <meta name="language" content="en">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://www.google-analytics.com" crossorigin />
    @yield('preconnect')

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="{{ $canonicalURL ?? getCanonical() }}" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{{ route('rss') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('styles')

    @guest
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('settings.ga_tracking_code') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('settings.ga_tracking_code') }}', {
             'page_title' : '@yield('page-title')',
             'page_path': '{{ parse_url($canonicalURL ?? getCanonical())['path'] ?? '/' }}',
             'siteSpeedSampleRate': 100
        });
    </script>
    <script async defer data-domain="photography.schlachter.xyz" src="https://analytics.schlachter.xyz/js/plausible.js"></script>
    @endguest
</head>

<body class="{{ supportsWebp() ? 'supports-webp' : '' }}">
    @if($showHero ?? true)
    <div class="hero-image @if(!($largeHero ?? false)) hero-small @endif @if($defaultHeroImage ?? false) default-image @endif">
        <nav class="top-nav">
            <a href="{{ route('albums.all') }}">Albums</a>
            <a href="{{ route('home') }}"><span class="sr-only">Home</span><svg style="width: 1em;vertical-align: -.125em;" class="svg-inline--fa fa-camera fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" class="svg-inline--fa fa-camera fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path></svg></a>
            <a href="{{ route('images.all') }}">Photos</a>
        </nav>
        <h1 class="bottom-text">
            {{ config('settings.site_name', 'Photography | Author Name') }}
        </h1>
        @yield('hero-content')
        @if($showScrollButton ?? false)
        <button class="bottom-scroll-arrow btn btn-link">
            <span class="sr-only">Scroll Down</span>
            <svg style="width: .875em;vertical-align: -.125em;" class="svg-inline--fa fa-arrow-down fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M413.1 222.5l22.2 22.2c9.4 9.4 9.4 24.6 0 33.9L241 473c-9.4 9.4-24.6 9.4-33.9 0L12.7 278.6c-9.4-9.4-9.4-24.6 0-33.9l22.2-22.2c9.5-9.5 25-9.3 34.3.4L184 343.4V56c0-13.3 10.7-24 24-24h32c13.3 0 24 10.7 24 24v287.4l114.8-120.5c9.3-9.8 24.8-10 34.3-.4z"></path></svg>
        </button>
        @endif
    </div>
    @else
    <h1 class="sr-only">{{ config('settings.site_name', 'Photography | Author Name') }}</h1>
    @endif
    <main>
        @yield('content')
    </main>

    <footer class="container container-fluid">
        <emph>&copy; <span class="copyright-year">{{ now()->year }}</span> {{ config('settings.author_name', 'Author Name') }}</emph>
        @if($printsLink = config('settings.prints_link'))
        <span style="float: right;">
            <a href="{{ $printsLink }}" target="_blank" rel="noopener">
                Buy Prints
            </a>
        </span>
        @endif
    </footer>
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <script src="{{ mix('js/app.js') }}" async></script>
    @yield('scripts')
    <script src="//instant.page/5.0.1" type="module" data-instant-intensity="mousedown" integrity="sha384-0DvoZ9kNcB36fWcQApIMIGQoTzoBDYTQ85e8nmsfFOGz4RHAdUhADqJt4k3K2uLS"></script>
</body>

</html>
