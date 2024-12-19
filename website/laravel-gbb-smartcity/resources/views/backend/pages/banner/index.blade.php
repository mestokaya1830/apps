@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <table class="table admin-table">
              <thead>
                  <tr class="list-column">
                      <th scope="col" class="col-2" style="text-align: left;">Resim</th>
                      <th scope="col">Başlık</th>
                      <th scope="col">Text</th>
                      <th scope="col">İşlemler</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($result as $item)
                      <tr class="list-rows">
                          <td scope="col" class="col-2" style="text-align: left;"><img src="{{ asset($item->img)}}" alt="" class="project-img"></td>
                          <td scope="col">{{ $item->title }}</td>
                          <td scope="col col-4" ><textarea class="adding-text" cols="50" rows="5" disabled>{{ $item->text }}</textarea></td>
                          <td scope="col">
                            <a href="{{route('banner.edit', $item->id)}}" class="btn btn-primary">Düzenle</a>
                            </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
    </div>
</div>
@stop
<script>
    //remove category
    const deleteBanner = async (id, e) => {
        const result = await fetch('/admin/banner/delete',{
          method:'POST',
          headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN':'{{csrf_token()}}'
          },
          body:JSON.stringify({
            id: id
          })
        })
        if(result.status === 200){
            e.target.parentNode.parentNode.remove()
        }
    }
</script>
