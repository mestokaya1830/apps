@extends('welcome')
@section('content')
    <main id="main">
        <div class="modal fade bs-example-modal-lg search-bg popup1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content search-popup">
                    <div class="text-center">
                        <a href="#" class="close2" data-dismiss="modal" aria-label="Close">× Kapat</a>
                    </div>
                    <div class="row search-outer">
                        <div class="col-md-11"><input type="text" placeholder="Search for products..." /></div>
                        <div class="col-md-1 text-right"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
        <section id="home" class="slider-area slider-four fix p-relative">
            <div class="slider-active">
                <div class="single-slider slider-bg d-flex align-items-center" style="background: url(img/slider/slider_img_bg.png) no-repeat; background-position: right top;">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7 col-md-7">
                                <div class="slider-content s-slider-content mt-150">
                                    <h5 data-animation="fadeInDown" data-delay=".4s">HOŞGELDİNİZ </h5>
                                        <h2 data-animation="fadeInUp" data-delay=".4s">İklim kriziyle mücadelede bizimle misin?</h2>
                                        <div class="col-xl-2 col-lg-2 text-right d-none d-lg-block mt-15 mb-15">
                                            <a href="{{route('test')}}" class="btn ss-btn">ÇEVRE KORUMA TESTİ</a>
                                        </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 join-quiz-btn-mobil pl-0">
                                <a href="{{route('test')}}" class="btn ss-btn">İklim değişikliği ile mücadele testi</a>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <div class="slider-img" data-animation="fadeInUp" data-delay=".4s">
                                <img src="img/slider/slider_img05.png" alt="slider_img05">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="counter-area p-relative pt-80 pb-80" style="background: url(img/bg/counter-bg.png) repeat-x;">
            <div class="container">

                 <div class="row">
                      <div class="col-lg-4 col-md-12 col-sm-12">
                          <div class="section-title">
                            <h2>
                              ÖDÜLLER
                            </h2>

                        </div>
                      </div>
                      <div class="col-lg-8 col-md-12 col-sm-12">
                          <div class="row text-center">
                                <div class="col-lg-4 col-md-6 col-sm-12 p-2">
                                    <div class="single-counter wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                        <div class="icon">
                                            <i class="fa fa-laptop" aria-hidden="true"></i>
                                        </div>
                                        <div class="counter p-relative">
                                            <h1>1</h1>
                                            <p>Adet Laptop</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 p-2">
                                    <div class="single-counter wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                        <div class="icon">
                                            <i class="fa fa-tablet" aria-hidden="true"></i>
                                        </div>
                                        <div class="counter p-relative">
                                            <h1>1</h1>
                                            <p>Adet Tablet</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 p-2">
                                    <div class="single-counter wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                                        <div class="icon">
                                            <i class="fa fa-bicycle" aria-hidden="true"></i>
                                        </div>
                                        <div class="counter p-relative">
                                            <h1>3</h1>
                                            <p>Adet Bisiklet</p>
                                        </div>
                                    </div>
                                </div>
                          </div>
                      </div>
                </div>
            </div>
        </div>
        <section id="services-08" class="services-08 pb-120 p-relative" style="background: url(img/bg/aliment-left.png) no-repeat; background-position: left center;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title center-align mb-50 text-center">
                            <h2>
                                Karbon Ayak İzi
                            </h2>
                            <h5 style="text-align:center;margin:20px auto;">
                                Karbon ayak izi evsel enerji tüketimi, ulaşım, kullandığımız ürünlerin üretilmesi ve tüketilmesi dahil olmak üzere fosil yakıtlarının yanmasından ortaya çıkan sera gazı (CO2, CH4, SF6 vb.) emisyonlarının birim karbondioksit cinsinden ölçüsüdür.
                            </h5>
                            <h3>
                                Karbon Ayak İzini Nasıl Azaltacağını Öğrenmek İster Misin?
                            </h3>

                        </div>

                    </div>

                </div>
                <div class="row services-08-item--wrapper mt-0">
                        <div class="col-lg-4 col-md-4">
                            <a href="{{route('subject1')}}">
                                <div class="services-08-item">
                                    <div class="services-08-thumb index-logo">
                                        <i class="flaticon flaticon-eco-home"></i>
                                    </div>
                                    <div class="services-08-content">
                                        <h3 class="index-logo"> Evde </h3>
                                        <ul>
                                            <li>-İhtiyacından fazlasını almayarak.</li>
                                            <li>-Satın aldığımız ürünlerin karbon ayak izini öğrenip bilinç oluşturarak.</li>
                                            <li>-Plastik bardak ve pipet yerine kendi cam/metal pipet ve termosunu taşıyarak.</li>
                                            <li>
                                                <a href="{{route('subject1')}}">
                                                    <h5 style="color:#76c21b;">
                                                       Devam...
                                                    </h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <a href="{{route('subject1')}}">
                                <div class="services-08-item">
                                    <div class="services-08-thumb index-logo">
                                    <i class="flaticon flaticon-solar-panel"></i>
                                    </div>
                                    <div class="services-08-content">
                                        <h3 class="index-logo">Bahçede</h3>
                                        <ul>
                                            <li>-Çim yerine daha az su isteyen yeşil bitkiler yetiştirerek</li>
                                            <li>-Kimyasal ilaç ve gübre kullanmayarak.</li>
                                            <li>-Yaprakları kompost gübre yapımı için değerlendirerek.</li>
                                            <li>-Yağmur suyunu depolayıp sulamada kullanarak.</li>

                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <a href="{{route('subject1')}}">
                                <div class="services-08-item">
                                    <div class="services-08-thumb index-logo">
                                    <i class="flaticon flaticon-wind-energy"></i>
                                    </div>
                                    <div class="services-08-content">
                                        <h3 class="index-logo">Günlük Yaşamında</h3>
                                        <ul>
                                            <li>-Asansör yerine merdiveni tercih ederek.</li>
                                            <li>-Tek kullanımlık bardak tabak gibi ürünleri tercih etmeyerek..</li>
                                            <li>
                                                <a href="{{route('subject1')}}">
                                                    <h5 style="color:#76c21b;">
                                                       Devam...
                                                    </h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                <div class="row services-08-item--wrapper mt-0">
                        <div class="col-lg-4 col-md-4">
                            <a href="{{route('subject2')}}">
                                <div class="services-08-item">
                                    <div class="services-08-thumb index-logo">
                                    <i class="flaticon flaticon-customer-support"></i>
                                    </div>
                                    <div class="services-08-content">
                                        <h3 class="index-logo">Ulaşımda</h3>
                                        <ul>
                                            <li>-Yakın mesafeleri yürüyerek veya bisiklet kullanarak, uzak mesafeleri toplu taşıma araçları ile katederek.</li>
                                            <li>-Aynı yöne giden insanlarla aracımızı paylaşıp daha az karbon ayak izi bırakarak.</li>
                                            <li>
                                                <a href="{{route('subject2')}}">
                                                    <h5 style="color:#76c21b;">
                                                       Devam...
                                                    </h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <a href="{{route('subject3')}}">
                                <div class="services-08-item">
                                    <div class="services-08-thumb index-logo">
                                    <i class="flaticon flaticon-charging-station"></i>
                                    </div>
                                    <div class="services-08-content">
                                        <h3 class="index-logo"> Ofiste</h3>
                                        <ul>
                                            <li>-Enerji verimliliği yüksek cihazlar tercih ederek.</li>
                                            <li>-Kullanmadığımız elektronik cihazları uyku modunda bırakmayıp tam kapatarak.</li>
                                            <li>
                                                <a href="{{route('subject3')}}">
                                                    <h5 style="color:#76c21b;">
                                                       Devam...
                                                    </h5>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
        </section>
        <section id="work" class="pt-40 pb-70" style="background: url(img/bg/aliment-right2.png) no-repeat; background-position: right center;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title center-align mb-50 text-center">
                            <h2>
                            Konular
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="portfolio ">
                    <div class="grid col3">
                        <div class="grid-item website">
                            <a href="{{route('subject1')}}">
                                <figure class="gallery-image">
                                <img src="img/gallery/protfolio-img01.png" alt="img" class="img">
                                    <figcaption>
                                        <h4>Karbon Ayak İzi</h4>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <div class="grid-item seo">
                            <a href="{{route('subject2')}}">
                                <figure class="gallery-image">
                                <img src="img/gallery/protfolio-img02.png" alt="img" class="img">
                                    <figcaption>
                                        <h4>PARİS İKLİM ANLAŞMASI</h4>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                        <div class="grid-item marketing smm">
                            <a href="{{route('subject3')}}">
                                <figure class="gallery-image">
                                    <img src="img/gallery/protfolio-img03.png" alt="img" class="img">
                                    <figcaption>
                                        <h4>İKLİM KRİZİ İLE MÜCADELE ETMEMEMİZ DURUMUNDAKİ FEKALET SENARYOLARI NELER BİLİYOR MUSUN?</h4>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="graph" class="features-area pt-80 pb-80"  style="background:url('img/bg/cat-bg.png'); background-size: cover;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="section-title cta-title text-center mb-30">
                            <h2>İklim kriziyle mücadelede bizimle misin?</h2>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 text-center">
                        <a href="{{route('contact')}}" class="btn ss-btn">Bizimle İletişime Geçin</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
