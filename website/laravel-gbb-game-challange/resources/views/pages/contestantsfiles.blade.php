@extends('layout')
@section('content')
    <div class="main-content">
      <div class="container" style="padding:50px 0;">
        <h2>
            <span id="contestants-status" class="cl-g">Katılımcı Dosyaları</span>
        </h2>
        <div class="row">
          @foreach($files as $file)
            <div class="col-lg-12 col-md-12 col-sm-12">
              <a href="/downloadfile/{{$file}}" title="{{$file}}" style="display:flex;flex-direction:column;">
                <span>
                  <img src="{{asset('/images/zip.png')}}" alt="">
                  <span>{{$file}}</span>
                </span>
                <span class="download-btn">İndir</span>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </div> 
@stop