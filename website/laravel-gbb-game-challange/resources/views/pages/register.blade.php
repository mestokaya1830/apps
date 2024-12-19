@extends('layout')
@section('content')
    <div class="main-content">
    <section id="form" class="register-section pt-100 pb-100">
            <div class="container">
                <div class="register-box">
                    <div class="sec-title text-center mb-30">
                        <h2 class="title mb-10">Katılımcı Formu</h2>
                    </div>
                    <div class="styled-form">
                        <form action="" method="post" id="register-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="form-group col-lg-12 mb-25">
                                    <input type="text" id="name" name="firstName" value="" placeholder="Ad" required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <input type="text" id="last-name" name="lastName" value="" placeholder="Soyad" required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <input type="email" id="email" name="email" value="" placeholder="Mail Adresi " required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <input type="tel" id="phone" name="phone" minlength="11" maxlength="11" placeholder="0-000-000-00-00" pattern="[0-9]+" oninvalid="this.setCustomValidity('Telefon 11 karekter ve rakam olmalıdır!')" oninput="setCustomValidity('')" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="tel" id="address" name="address" placeholder="Adres" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" id="identity" name="identity" value="" placeholder="TC" minlength="11"  maxlength="11" pattern="[0-9]+" oninvalid="this.setCustomValidity('TC 11 karekter ve rakam olmalıdır!')" oninput="setCustomValidity('')" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="date" name="birthDate" id="" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="text" name="city" id="city" placeholder="Yaşadığı Şehir ve Ülke" required>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="reg-form">
                                        <div class="reg-title">Öğrenim Durumu</div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="yuksek-lisans" value="Yüksek Lisans" style="width: 20px;margin-right: 10px;" required>
                                            <label for="yuksek-lisans" style="margin:0;padding:0;">Yüksek Lisans</label>
                                        </div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="lisans" value="Lisans" style="width: 20px;margin-right: 10px;" required>
                                            <label for="lisans" style="margin:0;padding:0;">Lisans</label>
                                        </div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="on-lisans" value="Ön Lisans" style="width: 20px;margin-right: 10px;" required>
                                            <label for="on-lisans" style="margin:0;padding:0;">Ön Lisans</label>
                                        </div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="lise" value="Lise" style="width: 20px;margin-right: 10px;" required>
                                            <label for="lise" style="margin:0;padding:0;">Lise</label>
                                        </div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="ortaokul" value="Ortaokul" style="width: 20px;margin-right: 10px;" required>
                                            <label for="ortaokul" style="margin:0;padding:0;">Ortaokul</label>
                                        </div>
                                        <div class="reg-item">
                                            <input type="radio" name="education" id="diger" value="Diger" style="width: 20px;margin-right: 10px;" required>
                                            <label for="diger" style="margin:0;padding:0;">Diger</label>
                                        </div>
                                    </div>
                                    <div class="reg-form">
                                        <div class="reg-title">
                                            Eğitici / Öğretici Mobil Oyun Uygulama Projeniz Hakkında Özet Bilgi (En az 100 Karakter) *
                                        </div>
                                        <textarea name="about" id="" cols="30" rows="1" minlength="100" pattern=".{100,}" oninvalid="this.setCustomValidity('Bu alan 100 karekterden az olamaz!')" oninput="setCustomValidity('')" required placeholder="Özet Alanı"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div  class="container mb-5">
                                <div id="fileUploadCon" class="form-group">
                                    <div style="margin-bottom:10px;color:darkred;">Lütfen 100 mb üzeri dosyalar içi Github yada benzeri bir Depolama-Link`i veriniz!</div>
                                    <input id="file" name="file" type="file" accept=".zip, .rar" class="form-control" style="height:44px;" required>
                                </div>

                                <div class="form-group">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-form">
                                <a href="rules" class="reg-text">
                                    KATILIM ŞARTLARI
                                </a>
                                <hr>
                            </div>
                            <div id="aggre" class="reg-form">
                                <label for="aggre">
                                    <span class="aggre-text">Katılım Şartlarını, Taahütnameyi, ve KVKK Metnini Okudum Kabul Ediyorum.</span>
                                </label>
                                <input type="checkbox" name="aggre" id="aggre" class="aggre-btn" onchange="setAggre()">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center" style="padding:0;">
                                <button type="submit" id="submit" disabled class="readon disabled-btn"><span class="txt">İleri</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
       <div class="done-con">
           <div id="done" class="alert alert-primary" style="display:none;">
               Kaydınız başarıyla tamamlanmıştır!
           </div>
       </div>
    </div>
    <script>
        const setAggre = () => {
            if(document.getElementById('submit').hasAttribute('disabled')){
                document.getElementById('submit').removeAttribute('disabled')
                document.getElementById('submit').classList.remove('disabled-btn')
                document.getElementById('submit').classList.add('register-btn')
            } else {
                document.getElementById('submit').setAttribute('disabled','disabled')
                document.getElementById('submit').classList.add('disabled-btn')
                document.getElementById('submit').classList.remove('register-btn')
            }
        }
    </script>
@stop
