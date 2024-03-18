<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fac">
        <span class="title-2">Profil</span>
      </header>
      <ul class="users-wrapper">
        <div  class="users-container">
          <h1 class="profile-title">
            <img src="@/assets/img/user-shield.webp" alt="" class="user-details-icon">
            <span class="profile-title-text">{{ profile.user }}</span>
          </h1>
          <li class="user-details-items">
            <span class="user-details-text nick-name">Kod Ad</span>
            <input v-model="profile.nick" type="text" class="search-2" required />
              <span class="info profile-info" title="Bu alan şifre sıfırlama için özeldir.Lütfen kimseyle paylaşmayınız!">?</span>
              <LoaderComponent  v-if="isLoader == 'nick'"/>
              <span>
                <img src="@/assets/img/save.webp" @click="profileUpdate(profile.nick)" class="menu-icons ml10 cp"/>
              </span>
          </li>
          <li class="user-details-items">
            <span class="user-details-text">Kayıt Tarih</span>
            <span class="edit-value">{{ moment(profile.date).format('MM-DD-YY') }}</span>
          </li>
          <li class="user-details-items">
            <span class="user-details-text">Durum</span>
            <span class="edit-value">{{ profile.state }}</span>
          </li>
        </div>
  
        <div v-if="role == 'Admin'"  class="users-container">
          <li class="user-details-items">
            <span class="user-details-text">Müşteri Komisyon</span>
            <span class="edit-value">%{{ profile.customercomission }}</span>
          </li>
        </div>
  
        <div v-if="role != 'Member'" class="users-container">
          <li class="user-details-items">
            <span class="user-details-text">Üye Limiti</span>
            <span class="edit-value">{{ profile.userlimit }}</span>
          </li>
          <li class="user-details-items">
            <span class="user-details-text">Kalan Üye Limiti</span>
            <span class="edit-value">{{ profile.userlimit - profile.usedlimit }}</span>
          </li>
        </div>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios"
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'Profile',
  inject:['moment'],
  components:{
    LoaderComponent
  },
  data () {
    return {
      profile: {},
      isLoader: ''
    }
  },
  mounted () {
    this.getProfile()
  },
  computed:{
    role () {
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    }
  },
  methods: {
    async getProfile () {
      await axios.get('/api/admin/profile').then((result) => {
        this.profile = result.data.profile
      })
    },
    async profileUpdate (value) {
      if(value.length < 4 || !String(value).match(/^[a-zA-Z0-9]/)){
        alert('Nick alanı en az 4 karekter ve ilk karekter Harf yada Sayı olabilir!')
      } else {
        this.isLoader = 'nick'
        await axios.patch('/api/admin/profile-update', {nick: value}).then((result) => {
          if (result.status === 204) {
            this.isLoader = ''
            return false
          }
          alert(result.data.message)
          this.isLoader = ''
        })
      }
    }
  }
}
</script>