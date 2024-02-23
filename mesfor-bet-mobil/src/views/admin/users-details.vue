<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fac">
        <span class="title-2">Üye Detay</span>
      </header>
      <ul class="users-wrapper">
        <div class="users-container">
          <h1 class="profile-title">
            <img src="@/assets/img/user-shield.webp" alt="" class="user-details-icon">
            <span class="profile-title-text">{{ users.user }}</span>
          </h1>
          <li class="user-details-items">
            <span class="user-details-text">Kayıt Tarihi</span>
            <span class="edit-value">{{ moment(users.date).format('MM-DD-YY') }}</span>
          </li>
          <li class="user-details-items">
            <span class="user-details-text">Durum</span>
            <select v-model="users.state" class="select-2">
              <option value="aktif" selected>Aktif</option>
              <option value="pasif">Pasif</option>
            </select>
            <LoaderComponent  v-if="isLoader == 'state'"/>
            <span>
              <img src="@/assets/img/save.webp" @click="updateState()" class="menu-icons ml10 cp"/>
            </span>
          </li>
          <li v-if="role == 'Superadmin'" class="user-details-items">
            <span class="user-details-text">Ödeme</span>
            <span class="edit-value">{{ moment(users.payment).format('YYYY-MM-DD HH:mm:ss') }}</span>
            <LoaderComponent v-if="isLoader == 'payment'"/>
            <span>
              <img src="@/assets/img/save.webp" @click="updatePayment()" class="menu-icons ml10 cp"/>
            </span>
          </li>
          <li class="user-details-trash">
            <LoaderComponent v-if="isLoader == 'delete'" />
            <img src="@/assets/img/trash.webp" v-else class="menu-icons cp"  @click="deleteUser(users.user)"/>
          </li>
        </div>
  
      <div v-if="role == 'Admin'" class="users-container">
        <li class="user-details-items">
          <span class="user-details-text">Bakiye</span>
          <span v-if="users.creditremain" class="edit-value">{{ (users.creditremain).toFixed(2) }}</span>
        </li>
        <li class="user-details-items user-credit-con">
          <span class="user-details-text add-credit-text">Bakiye Ekle/Çıkar</span>
          <input v-model="updateAmount" type="number" min="0" class="search-2" required placeholder="Ekle/Çıkar">
          <LoaderComponent  v-if="this.isLoader == 'credit'" />
          <div class="credit-btn-con">
            <img src="@/assets/img/minus.webp" alt="" @click="updateCreditRemain('minus')" class="menu-icons ml10 mr10 cp">
            <img src="@/assets/img/plus.webp" alt="" @click="updateCreditRemain('plus')" class="menu-icons cp">
          </div>
        </li>
      </div>
  
      <div v-if="users.role != 'Member'" class="users-container">
        <li class="user-details-items">
          <span class="user-details-text">Üye Limiti</span>
          <input v-model="users.userlimit" type="number" class="search-2">
          <LoaderComponent  v-if="isLoader == 'limit'"/>
          <span>
            <img src="@/assets/img/save.webp" @click="updateUserLimit(users.userlimit)" class="menu-icons ml10 cp"/>
          </span>
        </li>
        <li class="user-details-items">
          <span class="user-details-text">Kalan Üye Limiti</span>
          <span class="edit-value">{{ (users.userlimit - users.usedlimit) }}</span>
        </li>
      </div>
    </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios"
import mixins from '@/mixins/index.js'
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'Userdetails',
  inject:['moment'],
  mixins:[mixins],
  components:{
    LoaderComponent
  },
  data () {
    return {
      users: {},
      isLoader: '',
      updateAmount:null
    }
  },
  mounted () {
    this.userDetails()
  },
  computed:{
    role () {
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    },
    getUsedCredit (){
      return (this.users.credit - this.users.creditremain).toFixed(2)
    }
  },
  methods: {
    async userDetails () {
      await axios.get('/api/admin/users/' + this.$route.params.id).then((result) => {
        if(result.data.result){
          this.users = result.data.result
        }
      })
    },
    async updatePayment () {
      this.isLoader = 'payment'
      await axios.put('/api/admin/payment-update/' + this.$route.params.id, {users: this.users}).then((result) => {
        if (result.data.code === 200) {
          this.isLoader = ''
        }
      })
    },
    async updateState () {
      this.isLoader = 'state'
      await axios.put('/api/admin/state-update/' + this.$route.params.id, {state: this.users.state}).then((result) => {
        if (result.data.code === 200) {
          this.isLoader = ''
        }
      })
    },
    async deleteUser (id) {
      const cfm = confirm('Bu kullanıcıyı ait tüm bilgiler silinecektir!')
      if(cfm){
        this.isLoader = 'delete'
        await axios.post('/api/admin/delete/' + id).then((result) => {
          if (result.data.code === 200) {
            this.$router.push('/admin/users')
            this.betInfoMix()
            this.isLoader = ''
            return false
          }
          this.isLoader = ''
          alert(result.data.message)
        })
      }
    },
    async updateUserLimit (value) {
      if(value && value > 0){
        this.isLoader = 'limit'
        await axios.put('/api/admin/users-limit-update/' + this.$route.params.id, {newlimit:value}).then((result) => {
          if (result.data.code === 200) {
            this.isLoader = ''
          }
        })
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    },
    async creditRemainFunction (operate) {
      this.isLoader = 'credit'
      await axios.put('/api/admin/credit-remain-update/' + this.$route.params.id, {operate:operate,creditremain:this.users.creditremain, updateamount: this.updateAmount}).then((result) => {
        if (result.data.code === 200) {
          this.updateAmount = null
          this.userDetails()
          this.betInfoMix()
          this.isLoader = ''
          return false
        }
        alert(result.data.message)
      })
    },
    updateCreditRemain (operate) {
      if (this.updateAmount && this.updateAmount > 1) {
        if(operate === 'minus'){
          if (this.updateAmount > this.users.creditremain) {
            alert('Miktar bakiyeden büyük olamaz!')
            return false
          } else {
            this.creditRemainFunction(operate)
          }
        }
        if(operate === 'plus'){
          this.creditRemainFunction(operate)
        }
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    }
  }
}
</script>
