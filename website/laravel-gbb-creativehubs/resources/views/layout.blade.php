<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('main.css')}}">
</head>
<body>
    <header>@include('adminHeader')</header>
    <div class="admin-container">
        <section class="admin-left">
            <ul>
                <li class="left-menu"><a href="nodes">Düğümler</a></li>
                <li class="left-menu"><a href="addnode">Düğüm Ekleme</a></li>
                <li class="left-menu"><a href="addstyle">Düğüm Biçimlendirme</a></li>
            </ul>
        </section>
        <section  class="admin-right">@yield('content')</section>
    </div>
</body>
</html>
