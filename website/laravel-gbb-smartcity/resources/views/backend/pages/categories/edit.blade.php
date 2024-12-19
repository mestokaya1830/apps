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
      <form action="{{ route('categories.update', $category[0]->id) }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
        @method('PUT')
        @csrf
        <input type="hidden" name="type" id="category" value="categories">
        <input type="text" name="category" id="categories-title" class="inputs" minlength="2" maxlength="100" value="{{ $category[0]->category }}" placeholder="Kategori" required>
        <input type="file" name="img" id="project-img" class="inputs">
        <input type="submit" id="add-category" class="inputs" value="Kaydet">
      </form>
    </div>
</div>
@stop
