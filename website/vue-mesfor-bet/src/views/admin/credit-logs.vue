<template>
  <div>
    <div class="admin-con">
    <header class="menu-1 fjsbac">
      <div class="strict-width">
        <span class="title-2">Bakiye Geçmişi</span>
        <span class ="cl-y mr10">({{ creditLog.length }})</span>
        <div class="bet-date">
          <input v-model="dateStart" type="date" class="search-5">
          <input v-model="dateFinish" type="date" class="search-5">
          <div @click="dateFilter()" class="search-btn">ARA</div>
          <div @click="resetFilter()" class="search-btn">HEPSİ</div>
        </div>
      </div>
    </header>
    <div>
      <div class="bet-list-header">
        <div>NO</div>
        <div v-if="role == 'Member'">ÜYE ADI</div>
        <div v-else>
          <select  v-model="userBox" class="select-2" @change="getCreditLogs()">
            <option disabled>Üyeler</option>
            <option v-for="list in userList" :value="list.user" :key="list.id">{{ list.user }}</option>
          </select>
        </div>
        <div class="sort-items" @click="sortList('date')" title="Sıralama">TARİH</div>
        <div class="sort-items" @click="sortList('date')" title="Sıralama">SAAT</div>
        <div class="sort-items" @click="sortList('des')"  title="Sıralama">NEDEN</div>
        <div class="sort-items" @click="sortList('amount')" title="Sıralama">MİKTAR</div>
        <div class="sort-items" @click="sortList('ope')" title="Sıralama">İŞLEM</div>
        <div class="sort-items" @click="sortList('creditremain')" title="Sıralama">BAKİYE</div>
      </div>
    </div>
    <div class="bet-summary-con">
      <template v-for="(list, index) in creditLog" :key="list._id">
        <div class="bet-list">
          <div class="betid-con"><span class="badge betid">{{ index }}</span></div>
          <div>{{ list.user }}</div>
          <div>{{ moment(list.date).format('MM-DD') }}</div>
          <div>{{ moment(list.date).format('H:mm:ss') }}</div>
          <div class="citems-list list-des">{{ list.des }}</div>
          <div>{{ (list.amount).toFixed(2) }}</div>
          <div :class="{Online: list.ope == 'Eklendi', Kaybetti: list.ope == 'Offline'}">{{ list.ope }}</div>
          <div>{{ (list.creditremain).toFixed(2) }}</div>
        </div>
      </template>
      <PageEndComponent :length="creditLog.length" />
    </div>
  </div>
  </div>
</template>

<script>
import axios from "axios"
import PageEndComponent from "@/components/page-end-component.vue";
export default {
 name: 'Creditlog',
 inject:['moment'],
 components:{
   PageEndComponent
 },
 data () {
   return {
     creditLog: {},
     userList: {},
     userBox: 'Üyeler',
     dateStart: this.moment().subtract(7,'days').format('YYYY-MM-DD'),
     dateFinish: this.moment().add(1,'days').format('YYYY-MM-DD'),
     isSort: false,
     isCreditOpen: false
   }
 },
 mounted () {
   this.getUserList()
   this.getCreditLogs()
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
   async getCreditLogs () {
     await axios.get(`/api/admin/credit-logs/${this.userBox}`).then((result) => {
       if (result.data.creditlog) {
         this.creditLog = result.data.creditlog
       }
     })
   },
   async dateFilter () {
     if (!this.dateFinish) {
      this.dateFinish = this.moment().add(1,'days').format('YYYY-MM-DD')
     }
     await axios.get(`/api/admin/credit-logs/date-filter/${this.userBox}/${this.dateStart}/${this.dateFinish}`).then((result) => {
       if (result.data.datefilter.length > 0) {
         this.creditLog = result.data.datefilter
         return false
       }
       this.creditLog = result.data.datefilter
     })
   },
   resetFilter () {
     this.creditLog = {}
     this.getCreditLogs()
   },
   sortList(name) {
     if (name) {
       this.creditLog.sort((a, b) => {
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
