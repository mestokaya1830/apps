<template>
  <div>
    <aside class="live-fixture-left">
      <div class="menu-1 fjsbac">
        <article class="fac">
          <img src="@/assets/img/live.webp" alt="" class="menu-icons ml10">
          <span class="title-2">Basketbol</span>
          <span class="cl-y">({{ liveListLength }})</span>
        </article>
        <div class="fjeac">
          <img src="@/assets/img/switch.webp" class="menu-icons mr10 cp" alt="" @click="isLeagueOpen =! isLeagueOpen"  title="Hepsi">
          <img src="@/assets/img/all.webp" class="menu-icons mr10 ml10 cp" alt="" @click="getLive()"  title="Hepsi">
        </div>
      </div>
      <div class="live-left-container">
        <div class="live-search-wrapper">
          <input  v-model="searchInputMatch" type="search" class="search-1" @keydown.enter="searchMatch()" placeholder="Maç ara...">
        </div>
        <div class="fixture-con">
          <div  v-if="isLoader" class="loader-container">
            <LoaderComponent />
          </div>
          <details :open="isLeagueOpen" class="live-details" v-for="item in liveList" :key="item.Id">
           <summary class="fixture-title">
             <div><img :src="getFlagsMix(item[0].RegionName)" onerror="this.src='../../../img/Unknown.png'" alt="" class="flags-live"></div>
             <div class="left-links-text">{{item[0].RegionName}} {{String(item[0].LeagueName).slice(0,15)}}</div>
           </summary>
           <div v-for="subitem in item" :key="subitem" @click="getLiveOdds(subitem)" class="live-list basket-bg">
             <span class="left-list-items">
               <span class="left-list-items">
                 <span>{{subitem.HomeTeam}}</span>
                 <span>{{subitem.AwayTeam}}</span> 
               </span>
               <div class="left-list-items-time">
                 <span v-if="subitem.Scoreboard.period === 'Q1'">1.Çeyrek</span>
                 <span v-if="subitem.Scoreboard.period === 'Q2'">2.Çeyrek</span>
                 <span v-if="subitem.Scoreboard.period === 'Q3'">3.Çeyrek</span>
                 <span v-if="subitem.Scoreboard.period === 'Q4'">4.Çeyrek</span>
                 <span v-if="subitem.Scoreboard.period === 'Halftime'">Devre Arası</span>
                 <span>{{subitem.Scoreboard.indicator}}</span>
                 <span>{{subitem.Scoreboard.score}}</span>
               </div>
             </span>
           </div>
         </details>
         <PageEndComponent :length="liveListLength" />
        </div>
      </div>
    </aside>
    <div class="live-fixture-center">
      <div class="menu-1 fjsbac">
        <article class="fac">
          <img src="@/assets/img/live.webp" alt="" class="menu-icons ml10">
          <span class="title-2">Canlı Pano</span>
          <span class="cl-y ml10 ml10">({{liveOddsLength}})</span>
        </article>
      </div>
      <div class="live-center-container">
        <div v-if="isLiveBet" class="live-center-bet">
          <div class="live-center-bet-basket">
            <div class="live-center-panel po-r">
              <div class="scores-board cp" @click="isEventBoard = ! isEventBoard">
                <span class="sbnh">{{String(liveOddsEvent.HomeTeam).slice(0,30)}}</span>
                <div class="sbc">
                  <span v-if="liveOddsEvent.Scoreboard" class="sbt">
                    {{liveOddsEvent.Scoreboard.score}}
                  </span>
                </div>
                <span class="sbna">{{String(liveOddsEvent.AwayTeam).slice(0,30)}}</span>
              </div>
              <div v-if="liveOddsEvent.Scoreboard" class="center-header">
                <img src="@/assets/img/bars.svg" class="live-timer"/>
                <span class="match-minutes">
                  <span v-if="liveOddsEvent.Scoreboard.period === 'Q1'">1.Çeyrek</span>
                  <span v-if="liveOddsEvent.Scoreboard.period === 'Q2'">2.Çeyrek</span>
                  <span v-if="liveOddsEvent.Scoreboard.period === 'Q3'">3.Çeyrek</span>
                  <span v-if="liveOddsEvent.Scoreboard.period === 'Q4'">4.Çeyrek</span>
                  <span v-if="liveOddsEvent.Scoreboard.period === 'Halftime'">Devre Arası</span>
                  <span class="ml20">{{liveOddsEvent.Scoreboard.indicator}}</span>
                </span>
              </div>
            </div>
          </div>
          <div class="live-suboptions">
            <header class="suboptions-header">
              <div>
                <img src="@/assets/img/switch.webp" class="menu-icons mr10 cp" alt="" @click="isMarketOpen =! isMarketOpen"  title="Hepsi">
              </div>
              <input type="search"  v-model="searchInputGame" @keydown.enter="searchGame()" class="search-1" placeholder="Bahis ara...">
              <ul class="live-option-filter">
                <li class="fjsbac">
                  <a 
                  class="live-option-filter-items bg-o" 
                  @click.prevent="setActive('all'), marketFilter()" 
                  :class="{ activeLiveFilter: isActive('all') }" 
                  href="#all">Hepsi
                </a>
                  <a 
                    class="live-option-filter-items bg-o" 
                    @click.prevent="setActive('totals'), marketFilter('Toplam')" 
                    :class="{ activeLiveFilter: isActive('totals') }" 
                    href="#totals">Toplam Basket
                  </a>
                  <a 
                    class="live-option-filter-items bg-o" 
                    @click.prevent="setActive('handicup'), marketFilter('Handikap')" 
                    :class="{ activeLiveFilter: isActive('handicup') }" 
                    href="#handicup">Handikap
                  </a>
                  <a 
                    class="live-option-filter-items bg-o" 
                    @click.prevent="setActive('spread'), marketFilter('Spread')" 
                    :class="{ activeLiveFilter: isActive('spread') }" 
                    href="#spread">Spread
                  </a>
                  <a 
                    class="live-option-filter-items bg-o" 
                    @click.prevent="setActive('points'), marketFilter('Basket Sayısı')" 
                    :class="{ activeLiveFilter: isActive('points') }" 
                    href="#points">Basket Sayısı
                  </a>
                </li>
              </ul>
            </header>
            <div class="scores-statistics-con">
              <div class="live-tab">
                <div  v-if="isOddsLoader" class="loader-container">
                  <LoaderComponent />
                </div>
                <template v-for="item in liveOdds" :key="item.id">
                  <details :open="isMarketOpen">
                    <summary :class="{suspendClass: item.visibility == 'Suspended'}" class="sublist-header">
                      <span>{{item.name.value}} <span class="cl-y ml10">{{ item.attr }}</span></span>
                    </summary>
                    <div v-if="item.visibility === 'Visible'" class="subodds-list">
                      <template v-for="subitem in item.results" :key="subitem">
                        <div class="subodds-wrapper prebwinfixture" >
                          <span class="odds">{{subitem.name.value}}</span>
                          <span class="oddsrate ml5 cl-r" @click="addSlip(item.id, subitem.name.value, subitem.odds, item.name.value)">{{subitem.odds}}</span>
                        </div>
                      </template>
                    </div>
                  </details>
                </template>
                <PageEndComponent :length="liveOddsLength" />
              </div>
            </div>
          </div> 
        </div> 
        <div v-else class="live-center-no-bet ">
          <h3>Henüz Bir Karşılaşma Seçmediniz..</h3>
          <i class="fas fa-arrow-circle-left cl-r fa-5x"></i>
        </div>
      </div>
    </div>
    <aside class="slip-side">
      <SlipComponent />
    </aside>
  </div>
</template>
<script>
import axios from "axios"
import mixins from '@/mixins/index.js'
import SlipComponent from "@/components/slip-component.vue";
import PageEndComponent from "@/components/page-end-component.vue";
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'Basket',
  mixins: [mixins],
  components: {
    SlipComponent,
    PageEndComponent,
    LoaderComponent
  },
  data () {
    return {
      liveList: {},
      liveOdds: {},
      liveEvents: {},
      liveOddsEvent: {},
      liveListLength: 0,
      liveOddsLength:0,
      searchMatches: {},
      searchGames: {},
      searchInputMatch: '',
      searchInputGame: '',
      slip: {},
      intervalLiveList: null,
      intervalLiveOdds: null,
      isEventBoard: false,
      isLiveBet: false,
      isBetSlip: false,
      isSlipScore: false,
      isLeagueOpen: true,
      isMarketOpen: true,
      isLoader: false,
      isOddsLoader: false,
      activeItem: 'all'
    }
  },
  mounted () {
    this.getLive()
    this.intervalLeagueList = setInterval(() => {
      this.getLive()
    }, 30 * 1000)
  },
  methods: {
    async getLive () {
      await axios.get("/api/games/basket-live").then((result) => {
        if(result.data.auth){
          window.location.reload()
          return false
        }
        if(result.data){
          this.isLoader = true
          const final = result.data
          this.liveList =  this.setGroupMix(final, 'LeagueId')
          this.isLoader = false
          
          this.liveListLength = final.length
          this.suspendBet = final.map(item => {
            return {
              id:String(item.Id).slice(-3),
              score:item.HomeTeam +'-'+ item.AwayTeam
            }
          })
          this.transCountriesMix(final)
          this.searchMatches = result.data
        }
      })
    },
    getLiveOdds(value) {
      this.isOddsLoader = true
      this.liveOdds = {}  
      this.liveEvents = value
      this.isLiveBet = true
      if (this.isLiveBet) {
        this.liveOddsFunc()
        this.intervalLiveOdds = setInterval(() => {
          this.liveOddsFunc()
        }, 10 * 1000)
      }
      window.scrollTo(0, 250)
    },
    async liveOddsFunc(){
      let avoidMarkets = []
      if(localStorage.getItem('set')){
        avoidMarkets = JSON.parse(localStorage.getItem('set')).map(item => {
          if(item.type == 'basket-live-market') return item.marketId
        })
      }
      await axios.get(`/api/games/live-odds/${this.liveEvents.Id}`).then((result) => {
        if(avoidMarkets.length > 0){
          this.liveOdds = result.data[0].Markets.filter(item1 => {return !avoidMarkets.some(item2 => (item1.name.value.includes(item2)))})
        } else {
          this.liveOdds = result.data[0].Markets
        }

        this.liveOdds.sort((a, b) => a.name.value > b.name.value ? 1 : -1)
        this.isOddsLoader = false
        this.liveOddsEvent = result.data[0]
        this.liveOddsLength = this.liveOdds.length
        this.searchGames = this.liveOdds
        this.transMarketsMixBasket(this.liveOdds)
        this.transOddsMixBasket(this.liveOdds)
        this.activeItem = 'all'
      })
    },
    searchMatch () {
      if(this.searchMatches){
        const temp = this.searchMatches.filter(item => item.HomeTeam.toLowerCase().includes(this.searchInputMatch.toLowerCase()) || item.AwayTeam.toLowerCase().includes(this.searchInputMatch.toLowerCase()))
        this.liveList = this.setGroupMix(temp, 'LeagueId')
        this.liveListLength = temp.length
        this.searchInputMatch = ''
      }
    },
    searchGame () {
      if(this.searchGames){
        const temp = this.searchGames.filter(item => item.name.value.toLowerCase().includes(this.searchInputGame.toLowerCase()))
        this.liveOdds = temp
        this.liveOddsLength = temp.length
        this.searchInputGame = ''
      }
    },
    addSlip (marketId, option, rate, game) {
      this.slip = {
        betid: this.liveEvents.Id,
        user: this.$store.state.auth.user,
        admin: this.$store.state.auth.admin,
        superadmin: this.$store.state.auth.superadmin,
        matches: this.liveEvents.HomeTeam +' - '+ this.liveEvents.AwayTeam,
        games: game,
        options: option,
        rate: rate,
        stream: 'Canlı',
        state: 'Aktif',
        eventtime:'D-' + this.liveOddsEvent.Scoreboard.indicator +'  S-'+ this.liveOddsEvent.Scoreboard.score,
        score:this.liveOddsEvent.Scoreboard.score,
        branch:'basketStyle',
        marketId:marketId
      }
      if (!this.$store.state.betslip){
        this.$store.commit('setBetSlip', true)
      }
      setTimeout(() => {
        let indexHolder = 0
        if (this.$store.state.slips.length > 0) {
        const findIndex = this.$store.state.slips.find((item,index) =>{
          indexHolder = index
          return item.betid === this.liveEvents.Id
        })
        if (findIndex === undefined) {
          this.$store.commit('setSlips', this.slip)
        } else {
          this.$store.commit('removeSlipItem', indexHolder)
          setTimeout(() => {
            this.$store.commit('setSlips', this.slip)
          }, 10)
        }
      } else {
        this.$store.commit('setSlips', this.slip)
      }
      }, 20)
    },
    isActive (menuItem) {
      return this.activeItem === menuItem
    },
    setActive (menuItem) {
      this.activeItem = menuItem
    },
    marketFilter(marketname){
      if(marketname == undefined){
        this.liveOdds = this.searchGames
        this.liveOddsLength = this.liveOdds.length
      } else {
        this.liveOdds = this.searchGames.filter(item => item.name.value.includes(marketname))
        this.liveOddsLength = this.liveOdds.length
      }
    }
  },
  beforeDestroy: function() {
    clearInterval(this.intervalLiveList)
    clearInterval(this.intervalLiveOdds)
  }
}
</script>