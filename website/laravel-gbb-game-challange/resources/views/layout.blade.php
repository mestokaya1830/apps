<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
    <div>@include('/partials.header')</div>
    <div class="home-style5">@yield('content')</div>
    <div id="rs-footer" class="rs-footer">@include('/partials.footer')</div>
    <div id="scrollUp" class="orange-color">
        <i class="fa fa-angle-up"></i>
    </div>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/wow.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
</body>
</html>
