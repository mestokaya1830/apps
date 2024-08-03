<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend.partials.head')
</head>
<body class="defult-home" id="default-home">
    <header>@include('/backend.partials.adminHeader')</header>
    <div class="admin-page" id="admin-page">
        <section class="admin-left" id="admin-left">@include('backend.partials.adminMenu')</section>
        <section  class="admin-right">@yield('content')</section>
    </div>
    <script>
        const hrefArray = document.location.href.split('/')
        if(hrefArray[hrefArray.length - 2] === 'admin'){
            document.getElementById(hrefArray[hrefArray.length - 1]).classList.add('active-list')
        }
    </script>
</body>
</html>