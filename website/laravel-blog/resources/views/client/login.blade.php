<x-layout title="Login">
    <div class="container">
        <h1 style="margin-bottom: 30px;">Login</h1>
        <form action="{{route('login')}}" method="post" class="container border rounded p-5">
            @csrf
            <div class="mb-3 row">
                <label for="email" class="form-label">Email</label>
                <div>
                    <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}">
                    <div class="text text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="form-label">Password</label>
                <div>
                    <input type="password" class="form-control" name="password" id="inputPassword">
                    <div class="text text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me?
                </label>
            </div>
            <div class="text text-danger">
                @error('credential')
                    {{$message}}
                @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-lg">Login</button>
            </div>
        </form>
    </div>
</x-layout>
