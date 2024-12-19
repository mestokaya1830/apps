<div class="admin-header">
    <div>
        <a href="#" class="header-text" onclick="openMenu()">

        </a>
        <a href="/" class="header-text">
            <img src="{{asset('images/home.png')}}" alt="" />
        </a>
      </div>
    @if(session()->has('admin'))
        <img src="{{asset('images/logout.png')}}" alt="" onclick="logout()" class="header-text"/>
    @endif
</div>
<script>
    const logout = async () => {
        const result = await fetch('/logout', {
            method: 'DELETE',
            headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'}
        })
        if(result){
            window.location.href= "/"
        }
    }
    const openMenu = () => {
        document.getElementById('admin-left').style.display = 'block'
        document.getElementById('admin-left').style.top = 0
    }
</script>
