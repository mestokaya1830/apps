<template>
  <div id="app" @scroll="updateScroll()">
    <RouterView class="app-page" />
    <span
      v-if="scrollState"
      ref="btnScroll"
      class="scroll-top"
      @click="scrollTop()">
      <img src="@/assets/img/up.webp" width="50px" alt="" />
  </span>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "app",
  data() {
    return {
      scrollState: false,
      scrollPosition: 1000
    };
  },
  methods: {
    updateScroll() {
      if (window.scrollY > this.scrollPosition) {
        this.scrollState = true;
        return false
      }
      this.scrollState = false;
    },
    scrollTop() {
      window.scrollTo(0, 0);
    }
  },
  provide(){
    return {
      moment: moment
    }
  }
}
</script>

<style>
.app-page{
  display: flex;
  flex-direction: column;
  min-width: 1650px;
}
.scroll-top {
  position: fixed;
  bottom: 40px;
  right: 20px;
  cursor: pointer;
  z-index: 10;
  color: var(--green);
}
.login-page {
  background-image: url('@/assets/img/home.webp');
  background-position: center;
  background-size: cover; 
  min-height: 100vh;
}
.login-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 30vw;
  min-height: 70vh;
  background-color: #171c248a;
}
.login-header {
  align-items: center;
  min-height: 30vh;
}
.password-reset-link {
  color: #fff;
  text-align: center;
}
.login-center {
  padding: 40px;
  width: 100%;
}
.login-inputs {
  height: calc(36px + 1vh);
  margin: 10px 0;
  border-radius: var(--radius);
  padding-left: 10px;
  color: #fff;
  font-size: calc(18px + 0.2vw);
  border: none;
  background-color: #0c0c0c33;
}
.login-inputs:focus {
  outline: none;
  background-color: #00000090;
}
.login-inputs::placeholder{color: #ccc;}
.login-button {
  width: 100%;
  height: calc(38px + 1vh);
  margin: 15px auto;
  border: none;
  color: #fff;
  letter-spacing: 1px;
  border-radius: var(--radius);
  cursor: pointer;
  font-size: calc(20px + 0.2vw);
  background-color: var(--green);
}
@media screen and (max-width: 720px){
  .login-form,
  .resetpass-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100vw;
    height: 100dvh;
    margin: 0;
    border-radius: 0;
  } 
}
@media screen and (max-width: 1280px){
  .scroll-top{display: none;}
}
</style>