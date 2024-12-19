@extends('backend.master')
@section('content')
<div class="admin-container">
  <div style="margin-left: 20px;">
    @if ($errors->any)
      @foreach ($errors->all() as $error)
          <div class="alert alert-danger m-1" role="alert">{{ $error }}</div>
      @endforeach
    @endif
  </div>
    <div class="row admin-rows">
      <form action="{{ route('projects.store') }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
            @csrf
            <input type="hidden" name="type" value="Projects">
            <select name="category" id="" class="inputs">
              @foreach ($categories as $item)
                  <option value="{{ $item->category }}">{{ $item->category }}</option>
              @endforeach
          </select>
            <input type="text" name="title" id="ptoject-title" class="inputs" minlength="2" maxlength="100" placeholder="Başlık" required>
            <textarea name="text" id="" cols="30" rows="10" class="inputs" minlength="20" maxlength="50000"  placeholder="Text" required></textarea>
            <input type="file" name="file" id="project-img" class="inputs" required>
            <input type="submit" id="add-project" value="Ekle">
        </form>
      </div>
</div>
@stop