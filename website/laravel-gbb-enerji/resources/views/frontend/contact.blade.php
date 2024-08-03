@extends('welcome')
@section('content')
<section  class="contact-area after-none contact-bg pt-120 pb-120" >
    <div class="container">
        <div class="row">
             <div class="col-lg-5">
             <div style="margin-top:30px;">
                <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                    <div class="f-cta-icon">
                        <i class="far fa-map"></i>
                    </div>
                    <h5>Gaziantep Büyükşehir Belediyesi</h5>
                    <p>
                        <span>
                            İncilipınar Mah. Şehit Yusuf Erin Caddesi Büyükşehir Belediyesi Binası Şehitkamil / Gaziantep
                        </span>
                    </p>
                </div>
                <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                    <div class="f-cta-icon">
                        <i class="far fa-map"></i>
                    </div>
                    <h5>GBB Enerji</h5>
                    <p>
                        <span>
                            Fıstıklık Mah. Turgut Özal Bulvarı No:224, 27000 Şehitkamil/Gaziantep
                        </span>
                    </p>
                </div>
                 <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                    <div class="f-cta-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <h5>Çalışma Saatleri</h5>
                    <p>Pzt - Cum 08:00-12:00 ve 13:00-17:00 Saatleri
                </div>
            </div>

            </div>
            <div class="col-lg-7">
                <div class="contact-bg02 wow fadeInLeft  animated">
                <div class="section-title center-align">
                   <h5>İLETİŞİM</h5>

                </div>
                <form action="{{route('contact.email')}}" method="post">
                    @csrf
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-name mb-30">
                            <input type="text" name="name" placeholder="Ad" required value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-email mb-20">
                            <input type="text"  name="lastname" placeholder="Soyad" required value="{{old('lastname')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-subject mb-30">
                            <input type="text" id="email" name="email" placeholder="Email" required value="{{old('email')}}" placeholder="Posta Adresi"&#x1F534; pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninvalid="this.setCustomValidity('Posta Adresi Formata Uygun Degil')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-subject mb-30">
                            <input type="number" id="phone" name="phone" placeholder="Tel" required value="{{old('phone')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-field p-relative c-subject mb-30">
                            <input type="text" id="subject" name="subject" placeholder="Konu" required value="{{old('subject')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-field p-relative c-message mb-30">
                            <textarea name="message" id="message" cols="30" rows="10" placeholder="Mesaj" required>{{old('message')}}</textarea>
                        </div>
                        <div class="slider-btn">
                            <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">GÖNDER</button>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>

</section>
@stop
