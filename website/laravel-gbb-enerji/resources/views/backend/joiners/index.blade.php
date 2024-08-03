@extends('backend.dashboard')
@section('content')

 <div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="custom-toolbar">
          <h2>Katılımcılar</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>Soyad</th>
                            <th>Telefon</th>
                            <th>TC</th>
                            <th>Doğru Sayısı</th>
                            <th>Yanlış Sayısı</th>
                            <th>Katılım Tarihi</th>
                            <th>Bitiş Tarihi</th>
                            <th>Süre</th>
                            <th>Puan</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($joiners)
                        @foreach($joiners as $item)
                            <tr>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['lastname']}}</td>
                                <td>{{$item['phone']}}</td>
                                <td>{{$item['identity']}}</td>
                                @foreach($item['results'] as $item2)
                                    <td>{{$item2->correct_count}}</td>
                                    <td>{{$item2->wrong_count}}</td>
                                    <td>{{$item2->start_time}}</td>
                                    <td>{{$item2->created_at}}</td>
                                    <td>{{$item2->diff}} .sn</td>
                                    <td>{{$item2->score}}</td>
                                    <td>
                                        <a href="{{route('joiners.details',
                                        [$item->id, $item2->quizes_id])}}"
                                        style="color:#fff;"
                                        class="btn btn-success waves-effect waves-themed">Detaylar</a>
                                    </td>
                                @endforeach
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
