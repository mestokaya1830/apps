<div class="admin-menu-con">
<header class="admin-left-header">
    <img src="{{ asset('/images/icons/1.png') }}" width="32" alt="">
    <div class="admin-left-title">Admin Menu</div>
</header>
<ul>
    <li id="banner" class="admin-left-list">
        <a href="{{url('/admin/banner')}}">
            <img src="{{asset('/images/icons/5.png')}}" width="26" alt="">
            <div>Banner</div>
        </a>
    </li>
    <li id="categories" class="admin-left-list">
        <a href="{{url('/admin/categories')}}">
           <img src="{{asset('/images/icons/2.png')}}" width="26" alt="">
            <div>Katagoriler</div>
        </a>
    </li>
    <li id="projects" class="admin-left-list">
        <a href="{{url('/admin/projects')}}">
            <img src="{{asset('/images/icons/3.png')}}" width="26" alt="">
            <div>Projeler</div>
        </a>
    </li>
    <li id="activities" class="admin-left-list">
        <a href="{{url('/admin/activities')}}">
            <img src="{{asset('/images/icons/4.png')}}" width="26" alt="">
            <div>Etkinlikler</div>
        </a>
    </li>
    <li id="uploadimage" class="admin-left-list">
        <a href="{{url('/admin/uploadimage')}}">
            <img src="{{asset('/images/icons/6.png')}}" width="26" alt="">
            <div>Resim Ekle</div>
        </a>
    </li>
</ul>
</div>
