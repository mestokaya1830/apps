<template>
  <div class="login-page fjcac">
      <form class="login-form" @submit.prevent="resetPass">
        <header class="login-header fjcac-col">
          <img src="@/assets/img/logo.webp" alt="" class="login-logo">
        </header>
        <div class="login-center f-col">
          <input
            v-model="setPass.user"
            ref="username"
            @focus="removeError()"
            type="text"
            class="login-inputs"
            required
            pattern="^[A-Za-z0-9].{3,50}"
            oninvalid="this.setCustomValidity('Üye alanı en az 4 karekter ilk karekter Harf yada Sayı olmalıdır!')"
            oninput="setCustomValidity('')"
            placeholder="Üye Adı"
          />
          <input
            v-model="setPass.nick"
            @focus="removeError()"
            type="text"
            class="login-inputs"
            required
            pattern="^[A-Za-z0-9].{3,50}"
            oninvalid="this.setCustomValidity('Nick alanı en az 4 karekter ilk karekter Harf yada Sayı olmalıdır!')"
            oninput="setCustomValidity('')"
            placeholder="Nick"
          />
          <input
            v-model="setPass.pass"
            @focus="removeError()"
            type="password"
            class="login-inputs"
            required
            pattern=".{4,}"
            oninvalid="this.setCustomValidity('Şifre en az 4 karekter olmalıdır!')"
            oninput="setCustomValidity('')"
            placeholder="Yeni Şifre"
          />
          <input v-if="!isLoader && !message" type="submit" value="Şifre Sıfırla" class="login-button"/>
          <div v-if="isLoader" class="loader-container">
            <LoaderComponent />
          </div>
          <AlertComponent v-if="message" :message="message" />
        </div>
      </form>
  </div>
</template>

<script>
import axios from "axios";
import LoaderComponent from "@/components/loader-component.vue";
import AlertComponent from "@/components/alert-component.vue";
export default {
  name: "ResetPassword",
  components:{
    LoaderComponent,
    AlertComponent
  },
  data() {
    return {
      setPass: {
        user: '',
        nick: '',
        pass: '',
      },
      isLoader: false,
      message: '',
    };
  },
  mounted(){
    this.$refs.username.focus()
  },
  methods: {
    async resetPass() {
      this.isLoader = true;
      await axios.post("/api/reset-password", this.setPass).then((result) => {
        if (result.data.code === 200) {
          this.message = {
            state:'success',
            result: result.data.message
          }
          this.isLoader = false;
          this.$router.push("/");
          return false
        } 
        this.isLoader = false;
        this.message = {
          state:'error',
          result:result.data.message
        }
      });
    },
    removeError() {
      this.message = null
    }
  }
}
</script>