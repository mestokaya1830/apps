<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fjsbac">
        <article>
          <span class="title-2">Üye Ekle</span>
        </article>
      </header>
      <div class="users-wrapper">
        <img src="@/assets/img/user-shield.webp" alt="" class="big-icons">
        <form class="users-container" @submit.prevent="addUser()">
          <input type="text" v-model="newUser.user" class="search-3 mb10" ref="username"  @focus="removeError()" maxlength = "50" required pattern="^[A-Za-z0-9].{3,50}" oninvalid="this.setCustomValidity('Üye alanı en az 4 karekter ve ilk karekter Harf yada Sayı olabilir!')" oninput="setCustomValidity('')" placeholder="Ad">
          <input type="text" v-model="newUser.nick" class="search-3 mb10" @focus="removeError()" maxlength = "50" required pattern="^[A-Za-z0-9].{3,50}" oninvalid="this.setCustomValidity('Nick alanı en az 4 karekter ve ilk karekter Harf yada Sayı olabilir!')" oninput="setCustomValidity('')" placeholder="Kod Ad">
          <input type="text" v-model="newUser.pass" class="search-3 mb10" maxlength = "50" required pattern=".{4,50}" oninvalid="this.setCustomValidity('Şifre en az 4 karekter olabilir!')" oninput="setCustomValidity('')" placeholder="Şifre">
          <div>
            <input type="number" v-if="$store.state.auth.role == 'Admin'" v-model="newUser.credit" class="search-3 mb10" min="50" required oninvalid="this.setCustomValidity('Minumum Kredi Tutarı 50 Tl olabilir!')" oninput="setCustomValidity('')" placeholder="Bakiye">
          </div>
          <!-- boss and superadmin section -->
          <div v-if="$store.state.auth.role === 'Boss' || $store.state.auth.role === 'Superadmin'" class="limit-box-con">
            <span class="user-details-text">Üye Limiti</span>
            <select v-model="newUser.userlimit" class="select-2" required oninvalid="this.setCustomValidity('Limit alanı boş bırakılamaz!')" oninput="setCustomValidity('')">
              <option value="0" selected disabled>0</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="50">50</option>
            </select>
          </div>
          <footer class="form-footer register">
            <button v-if="isBtnReg" class="btn btn-2 bg-l">Ekle</button>
            <div class="loader-container"  v-if="isLoader"><LoaderComponent /></div>
            <AlertComponent v-if="message" :message="message"/>
          </footer>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios"
import mixins from '@/mixins/index.js'
import LoaderComponent from "@/components/loader-component.vue";
import AlertComponent from "@/components/alert-component.vue";
export default {
  name: 'AddUser',
  mixins:[mixins],
  components:{
    LoaderComponent,
    AlertComponent
  },
  mounted(){
    this.$refs.username.focus()
  },
  data () {
    return {
      newUser: {
        user: '',
        nick: '',
        pass: '',
        credit: '',
        role: this.$store.state.auth.role,
        userlimit: 0,
        usedlimit: 0,
        customercomission: this.$store.state.auth.customercomission,
        usercancelbet: this.$store.state.auth.usercancelbet,
        admin: this.$store.state.auth.user
      },
      isBtnReg: true,
      isLoader: false,
      message: ''
    }
  },
  methods: {
    async addUser () {
        this.isBtnReg = false
        this.isLoader = true
        await axios.post('/api/admin/add-user', {newUser:this.newUser} ).then((result) => {
          if (result.data.code === 201) {
            this.message = {
              state:'success',
              result: result.data.message
            }
            this.isBtnReg = false
            this.isLoader = false
            this.betInfoMix()
            this.$router.push('/admin/users')
          } else {
            this.message = {
              state:'error',
              result: result.data.message
            }
            this.isLoader = false
            this.isBtnReg = false
            setTimeout(() => {
              this.message = null
              this.isBtnReg = true
            }, 2000)
          }
        })
    },
    removeError () {
      this.error = null
      this.isBtnReg = true
    }
  }
}
</script>
