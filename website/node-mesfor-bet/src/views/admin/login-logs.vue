<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fjsbac">
        <div class="strict-width">
          <span class="title-2">Oturum Geçmişi</span>
          <span class ="cl-y mr10">({{ loginLog.length }})</span>
          <div class="bet-date">
            <input v-model="dateStart" type="date" class="search-5">
            <input v-model="dateFinish" type="date" class="search-5">
            <div class="search-btn" @click="filterAsDay()">ARA</div>
            <div class="search-btn" @click="resetFilter()">HEPSİ</div>
          </div>
        </div>
      </header>
      <div>
        <div class="bet-list-header">
          <div>NO</div>
          <div>
            <div v-if="role == 'Member'">ÜYE ADI</div>
            <select v-else v-model="userBox" class="select-2" @change="getLoginLogs()">
              <option disabled selected>Üyeler</option>
              <option value="Sahip">Sahip</option>
              <option v-for="list in userList" :value="list.user" :key="list.id">{{ list.user }}</option>
            </select>
          </div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">TARİH</div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">SAAT</div>
          <div class="sort-items" @click="sortList('proccess')" title="Sıralama">İŞLEM</div>
          <div class="sort-items" @click="sortList('ip')" title="Sıralama">IP</div>
        </div>
      </div>
      <div class="bet-summary-con">
        <template v-for="(list, index) in loginLog" :key="list._id">
          <div class="bet-list">
            <div class="betid-con"><span class="badge betid">{{ index }}</span></div>
            <div>{{ list.user }}</div>
            <div>{{ moment(list.date).format('MM-DD') }}</div>
            <div>{{ moment(list.date).format('H:mm:ss') }}</div>
            <div>
              <div :class="list.proccess">{{ list.proccess }}</div>
            </div>
            <div class="ip-field">{{ list.ip }}</div>
          </div>
        </template>
        <PageEndComponent :length="loginLog.length" />
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios"
import PageEndComponent from "@/components/page-end-component.vue";
export default {
  name: 'Loginlog',
  inject:['moment'],
  components:{
    PageEndComponent
  },
  data () {
    return {
      loginLog: {},
      userList: {},
      userBox: 'Üyeler',
      dateStart: this.moment().subtract(7,'days').format('YYYY-MM-DD'),
      dateFinish: this.moment().add(1,'days').format('YYYY-MM-DD'),
      isSort: false,
      isLoginOpen:false
    }
  },
  mounted () {
    this.getUserList()
    this.getLoginLogs()
  },
  computed: {
    role () {
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    }
  },
  methods: {
    async getUserList () {
      await axios.get('/api/admin/user-list').then((result) => {
        if(result.data.result){
          this.userList = result.data.result
        }
      })
    },
    async getLoginLogs () {
      await axios.get(`/api/admin/login-logs/${this.userBox}`).then((result) => {
        if (result.data.loginlog) {
          this.loginLog = result.data.loginlog
        }
      })
    },
    async filterAsDay () {
      if (!this.dateFinish) {
       this.dateFinish = this.moment().add(1,'days').format('YYYY-MM-DD')
      }
      await axios.get(`/api/admin/login-logs/date-filter/${this.userBox}/${this.dateStart}/${this.dateFinish}`).then((result) => {
        if (result.data.datefilter.length > 0) {
          this.loginLog = result.data.datefilter
          return false
        }
        this.loginLog = result.data.datefilter
      })
    },
    resetFilter () {
      this.loginLog = {}
      this.getLoginLogs()
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
