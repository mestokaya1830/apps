@extends('backend.dashboard')
@section('content')
<div id="panel-5" class="panel col-md-12">
  <div  class="custom-toolbar">
      <h2>
          Yeni Kullanıcı Ekle
      </h2>
  </div>
  <div class="panel-container show">
      <div class="panel-content p-0">
          <form class="needs-validation" action="{{route('users.store')}}" method="post">
            @csrf
              <div class="panel-content">
                  <div class="form-row">
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Ad <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="name" id="validationTooltip01" placeholder="Ad" required>
                          
                      </div>
                      <div class="col-md-12 mb-3">
                        <label class="form-label" for="validationTooltip03">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                          </div>
                          <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninvalid="this.setCustomValidity('Posta Adresi Formata Uygun Degil')" oninput="setCustomValidity('')" class="form-control" class="form-control" name="email" id="validationTooltip03" placeholder="Email" aria-describedby="inputGroupPrepend2" required>
                          <div class="invalid-tooltip">
                            Kullanıcı Adı
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip02">Şifre <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="password" id="validationTooltip02" placeholder="Şifre" required>
                         
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
