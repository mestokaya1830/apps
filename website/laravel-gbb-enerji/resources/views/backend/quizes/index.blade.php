@extends('backend.dashboard')
@section('content')

 <div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="custom-toolbar">
          <h2>Konular</h2>
          <a href="{{route('quiz.create')}}" class="btn btn-success waves-effect waves-themed"><i class ="fal fa-plus fs-lg mr-2"></i>Konu Ekle</a>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th>Başlık</th>
                            <th class="col col-5">Açıklama</th>
                            <th>Durum</th>
                            <th>Bitiş Tarihi</th>
                            <th>Soru Sayısı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($quizes)
                        @foreach($quizes as $item)
                          <tr>
                              <td>{{$item->title}}</td>
                              <td class="col col-5"><textarea name="" id="" rows="2" disabled style="width: 100%;">{{$item->description}}</textarea></td>
                              <td>
                                  @switch($item->state)
                                  @case('aktif')
                                    <span class="badge badge-success badge-pill" style="font-size: 15px;width:100%;">{{$item->state}}</span>
                                  @break
                                  @case('taslak')
                                    <span class="badge badge-warning badge-pill" style="font-size: 15px;width:100%;">{{$item->state}}</span>
                                  @break
                                  @case('pasif')
                                    <span class="badge badge-danger badge-pill" style="font-size: 15px;width:100%;">{{$item->state}}</span>
                                  @break
                                  @default
                                    {{$item->state}}</td>
                                  @endswitch
                                </td>
                                <td title="{{$item->finished_at}}">{{$item->finished_at->diffForHumans()}}</td>
                              <td>{{$item->questions_count}}</td>
                              <td>
                                <a href="{{route('questions.index', $item->id)}}" style="color:#fff;" class="btn btn-primary waves-effect waves-themed">Sorular</a>
                                <a href="{{route('quiz.edit', $item->id)}}" style="color:#fff;" class="btn btn-success waves-effect waves-themed">Düzenle</a>
                                <form action="{{route('quiz.destroy', $item->id)}}" method="post" style="display:inline;">
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
