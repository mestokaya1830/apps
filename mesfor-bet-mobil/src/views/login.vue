<template>
  <div class="login-page fjcac">
    <form class="login-form" @submit.prevent="login()">
      <header class="login-header fjcac-col">
        <img src="@/assets/img/logo.webp" alt="" class="login-logo">
      </header>
      <div class="login-center f-col">
        <input v-model="user" type="text" ref="username" @focus="removeError()" class="login-inputs" placeholder="Üye Adı" required
          pattern="^[A-Za-z0-9].{3,50}"
          oninvalid="this.setCustomValidity('Üye alanı en az 4 karekter ilk karekter Harf yada Sayı olmalıdır')"
          oninput="setCustomValidity('')" tabindex='0'>
        <input v-model="pass" type="password" @focus="removeError()" class="login-inputs" placeholder="Şifre" required
          oninvalid="this.setCustomValidity('Şifre alanı boş bırakılamaz!')" oninput="setCustomValidity('')" tabindex='0'>
        <input v-if="!isLoader && !message" type="submit" value="Giriş" class="login-button">
        <div class="loader-container">
          <LoaderComponent v-if="isLoader"/>
        </div>
        <AlertComponent v-if="message" :message="message" />
        <router-link to="/resetpassword" class="password-reset-link">
          <span>Şifre Sıfırlama</span>
        </router-link>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios"
import LoaderComponent from "@/components/loader-component.vue";
import AlertComponent from "@/components/alert-component.vue";
export default {
  name: 'LoginPage',
  components:{
    LoaderComponent,
    AlertComponent
  },
  data() {
    return {
      user: '',
      pass: '',
      message: '',
      isLoader: false
    }
  },
  mounted(){
    if(this.$store.state.auth){
      this.$router.push('/categories')
    }
    this.$refs.username.focus()
  },
  methods: {
    async login() {
      if (navigator.onLine === true) {
        this.isLoader = true
        await axios.post('/api/login', { user: this.user, pass: this.pass }).then((result) => {
          if (result.data.code === 200) {
            this.$store.commit('setAuth', result.data.auth)
            this.isLoader = false
            this.message = {
              state: 'success',
              result: result.data.login
            }
            this.$router.go('/categories')
          } else {
            this.isLoader = false
            this.message = {
              state: 'error',
              result: result.data.login
            }
          }
        })
        return false
      }
      this.message = {
        state: 'error',
        result: 'Baglanti Yok!'
      }
    },
    removeError() {
      this.message = null
    }
  }
}
</script>
