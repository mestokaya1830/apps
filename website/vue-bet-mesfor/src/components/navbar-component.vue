<template>
  <div class="navbar">
    <img src="@/assets/img/logo.webp" alt="" class="navbar-logo cp" @click="$router.push('/categories')"/>
    <nav class="navbar-left">
      <router-link to='/games/soccer' class="navbar-links" exact-active-class="active">
        <img src="@/assets/img/soccer.webp" alt="" class="menu-icons mr10">Futbol</router-link>
      <router-link to="/games/soccer-live" class="navbar-links" exact-active-class="active">
        <img src="@/assets/img/live.webp" alt="" class="menu-icons mr10">Futbol Canlı</router-link>
      <router-link to="/games/basket" class="navbar-links" exact-active-class="active">
        <img src="@/assets/img/basket.webp" alt="" class="menu-icons mr10">Basket</router-link>
      <router-link to="/games/basket-live" class="navbar-links" exact-active-class="active">
        <img src="@/assets/img/live.webp" alt="" class="menu-icons mr10">Basket Canlı</router-link>
      <router-link to="/admin" class="navbar-links" exact-active-class="active">
        <img src="@/assets/img/admin.webp" alt="" class="menu-icons mr10">Hesabım</router-link>
    </nav>

    <nav class="navbar-right">
      <router-link to="/categories" class="navbar-icons">
        <img src="@/assets/img/home-navbar.webp" alt=""  class="navbar-icons">
      </router-link>
      <div v-if="$route.path.includes('/admin')" @click="openChatHandel()" title="Chat" class="navbar-icons msg-info">
        <img src="@/assets/img/chat.webp" alt="" class="navbar-icons">
        <span class="msg-count" v-if="$store.state.msgcount > 0">{{ newMsg }}</span>
      </div>
      <a href="#" class="navbar-icons" @click="logout" title="Çıkış">
        <LoaderComponent v-if="isLoader"/>
        <img v-else src="@/assets/img/signout.webp" alt="" class="logout-icons cp">
      </a>
    </nav>
  </div>
</template>

<script>
import axios from "axios";
import { socket } from "@/socket"
import LoaderComponent from "@/components/loader-component.vue";

export default {
  name: "navbar-component",
  components: {
    LoaderComponent
  },
  data() {
    return {
      isLoader: false,
      newMsg: '',
      slipIcon: false,
      slipState: false
    };
  },
  mounted() {
    socket.on("msgcount", () => {
      this.newMsg++
      this.$store.commit('setMsgCount', (this.$store.state.msgcount + this.newMsg))
    }); 
    this.getMsgCount()
  },
  methods: {
    async logout() {
      this.isLoader = true;
      await axios.post("/api/logout").then((result) => {
        if (result.status == 204) {
          this.$store.commit("setBetSlip", false);
          this.$store.commit("removeSlips", '');
          this.$store.commit("setOpenChat", false);
          this.$store.commit("setAuth", '');
          localStorage.clear();
          this.isLoader = false;
          this.$router.push("/");
          socket.close();
        }
      })
    },
    async getMsgCount() {
      await axios.get("/api/chat/msg-count").then((result) => {
        if (result.data.message) {
          this.newMsg = result.data.message
          this.$store.commit('setMsgCount', result.data.message)
          this.setNotify()
          return false
        }
      })
    },
    async setNotify() {
      const showNotification = () => {
        const notification = new Notification('Bet Notification', {
          body: 'Yeni mesajiniz var',
          icon: '/icon.webp'
        });

        setTimeout(() => {
          notification.close();
        }, 10 * 1000);
        notification.addEventListener('click', () => {
          this.openChatHandel()
        });
      }
      let granted = false;
      if (Notification.permission === 'granted') {
        granted = true;
      }else if (Notification.permission !== 'denied') {
        let permission = await Notification.requestPermission();
        granted = permission === 'granted' ? true : false;
      }
      granted ? showNotification() : showError();
    },
    openChatHandel() {
      this.$store.commit("setOpenChat", true);
      this.isNewMsg = false;
    }
  }
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  width: 100%;
  height: calc(80px + 0.2vw);
  background-color: var(--black);
  padding: 0 10px;
  color: #fff;
  z-index: 1;
  top: 0;
  box-shadow: 0 5px 10px #000;
}
.navbar-logo{
  width: 70px;
}
.navbar-left{
  display: flex;
  width: 85%;
}
.navbar-right{
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 260px;
}
.navbar-logo {
  margin-right: 1vw;
}
.navbar-links {
  display: flex;
  align-items: center;
  width: fit-content;
  padding: 5px 10px;
  margin: 0 16px;
  color: #fff;
  letter-spacing: 0.5;
  font-family: roboto;
  font-size: calc(20px + 0.2vw);
}
.navbar-links:hover {
  color: yellow;
}
.navbar-icons {
  margin: 0 5%;
  cursor: pointer;
  height: calc(30px + 0.2vw);
}
.msg-info {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  border-radius: 40px;
  cursor: pointer;
  color: #fff;
  position: relative;
}
.msg-count{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 30px;
  height: 30px;
  border-radius: 30px;
  position: absolute;
  top: 25px;
  font-size: 18px;
  background-color: var(--lightgreen);
}
@media screen and (max-width: 1280px){
  .navbar{
    position: static;
  }
}
</style>