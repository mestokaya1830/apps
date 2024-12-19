@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Proje Ekle</a>
          <table class="table admin-table project-table">
              <thead>
                  <tr class="list-column">
                      <th >Resim</th>
                      <th >Kategori</th>
                      <th >Başlık</th>
                      <th >Text</th>
                      <th >İşlemler</th>
                  </tr>
              </thead>
              <tbody>
                  @isset($result)
                    @foreach($result as $item)
                        <tr class="list-rows">
                            <td>
                                <img src="{{ asset('/uploads/projects/'.$item->title.'/'.$item->img)}}" alt="" class="project-img">
                            </td>
                            <td >{{ $item->category }}</td>
                            <td >{{ $item->title }}</td>
                            <td ><textarea class="adding-text" cols="50" rows="1" disabled>{{ $item->text }}</textarea></td>
                            <td>
                                <a href="{{route('projects.edit', $item->id)}}" class="del-btn-warning" id="edit-project">Düzenle</a>
                                <button class="del-btn-danger" onclick="deleteProject({{$item->id}},'{{$item->title}}', event)">Sil</button>
                            </td>
                        </tr>
                    @endforeach
                  @endisset
                  @isset($msg)
                        {{$msg}}
                    @endisset
              </tbody>
          </table>
        </div>
    </div>
</div>
@stop
<script>
    //remove project
    const deleteProject = async (id,project, e) => {
        let check = "Bu proje silinsinmi?";
        if (confirm(check) == true) {
            const result = await fetch(`{{route('projects.destroy', '')}}/${id}`,{
              method:'DELETE',
              headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN':'{{csrf_token()}}'
              },
              body:JSON.stringify({
                project:project
              })
            })
            if(result.status === 200){
                e.target.parentNode.parentNode.remove()
            }
        } else {
            check = "You canceled!";
        }
    }
</script>
