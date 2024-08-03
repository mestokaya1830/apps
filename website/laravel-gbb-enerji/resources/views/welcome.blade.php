<!DOCTYPE html>
<html lang="tr">
    <head>
        @include('/partials.head')
    </head>
    <body>
        <nav>
            @include('/partials.navbar')
        </nav>
        @yield('content')
        <footer class="footer-bg footer-p">
            @include('/partials.footer')
        </footer>
        {{-- @include('/partials.scripts') --}}
    </body>
</html>
