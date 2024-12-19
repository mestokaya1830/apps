@extends('backend.dashboard')
@section('content')
<div id="panel-5" class="panel col-md-12">
  <div  class="custom-toolbar">
      <h2>
         Kullanıcı Güncelle
      </h2>
  </div>
  <div class="panel-container show">
      <div class="panel-content p-0">
          <form class="needs-validation" action="{{route('users.update',$users->id)}}" method="post">
            @method('put')
            @csrf
              <div class="panel-content">
                  <div class="form-row">
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Ad <span class="text-danger">*</span> </label>
                          <input type="text" class="form-control" name="name" value="{{$users->name}}" placeholder="Ad" required>
                          
                      </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label" for="validationTooltip03">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                          </div>
                          <input type="email" class="form-control" name="email" value="{{$users->email}}" placeholder="Email" aria-describedby="inputGroupPrepend2" disabled>
                          
                        </div>
                      </div>
                  </div>
                  
              </div>
              <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
              
                  <button class="btn btn-primary ml-auto" type="submit">Kaydet</button>
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
