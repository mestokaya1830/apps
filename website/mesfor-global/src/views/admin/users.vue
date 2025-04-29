<template>
  <div>
    <div class="admin-con">
        <header class="menu-1 fac">
          <span class="title-2">Üyeler</span>
          <span class="cl-y">({{ users.length }})</span>
          <span class="title-2">Aktif bayi sayısı: </span>
          <span class="cl-y">({{ activeUsers }})</span>
        </header>
        <div>
          <div class="bet-list-header">
            <div class="bet-search">
              <input v-model="searchBox" type="text" class="search-5" placeholder="Ara..."
                @keyup.enter="search()" />
            </div>
            <div class="sort-items" @click="sortList('admin')">ADMİN</div>
            <div class="sort-items" @click="sortList('role')">YETKİ</div>
            <div v-if = "role == 'Admin'" class="sort-items">BAKİYE</div>
            <div v-if = "role == 'Boss' || role == 'Superadmin'" class="sort-items">ÜYE LİMİTİ</div>
            <div class="sort-items" @click="sortList('state')">DURUM</div>
            <div v-if="role == 'Superadmin'" class="sort-items" @click="sortList('payment')">ÖDEME</div>
          </div>
        </div>
        <div class="bet-summary-con">
          <template v-for="list in users" :key="list._id">
            <router-link class="bet-list" :to="'/admin/users/' + list.user">
              <div class="bet-list-user-row">
                <img src="@/assets/img/user-shield.webp" alt="" class="user-list-icon">
                <span>{{ list.user }}</span>
              </div>
              <div>{{ list.admin }}</div>
              <div>{{ list.role }}</div>
              <div v-if = "role == 'Admin'"> {{ (list.creditremain).toFixed(2) }}</div>
              <div v-if = "role == 'Boss' || role == 'Superadmin'">{{ list.userlimit }} / {{ (list.userlimit - list.usedlimit) }}</div>
              <div>{{ list.state }}</div>
              <div  v-if="role == 'Superadmin'" class="payment-list" :class="{ paymentTimeClass: cancelTime(list.payment) > 30 }">
                {{ moment(list.payment).format('MM-DD') }}
              </div>
            </router-link>
          </template>
          <PageEndComponent :length="users.length" />
        </div>
      </div>
  </div>
</template>

<script>
import axios from "axios"
import mixins from '@/mixins/index.js'
import PageEndComponent from "@/components/page-end-component.vue";
export default {
  name: 'Users',
  inject:['moment'],
  mixins:[mixins],
  components:{
    PageEndComponent
  },
  data() {
    return {
      users: {},
      activeUsers: 0,
      searchBox: '',
      adminSelect: null,
      isSort: false,
      sortName: null,
      isUserOpen: false
    }
  },
  mounted() {
    this.getUsers()
    this.getActiveUsers()
  },
  computed: {
    role() {
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    }
  },
  methods: {
    async getUsers() {
      await axios.get('/api/admin/users').then((result) => {
        if(result.data.result){
          this.users = result.data.result
        }
      })
    },
    async getActiveUsers() {
      await axios.get("/api/admin/active-users").then((result) => {
        if (result.data.result[0]) {
          this.activeUsers = result.data.result[0].count;
        }
      });
    },
    async search() {
      if(!this.searchBox){
        this.getUsers()
      } else {
        await axios.get(`/api/admin/user-search/${this.searchBox}`).then((result) => {
          if (result.data.result.length > 0) {
            this.users = result.data.result
            this.searchBox = ''
            return false
          }
          this.users = {}
          this.searchBox = ''
        })
      }
    },
    cancelTime(value) {
      let diff = Date.now() - new Date(value).getTime()
      return Math.floor((diff) / (1000 * 60 * 60 * 24))
    },
    sortList(name) {
      if (name) {
        this.loginLog.sort((a, b) => {
          if (this.isSort) {
            return a[name] > b[name] ? 1 : -1
          }
          return a[name] > b[name] ? -1 : 1
        })
        this.isSort = !this.isSort
      }
    }
   
  }
}
</script>