<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fac" >
        <span class="title-2">Şikayet ve Öneriler</span>
      </header>
      <form @submit.prevent="sendAdvise()" class="advise-con">
        <img src="@/assets/img/email.webp" class="big-icons mtb50" alt="">
        <input type="text" v-model="advise.subject" class="search-2" required placeholder="Konu" @focus="removeError()" pattern="^[A-Za-z].{3,50}"
          oninvalid="this.setCustomValidity('Konu en az 4 ile 50 arası karekter olmalıdır')"
          oninput="setCustomValidity('')" tabindex='1'>
        <textarea v-model="advise.text" ref="message" cols="30" rows="10" class="advise-text" required placeholder="Konu"></textarea>
        <div v-if="isLoader" class="loader-container">
          <LoaderComponent />
        </div>
        <input v-if="!isLoader && !message" type="submit" value="Gönder" class="btn btn-2 bg-l">
        <AlertComponent v-if="message" :message="message" />
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import LoaderComponent from '@/components/loader-component.vue'
import AlertComponent from '@/components/alert-component.vue'
export default {
  name:'Advise',
  components:{
    LoaderComponent,
    AlertComponent
  },
  data () {
    return {
      advise:{
        subject:'',
        text:''
      },
      isLoader: false,
      message:''
    }
  },
  methods:{
    async sendAdvise(){
      if(this.$refs.message.value.length < 20){
        alert('Mesaj en az 20 ile 500 arası karekter olmalıdır')
        return false
      } else {
        this.isLoader = true
        await axios.post('/api/admin/boss/advise', {advise: this.advise}).then(result => {
          if(result.data.code == 200){
            this.isLoader = false
            this.message = {
              state:'success',
              result:'İsteiğiniz başarıyla gönderilmiştir'
            }
            setTimeout(() => {
              this.message = ''
            }, 2000);
          }
        })
      }
    }
  }
}
</script>