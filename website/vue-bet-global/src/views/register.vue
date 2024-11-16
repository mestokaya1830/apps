<template>
  <div class="login-page fjcac">
    <a href="/" class="home-btn" title="Ana Sayfa">
      <img src="@/assets/img/home-navbar.webp" alt="" width="40">
    </a> 
    <form class="login-form" @submit.prevent="register()">
      <header class="login-header fjcac-col">
        <img src="@/assets/img/logo.webp" alt="" class="login-logo">
      </header>
      <div class="login-center f-col">
          <input v-model="newUser.user" type="text" ref="username" @focus="removeError()" class="login-inputs" placeholder="Kullanıcı Adı" required
            pattern="^[A-Za-z0-9].{3,50}"
            oninvalid="this.setCustomValidity('Üye alanı en az 4 karekter ilk karekter Harf yada Sayı olmalıdır')"
            oninput="setCustomValidity('')" tabindex='0'>
          <input v-model="newUser.email" type="text" ref="email" @focus="removeError()" class="login-inputs" placeholder="Email" required
            pattern="^[A-Za-z0-9].{3,50}"
            oninvalid="this.setCustomValidity('Email alanı en az 4 karekter ilk karekter Harf yada Sayı olmalıdır')"
            oninput="setCustomValidity('')" tabindex='0'>
          <input v-model="newUser.pass" type="password" @focus="removeError()" class="login-inputs" placeholder="Şifre" required
            oninvalid="this.setCustomValidity('Şifre alanı boş bırakılamaz!')" oninput="setCustomValidity('')" tabindex='0'>
          <input v-model="passConfirm" type="password" @focus="removeError()" class="login-inputs" placeholder="Şifre Tekrar" required
            oninvalid="this.setCustomValidity('Şifre alanı boş bırakılamaz!')" oninput="setCustomValidity('')" tabindex='0'>
            <div class="captcha-con">
              <div id="captcha"></div>
              <input type="text" class="input" name="" id="recapctha_input" @paste.prevent>
              <img src="@/assets/img/refresh.png" alt="" id="refresh-btn" @click="refreshCaptcha()">
            </div>
          <input v-if="!isLoader && !message" type="submit" value="Devam" class="login-button">
        <div class="loader-container">
          <LoaderComponent v-if="isLoader"/>
        </div>
        <AlertComponent v-if="message" :message="message" />
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
      newUser:{
        user: '',
        pass: '',
        email:'',
      },
      passConfirm: '',
      message: '',
      isLoader: false
    }
  },
  mounted(){
    if(this.$store.state.auth != ''){
      this.$router.push('/')
    }
    this.$refs.username.focus()
    this.setCaptcha()
  },
  methods: {
    async register() {
      if (navigator.onLine === true) {
        if(this.newUser.pass !== this.passConfirm){
          this.message = {
            state: 'error',
            result: 'Şifreler uyuşmuyor!'
          }
          this.isLoader = false
          return false
        }
        this.isLoader = true
        await axios.post('/api/register', {newUser: this.newUser}).then((result) => {
          if (result.status == 200) {
            this.isLoader = false
            this.message = {
              state: 'success',
              result: result.data.message
            }
            this.$router.push('/login')
          } else {
            this.isLoader = false
            this.message = {
              state: 'error',
              result: result.data.message
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
    setCaptcha(){
      let key = ''
      key = (Math.random() + 1).toString(36).substring(8)
      let splitValue = key.split('')
      splitValue.forEach(item => {
        let captchaItem = document.createElement('div')
        captchaItem.innerText = item
        captchaItem.setAttribute('class', 'captchaItem')
        captchaItem.setAttribute('style', `transform:rotate(${Math.floor(Math.random() * 40)}deg)`)
        document.getElementById('captcha').appendChild(captchaItem)
      });
    },
    refreshCaptcha(){
     document.getElementById('captcha').innerText = ''
      this.setCaptcha()
    },
    checkCaptcha(){
      let recapctha_input = $('#recapctha_input').value
      if (key != recapctha_input) {
        e.preventDefault()
        alert('Not match!')
       document.getElementById('captcha').innerText = ''
        this.this.setCaptcha()
      } else {
        return true
      }
    },
    removeError() {
      this.message = null
    }
  }
}
</script>

<style>
  .captcha-con {
    display: flex;
    width: 100%;
    justify-content: center;
    padding: 10px;
    margin: 0 auto;
  }
  #recapctha_input {
    text-align: center;
    width: 100%;
    height: 42px;
    margin-left: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding-left: 5px;
    font-size: 28px;
    letter-spacing: 3px;
  }
  #captcha {
    display: flex;
    align-items: center;
    width: 100%;
    height: 42px;
    padding: 10px;
    background-image: url('@/assets/img/cbg.jpg');
    background-position: center;
    background-size: cover;
    border-radius: 3px;
  }

  .captchaItem {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 40px;
    font-size: 30px;
    position: relative;
    color: #fff;
  }

  #refresh-btn {
    height: 40px;
    cursor: pointer;
    margin: 0 10px;
  }

  #refresh-btn:hover {
    transform: scale(1.1);
  }
</style>
