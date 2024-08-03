@extends('backend.dashboard')
@section('content')

 <div class="col-xl-12">
    <div id="panel-1" class="panel">
        <div class="custom-toolbar">
          <h2>Kullanıcılar</h2>
          <a href="{{route('users.create')}}" class="btn btn-success waves-effect waves-themed">Kullanıcı Ekle</a>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
               
                <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>Posta Adresi</th>
                            <th>Yetki</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if($users)
                        @foreach($users as $item)
                          <tr>
                              <td>{{$item->name}}</td>
                              <td>{{$item->email}}</td>
                              <td>{{$item->role}}</td>
                              <td>{{$item->created_at}}</td>
                              <td>
                                <a href="{{route('users.edit', $item->id)}}" style="color:#fff;" class="btn btn-success waves-effect waves-themed">Düzenle</a>
                                
                                <form action="{{route('users.destroy', $item->id)}}" method="post" style="display:inline;">
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