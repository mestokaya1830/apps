<template>
  <div>
    <div class="banner">
      <div class="banner-user-info">
        <div v-if="$store.state.auth">Sahip: {{ $store.state.auth.user }}</div>
        <div v-if="(role == 'Admin' || role == 'Member') && $store.state.betinfo.creditremain">Bakiye: {{ ($store.state.betinfo.creditremain).toFixed(2) }} </div>
      </div>
      <div class="anons-con">
        <p class="anons" v-if="anons">
          <span>{{ anons }}</span>
        </p>
      </div>
    </div>
    <div class="banner-bottom-logo" id="banner-logo">
      <img src="@/assets/img/logo.webp" alt="no image" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  Name:'Banner',
  data() {
    return {
      anons: ""
    };
  },
  mounted(){
    this.getAnons()
  },
  computed: {
    lastMsg() {
      return this.$store.state.msgcount;
    },
    getEarnAdmin() {
      return this.$store.state.betinfo.credit - this.$store.state.betinfo.creditremain;
    },
    role(){
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    }
  },
  methods: {
    async getAnons() {
      await axios.get("/api/admin/boss-get-anons").then((result) => {
        if (result.data.result) {
          this.anons = result.data.result.anons;
        }
      });
    }
  },
};
</script>

<style scoped>
.banner {
  width: 100%;
  min-height: 250px;
  background-image: url('@/assets/img/home.webp');
  background-size: cover;
  background-position: bottom;
  background-repeat: no-repeat;
  margin-top: 80px;
  padding-top: 20px;
  box-shadow: 0px 5px 10px #000;
}
.banner-user-info {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  height: 50px;
  color: #fff;
  display: flex;
  padding-left: 20px;
  font-size: calc(16px + 0.2vw);
}
.banner-bottom-logo{
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 70px;
}
.banner-bottom-logo > img{
  width: 70px;
}
.anons-con {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
  min-height: 70px;
  background-color: rgba(0, 0, 0, .1);
  list-style: none;
}
.anons {
  width: 80%;
  margin: 0 auto;
  color: yellow;
  white-space: nowrap;
  overflow: hidden;
  position: absolute;
  font-size: calc(20px + 0.2vw);
}
.anons span {
  display: inline-block;
  padding-left: 100%;
  animation: anons-item 20s linear infinite;
}
.boss-con {
  padding: 10px;
}
@keyframes anons-item {
  0% {
    transform: translate(0, 0);
  }

  100% {
    transform: translate(-100%, 0);
  }
}
@media screen and (max-width: 1280px){
  .banner{margin-top: 0;}
}
</style>