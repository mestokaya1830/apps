<nav class="navbar">
    <div>
        <a href="{{route('client.index')}}" class="links {{Route::is('client.index') ? 'active' : 'inActive'}}">Home</a>
        <a href="{{route('client.about')}}" class="links {{Route::is('client.about') ? 'active' : 'inActive'}}">About</a>
        <a href="{{route('client.contact')}}" class="links {{Route::is('client.contact') ? 'active' : 'inActive'}}">Contact</a>
    </div>

    @guest
        <div>
            <a href="{{ route('register') }}" class="links">Register</a>
            <a href="{{ route('login') }}" class="links">Login</a>
        </div>
    @endguest
    @auth
        <div style="display: flex;align-items:center;">
            <a href="{{route('admin.index')}}" class="links {{Route::is('admin.index') ? 'active' : 'inActive'}}">{{ auth()->user()->name }}</a>
            <div class="dropdown">
                <img src="https://picsum.photos/200/300" alt="" class="btn btn-secondary dropdown-toggle"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{route('admin.index')}}">Posts</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    @endauth
</nav>
