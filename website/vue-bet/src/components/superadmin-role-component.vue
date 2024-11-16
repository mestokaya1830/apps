<template>
  <div>
    <ul>
      <li class="menu-1 title-2 fjcac">Superadmin</li>
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
      </li>
    </ul>
  </div>
</template>