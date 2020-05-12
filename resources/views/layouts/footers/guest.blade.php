<footer class="footer">
    <div class="container">
        <nav class="float-left">
        <ul>
            <li>
            <a href="{{ route('home') }}">
                {{ __('Home') }}
            </a>
            </li>
        </ul>
        </nav>
        <div class="copyright float-right">
        &copy;{{ today()->year }}, admin theme made with <i class="material-icons">favorite</i> and based on work by
        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> and <a href="https://www.updivision.com" target="_blank">UPDIVISION</a> for a better web.
        </div>
    </div>
</footer>