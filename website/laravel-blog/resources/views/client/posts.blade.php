<x-layout title="Home">
    <h1>{{ $user }} Posts   / {{$posts->total()}}</h1>
    <a href="{{route('client.index')}}">Return</a>
    @if ($posts)
        <div class="row">
            @foreach ($posts as $item)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{asset('storage/'.$item->image)}}" alt="">
                            <h3 class="card-title">{{ $item->title }}</h3>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $item->created_at->diffForHumans() }} / <a href="{{route('client.user.posts', $item->user)}}">{{$item->user->name}}</a></h6>
                            <p class="card-text">{{ Str::words($item->body, 25, '...') }}</p>
                            <a href="{{route('client.show', $item)}}" class="card-link">Read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="pagination pagination-lg justify-content-end">{{ $posts->links() }}</div>
</x-layout>
