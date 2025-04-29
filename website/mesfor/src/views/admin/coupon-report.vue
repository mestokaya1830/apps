<template>
   <div>
    <div class="admin-con">
      <header class="menu-1 fjsbac">
        <span class="title-2">Raporlar</span>
        <div>
          <select v-if="role == 'Admin'" v-model="userBox" @change="getDetailsInfo()" class="select-1">
            <option value="Hepsi" selected>Hepsi</option>
            <option v-for="list in userList" :value="list.user" :key="list.id">{{ list.user }}</option>
          </select>
        </div>
      </header>
      <div class="coupon-container">
        <div class="fjcac  mtb50">
          <img src="@/assets/img/big-list.webp" alt="" class="big-icons">
        </div>
        <ul class="coupon-list">
          <div class="coupon-details-container">
            <li class="coupan-details-title bg-y">
              <h3>AKTİFLER</h3>
            </li>
            <li class="coupan-details-items">
              <span>Adet</span>
              <span>{{ activeInfo.activecount }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Miktar</span>
              <span v-if="activeInfo.activeamount">{{ (activeInfo.activeamount).toFixed(2) }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Kazanç</span>
              <span v-if="activeInfo.activeearn">{{ (activeInfo.activeearn).toFixed(2) }}</span>
            </li>
          </div>
          <div class="coupon-details-container">
            <li class="coupan-details-title bg-g">
              <h3>KAZANANLAR</h3>
            </li>
            <li class="coupan-details-items">
              <span>Adet</span>
              <span><span>{{ wonInfo.woncount }}</span></span>
            </li>
            <li class="coupan-details-items">
              <span>Miktar</span>
              <span v-if="wonInfo.wonamount">{{ (wonInfo.wonamount).toFixed(2) }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Ödenen</span>
              <span v-if="wonInfo.wonearn">{{ (wonInfo.wonearn).toFixed(2) }}</span>
            </li>
          </div>
          <div class="coupon-details-container">
            <li class="coupan-details-title bg-r">
              <h3>KAYBEDENLER</h3 >
            </li>
            <li class="coupan-details-items">
              <span>Adet</span>
              <span>{{ lostInfo.lostcount }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Miktar</span>
              <span v-if="lostInfo.lostamount">{{ (lostInfo.lostamount).toFixed(2) }}</span>
            </li>
          </div>
          <div class="coupon-details-container">
            <li class="coupan-details-title bg-lb">
              <h3>TOPLAM</h3>
            </li>
            <li class="coupan-details-items">
              <span>Adet</span>
              <span>{{ totalInfo.totalcount }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Miktar</span>
              <span v-if="totalInfo.totalamount">{{ (totalInfo.totalamount).toFixed(2) }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Ödenen</span>
              <span v-if="wonInfo.wonearn">{{ (wonInfo.wonearn).toFixed(2) }}</span>
            </li>
            <li class="coupan-details-items">
              <span>Kasa</span>
              <span>{{ totalResult }}</span>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios"
export default {
  name: 'Detailsaccount',
  data() {
    return {
      userBox: 'Hepsi',
      userList: {},
      activeInfo: {},
      wonInfo: {},
      lostInfo: {},
      totalInfo: {},
      credit: {}
    }
  },
  mounted() {
    this.getUserlist()
    this.getDetailsInfo()
  },
  computed: {
    role () {
      if(this.$store.state.auth){
        return this.$store.state.auth.role
      }
    },
    totalResult() {
      if(this.wonInfo.wonearn > 0){
        const total = this.totalInfo.totalamount - this.wonInfo.wonearn
        return total.toFixed(2)
      } else {
        return this.totalInfo.totalamount
      }
    }
  },
  methods: {
    async getUserlist() {
      await axios.get('/api/admin/user-list').then((result) => {
        if(result.data.result){
          this.userList = result.data.result
        }
      })
    },
    async getDetailsInfo() {
      const activeinfo = await axios.get(`/api/admin/active-info/${this.userBox}`)
      const woninfo = await axios.get(`/api/admin/won-info/${this.userBox}`)
      const lostinfo = await axios.get(`/api/admin/lost-info/${this.userBox}`)
      const totalinfo = await axios.get(`/api/admin/total-info/${this.userBox}`)
      const credit = await axios.get(`/api/admin/credit-info/Hepsi`)
      Promise.all([activeinfo, woninfo, lostinfo, totalinfo, credit]).then((result) => {
        const final = {
          ...result[0].data,
          ...result[1].data,
          ...result[2].data,
          ...result[3].data,
          ...result[4].data
        }
        final.activeinfo ? this.activeInfo = final.activeinfo : this.activeInfo = 0
        final.woninfo ? this.wonInfo = final.woninfo : this.wonInfo = 0
        final.lostinfo ? this.lostInfo = final.lostinfo : this.lostInfo = 0
        final.totalinfo ? this.totalInfo = final.totalinfo : this.totalInfo = 0
        final.credit ? this.credit = final.credit : this.credit = 0
      })
    }
  }
}
</script>