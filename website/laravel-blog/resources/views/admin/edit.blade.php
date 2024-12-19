<x-layout title="Edit">
    @if ($post)
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h1>{{ $post->title }} / {{ $post->user->name }}</h1>
                <div class="card">
                    <form action="{{ route('admin.update', $post) }}" method="post" enctype="multipart/form-data" class="card-body">
                        @csrf
                        @method('PUT')
                        <a href="{{route('admin.index')}}">Return</a>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="">
                        <div class="text text-danger">
                            @error('image')
                                {{ $message }}
                            @enderror
                        </div>
                        <label for="title">Title</label>
                        <input type="text" class="form-control mb-3" name="title" id="title"
                            value="{{ $post->title }}">
                        <div class="text text-danger">
                            @error('title')
                                {{ $message }}
                            @enderror
                        </div>
                        <label for="body">Body</label>
                        <textarea name="body" class="form-control mb-3" id="body" cols="30" rows="10">{{ $post->body }}</textarea>
                        <div class="text text-danger">
                            @error('body')
                                {{ $message }}
                            @enderror
                        </div>

                        <div class="mt-3">
                            <input type="file" name="image" id="image">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mt-3">Update Post</button>
                        </div>
                </div>
            </div>
        </div>
    @endif
</x-layout>
