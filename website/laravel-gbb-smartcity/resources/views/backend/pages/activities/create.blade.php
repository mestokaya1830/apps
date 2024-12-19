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
      <form action="{{ route('activities.store') }}" method="post"  class="resource" enctype="multipart/form-data" class="resource">
              @csrf
              <input type="hidden" name="type" value="Activities">
              <input type="text" name="title" id="activities-title" minlength="2" maxlength="100" class="inputs" placeholder="Başlık" required>
              <textarea name="text" id="" cols="30" rows="10" class="inputs" minlength="20" maxlength="50000"  placeholder="Text" required></textarea>
              <input type="file" name="file" id="activities-img" class="inputs" required>
              <input type="submit" id="add-activities"  value="Ekle">
          </form>
    </div>
</div>
@stop
