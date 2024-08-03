@extends('backend.dashboard')
@section('content')
<div id="panel-5" class="panel col-md-12">
  <div  class="custom-toolbar">
      <h2>
          {{$quiz->title}} İçin Soru Oluştur
      </h2>
  </div>
  <div class="panel-container show">
      <div class="panel-content p-0">
          <form class="needs-validation" action="{{route('questions.store', $quiz->id)}}" method="post">
            @csrf
              <div class="panel-content">
                  <div class="form-row">
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">Konu<span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="subject"  id="validationTooltip01" placeholder="Konu" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">Seviye<span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="level" id="validationTooltip01" placeholder="Seviye" required value="{{old('level')}}">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">Sıra<span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="line" id="validationTooltip01" placeholder="Sıra" required value="{{old('line')}}">
                      </div>
                      <div class="col-md-12 mb-3">
                          <label class="form-label" for="validationTooltip01">Soru <span class="text-danger">*</span> </label>
                          <textarea class="form-control" name="question" id="" cols="30" rows="2" style="width: 100%;" required placeholder="Soru">{{old('question')}}</textarea>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">A <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="A" id="validationTooltip01" placeholder="A" required value="{{old('A')}}">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">B <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="B" id="validationTooltip01" placeholder="B" required value="{{old('B')}}">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">C <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="C" id="validationTooltip01" placeholder="C" value="{{old('C')}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label" for="validationTooltip01">D <span class="text-danger">*</span> </label>
                          <input type="text"  class="form-control" name="D" id="validationTooltip01" placeholder="D" value="{{old('D')}}" required>
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label">Doğru Cevap <span class="text-danger">*</span> </label>
                          <select name="correct_answer" id="" class="form-control">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                          </select>
                      </div>

                  </div>

              </div>
              <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                  <button class="btn btn-primary ml-auto" type="submit">Ekle</button>
              </div>
          </form>
      </div>
  </div>
</div>
@stop
