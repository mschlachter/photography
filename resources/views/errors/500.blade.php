@extends('layouts.external', ['largeHero' => true, 'defaultHeroImage' => true])
@section('page-title', buildPageTitle('Error Loading Page'))
@section('meta-description', '')

@section('hero-content')
<div class="center-text">
    <h2>
        Error loading page: {{ $exception->getStatusCode() }}
    </h2>
    <p>
        It's possible that this page is currently being updated; please try again in a few minutes.
    </p>
    <p>
        If you continue to see this page for more than a few minutes, let me know by sending an email to <a href=" mailto:admin@schlachter.xyzz?subject=Error%20on%20page%3A%20{{ $exception->getStatusCode() }}&body=Hello%2C%0D%0A%0D%0AI'm%20experiencing%20an%20error%20loading%20the%20page%20{{ url()->current() }}">admin@schlachter.xyz</a> telling me the page you're trying to access ({{ url()->current() }}) and the error code ({{ $exception->getStatusCode() }}).
    </p>
</div>
@endsection
