<div class="full-width-header header-style1 home1-modifiy home12-modifiy">
  <header id="rs-header" class="rs-header">
      <div class="topbar-area home11-topbar">
          <div class="container">
              <div class="row y-middle">
                  <div class="col-md-12">
                      <h3 class="home-text">
                          <div>
                            <a href="#" style="margin-right:10px;" onclick="openMenu()"><i class="fa fa-list"></i></a>
                            <a href="/"><i class="fa fa-home"></i></a>
                          </div>
                        @if(session()->has('admin'))
                            <span class="home-logout" onclick="logout()">Çıkış</span>
                        @endif
                      </h3>
                  </div>
              </div>
          </div>
      </div>
  </header>
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
