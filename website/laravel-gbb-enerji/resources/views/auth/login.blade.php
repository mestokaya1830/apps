<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <title>Gbb Enerji</title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="msapplication-tap-highlight" content="no">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
        <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon.png">
        <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    </head>
    <body>
        <div class="page-wrapper auth">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">

                            </div>

                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-12 py-lg-5 my-lg-12 px-12 px-sm-0">
                            <div class="row" style="justify-content: center;">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
                                    <div class="card p-4 rounded-plus bg-faded">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus oninvalid="this.setCustomValidity('Lütfen işaretli yerleri doldurunuz')" oninput="this.setCustomValidity('')">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div class="help-block">{{$message}}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password" class="form-label">{{ __('Şifre') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autofocus oninvalid="this.setCustomValidity('Lütfen işaretli yerleri doldurunuz')" oninput="this.setCustomValidity('')">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <div class="help-block">{{$message}}</div>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Beni hatırla') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row no-gutters">
                                                <div class="col-lg-12 pl-lg-1 my-2">
                                                    <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">Giriş</button>
                                                </div>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Şifre Sıfırlama?') }}
                                                </a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="js-color-profile" class="d-none">
            <span class="color-primary-50"></span>
            <span class="color-primary-100"></span>
            <span class="color-primary-200"></span>
            <span class="color-primary-300"></span>
            <span class="color-primary-400"></span>
            <span class="color-primary-500"></span>
            <span class="color-primary-600"></span>
            <span class="color-primary-700"></span>
            <span class="color-primary-800"></span>
            <span class="color-primary-900"></span>
            <span class="color-info-50"></span>
            <span class="color-info-100"></span>
            <span class="color-info-200"></span>
            <span class="color-info-300"></span>
            <span class="color-info-400"></span>
            <span class="color-info-500"></span>
            <span class="color-info-600"></span>
            <span class="color-info-700"></span>
            <span class="color-info-800"></span>
            <span class="color-info-900"></span>
            <span class="color-danger-50"></span>
            <span class="color-danger-100"></span>
            <span class="color-danger-200"></span>
            <span class="color-danger-300"></span>
            <span class="color-danger-400"></span>
            <span class="color-danger-500"></span>
            <span class="color-danger-600"></span>
            <span class="color-danger-700"></span>
            <span class="color-danger-800"></span>
            <span class="color-danger-900"></span>
            <span class="color-warning-50"></span>
            <span class="color-warning-100"></span>
            <span class="color-warning-200"></span>
            <span class="color-warning-300"></span>
            <span class="color-warning-400"></span>
            <span class="color-warning-500"></span>
            <span class="color-warning-600"></span>
            <span class="color-warning-700"></span>
            <span class="color-warning-800"></span>
            <span class="color-warning-900"></span>
            <span class="color-success-50"></span>
            <span class="color-success-100"></span>
            <span class="color-success-200"></span>
            <span class="color-success-300"></span>
            <span class="color-success-400"></span>
            <span class="color-success-500"></span>
            <span class="color-success-600"></span>
            <span class="color-success-700"></span>
            <span class="color-success-800"></span>
            <span class="color-success-900"></span>
            <span class="color-fusion-50"></span>
            <span class="color-fusion-100"></span>
            <span class="color-fusion-200"></span>
            <span class="color-fusion-300"></span>
            <span class="color-fusion-400"></span>
            <span class="color-fusion-500"></span>
            <span class="color-fusion-600"></span>
            <span class="color-fusion-700"></span>
            <span class="color-fusion-800"></span>
            <span class="color-fusion-900"></span>
        </p>
    </body>
</html>
