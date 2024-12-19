@extends('backend.dashboard')
@section('content')

 <div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="custom-toolbar">
          <h2>{{$quiz->title}}</h2>
          <a href="{{route('questions.create', $quiz->id)}}" class="btn btn-success waves-effect waves-themed"><i class ="fal fa-plus fs-lg mr-2"></i>Soru Ekle</a>
        </div>
        
        <div class="panel-container show">
            <div class="panel-content">
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th class="col col-5">Soru</th>
                            <th>Konu</th>
                            <th>Seviye</th>
                            <th>Sıra</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>Dogru Cevap</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($quiz->questions)
                        @foreach($quiz->questions as $item)
                          <tr>
                              <td class="col col-5"><textarea name="" id="" rows="2" disabled style="width: 100%;">{{$item->question}}</textarea></td>
                              <td>{{$item->subject}}</td>
                              <td>{{$item->level}}</td>
                              <td>{{$item->line}}</td>
                              <td>{{$item->A}}</td>
                              <td>{{$item->B}}</td>
                              <td>{{$item->C}}</td>
                              <td>{{$item->D}}</td>
                              <td>{{$item->correct_answer}}</td>
                              <td>
                                <a href="{{route('questions.edit', [$quiz->id, $item->id])}}" style="color:#fff;" class="btn btn-success waves-effect waves-themed">Düzenle</a>
                                <form action="{{route('questions.destroy', [$quiz->id, $item->id])}}" method="post" style="display:inline;">
                                  @method('delete')
                                  @csrf
                                  <button type="submit" class="btn btn-danger waves-effect waves-themed">Sil</button>
                                </form>
                              </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(function(){
        $('#dt-basic-example').dataTable();
    });
</script>

@endsection
