<template>
  <div>
    <ul>
      <li class="menu-1 title-2 fjcac">Üye</li>
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
        <header class="title-1">Raporlar</header>
        <router-link to="/admin/coupon-report" class="admin-links" exact-active-class="active" >
          <span class="admin-menu-icons">&#9910;</span>
          <span class="admin-menu-text">Kupon Raporu</span>
        </router-link>
        <router-link to="/admin/game-logs" class="admin-links" exact-active-class="active" >
          <span class="admin-menu-icons">&#9910;</span>
          <span class="admin-menu-text">Oyun Geçmişi</span>
        </router-link>
        <router-link to="/admin/credit-logs" class="admin-links" exact-active-class="active" >
          <span class="admin-menu-icons">&#9910;</span>
          <span class="admin-menu-text">Bakiye Geçmişi</span>
        </router-link>
        <router-link to="/admin/login-logs" class="admin-links" exact-active-class="active" >
          <span class="admin-menu-icons">&#9910;</span>
          <span class="admin-menu-text">Oturum Geçmişi</span>
        </router-link>
      </li>
      <li class="admin-menu-links">
        <header class="title-1">Üye</header>
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