<x-layout title="Register">
    <div class="container">
        <h1 style="margin-bottom: 30px;">Register</h1>
        <form action="{{route('register')}}" method="post" class="container border rounded p-5">
            @csrf
            <div class="mb-3 row">
                <label for="name" class="form-label">Name</label>
                <div>
                    <input type="name" class="form-control" name="name" id="name" value="{{old('name')}}">
                    <div class="text text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
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
            <div class="mb-3 row">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-lg">Register</button>
            </div>
        </form>
    </div>
</x-layout>
