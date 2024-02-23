<template>
  <div>
    <div class="slip-header">
      <article class="fac">
        <img src="@/assets/img/list.webp" alt="" class="menu-icons ml10">
        <span class="title-2">Kuponlar</span>
        <span v-if="$store.state.betslip" class="cl-y ml10">({{ slips.length }})</span>
      </article>
      <img src="@/assets/img/close.webp" v-if="closeSlip" class="close" title="Kapat" @click="closeSlipHandle()" >
    </div>
    <div class="slip-side-con">
      <div v-if="this.$store.state.betslip">
        <div v-if="!isSlipLoader" class="slip-con">
          <ul id="printMe" class="slip-item-con">
            <div class="print-title only-print">
              <h3 class="slip-title">Bahislerim</h3>
              <li class="slip-order">
                <span class="slip-items">Kod: {{ slipSummary.sumid }}</span>
                <span>Tarih: {{ moment(new Date(), 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD HH:mm')
                }}</span>
              </li>
            </div>
            <li v-for="(list, index) in slips" :key="index" class="slip print-list">
              <div class="slip-order">
                <span class="slip-items slip-items-text">Maç kodu:</span>
                <span class="badge slip-code">{{ String(list.betid).slice(-3) }}</span>
              </div>
              <div class="slip-order">
                <span class="slip-match">{{ list.matches }}</span>
              </div>
              <div class="slip-order">
                <span class="slip-items slip-items-text">Bahis:</span>
                <span class="slip-items slip-items-break">{{ list.games }}</span>
              </div>
              <div class="slip-order jcsb">
                <div>
                  <span class="slip-items slip-items-text">Seçim:</span>
                  <span class="slip-items slip-items-break">{{ list.options }}</span>
                </div>
                <strong class="slip-rate">{{ list.rate }}</strong>
              </div>
              <img src="@/assets/img/trash-gray.webp" @click="removeSlip(index, list.betid)" class="slip-trash logo-2 no-print" alt="">
            </li>
            <ul class="print-result only-print">
              <li class="info-con">
                <span>Toplam Bahis: </span>
                <span> {{ slips.length }}</span>
              </li>
              <li class="info-con info-con-rate">
                <span>Toplam Oran:</span>
                <span> {{ getTotalRate }}</span>
              </li>
              <li class="info-con info-con-rate">
                <span>Miktar:</span>
                <span> {{ slipSummary.amount }}</span>
              </li>
              <li class="info-con">
                <span>Toplam Kazanç:</span>
                <span>{{ getNetEarn }}</span>
              </li>
            </ul>
          </ul>
            <div class="slip-total-rate">
              <span><b>Oran</b> : {{ getTotalRate }}</span>
              <span><b>Brüt</b> : {{ getEarnUpdate }}</span>
            </div>
            <div class="slip-total-rate">
              <span><b>Komisyon</b> : % {{ this.$store.state.auth.customercomission }}</span>
              <span><b>Net</b> : {{ getNetEarn }}</span>
            </div>
            <div class="slip-total-rate remain-credit">
              <b>Bakiye: </b>
              <span v-if="creditRemain">{{ (creditRemain).toFixed(2) }}</span>
            </div>
            <div class="rate-terms">
              Oran Değişimlerini Kabul Ediyorum
            </div>
            <div class="slip-owner">
              <input v-model="slipSummary.owner" type="text" class="search-4" placeholder="Kupon Sahibi"
                @focus="clearOwner($event)">
            </div>
            <ul class="amount-btn">
              <li v-for="btn in amountBtn" :key="btn" class="amount-btn-items">
                <input v-model="slipSummary.amount" type="radio" class="amount-radio" :value="btn" :id="btn" @change="getEarn()">
                <label :for="btn" class="betrdb-lbl">{{ btn }}</label>
              </li>
            </ul>
            <div v-if="betMsg" class="bet-msg">
              <span>{{ betMsg }}</span>
            </div>
            <div class="amount-btn">
              <input v-model="slipSummary.amount" type="number" class="search-4 amount-btn-items" step="5" min="5" placeholder="Miktar"
                @input="getEarn()">
              <input type="button" class="clear amount-btn-items" value="Temizle" @click="removeAllSlips()">
              <input type="submit" class="done amount-btn-items" value="Yatır" @click="addBet()">
            </div>
        </div>
        <div v-if="isSlipLoader" class="live-slip">
          <div v-if="!isDialog" class="live-sliploader-con">
            <span class="live-slip-text">Kupon Yatırılıyor</span>
            <div class="loader-container">
              <LoaderComponent class="live-slip-loader" />
            </div>
          </div>
          <div v-if="isDialog" class="dialog print-dialog">
            <div class="dialog-content-print">
              <button ref="printbutton" class="dialog-side dsp" v-print="'#printMe'" @keyup.enter="hidePrintDialog()"
                @click="hidePrintDialog()" tabindex="5">
                <span class="print-icons">&#128424;</span>
              </button>
              <button class="dialog-side dsp" @keyup.enter="hidePrintDialog()" @click="hidePrintDialog()" tabindex="6">
                <span class="print-icons">&#128683;</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="slip-no-bet">
        <div v-if="role == 'Member'" class="last-coupon" @click="getLastCoupon()">{{ lastCoupon }}</div>
        <img src="@/assets/img/checklist.webp" class="no-slip-image" alt="">
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios"
import mixins from "@/mixins/index.js"
import LoaderComponent from '@/components/loader-component.vue';
export default {
  name: 'Slipside',
  inject: ['moment'],
  mixins: [mixins],
  components: {
    LoaderComponent
  },
  data() {
    return {
      slips: this.$store.state.slips,
      creditRemain: null,
      matches: null,
      earn: 0,
      totalRate: 1,
      finalRate: null,
      betMsg: null,
      amountBtn: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 75, 100],
      isDialog: false,
      isSlipLoader: false,
      lastCoupon: 'Son Oynanan Kuponu Getir',
      closeSlip: false,
      slipSummary: {
        sumid: 0,
        user: this.$store.state.auth.user,
        admin: this.$store.state.auth.admin,
        superadmin: this.$store.state.auth.superadmin,
        amount: null,
        owner: 'Sahip',
        stream: 'Bülten',
      }
    }
  },
  computed: {
    getTotalRate() {
      this.totalRate = 1
      for (const key in this.slips) {
        this.totalRate *= this.slips[key].rate
      }
      return this.totalRate.toFixed(2)
    },
    getEarnUpdate() {
      return (this.earn = this.slipSummary.amount * this.totalRate).toFixed(0)
    },
    getNetEarn() {
      const earn = this.slipSummary.amount * this.totalRate
      const comission = (earn * this.$store.state.auth.customercomission) / 100
      return (earn - comission).toFixed(2)
    },
    role() {
      if (this.$store.state.auth) {
        return this.$store.state.auth.role
      }
    }
  },
  mounted() {
    if(window.matchMedia('screen and (max-width: 1280px)').matches){
      this.closeSlip = true
    }
  },
  methods: {
    async getLastCoupon() {
      await axios.get('/api/admin/last-coupon').then((result) => {
        if (result.data.status === 401) {
          this.lastCoupon = 'Kupon Bulunamadı!'
          setTimeout(() => {
            this.lastCoupon = 'Son Oynanan Kuponu Getir'
          }, 3000)
        } else {
          let bets = []
          for (const key in result.data) {
            bets.push(
              {
                betid: result.data[key].betid,
                user: this.$store.state.auth.user,
                admin: this.$store.state.auth.admin,
                superadmin: this.$store.state.auth.superadmin,
                matches: result.data[key].matches,
                games: result.data[key].games,
                options: result.data[key].options,
                rate: result.data[key].rate,
                stream: 'Bülten',
                state: 'Aktif',
                eventtime: result.data[key].eventtime,
                branch: result.data[key].branch
              }
            )
            this.$store.commit('setSlips', bets[key])
          }
          if (!this.$store.state.betslip) {
            this.$store.commit('setBetSlip', true)
          }
        }
      })
    },
    async addBet() {
      if (navigator.onLine === false) {
        this.betMsg = 'Baglantı Yok!'
        return false
      }
      this.betMsg = ''
      if (this.$store.state.auth.role !== 'Member') {
        this.betMsg = 'Oyun Yetkiniz Yoktur!'
        return false
      }
      const minms = this.$store.state.auth.settings.minms
      const maxms = this.$store.state.auth.settings.maxms
      const minkm = this.$store.state.auth.settings.minkm
      const maxkm = this.$store.state.auth.settings.maxkm
      const cminms = this.$store.state.auth.settings.cminms
      const cmaxms = this.$store.state.auth.settings.cmaxms
      const cminkm = this.$store.state.auth.settings.cminkm
      const cmaxkm = this.$store.state.auth.settings.cmaxkm
      const creditremain = this.$store.state.betinfo.creditremain
      let checksuspend = false
      let suspendcode = null
      if (this.slips.length < minms) {
        this.betMsg = 'Minumum Maç sayısı' + ' ' + minms + ' ' + 'olmalıdır'
        return false
      }
      if (this.slips.length > maxms) {
        this.betMsg = 'Maximum Maç sayısı' + ' ' + maxms + ' ' + 'olmalıdır'
        return false
      }
      if (this.slipSummary.amount < minkm) {
        this.betMsg = 'Miktar' + ' ' + minkm + ' den az olamaz! '
        return false
      }
      if (this.slipSummary.amount > maxkm) {
        this.betMsg = 'Miktar' + ' ' + maxkm + ' den fazla olamaz!'
        return false
      }
      if (this.slips.length < cminms) {
        this.betMsg = 'Minumum Maç sayısı' + ' ' + cminms + ' ' + 'olmalıdır'
        return false
      }
      if (this.slips.length > cmaxms) {
        this.betMsg = 'Canli Maximum Maç sayısı' + ' ' + cmaxms + ' ' + 'olmalıdır'
        return false
      }
      if (this.slipSummary.amount < cminkm) {
        this.betMsg = 'Miktar' + ' ' + cminkm + ' den az olamaz! '
        return false
      }
      if (this.slipSummary.amount > cmaxkm) {
        this.betMsg = 'Miktar' + ' ' + cmaxkm + ' den fazla olamaz!'
        return false
      }
      if (this.slipSummary.amount > creditremain) {
        this.betMsg = 'Yetersiz Bakiye'
        return false
      }
      if (!this.slipSummary.amount || this.slipSummary.amount < 1) {
        this.betMsg = 'Miktar Boş Bırakılamaz!'
        return false
      }
      this.isSlipLoader = true
      await axios.get('/api/admin/ides').then(result => {
        if (result.data.ides) {
          let sumid = result.data.ides.sumid
          this.slipSummary.sumid = parseInt(sumid + 1)
        }
      })

      const slipList = this.$store.state.slips.filter(item => item.stream != 'Canlı')
      const eventtime = slipList.filter(item => item.eventtime < this.moment().format('YYYY-MM-DD HH:mm')).map(item => {return{betid: item.betid}})
      if(eventtime.length > 0){
        this.betMsg = String(eventtime[0].betid).slice(-3) + ' Nolu Kupon Illegaldir'
        checksuspend = true
        this.isSlipLoader = false
        return false
      }
      const livebet = this.$store.state.slips.filter(item => item.stream === 'Canlı')
      if (livebet.length < 1) {
        this.sendBet()
        return false
      }
      // live-bet
      this.slipSummary.stream = 'Canlı'
      setTimeout(() => {
        const betid = livebet.map(item => item.betid)
        axios.get(`/api/games/live-odds/${betid}`).then((result) => {
          let finalOdds = []
          if(result.data.length > 0){
            result.data.forEach(item => {
              if(item.SportId == 7){
                finalOdds.push({
                  scoreboard: item.Scoreboard,
                  id: item.Id,
                  markets: item.Markets.filter(item2 => {
                    return livebet.some(item3 => (item3.marketId == item2.id))
                  })
                })
              }
              if(item.SportId == 4){
                finalOdds.push({
                  scoreboard: item.Scoreboard,
                  id: item.Id,
                  markets: item.optionMarkets.filter(item2 => {
                    return livebet.some(item3 => (item3.marketId == item2.id))
                  })
                })
              }
            })
            //check suspended
            if (finalOdds.length > 0) {
              livebet.forEach(item => {
                finalOdds.forEach(item2 => {
                  if (item.betid == item2.id && item2.markets.length < 1) {
                    suspendcode = item.betid
                    checksuspend = true
                    this.betMsg = suspendcode.slice(-3) + '  ' + 'Nolu Bahis Kapalıdır!'
                  } else {
                    item2.markets.forEach(item3 => {
                      if (item.marketId == item3.id && (item3.visibility == 'Suspended' || item3.status == 'Suspended')) {
                        suspendcode = item.betid
                        checksuspend = true
                        this.betMsg = suspendcode.slice(-3) + '  ' + 'Nolu Bahis Askıdadır!'
                      }
                    })
                  }
                })
              })
              if (checksuspend) {
                this.isSlipLoader = false
              } else {
                this.sendBet()
              }
            } else {
              this.isSlipLoader = false
              this.betMsg = 'Bahise Kapalıdır!'
            }
          } else {
            alert('No data')
          }
        })
      }, 5000)
             
    },
    async sendBet() {
      if(this.slips.length > 0){
        this.isSlipLoader = true
        this.error = null
        await axios.post('/api/admin/add-bet', {
          sliplength: this.slips.length,
          slipSummary: this.slipSummary,
          slips: this.$store.state.slips,
          maxrate: this.$store.state.auth.settings.maxrate,
          maxearn: this.$store.state.auth.settings.maxearn,
          auth: this.$store.state.auth
        }).then((result) => {
          if (!result.data.error) {
            this.slipSummary.owner = 'Sahip'
            this.isDialog = true
            setTimeout(() => {
              if (this.isDialog) {
                this.$refs.printbutton.focus()
              }
            }, 500)
          } else {
            this.betMsg = result.data.error
          }
        })
      }
    },
    clearOwner(event) {
      event.target.value = ''
    },
    getEarn() {
      this.earn = this.slipSummary.amount * this.finalRate
      this.creditRemain = this.$store.state.betinfo.creditremain - this.slipSummary.amount
    },
    removeSlip(index, betid) {
      document.querySelectorAll('.bg-lg').forEach(item => {
        if (item.getAttribute('data-id') == betid) {
          item.classList.remove('bg-lg')
        }
      })
      this.$store.commit('removeSlipItem', index)
      if (this.slips.length === 0) {
        this.$store.commit('setBetSlip', false)
        this.betMsg = null
        this.earn = null
        this.creditRemain = null
        this.slipSummary.amount = null
        this.error = null
        this.totalRate = 1
        this.finalRate = 1
      }
    },
    removeAllSelected() {
      document.querySelectorAll('.bg-lg').forEach(item => {
        item.classList.remove('bg-lg')
      })
    },
    removeAllSlips() {
      this.betMsg = null
      this.earn = null
      this.creditRemain = null
      this.slipSummary.amount = null
      this.error = null
      this.totalRate = 1
      this.finalRate = 1
      this.$store.commit('removeSlips', [])
      this.$store.commit('setBetSlip', false)
      this.removeAllSelected()
    },
    print() {
      this.$htmlToPaper('printMe')
    },
    hidePrintDialog() {
      this.isDialog = false
      this.isSlipLoader = false
      setTimeout(() => {
        this.removeAllSlips()
        this.betInfoMix()
      }, 500)
    },
    closeSlipHandle(){
      this.$store.commit('setOpenSlip', false)
    }
  }
}
</script>

<style>
.slip-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: calc(60px + 0.1vw);
  border-top-left-radius: var(--radiuslarge);
  border-top-right-radius: var(--radiuslarge);
  padding: 0 5px;
  background-color: var(--black);
  border-bottom: 1px solid #ccc;
}
.slip-side-con{
  border: 1px solid #ccc;
  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
  overflow: hidden;
  border-top: none;
}
.slip-con {
  display: flex;
  flex-direction: column;
  background-color: var(--darkwhite);
  padding: 10px;
  padding-bottom: 0;
}
.slip-items-text {
  margin-right: 5px;
}

.slip-items-break {
  word-break: break-word;
}

.slip-match {
  width: 80%;
  color: brown;
}
.slip-total-rate {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 36px;
  box-shadow: 2 1px 1px #999;
  margin-top: 2px;
}
.slip-total-rate{
  border-bottom: 1px solid #ddd;
  padding: 0 5px;
}
.slip-code {
  display: flex;
  justify-content: center;
  align-items: center;
  width: fit-content;
  height: 24px;
  margin-right: 5px;
  padding: 0 5px;
  background-color: var(--green);
}

.slip {
  display: flex;
  margin: 3px 0;
  padding: 5px;
  position: relative;
  flex-direction: column;
  min-height: 70px;
  border-radius: var(--radiuslarge);
  border: 1px solid #999;
  background-color: #fff;
}

.jcsb {
  justify-content: space-between;
}

.slip-order {
  display: flex;
  align-items: center;
  padding: 2px;
}

.slip-trash {
  position: absolute;
  top: 8px;
  right: 8px;
  cursor: pointer;
  width: 18px;
}
.slip-total-rate {
  align-items: center;
  height: 30px;
  min-height: 30px;
}

.slip-rate {
  padding: 2px 5px;
  color: #fff !important;
  border-radius: 2px;
  background-color: var(--green);
}

.rate-terms {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 30px;
  color: var(--red);
}

.amount-btn {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  list-style: none;
  box-shadow: 2 1px 1px #999;
  position: relative;
  z-index: 0;
}
.amount-radio{
  visibility: hidden;
}
.bet-msg {
  margin: 5px;
  margin-top: 8px;
  text-align: center;
  background-color: brown;
  color: #fff;
  padding: 8px 3px;
  border-radius: 3px;
}

.amount-btn-items {
  position: relative;
  width: 28%;
  margin: 12px 6px;
}
.betrdb-lbl:hover{
  background-color: #ddd;
  cursor: pointer;
}
.betrdb-lbl {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 32px;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 5;
  color: #222;
  border: 1px solid #999;
  border-radius: var(--radius);
  background-color: #fff;
}
.slip-proc {
  padding: 10px 7px;
}

.clear,
.done {
  min-width: 80px;
  border: none;
  border-radius: var(--radius);
  height: 100%;
  color: #fff;
  margin-left: 3px;
  border: 1px solid #d7d7d7;
  cursor: pointer;
  height: calc(32px + 0.2vh);
  font-size: calc(16px + 0.2vw);
}
.clear:hover,
.done:hover{
  filter: brightness(120%);
}
.amount{
  min-height: 34px;
  border-radius: var(--radius);
  min-width:100px !important;
}
.slip-owner{
  height: 34px;
  padding:0 5px;
}

.done {
  background-color: var(--green);
}

.clear {
  background-color: var(--red);
}

.slip-item-con {
  display: flex;
  flex-direction: column;
}

.selected {
  background-color: #009464;
}

.slip-no-bet,
.live-slip {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  height: 500px;
  background-size: cover;
  background-position: center;
  background-color: var(--black);
}
.last-coupon {
  width: 94%;
  text-align: center;
  height: 40px;
  line-height: 40px;
  margin-top: 15px;
  color: #fff;
  background-color: var(--green);
  cursor: pointer;
  border-radius: 3px;
  font-size:calc(16px + 0.2vw);
}
.last-coupon:hover{
  filter: brightness(120%);
}
.live-sliploader-con {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 15%;
}

.live-slip-text {
  color: #EAD76C;
  margin: 20px 0;
}

.live-slip-loader {
  height: 15px;
}

.only-print {
  display: none;
}

.print-dialog {
  width: 90% !important;
  left: 5%;
  top: 10%;
  margin: auto;
  border-radius: 4px;
  border: 5px solid #f1f1f1;
  background-color: #091c0bd6;
}
.dialog-side {
  display: flex;
  flex-direction: column;
  color: #fff;
  width: 50%;
  align-items: center;
  padding: 5px 0;
  margin: 0 3px;
  border: none;
  border: 2px solid transparent;
  background-color: transparent;
}
.dialog-side:hover, .dialog-side:focus {
  cursor: pointer;
  border-color: #307858;
}
.dialog-content-print {
  display: flex;
  justify-content: center;
  width: 100%;
  padding: 30px 10px;
}

.dsp {
  border-color: #EAD76C;
  padding: 15px 0;
  margin: 0 10px;
}

.print-icons {
  margin: 0 20px;
  font-size: calc(40px + 0.5vw);
}

.print-icons:focus {
  border: 1px solid var(--green);
}
.no-slip-image{
  width: 256px;
  margin-top: 40px;
}
@media print {
  .no-print {
    display: none;
  }

  .only-print {
    display: block;
    padding: 5px 10px;
    color: #111;
  }

  .slip-title {
    display: flex;
    justify-content: center;
    padding: 10px 0;
    border-bottom: 1px solid #444;
  }

  .slip-date {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 3px 5px;
    border-bottom: 1px solid #444;
  }

  .print-title {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 60px;
    padding: 10px 0;
    border-bottom: 1px solid #444;
  }

  .print-list {
    border: none;
    margin: 0;
    padding: 0 2px;
    box-shadow: none;
    border-bottom: 1px solid #444;
  }

  .slip {
    height: auto;
    min-height: 70px;
  }

  .slip-order {
    display: flex;
    justify-content: space-between;
    box-shadow: none;
  }

  .slip-items {
    color: black;
  }

  .slip-match {
    padding-top: 5px;
  }

  .slip-rate {
    color: #000 !important;
  }

  .print-result {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-top: 5px;
    border-bottom: 1px solid #444;
    position: static;
  }

  .info-con {
    display: flex;
    justify-content: space-between;
    border: none;
    height: 20px;
  }
}</style>