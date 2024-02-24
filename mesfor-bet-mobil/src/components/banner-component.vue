<template>
  <div>
    <div class="banner">
      <div class="banner-user-info-con">
        <div class="banner-user-info">
          <div v-if="$store.state.auth">Sahip: {{ $store.state.auth.user }}</div>
          <div v-if="(role == 'Admin' || role == 'Member') && $store.state.betinfo.creditremain">Bakiye: {{ ($store.state.betinfo.creditremain).toFixed(2) }} </div>
        </div>
        <div>
          <span v-if="slipIcon" class="slip-open cl-w pr" @click="slipOpenFunction()" title="Kuponlar">
            <span class="navbar-slip-length">{{ $store.state.slips.length }}</span>
          </span>
        </div>
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
      anons: "",
      slipIcon: false,
      slipOpen: false
    };
  },
  mounted(){
    this.getAnons()
    this.$route.path.includes('games') ? this.slipIcon = true : this.slipIcon = false
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
    },
    slipOpenFunction(){
      this.slipOpen = true
      this.$store.commit('setSlipOpen', this.slipOpen)
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
.banner-user-info-con {
  display: flex;
  justify-content: space-between;
  height: 50px;
  color: #fff;
  padding: 0 10px;
}
.slip-open{
  display: flex;
  justify-content: center;
  align-items: center;
  width: 60px;
  height: 50px;
  position: fixed;
  right: 0;
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
  background-color: var(--lightgreen);
  font-size: 22px;
}
.banner-user-info {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  height: 50px;
  color: #fff;
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
  margin-top: 80px;
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
</style>