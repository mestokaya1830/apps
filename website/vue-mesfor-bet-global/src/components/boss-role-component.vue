<template>
  <div>
   <ul>
    <li class="admin-menu-links">
      <header class="title-1">Kupon İşlemleri</header>
      <router-link to="/admin" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9878;</span>
        <span class="admin-menu-text">Kuponlar</span>
      </router-link>
      <router-link to="/admin/singel-bets" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9878;</span>
        <span class="admin-menu-text">Tek Maça Kalanlar</span>
      </router-link>
    </li>
    <li class="admin-menu-links">
      <header class="title-1">Üyeler</header>
      <router-link to="/admin/users" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9785;</span>
        <span class="admin-menu-text">Üyeler</span>
      </router-link>
      <router-link to="/admin/add-user" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9785;</span>
        <span class="admin-menu-text">Üye Ekle</span>
      </router-link>
      <router-link to="/admin/profile" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9785;</span>
        <span class="admin-menu-text">Profil</span>
      </router-link>
    </li>
    <li class="admin-menu-links">
      <header class="title-1">Genel</header>
      <router-link to="/admin/rules" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9907;</span>
        <span class="admin-menu-text">Bahis Kuralları</span>
      </router-link>
      <router-link to="/admin/advise-post" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9876;</span>
        <span class="admin-menu-text">Şikayet ve Öneriler</span>
      </router-link>
      <router-link to="/admin/advise-list" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9776;</span>
        <span class="admin-menu-text">Advise List</span>
      </router-link>
      <router-link to="/admin/boss" class="admin-links" exact-active-class="active" >
        <span class="admin-menu-icons">&#9813;</span>
        <span class="admin-menu-text">Boss</span>
      </router-link>
    </li>
   </ul>
  </div>
</template>