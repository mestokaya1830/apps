@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
      <div style="margin-left: 20px;">
        @if ($errors->any)
          @foreach ($errors->all() as $error)
              <div class="alert alert-danger m-1" role="alert">{{ $error }}</div>
          @endforeach
        @endif
      </div>
      <form action="{{ route('categories.store') }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
        @csrf
        <input type="hidden" name="type" id="category" value="categories">
        <input type="text" name="category" id="categories-title" class="inputs" minlength="2" maxlength="100" placeholder="Kategori" required>
        <input type="file" name="file" id="project-img" class="inputs" required>
        <input type="submit" id="add-category" value="Ekle" class="inputs">
      </form>
    </div>
</div>
@stop
