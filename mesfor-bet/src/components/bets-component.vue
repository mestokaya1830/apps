<template>
  <div v-if="role != 'Superadmin'">
    <div class="admin-con">
      <header class="menu-1 fjsbac">
        <article class="fac">
          <span class="title-2">{{ title }}</span>
          <span class="cl-y">({{ betSummary.length }})</span>
        </article>
        <section v-if="$route.name == 'bets' && role != 'Boss'" class="bet-menu">
          <div class="bet-filter">
            <span class="select-placeholder">Bugün</span>
            <select v-model="stateBox" @change="getBetSummary()" class="select-1">
              <option value="Aktif" selected>Aktifler</option>
              <option value="Hepsi">Hepsi</option>
              <option value="Kazandi">Kazananlar</option>
              <option value="Kaybetti">Kaybedenler</option>
              <option value="iptal">İptaller</option>
              <option value="iade">İadeler</option>
            </select>
          </div>
          
          <div v-if="role != 'Boss'" class="bet-filter">
            <select v-model="weeklyFilter" @change="weekFilter()" class="select-1">
              <option selected disabled>Haftalık</option>
              <option value="Aktif" selected>Aktifler</option>
              <option value="Hepsi">Hepsi</option>
              <option value="Kazandi">Kazananlar</option>
              <option value="Kaybetti">Kaybedenler</option>
              <option value="iptal">İptaller</option>
              <option value="iade">İadeler</option>
            </select>
          </div>
          <div class="bet-date">
            <input v-model="dateStart" type="date" class="search-5 mr10" />
            <input v-model="dateFinish" type="date" class="search-5 mr10" />
            <select v-model="dateBox" @change="dateFilter()" class="select-1">
              <option value="Tür Seç" selected disabled>Tür Seç</option>
              <option value="Aktif">Aktifler</option>
              <option value="Hepsi">Hepsi</option>
              <option value="Kazandi">Kazananlar</option>
              <option value="Kaybetti">Kaybedenler</option>
              <option value="iptal">İptaller</option>
              <option value="iade">İadeler</option>
            </select>
          </div>
        </section>
      </header>
      <div v-if="isLoader" class="loader-container">
        <LoaderComponent />
      </div>
      <div v-else>
        <div class="bet-list-header">
          <div class="bet-header-code">
            <input v-model="searchBox" type="number" class="search-5" placeholder="Kod Ara..."
              @keyup.enter="search()" />
          </div>
          <div class="owner" v-if="role != 'Member'">
            <select v-model="userBox" @click="getBetSummary()" class="select-2">
              <option selected value="Hepsi">Üyeler</option>
              <option v-for="list in userList" :value="list.user" :key="list.id">
                {{ list.user }}
              </option>
            </select>
          </div>
          <div v-else class="owner sort-items" @click="sortList('owner')" title="Sıralama">SAHİP</div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">TARİH</div>
          <div class="sort-items" @click="sortList('date')" title="Sıralama">SAAT</div>
          <div class="sort-items" @click="sortList('betscount')" title="Sıralama">MBS</div>
          <div class="sort-items" @click="sortList('amount')" title="Sıralama">MİKTAR</div>
          <div class="sort-items" @click="sortList('rate')" title="Sıralama">ORAN</div>
          <div class="sort-items" @click="sortList('earn')" title="Sıralama">KAZANÇ</div>
          <div class="sort-items" @click="sortList('stream')" title="Sıralama">TÜR</div>
          <div>DURUM</div>
        </div>
        <div class="bet-summary-con">
          <template v-for="(list, index) in betSummary" :key="list.sumid">
            <div class="bet-list cp" :class="list.state">
              <div class="bet-list-left" @click="getBets(index, list)">
                <div class="bet-list-code">
                  <span class="soccerStyle">{{ list.sumid }}</span>
                </div>
                <div class="owner" v-if="role != 'Member'">{{ list.user }}</div>
                <div class="owner" v-else>{{ list.owner }}</div>
                <div>{{ moment(list.date).format('MM-DD') }}</div>
                <div>{{ moment(list.date).format('H:mm:ss') }}</div>
                <div>{{ list.betscountremain }} / {{ list.betscount }}</div>
                <div>{{ list.amount }}</div>
                <div>{{ (list.rate).toFixed(2) }}</div>
                <div>{{ (list.earn).toFixed(2) }}</div>
                <div>{{ list.stream }}</div>
              </div>
              <div class="bet-list-right">
                <div v-if="role == 'Admin' && list.state == 'Kazandi'" class="payment-con">
                  <LoaderComponent v-if="betLoader == list.betid" />
                  <input v-if="list.adminpay == 'no'" type="button" class="btn-pay" value="ÖDE"
                    @click="paymentBet(list, $event)" />
                  <span v-else class="logo-2">&#128077;</span>
                </div>
                <div v-if="role == 'Member' && list.state == 'Kazandi'" class="payment-con">
                  <input v-if="list.adminpay == 'no'" type="button" class="input-box p5 cl-r" value="Bekliyor" disabled />
                  <span v-else class="logo-2">&#128077;</span>
                </div>
                <span v-if="list.state == 'Kaybetti'" class="logo-2">&#128078;</span>
                <span v-if="list.state == 'iptal'" class="logo-2">{{ list.state }}</span>
                <span v-if="list.state == 'iade'" class="logo-2">&#128072;</span>
                <span v-if="list.state == 'Aktif'" class="logo-2">&#9878;</span>
                <span v-if="list.state == 'Aktif' && role == 'Admin'" class="logo-2 cl-r mt5" title="İptal"
                  @click="cancelBet(list, index)"><img src="@/assets/img/trash.webp" alt="" class="bet-trash-icon"></span>
                <span
                  v-if="cancelTime(list.date) <= usercancelbet && (role == 'Member' && list.stream == 'Bülten' && list.state == 'Aktif')"
                  class="logo-2 cl-r mt5" @click="cancelBet(list, index)"><img src="@/assets/img/trash.webp" alt="" class="bet-trash-icon"></span>
              </div>
            </div>
          </template>
          <div v-if="isDetailsHandel" class="bet-details-model">
            <div class="bet-details-con" :class="{suboptionFull: maxWindow}">
              <header class="bet-menu">
                <div class="bet-details-tool">
                <img src="@/assets/img/print.webp" alt= "" class="menu-icons cp cl-y mr10" v-print="'#printMe'" title="Yazdır"/>
                <img src="@/assets/img/max.webp" alt="" @click="toggleMaxWindow()" class="menu-icons cp cl-y mr10 ml10" title="Tam Ekran" />
                <img src="@/assets/img/repeat.webp" v-if="role == 'Member' &&
                    betSum.state == 'Aktif' &&
                    betSum.stream == 'Bülten'
                    " class="menu-icons cp cl-y ml10 mr10" @click="repeatBets(bets)" title="Tekrar Yatır"/>
                </div>
                <div class="user-comission">
                  <div>
                    <span class="mr10">Brüt Kazanç </span>
                    <span>{{ cuponbaseearn }}</span>
                  </div>
                  <div>
                    <span class="mr10">Kesinti </span>
                    <span>{{ getComission }}</span>
                  </div>
                  <div>
                    <span class="mr10">Net Kazanç</span>
                    <span>{{ (cuponbaseearn - getComission).toFixed(2) }}</span>
                  </div>
                </div>
                <span>
                  <img src="@/assets/img/close.webp" alt="" title="Kapat" @click="closeDetails()" class="close">
                </span>
                
              </header>
              <div class="bet-list-header">
                <div>KOD</div>
                <div>SAAT</div>
                <div class="details-match-column">MAÇ</div>
                <div class="details-games-column">OYUN</div>
                <div class="details-games-column">SEÇİM</div>
                <div>ORAN</div>
                <div>TÜRÜ</div>
                <div>SKOR</div>
                <div class="input-select-con">DURUM</div>
              </div>
              <div class="bet-list-con">
                <template v-for="list in bets" :key="list._id">
                  <div class="bet-list" :class="{
                    Aktif: list.state == 'Aktif',
                    Kazandi: list.state == 'Kazandi',
                    Kaybetti: list.state == 'Kaybetti',
                    iade: list.state == 'iade',
                    iptal: list.state == 'iptal',
                  }">
                    <div class="betid-con">
                      <span :class="list.branch">{{ (list.betid).slice(-3) }}</span>
                    </div>
                    <div>{{ (list.eventtime).slice(-11) }}</div>
                    <div class="details-match-column">{{ String(list.matches).slice(0, 30) }}</div>
                    <div class="details-games-column">{{ list.games }}</div>
                    <div class="details-games-column">{{ list.options }}</div>
                    <div>{{ (list.rate) }}</div>
                    <div>{{ list.stream }}</div>
                    <div @click="getScore(list.betid)">
                      <div :class="{
                        green: list.state == 'Aktif' && list.ts == '1',
                        red: list.state == 'Aktif' && list.ts == '3',
                      }">{{ list.score }}</div>
                      <div v-if="list.ts == '1'">{{ list.tm }}</div>
                      <div v-if="list.ts == '0'">Başlamadı</div>
                    </div>
                    <PrintComponent :sumid="list.sumid" :betSum="betSum" :bets="bets" />
                    <LoaderComponent v-if="betLoader == list.betid" />
                    <div v-else class="input-select-con">
                      <div v-if="betSum.state != 'iptal' && role == 'Admin' || (role == 'Boss')">
                        <select v-if="list.state !== 'iptal'" v-model="list.state"
                          @click="setBetState(list)" class="select-2">
                          <option value="Aktif">Aktif</option>
                          <option value="Kazandi" v-if="list.state !== 'iade'">
                            Kazandi
                          </option>
                          <option value="Kaybetti">Kaybetti</option>
                          <option v-if="list.state !== 'Kazandi' &&
                            list.state !== 'Kaybetti'
                            " value="iade">
                            İade
                          </option>
                        </select>
                      </div>
                      <div v-else>{{ list.state }}</div>
                    </div>
                  </div>
                </template>
              </div>
              <div v-if="isScore" class="dialog-score-model">
                <header class="score-header">
                  <div class="score-title">Skor</div>
                  <img src="@/assets/img/close.webp" alt="" class="close" title="Kapat" @click="isScore = false"/>
                </header>
                <div v-if="isSubloader" class="loader-container">
                  <LoaderComponent />
                </div>
                <div v-else class="dialog-score-wrapper">
                  <div v-if="allScore">
                    <!-- soccer score -->
                    <div v-if="allScore.sport_id == '1'" class="dialog-score-con">
                      <div v-if="allScore && allScore.ss != null">
                        <div class="score-text">
                          Maç Durumu : {{ matchStatus }}
                        </div>
                        <div class="dialog-score">
                          <div v-if="allScore.scores[1] && allScore.scores[2]">
                            <div class="score-text">
                              İlk Yarı : {{ allScore.scores[1].home }} - {{ allScore.scores[1].away }}
                            </div>
                            <div class="score-text">
                              İkinci Yarı : {{ allScore.scores[2].home }} - {{ allScore.scores[2].away }}
                            </div>
                          </div>
                          <div class="score-text" v-else>
                            İlk Yarı : {{ allScore.scores[2].home }} - {{ allScore.scores[2].away }}
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- basket score -->
                    <div v-if="allScore.sport_id == '18'" class="dialog-score-con">
                      <div class="score-text">
                        Maç Durumu : {{ matchStatus }}
                      </div>
                      <div v-if="allScore.scores[1]" class="dialog-score">
                        <div class="score-text">
                          1.Çey: {{ allScore.scores[1].home }} - {{ allScore.scores[1].away }}
                        </div>
                      </div>
                      <div v-if="allScore.scores[2]" class="dialog-score">
                        <div class="score-text">
                          2.Çey: {{ allScore.scores[2].home }} - {{ allScore.scores[2].away }}
                        </div>
                      </div>
                      <div v-if="allScore.scores[3]" class="dialog-score">
                        <div class="score-text">
                          3.Çey: {{ allScore.scores[3].home }} - {{ allScore.scores[3].away }}
                        </div>
                      </div>
                      <div v-if="allScore.scores[4]" class="dialog-score">
                        <div class="score-text">
                          4.Çey: {{ allScore.scores[4].home }} - {{ allScore.scores[4].away }}
                        </div>
                      </div>
                      <div v-if="allScore.scores[7]" class="dialog-score">
                        <div class="score-text">
                          Toplam: {{ allScore.scores[7].home }} - {{ allScore.scores[7].away }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <span v-else>Veri yok!</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <PageEndComponent :length="betSummary.length" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import mixins from '@/mixins/index.js'
import print from 'vue3-print-nb'
import PrintComponent from "@/components/print-component.vue";
import PageEndComponent from "@/components/page-end-component.vue";
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'bets-component',
  inject: ['moment'],
  mixins: [mixins],
  components: {
    PrintComponent,
    PageEndComponent,
    LoaderComponent
  },
  props: {
    route: {
      type: String,
      required: true,
      default: 'betsummary'
    },
    title: {
      type: String,
      required: true,
      default: 'Kuponlar'
    }
  },
  directives: {
    print
  },
  data() {
    return {
      betSummary: {},
      userList: {},
      userBox: 'Hepsi',
      searchBox: null,
      stateBox: 'Aktif',
      weeklyFilter: 'Haftalık',
      dateBox: 'Tür Seç',
      dateStart: '',
      dateFinish: '',
      bets: {},
      betSum: {},
      removeIndex: null,
      betstate: null,
      getDetails: [],
      allScore: {},
      quickDate: 'Haftalık',
      cuponbaseearn: 0,
      betScore: null,
      isLoader: false,
      isSubloader: false,
      isDetailsHandel: false,
      isSort: false,
      betState: null,
      isScore: false,
      matchStatus: null,
      error: '',
      usercancelbet: this.$store.state.auth.usercancelbet,
      betLoader: '',
      cancelBetLoader: false,
      betCanceled: false,
      betCanceledCode: '',
      dateStart: this.moment().subtract(7, 'days').format('YYYY-MM-DD'),
      dateFinish: this.moment().add(1, 'days').format('YYYY-MM-DD'),
      maxWindow: false,
      isBetOpen: false
    }
  },
  mounted() {
    this.getBetSummary()
    this.getUserlist()
  },
  computed: {
    role() {
      if (this.$store.state.auth) {
        return this.$store.state.auth.role
      }
    },
    getComission() {
      const comission = (this.cuponbaseearn * this.$store.state.auth.customercomission) / 100
      return comission.toFixed(2)
    }
  },
  methods: {
    async getUserlist() {
      await axios.get('/api/admin/user-list').then((result) => {
        if (result.data.result) {
          this.userList = result.data.result
        }
      })
    },
    async getBetSummary() {
      this.isLoader = true
      await axios.get(`/api/admin/${this.route}/${this.userBox}/${this.stateBox}`).then((result) => {
        if (result.data.betsummary) {
          this.isLoader = false
          this.betSummary = result.data.betsummary
        }
      })
    },
    async getBets(index, list) {
      await axios.get('/api/admin/bet-summary/' + list.sumid).then((result) => {
        if (result.data.bets) {
          this.bets = result.data.bets
          this.isDetailsHandel = true
          this.betSum = list
          this.removeIndex = index
          this.cuponbaseearn = (list.baseearn).toFixed(2)
        }
      })
    },
    async removeBet() {
      this.cancelBetLoader = true
      await axios.post('/api/admin/cancel-bet', { betsum: this.betSum }).then((result) => {
        if (result.data.code == 200) {
          this.betSummary.splice(this.removeIndex, 1)
          this.betInfoMix()
          this.removeIndex = null
          this.cancelBetLoader = false
          this.betCanceled = true
          this.betSum = {}
        }
      })
    },
    async returnBet(betsum, index) {
      await axios.put('/api/admin/return-bet', { betsum: betsum }).then((result) => {
        if (result.data.code == 200) {
          this.betSummary.splice(index, 1)
          this.betInfoMix()
          this.betSum = {}
        } else {
          this.error = 'Yetersiz Kredi!'
        }
      })
    },
    async dateFilter() {
      if (!this.dateFinish) {
        this.dateFinish = this.moment().add(1, 'days').format('YYYY-MM-DD')
      }
      await axios.get(`/api/admin/bet-summary/date-filter/${this.userBox}/${this.dateBox}/${this.dateStart}/${this.dateFinish}`).then((result) => {
        if (result.data.datefilter) {
          this.betSummary = result.data.datefilter
        }
      })
    },
    async weekFilter() {
      await axios.get(`/api/admin/bet-summary/week-filter/${this.userBox}/${this.weeklyFilter}/${this.dateStart}/${this.dateFinish}`).then((result) => {
        if (result.data.weekfilter) {
          this.betSummary = result.data.weekfilter
        }
      })
    },
    async setBetState(betdetail) {
      this.betLoader = betdetail.betid
      this.getDetails = this.bets.map((item) => item.state)
      await axios.put('/api/admin/bet-state-update', { betsum: this.betSum, betdetail: betdetail }).then(() => {
        this.betLoader = ''
      })
    },
    async closeDetails() {
      this.isSubloader = false
      this.betid = 0
      this.isDetailsHandel = false
      let betstate = ''
      if (this.getDetails.length > 0) {
        const lost = this.getDetails.includes('Kaybetti')
        const active = this.getDetails.includes('Aktif')
        const won = this.getDetails.includes('Kazandi')
        const drawBet = this.getDetails.includes('iade')
        if (lost) {
          betstate = 'Kaybetti'
        } else if (this.getDetails.length == 1 && drawBet) {
          betstate = 'iade'
        } else if (won && !active) {
          betstate = 'Kazandi'
        } else {
          betstate = 'Aktif'
        }
        if (betstate !== '') {
          await axios.put('/api/admin/bet-summary-state-update', {betsum: this.betSum, betstate: betstate,}).then((result) => {
            if (result.data.message !== 'active') {
              setTimeout(() => {
                this.betSummary.splice(this.removeIndex, 1)
                this.removeIndex = ''
                this.getDetails = ''
                this.bets = {}
                this._id = ''
                this.betInfoMix()
              }, 500)
            }
          })
        }
      }
    },
    async getScore(id) {
      this.isScore = true
      this.isSubloader = true
      this.allScore = null
      await axios.get(`/api/games/scores/${id}`).then((result) => {
        this.allScore = result.data[0]
        if (result.data[0]) {
          if (result.data[0].time_status == '0') {
            this.matchStatus = 'Başlamadı'
          } else if (result.data[0].timer && result.data[0].timer.tm == 45) {
            this.matchStatus = 'Devre Arası'
          } else if (result.data[0].time_status == '3') {
            this.matchStatus = 'Bitti'
          } else {
            this.matchStatus = 'Devam Ediyor'
          }
        }
        this.isSubloader = false
      })
    },
    async paymentBet(list, event) {
      await axios.put('/api/admin/bet-payment', { betsum: list }).then((result) => {
        if (result.data.code == 200) {
          event.target.value = 'ÖDENDİ'
          event.target.style.backgroundColor = '#1A6D91'
          event.target.style.color = '#fff'
          this.betInfoMix()
        }
      })
    },
    async search() {
      if (!this.searchBox) {
        this.getBetSummary()
        return false
      }
      await axios.get(`/api/admin/bet-summary-search/${this.searchBox}`).then((result) => {
        if (result.data.betsummary.length > 0) {
          this.betSummary = result.data.betsummary
          this.searchBox = ''
          return false
        }
        this.betSummary = {}
        this.searchBox = ''
      })
    },
    cancelBet(betsum, index) {
      this.betSum = betsum
      this.betCanceledCode = betsum.sumid
      this.removeIndex = index
      if(confirm(`${betsum.sumid} Nolu Kupon İptal Edilsinmi ?`)){
       this.removeBet()
      }
    },
    cancelTime(value) {
      const diff = Date.now() - new Date(value).getTime()
      return Math.floor(diff / 1000 / 60)
    },
    print() {
      this.$htmlToPaper('printMe')
    },
    repeatBets(value) {
      if (this.$store.state.slips.length == 0) {
        value.filter((item) => {
          if (item.stream == 'Bülten') {
            const bets = {
              betid: item.betid,
              games: item.games,
              matches: item.matches,
              options: item.options,
              rate: item.rate,
              state: item.state,
              stream: item.stream,
              superadmin: item.superadmin,
              admin: item.admin,
              user: item.user,
              eventtime: item.eventtime,
              branch: item.branch
            }
            this.$store.commit('setSlips', bets)
            this.$router.push('/games/soccer')
            this.$store.commit('setBetSlip', true)
          }
        })
      } else {
        alert('Kupon listesi boş degil!')
      }
    },
    sortList(name) {
      if (name) {
        this.betSummary.sort((a, b) => {
          if (this.isSort) {
            return a[name] > b[name] ? 1 : -1
          }
          return a[name] > b[name] ? -1 : 1
        })
        this.isSort = !this.isSort
      }
    },
    toggleMaxWindow(){
      this.maxWindow =! this.maxWindow
    }
  }
}
</script>
