@extends('layout')
@section('content')
    <div class="main-content">
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
    </div> 
@stop