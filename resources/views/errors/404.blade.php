@extends('layouts.external', ['largeHero' => true])
@section('page-title', buildPageTitle('Page Not Found'))
@section('meta-description', '')

<x-header-image-background :defaultImage="true"/>

@section('hero-content')
<div class="center-text">
    <h2>
        Page Not Found
    </h2>
    <p>
        It seems the page you're looking for no longer exists.
    </p>
    <p>
        <button type="button" onclick="window.history.back()">Go Back</button>
        or
        <a href="{{ route('home') }}">
            Visit the Home Page
        </a>
    </p>
</div>
@endsection
