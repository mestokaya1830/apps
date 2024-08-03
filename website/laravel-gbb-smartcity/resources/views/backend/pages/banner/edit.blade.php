@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
      <form action="{{ route('banner.update', $banner->id) }}" method="post"  class="resource" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="type" value="Banner" >
        <input type="text" name="title" id="banner-title" class="inputs" minlength="2" maxlength="100" placeholder="Başlık" value="{{ $banner->title }}" required>
        <textarea name="text" id="" cols="30" rows="5" name="text" class="inputs" minlength="20" maxlength="50000"  placeholder="Text" required>
          {{ $banner->text }}
        </textarea>
        <input type="text" name="link" id="banner-text" class="inputs" placeholder="Link" value="{{ $banner->link }}" required>
        <input type="file" name="img" id="banner-img" class="inputs">
        <input type="submit" id="add-banner" value="Kaydet" class="inputs">
    </form>
    </div>
</div>
@stop