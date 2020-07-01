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
          &copy; {{ now()->year }},
          made and hosted by <a href="https://www.schlachter.xyz" rel="noopener" target="_blank">Matthew Schlachter</a>
        </div>
    </div>
</footer>