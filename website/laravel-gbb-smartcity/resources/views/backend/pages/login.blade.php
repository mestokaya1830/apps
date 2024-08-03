    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
    </head>
    <body>
        @include('/backend.partials.adminHeader')
        @if(session()->has('admin'))
            <script>window.location = "/admin/categories";</script>
        @endif
        <section class="register-section pt-100 pb-100">
            <div class="container">
                <div class="register-box">
                    <div class="sec-title text-center mb-30">
                        <h2 class="title mb-10">Giriş Formu</h2>
                    </div>
                    <form class="styled-form" onkeydown="login()">
                        <div class="row clearfix">
                            <div class="form-group col-lg-12 mb-25">
                                <input type="text" id="name" name="name" minlength="2" maxlength="50" onfocus="removeMessage()" placeholder="Admin" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="password" id="password" name="password" minlength="4" maxlength="50" onfocus="removeMessage()" placeholder="Şifre" required>
                            </div>
                        </div>
                        <div class="alert alert-danger login-message-none" id="login-message" role="alert">Geçersiz Oturum!</div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                            <button type="button" id="submit" class="readon register-btn" onclick="login()"><span class="txt" >Giriş</span></button>
                        </div>
                        <a href="resetpass">Şifrenizi mi unuttunuz?</a>
                    </form>
                </div>
            </div>
        </section>
       <script>
           //auth
            const login = async () => {
                const result = await fetch('/login', {
                    method:'Post',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':'{{csrf_token()}}',
                    },
                    body:JSON.stringify({
                        name: document.getElementById('name').value ,
                        password: document.getElementById('password').value
                    })
                })
                const final = await result.json()
                if(final === 200){
                    window.location.href = '/admin/banner'
                } else {
                   document.getElementById('login-message').classList.remove('login-message-none')
                }
            }
            const removeMessage = () => {
                document.getElementById('login-message').classList.add('login-message-none')
            }
       </script>
    </body>
    </html>
