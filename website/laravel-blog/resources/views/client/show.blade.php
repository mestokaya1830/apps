<x-layout title="Home">
    @if ($post)
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <h3>{{ $post->title }} / {{$post->user->name}}</h3>
            <a href="{{route('client.user.posts', $post->user)}}">Return</a>
            <div class="card">
                    <div class="card-body">
                        <img src="{{asset('storage/'.$post->image)}}" alt="">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->diffForHumans() }} / {{$post->user->name}}</h6>
                        <p class="card-text">{{ $post->body }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layout>
