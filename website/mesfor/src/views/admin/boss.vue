<template>
   <div>
    <div class="scroll">
      <div class="admin-con">
        <header class="bet-menu">
          <div>
            <span class="bet-menu-title">BOSS</span>
          </div>
        </header>
        <div class="bet-summary-con boss-con">
          <h2 class="boss-title">Backup</h2>
          <div class="boss-btn-con">
            <input type="button" class="btn" value="Backup Database" @click="backUpDatabase()">
            <input type="button" class="btn" value="Restore Database" @click="restoreDatabase()">
          </div>

          <h2 class="boss-title">Set Anons</h2>
          <textarea cols="30" rows="5" class="anons" v-model="anons" placeholder="message..."></textarea>
        <div class="boss-btn-con">
          <input type="button" value="Publish" @click="setAnons()" class="btn">
          <input type="button" value="Remove" @click="deleteAnons()" class="btn">
        </div>
        <h2 class="boss-title">Active Users</h2>
        <div class="bet-list-header">
          <div>USER</div>
          <div>ADMIN</div>
        </div>
        <div class="bet-summary-con">
        <template v-for="item in activeUsers" :key="item._id">
          <div class="bet-list">
            <div class="bet-list-user-row">
              <i class="fa fa-user cl-g mr10" />{{ item.user }}
            </div>
            <div>{{ item.admin }}</div>
          </div>
        </template>
      </div>
      <h2 class="boss-title">Old Datas</h2>
      <ul class="boss-old-data">
        <li>Betsummaries: {{ oldData[0] }}</li>
        <li>Bets: {{ oldData[1] }}</li>
        <li>Gamelogs: {{ oldData[2] }}</li>
        <li>Creditlogs: {{ oldData[3] }}</li>
        <li>Loginlogs: {{ oldData[4] }}</li>
      </ul>
      <div class="boss-btn-con">
        <input type="button" class="btn" value="Delete Old Data" @click="bossDeleteOldData()">
        <input type="button" class="btn" value="Delete Old Message" @click="bossDeleteOldMessages()">
      </div>
        </div>
        <div v-if="isLoader" class="boss-loader-con">
          <LoaderComponent />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios"
import LoaderComponent from '@/components/loader-component.vue'
export default {
  name: 'Boss',
  components:{
    LoaderComponent
  },
  data () {
    return {
      anons:null,
      isLoader: false,
      activeUsers: {},
      oldData:{}
    }
  },
  mounted () {
    this.getBossActiveUsers()
    this.getOldData()
  },
  methods: {
    async setAnons(){
      await axios.post('/api/admin/boss-set-anons',{anons:this.anons}).then(result => {
        alert(result.data)
      })
    },
    async deleteAnons(){
      await axios.post('/api/admin/boss-delete-anons').then(result => {
        alert(result.data)
      })
    },
    async getBossActiveUsers(){
      await axios.get('/api/admin/boss-active-users').then(result => {
        this.activeUsers = result.data.result
      })
    },
    async backUpDatabase(){
      this.isLoader = true
      await axios.post('/api/admin/boss-backup-database').then(result => {
        this.isLoader = false
        alert(result.data)
      })
    },
    async restoreDatabase(){
      this.isLoader = true
      await axios.post('/api/admin/boss-restore-database').then(result => {
        this.isLoader = false
        alert(result.data)
      })
    },
    async getOldData(){
      await axios.get('/api/admin/boss-get-old-data').then(result => {
        this.oldData = result.data
      })
    },
    async bossDeleteOldData(){
      this.isLoader = true
      await axios.post('/api/admin/boss-delete-old-data').then(result => {
        this.isLoader = false
        alert(result.data)
      })
    },
    async bossDeleteOldMessages(){
      this.isLoader = true
      await axios.post('/api/admin/boss-delete-old-messages').then(result => {
        this.isLoader = false
        alert(result.data)
      })
    }
  }
}
</script>