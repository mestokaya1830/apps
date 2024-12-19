@extends('backend.dashboard')
@section('content')
<div id="panel-5" class="panel col-md-12">
  <div  class="custom-toolbar">
      <h2>
          Yeni Konu Ekle
      </h2>
  </div>
  <div class="panel-container show">
      <div class="panel-content p-0">
          <form class="needs-validation" action="{{route('quiz.store')}}" method="post">
            @csrf
              <div class="panel-content">
                  <div class="form-row">
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Başlık <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="title" id="validationTooltip01" value="{{old('title')}}" placeholder="Başlık" required>
                      </div>
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Açıklama <span class="text-danger">*</span> </label><br>
                          <textarea name="description" id="" cols="30" rows="2" style="width:100%;" placeholder="Açıklama" required>{{old('description')}}</textarea>
                      </div>
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Bitiş Tarihi <span class="text-danger">*</span> </label>
                          <input type="datetime-local"  class="form-control" name="finished_at" id="validationTooltip01" value="{{old('finished_at')}}" placeholder="Bitiş Tarihi" required>
                      </div>
                  </div>

              </div>
              <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                  <button class="btn btn-primary ml-auto" type="submit">Ekle</button>
              </div>
          </form>
          <script>

              (function()
              {
                  'use strict';
                  window.addEventListener('load', function()
                  {

                      var forms = document.getElementsByClassName('needs-validation');

                      var validation = Array.prototype.filter.call(forms, function(form)
                      {
                          form.addEventListener('submit', function(event)
                          {
                              if (form.checkValidity() === false)
                              {
                                  event.preventDefault();
                                  event.stopPropagation();
                              }
                              form.classList.add('was-validated');
                          }, false);
                      });
                  }, false);
              })();

          </script>
      </div>
  </div>
</div>
@stop
