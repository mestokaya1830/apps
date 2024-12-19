<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akıllı Kent Gaziantep</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main.css') }}">
</head>
<body>
    <div class="admin-header">
        <div>
            <a href="#" class="header-text" onclick="openMenu()">

            </a>
            <a href="/" class="header-text">
                <img src="{{asset('images/home.png')}}" alt="" />
            </a>
          </div>
    </div>
    <section class="register-section pt-100 pb-100">
        <div class="container">
            <div class="register-box">
                <div class="sec-title text-center mb-30">
                    <h2 class="title mb-10">Şifre Sıfırlama</h2>
                </div>

                <div class="styled-form">
                    <form action="#" method="post" id="login-form">
                        @csrf
                        <div class="row clearfix">
                            <div class="form-group col-lg-12 mb-25">
                                <input type="email" id="email" name="email" value="" placeholder="Mail" required>
                            </div>

                            <div class="form-group col-lg-12">
                                <input type="password" id="new-pass" name="password" value="" placeholder="Yeni Şifre" required>
                            </div>
                        </div>
                        @isset($message)
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                        @endisset
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                            <button type="submit" id="submit" class="readon register-btn"><span class="txt">Sıfırla</span></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</body>
</html>
