<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akıllı Kent Gaziantep</title>
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body>
    <div class="full-width-header header-style1 home1-modifiy home12-modifiy">
        <header id="rs-header" class="rs-header">
            <div class="topbar-area home11-topbar">
                <div class="container">
                    <div class="row y-middle">
                        <div class="col-md-5">
                            <h3 class="home-text">
                            <a href="/">Ana Sayfa</a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </header>
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
                                <input type="email" id="email" name="email" minlength="10" maxlength="100" value="" placeholder="Mail" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="password" id="new-pass" name="password" value="" minlength="4" maxlength="50" placeholder="Yeni Şifre" required>
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
