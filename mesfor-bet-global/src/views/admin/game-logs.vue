<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fjsbac">
        <div class="strict-width">
          <span class="title-2">Oyun Geçmişi</span>
          <span class="cl-y mr10">({{ gamelog.length }})</span>
          <div class="bet-date">
            <input v-model="dateStart" type="date" class="search-5">
            <input v-model="dateFinish" type="date" class="search-5">
            <div class="search-btn" @click="dateFilter()">ARA</div>
          </div>
        </div>
      </header>
      <div>
        <div class="bet-list-header">
          <div class="bet-search">
            <input v-model="searchBox" type="text" @keyup.enter="search()" class="search-6" placeholder="Kod Ara..." />
          </div>
          <div v-if="role == 'Member'">ÜYE ADI</div>
          <div v-else>
            <select v-model="userBox" class="select-2" @change="getGameLogs()">
              <option disabled>Üyeler</option>
              <option v-for="list in userList" :value="list.user" :key="userList.id">{{ list.user }}</option>
            </select>
          </div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">TARİH</div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">SAAT</div>
          <div class="sort-items list-des" @click="sortList('des')" title="Sıralama">NEDEN</div>
          <div class="sort-items" @click="sortList('amount')" title="Sıralama">MİKTAR</div>
          <div class="sort-items" @click="sortList('ope')" title="Sıralama">İŞLEM</div>
          <div class="sort-items" @click="sortList('creditremain')" title="Sıralama">BAKİYE</div>
        </div>
      </div>
      <div class="bet-summary-con">
        <template v-for="list in gamelog" :key="list._id">
          <div class="bet-list">
            <div class="betid-con"><span class="badge betid">{{ list.gameid }}</span></div>
            <div>{{ list.user }}</div>
            <div>{{ moment(list.date).format('MM-DD') }}</div>
            <div>{{ moment(list.date).format('H:mm:ss') }}</div>
            <div class="citems-list list-des">{{ list.des }}</div>
            <div>{{ (list.amount).toFixed(2) }}</div>
            <div :class="{ Online: list.ope === 'Eklenen', Offline: list.ope === 'Eksilen' }">{{ list.ope }}</div>
            <div>{{ (list.creditremain).toFixed(2) }}</div>
          </div>
        </template>
        <PageEndComponent :length="gamelog.length" />
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios"
import PageEndComponent from "@/components/page-end-component.vue";
export default {
  name: 'Gamelog',
  inject: ['moment'],
  components: {
    PageEndComponent
  },
  data() {
    return {
      gamelog: {},
      userList: {},
      userBox: 'Üyeler',
      searchBox: '',
      dateStart: this.moment().subtract(7, 'days').format('YYYY-MM-DD'),
      dateFinish: this.moment().add(1, 'days').format('YYYY-MM-DD'),
      isSort: false,
      isGameOpen:false
    }
  },
  computed: {
    role() {
      if (this.$store.state.auth) {
        return this.$store.state.auth.role
      }
    },
    getLastId() {
      return Math.min.apply(Math, this.lastId)
    }
  },
  mounted() {
    this.getUserList()
    this.getGameLogs()
  },
  methods: {
    async getUserList() {
      await axios.get('/api/admin/user-list').then((result) => {
        if(result.data.result){
          this.userList = result.data.result
        }
      })
    },
    async getGameLogs() {
      await axios.get(`/api/admin/game-logs/${this.userBox}`).then((result) => {
        if (result.data.gamelog) {
          this.gamelog = result.data.gamelog
        }
      })
    },
    async dateFilter() {
      if (!this.dateFinish) {
        this.dateFinish = this.moment().add(1, 'days').format('YYYY-MM-DD')
      }
      await axios.get(`/api/admin/game-logs-date-filter/${this.userBox}/${this.dateStart}/${this.dateFinish}`).then((result) => {
        if (result.data.datefilter) {
          this.gamelog = result.data.datefilter
        }
      })
    },
    async search() {
      if(!this.searchBox){
        this.getGameLogs()
        return false
      }
      await axios.get(`/api/admin/game-logs-search/${this.searchBox}`).then((result) => {
        if (result.data.gamelog.length > 0) {
          this.gamelog = result.data.gamelog
          this.searchBox = ''
          return false
        }
        this.gamelog = {}
        this.searchBox = ''
      })
    },
    sortList(name) {
      if (name) {
        this.gamelog.sort((a, b) => {
          if (this.isSort) {
            return a[name] > b[name] ? 1 : -1
          }
          return a[name] > b[name] ? -1 : 1
        })
        this.isSort = !this.isSort
      }
    },
  }
}
</script>