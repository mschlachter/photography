@extends('layouts.external', ['largeHero' => true, 'defaultHeroImage' => true])
@section('page-title', buildPageTitle('Page Not Found'))
@section('meta-description', '')

@section('hero-content')
<div class="center-text">
    <h2>
        Page Not Found
    </h2>
    <p>
        It seems the page you're looking for no longer exists.
    </p>
    <p>
        <a href="{{ route('home') }}">
            Go Back to Home Page
        </a>
    </p>
</div>
@endsection
