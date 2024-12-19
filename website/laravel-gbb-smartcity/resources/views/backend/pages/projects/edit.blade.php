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
      <form action="{{ route('projects.update', $projects[0]->id) }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
        @method('PUT')
        @csrf
            <input type="hidden" name="type" value="Projects">
            <select name="category" id="" class="inputs">
                @foreach ($categories as $item)
                    <option value="{{ $item->category }}">{{ $item->category }}</option>
                @endforeach
            </select>
            <input type="text" name="title" id="ptoject-title" class="inputs" minlength="2" maxlength="100" value="{{ $projects[0]->title }}" placeholder="Başlık" required>
            <textarea name="text" id="" cols="30" rows="10" class="inputs" minlength="20" maxlength="50000"  placeholder="Text" required>{{ $projects[0]->text }}</textarea>
            {{-- <input type="file" name="file" id="project-img" class="inputs"> --}}
            <input type="submit" id="add-project" class="inputs" value="Kaydet">
        </form>
    </div>
</div>
@stop

