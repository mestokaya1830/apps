<template>
  <div>
    <footer class="footer">
      <div class="footer-top">
        <a href="https://www.facebook.com/profile.php?id=100051821220013" target="_blank"><img src="@/assets/img/facebook.webp" alt = "" class="social-icons mr20"/></a>
        <a href="https://www.instagram.com/mes.for/" target="_blank"><img src="@/assets/img/instagram.webp" alt="" class="social-icons"/></a>
      </div>
      <div class="footer-bottom">
        <img src="@/assets/img/18.webp" class="mr20" />
        <span class="text">Sistemimizi 18 yaşından büyükler ve yurtdışında ikamet edenler kullanabilirler...!</span>
      </div>
    </footer>
  </div>
</template>

<style scoped>
.footer{
  background-color: var(--black);
  padding: 10px;
  box-shadow: 5px 0 10px #000;
}
.text{
  color: #fff;
}
.footer-top{
  display: flex;
  align-items: center;
  height:auto;
}
.footer-bottom{
  display: flex;
  align-items: center;
}
.social-icons{
  margin: 20px;
  height: calc(40px + 0.5vw);
}
</style>