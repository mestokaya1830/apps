<template>
   <div>
    <div class="admin-con">
      <header class="menu-1 fac">
        <span class="title-2">Sistem Genel Ayarları</span>
      </header>
      <ul>
        <li class="fix-li-warning">
          <span class="sec-icon">&#9907;</span>
          <span class="sec-text cl-g">
            Sayın üyeler bu alandaki degişikliklerden sonra sisteme yeniden Giriş yapılmalıdır!
          </span>
        </li>
        <div class="main-set-list">
          <li class="fix-li users-container">
            <div class="fix-1" :for="user.autopay">
              <label :for="user.autopay" class="toggle-settings">
                <input type="checkbox" class="toggle-checkbox" :id="user.autopay" v-model="user.autopay" @change="autopayUpdate()" />
                <div class="toggle-switch"></div>
              </label>
              <span>Kazanan Kuponları Otomatik Ödeme</span>
            </div>
          </li>
          <div class="users-container">
            <li class="fix-li-2">
              <span class="logo-2 cl-g mr10">&#9881;</span>
              <span class="fix-li-items">Hatalı Giris Sayısı</span>
              <div class="fix-li-2-sub">
                <input type="number" v-model="user.logincount"  min="0" max="99" class="search-2" :input="user.logincount">
                <LoaderComponent v-if="isLoader == 'logincount'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateLoginCount(user.logincount)" class="menu-icons mr10 ml10 cp"/>
                </span>
              </div>
              <span class="fix-li-info">Dikkat! Verdiginiz degere ulaşılırsa sisteme giriş yapılamaz...</span>
            </li>
            <li class="fix-li-2">
              <span class="logo-2 cl-g mr10">&#9881;</span>
              <span class="fix-li-items">Müşteri Komisyon</span>
              <div class="fix-li-2-sub">
                <input type="number" v-model="user.customercomission"  min="0" max="10" class="search-2" :input="user.customercomission">
                <LoaderComponent v-if="isLoader == 'customercomission'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateCustomerComission(user.customercomission)" class="menu-icons mr10 ml10 cp"/>
                </span>
              </div>
              <span class="fix-li-info">Not: Kazanan kupondan kesilen miktar</span>
              <span class="cl-g">{{customererror}}</span>
            </li>
            <li class="fix-li-2">
              <span class="logo-2 cl-g mr10">&#9881;</span>
              <span class="fix-li-items">Müşteri Kupon İptal Süresi</span>
              <div class="fix-li-2-sub">
                <input type="number" v-model="user.usercancelbet"  min="1" max="90" class="search-2" :input="user.usercancelbet">
                <LoaderComponent v-if="isLoader == 'usercancelbet'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserCancelbet(user.usercancelbet)" class="menu-icons mr10 ml10 cp"/>
                </span>
              </div>
              <span class="fix-li-info">Minumum 1 olabilir</span>
            </li> 
          </div>
        </div>
      </ul>
    </div>
  </div>
</template>
<script>
import axios from "axios"
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'Generalset',
  components:{
    LoaderComponent
  },
  data () {
    return {
      user: '',
      isLoader:'',
      usererror:'',
      customererror:''
    }
  },
  mounted(){
    this.getUser()
  },
  methods: {
    async getUser () {
      await axios.get('/api/admin/single-user').then(result => {
        if(result.data){
          this.user = result.data.result[0]
        }
      })
    },
    async autopayUpdate () {
      await axios.put('/api/admin/autopay-update', {autopay:this.user.autopay})
    },
    async updateLoginCount (value) {
      if (value && value > -1) {
        this.isLoader = 'logincount'
        await axios.put('/api/admin/login-count-update', {logincount:this.user.logincount}).then((result) => {
          if (result.data.code == 200) {
            this.isLoader = ''
            this.getUser()
          }
        })
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    },
    async updateCustomerComission (value) {
      if (value == 0 || value > 0) {
        this.isLoader = 'customercomission'
        if (this.user.customercomission > 10) {
          this.usererror = 'Komisyon 10 den fazla olamaz!'
        } else {
          this.customererror = ''
          await axios.put('/api/admin/customer-comission-update', {customercomission:this.user.customercomission}).then((result) => {
            if (result.data.code === 200) {
              this.isLoader = ''
              this.getUser()
            }
          })
        }
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    },
    async updateUserCancelbet (value) {
      if (value == 0 || value > 0) {
        this.isLoader = 'usercancelbet'
        await axios.put('/api/admin/user-cancel-bet-update', {usercancelbet:this.user.usercancelbet}).then((result) => {
          if (result.data.code === 200) {
            this.isLoader = ''
            this.getUser()
          }
        })
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    }
  }
}
</script>
