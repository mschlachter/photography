<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('page-title')</title>
    <meta name="description" content="@yield('meta-description')">
    <meta name="author" content="Matthew Schlachter">
    <meta name="language" content="en">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://www.google-analytics.com" crossorigin />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="{{ $canonicalURL ?? getCanonical() }}" />
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{{ route('rss') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('styles')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-59906432-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-59906432-4', {
             'page_title' : '@yield('page-title')',
             'page_path': '{{ parse_url($canonicalURL ?? getCanonical())['path'] ?? '/' }}'
        });
    </script>
</head>

<body class="{{ supportsWebp() ? 'supports-webp' : '' }}">
    @if($showHero ?? true)
    <div class="hero-image @if(!($largeHero ?? false)) hero-small @endif @if($defaultHeroImage ?? false) default-image @endif">
        <nav class="top-nav">
            <a href="{{ route('albums.all') }}">Albums</a>
            <a href="{{ route('home') }}"><span class="sr-only">Home</span><i class="fas fa-camera"></i></a>
            <a href="{{ route('images.all') }}">Photos</a>
        </nav>
        <h1 class="bottom-text">
            Matthew Schlachter | Photography
        </h1>
        @if($largeHero ?? false)
        <button class="bottom-scroll-arrow btn btn-link">
            <span class="sr-only">Scroll Down</span>
            <i class="fas fa-arrow-down"></i>
        </button>
        @endif
    </div>
    @else
    <h1 class="sr-only">Matthew Schlachter | Photography</h1>
    @endif
    <main>
        @yield('content')
    </main>

    <footer class="container container-fluid">
        <emph>&copy; <span class="copyright-year">{{ now()->year }}</span> Matthew Schlachter</emph>
        <span style="float: right;">
            <a href="https://mschlachter.visualsociety.com/" target="_blank" rel="noopener">
                Buy Prints
            </a>
        </span>
    </footer>
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <script src="{{ mix('js/app.js') }}" async></script>
    <script src="https://kit.fontawesome.com/4d7bccd5f5.js" crossorigin="anonymous" async></script>
    @yield('scripts')
    <script src="//instant.page/5.0.1" type="module" data-instant-intensity="mousedown" integrity="sha384-0DvoZ9kNcB36fWcQApIMIGQoTzoBDYTQ85e8nmsfFOGz4RHAdUhADqJt4k3K2uLS"></script>
</body>

</html>
