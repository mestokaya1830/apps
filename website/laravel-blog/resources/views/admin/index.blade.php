<x-layout title="Admin Posts">
    <div class="d-flex justify-content-between">
        <h2 style="margin-bottom: 30px;">{{Auth::user()->name}} Posts / {{$posts->total()}}</h2>
        <h2><a class="btn btn-primary" href="{{ route('admin.create') }}">Create New Post</a></h2>
    </div>
    @if ($posts)
        <div class="row">
            @foreach ($posts as $item)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{asset('storage/'.$item->image)}}" alt="">
                            <h3 class="card-title">{{ $item->title }}</h3>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $item->created_at->diffForHumans() }} / </h6>
                            <p class="card-text">{{ Str::words($item->body, 25, '...') }}</p>
                            <a href="{{route('admin.show', $item)}}" class="card-link">read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="pagination pagination-lg justify-content-end">{{ $posts->links() }}</div>
</x-layout>
