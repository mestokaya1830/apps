@extends('backend.dashboard')
@section('content')
<div id="panel-5" class="panel col-md-12">
  <div  class="custom-toolbar">
      <h2>
          {{$question->question}} İçin Güncelleme
      </h2>
  </div>
  <div class="panel-container show">
      <div class="panel-content p-0">
          <form class="needs-validation" action="{{route('questions.update',[$question->quizes_id, $question->id])}}" method="post">
            @method('put')
            @csrf
              <div class="panel-content">
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip01">Konu<span class="text-danger">*</span> </label>
                        <input type="text"  class="form-control" name="subject"  id="validationTooltip01" placeholder="Konu" required value="{{$question->subject}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip01">Seviye<span class="text-danger">*</span> </label>
                        <input type="text"  class="form-control" name="level" id="validationTooltip01" placeholder="Seviye" required value="{{$question->level}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationTooltip01">Sıra<span class="text-danger">*</span> </label>
                        <input type="text"  class="form-control" name="line" id="validationTooltip01" placeholder="Sıra" required value="{{$question->line}}">
                    </div>
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Soru <span class="text-danger">*</span> </label>
                          <textarea class="form-control" name="question" id="" cols="30" rows="2" style="width: 100%;" required placeholder="Soru">{{$question->question}}</textarea>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">A <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="A" id="validationTooltip01" placeholder="A" value="{{$question->A}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">B <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="B" id="validationTooltip01" placeholder="B" value="{{$question->B}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">C <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="C" id="validationTooltip01" placeholder="C" value="{{$question->C}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">D <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="D" id="validationTooltip01" placeholder="D" value="{{$question->D}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">Doğru Cevap <span class="text-danger">*</span> </label>
                          <select name="correct_answer" id="" class="form-control">
                            <option @if(old('correct_answer') == 'A') selected @endif value="A">A</option>
                            <option @if(old('correct_answer') == 'B') selected @endif value="B">B</option>
                            <option @if(old('correct_answer') == 'C') selected @endif value="C">C</option>
                            <option @if(old('correct_answer') == 'D') selected @endif value="D">D</option>
                          </select>
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
