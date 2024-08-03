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
      <form action="{{ route('activities.update', $activity[0]->id) }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
        @method('PUT')
        @csrf
              <input type="hidden" name="type" value="Activities">
              <input type="text" name="title" id="activities-title" class="inputs" minlength="2" maxlength="50" value="{{ $activity[0]->title }}" placeholder="Başlık" required>
              <textarea name="text" id="" cols="30" rows="10" class="inputs" minlength="20" maxlength="50000"  placeholder="Text" required>{{ $activity[0]->text }}</textarea>
              {{-- <input type="file" name="file" id="activities-img" class="inputs"> --}}
              <input type="submit" id="add-activities" class="inputs" value="Kaydet">
          </form>
    </div>
</div>
@stop
