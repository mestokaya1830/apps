@extends('welcome')
@section('content')
<section  class="contact-area after-none contact-bg pt-120 pb-120" >
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="contact-bg02 wow fadeInLeft  animated">
                <div class="section-title center-align">
                   <h5>Katılım Formu</h5>
                </div>
                @if($errors->any)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger m-1" role="alert">{{$error}}</div>
                    @endforeach
                @endif
                <form action="{{route('joiner.signup')}}" method="post">
                    @csrf
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-name mb-30">
                            <input type="text" id="name" name="name" placeholder="Ad" required value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-email mb-20">
                            <input type="text" id="lastname" name="lastname" placeholder="Soyad" required value="{{old('lastname')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-subject mb-30">
                            <input type="number"  id="identity" name="identity" onblur="tckimlikkontorolu(this)" onkeydown="tckimlikkontorolu(this)" placeholder="TC" required value="{{old('identity')}}">
                            <p id="tc-msg"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-field p-relative c-subject mb-30">
                            <input type="number" id="phone" name="phone" min="10"  placeholder="Tel" required value="{{old('phone')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">

                        <div class="slider-btn">
                            <button type="submit" id="submit" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">GÖNDER</button>
                        </div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>

</section>
<script>

const tckimlikkontorolu = (tcno) => {
	let tckontrol,toplam; tckontrol = tcno; tcno = tcno.value; toplam = Number(tcno.substring(0,1)) + Number(tcno.substring(1,2)) +
	Number(tcno.substring(2,3)) + Number(tcno.substring(3,4)) +
	Number(tcno.substring(4,5)) + Number(tcno.substring(5,6)) +
	Number(tcno.substring(6,7)) + Number(tcno.substring(7,8)) +
	Number(tcno.substring(8,9)) + Number(tcno.substring(9,10));
	let strtoplam = String(toplam);
    let onunbirlerbas = strtoplam.substring(strtoplam.length,strtoplam.length-1);
	if(onunbirlerbas == tcno.substring(10,11)) {
        document.getElementById('submit').disabled = false
		document.getElementById('tc-msg').innerText = ''
	} else{
        document.getElementById('submit').disabled = true
		document.getElementById('tc-msg').innerText = 'Bu TC numarası geçersiz!'
	}
}
</script>
@stop
