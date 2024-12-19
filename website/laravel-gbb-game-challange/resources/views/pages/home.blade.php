@extends('layout')
@section('content')
    <div class="full-width-header header-style2">
        <header id="rs-header" class="rs-header">
            <div class="menu-area menu-sticky home-banner">
                    <div class="row y-middle">
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <div class="logo-cat-wrap">
                                <a href="http://www.gaziantepbilisim.com.tr" target="_blank" class="logo-link">
                                    <img src="{{ asset('/images/Gaziantep bilişim logo.png') }}" alt="" id="ga-logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 apply-btn-desktop">
                            <div class="logo-cat-wrap">
                                <a href="register" class="apply-btn-link">Hemen Başvur</a>
                            </div>
                        </div>
                    </div>
            </div>

        </header>
    </div>
    <div class="main-content">
        <div class="rs-banner style5">
            <img src="{{ asset('/images/biappyaz.jpeg') }}" alt="" style="width: 100vw;">
        </div>
        <div class="rs-services rs-service-custom style2 pt-100 md-pt-80 mt-5">
            <div class="container">
                <div class="row apply-btn-res">
                    <a href="register.html" class="apply-btn-link">Hemen Başvur</a>
                </div>
                <div class="row y-middle">
                    <div class="col-lg-6">
                        <div class="sec-title">
                            <h2 class="title mb-0">Eğitim Ödülleri</h2>
                            <p class="primary-custom">Kazanalara verilecek eğitimler!</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/market.png')}}"/></span>
                                <h4 class="title"><a href="#">Mobil Market Eğitimi</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="600ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/game.png')}}"/></span>
                                <h4 class="title"><a href="#">Oyun içi Reklam Geliri Nasıl Elde Edilir?</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/facebook.png')}}"/></span>
                                <h4 class="title"><a href="#">Facebook Market İpuçları</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="service-item wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/unity.png')}}"/></span>
                                <h4 class="title"><a href="#">Unity Püf Noktaları</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rs-services  style2 pt-100 md-pt-80 mb-5 mt-5">
            <div class="container">
                <div class="row apply-btn-res">
                    <a href="register" class="apply-btn-link">Hemen Başvur</a>
                </div>
                <div class="row y-middle">
                    <div class="col-lg-6">
                        <div class="sec-title">
                            <h2 class="title mb-0">Para Ödülleri</h2>
                            <p class="primary-custom">Kazanalara verilecek para ödüllleri!</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/o1.png')}}"/></span>
                                <h4 class="title money-title"><a href="#">3.000 TL Ödül</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="600ms" data-wow-duration="2000ms">
                            <div class="content-part">
                            <span class="icon-part"><img src="{{asset('/images/o2.png')}}"/></span>
                                <h4 class="title money-title"><a href="#">2.000 TL Ödül</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                            <div class="content-part">
                            <span class="icon-part"><img src="{{asset('/images/o3.png')}}"/></span>
                                <h4 class="title money-title"><a href="#">1.000 TL Ödül</a></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="rs-services  style2 pt-100 md-pt-80">
            <div class="container">
                <div class="row apply-btn-res">
                    <a href="register.html" class="apply-btn-link">Hemen Başvur</a>
                </div>
                <div class="row y-middle mb-5">
                    <div class="col-lg-6">
                        <div class="sec-title">
                            <h2 class="title mb-0">Extra Ödüller</h2>
                            <p class="primary-custom">Kazanalara verilecek extra ödülller!</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/extra.png')}}" width=200/></span>
                                <h4 class="title"><a href="#">1 Yıl Boyunca</a></h4>
                                <p class="primary-custom">MENTOR/EĞİTMEN/NETWORK</p>
                                <p class="primary-custom2">MASRAFLARI BİZDEN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="600ms" data-wow-duration="2000ms">
                            <div class="content-part">
                                <span class="icon-part"><img src="{{asset('/images/extra.png')}}" width=200/></span>
                                <h4 class="title"><a href="#">2 Yıl Boyunca</a></h4>
                                <p class="primary-custom">MARKET</p>
                                <p class="primary-custom2">MASRAFLARI BİZDEN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 md-mb-30">
                        <div class="service-item wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                            <div class="content-part content-part-bottom">
                                <span class="icon-part"><img src="{{asset('/images/extra.png')}}" width=200/></span>
                                <h4 class="title"><a href="#">2 Yıl Boyunca</a></h4>
                                <p class="primary-custom">Uygulama Reklam Kârının 90%'ı kazanan ekiplere verilecektir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rs-counter style2-about">
            <div class="container mb-5">
                <div class="row couter-area">
                    <div class="col-lg-4 col-md-6 md-mb-30">
                        <div class="counter-item text-center">
                            <h2 id="contestants" class="cl-g">0</h2>
                            <h4 class="title mb-0">Katılımcı Sayısı</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 md-mb-30">
                        <div class="counter-item text-center">
                            <h2 id="winners" class="cl-g">0</h2>
                            <h4 class="title mb-0">Kazananlar</h4>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="counter-item text-center">
                            <h2 id="invalids" class="cl-g">0</h2>
                            <h4 class="title mb-0">Geçersizler</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-10 col-md-10 col-sm-10" style="margin:auto;">
            <h2>Kazananlar</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr class="contestants-column-left">
                        <th scope="col">Ad</th>
                        <th scope="col">Soyad</th>
                        <th scope="col">Durum</th>
                        <th scope="col">Derece</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($winner)
                        @foreach($winner as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->lastname}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->line}}</td>
                        </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div> --}}
    </div>

    <script>
        //home counter----------------------------------------------
        const getCounter = async () => {
            const result = await fetch('/contestantscount')
            const final  = await result.json()
            const allData = final.contestants
            document.getElementById('contestants').innerText = allData.filter(item => item.id).length
            document.getElementById('winners').innerText = allData.filter(item => item.status === 'Kazandı').length
            document.getElementById('invalids').innerText = allData.filter(item => item.status === 'Geçersiz').length
        }
        getCounter()
    </script>
@stop
