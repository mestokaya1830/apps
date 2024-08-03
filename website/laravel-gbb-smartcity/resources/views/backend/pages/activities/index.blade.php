@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <a href="{{ route('activities.create') }}" class="btn btn-primary">Etkinlik Ekle</a>
          <table class="table admin-table">
              <thead>
                  <tr class="list-column">
                      <th scope="col" class="col-2" style="text-align: left;">Resim</th>
                      <th scope="col">Başlık</th>
                      <th scope="col" class="col-6">Text</th>
                      <th scope="col">İşlemler</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($result as $item)
                      <tr class="list-rows">
                          <td scope="col" class="col-2" style="text-align: left;"><img src="{{ asset('/uploads/activities/'.$item->title.'/'.$item->img)}}" alt="" class="project-img"></td>
                          <td scope="col col-5">{{ $item->title }}</td>
                          <td scope="col col-4"><textarea class="adding-text" cols="50" rows="1" disabled>{{ $item->text }}</textarea></td>
                          <td scope="col" style="display: flex;">
                            <a href="{{route('activities.edit', $item->id)}}" class="del-btn-warning" id="edit-activities">Düzenle</a>
                              <button class="del-btn-danger" onclick="deleteActivity({{$item->id}}, '{{$item->title}}', event)">Sil</button></td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
    </div>
</div>
@stop
<script>
    const deleteActivity = async (id,activiti, e) => {
        let check = "Bu etkinlik silinsinmi.";
        if (confirm(check) == true) {
            const result = await fetch(`{{route('activities.destroy', '')}}/${id}`,{
              method:'DELETE',
              headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN':'{{csrf_token()}}'
              },
              body:JSON.stringify({
                activiti:activiti
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
