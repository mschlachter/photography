<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('page-title')</title>
    <meta name="description" content="@yield('meta-description')">
    <meta name="author" content="Matthew Schlachter">
    <meta name="language" content="en">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="{{ $canonicalURL ?? getCanonical() }}" />

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('styles')
</head>

<body>
    @if($showHero ?? true)
    <div class="hero-image @if(!($largeHero ?? false)) hero-small @endif">
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
    </footer>
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <script src="{{ mix('js/app.js') }}" async></script>
    <script src="https://kit.fontawesome.com/4d7bccd5f5.js" crossorigin="anonymous" async></script>
    @yield('scripts')
</body>

</html>
