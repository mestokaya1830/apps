<x-layout title="Admin">
    @if ($post)
    <div class="row justify-content-center">
        <div class="col-sm-6">
                <h1>{{ $post->title }} / {{ $post->user->name }}</h1>
                <a href="{{route('admin.index')}}">Return</a>
                <div class="card">
                    <div class="card-body">
                        <img src="{{asset('storage/'.$post->image)}}" alt="">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->diffForHumans() }} </h6>
                        <p class="card-text">{{ $post->body }}</p>
                        <div class="d-flex">
                            <form action="{{route('admin.destroy', $post)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Post</button>
                                <a href="{{route('admin.edit', $post)}}"><button type="button" class="btn btn-warning">Edit Post</button></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layout>
