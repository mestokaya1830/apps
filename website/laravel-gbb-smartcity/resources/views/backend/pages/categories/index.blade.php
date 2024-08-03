@extends('backend.master')
@section('content')
<div class="admin-container">
    <div class="row admin-rows">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Kategory Ekle</a>
            <table class="table admin-table">
                <thead>
                    <tr class="list-column">
                        <th scope="col" class="col-2" style="text-align: left;">Resim</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Tarih</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $item)
                    <tr class="list-rows">
                        <td scope="col" class="col-2" style="text-align: left;"><img src="{{ asset('/uploads/categories/'.$item->category.'/'.$item->img)}}" alt="" class="project-img"></td>
                        <td scope="col">{{ $item->category }}</td>
                        <td scope="col">{{ $item->created_at }}</td>
                        <td scope="col">
                            <a href="{{route('categories.edit', $item->id)}}" class="del-btn-warning" id="edit-category">Düzenle</a>
                            <button class="del-btn-danger" onclick="deleteCategory({{$item->id}}, '{{$item->category}}', event)">Sil</button>
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
    const deleteCategory = async (id, category, e) => {
        let check = "Bu kategori silinsinmi?";
        if (confirm(check) == true) {
            const result = await fetch(`{{route('categories.destroy', '')}}/${id}`,{
              method:'DELETE',
              headers: {
                  Accept: 'application/json',
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN':'{{csrf_token()}}'
              },
              body:JSON.stringify({
                category:category
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
