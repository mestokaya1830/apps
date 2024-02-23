<template>
  <div class="fjsb">
    <aside class="countries">
      <header class="menu-1">
        <div class="countries-title">Ülkeler</div>
      </header>
      <div class="countries-list" v-for="item in countries" :key="item.Id" @click="getCountries(item[0].RegionId)">
        <article class="fjsbac">
          <div class="fac">
            <img :src="getFlagsMix(item[0].RegionName)" class="countries-flag" onerror="this.src='../../../img/Unknown.png'">
            <span class="title-5">{{ item[0].RegionName }}</span>
          </div>
          <span class="title-5 mr10">{{ item.length }}</span>
        </article>
      </div>
      <PageEndComponent :length="countries.length" />
    </aside>
    <aside class="fixture-side">
      <div class="menu-1 fjsbac">
        <div>
          <article class="fac">
            <img src="@/assets/img/soccer.webp" alt="" class="menu-icons">
            <span class="title-2">Futbol</span>
            <span class="cl-y">({{ leaguesLength }})</span>
          </article>
          <div class="fjeac">
            <img src="@/assets/img/switch.webp" class="menu-icons mr10 cp" alt="" @click="isLeagueOpen =! isLeagueOpen"  title="Hepsi">
            <img src="@/assets/img/all.webp" class="menu-icons ml10 mr10 cp" alt="" @click="getLeagues()"  title="Hepsi">
          </div>
        </div>
        <div>
          <input v-model="searchInputMatch" type="search" ref="search"  @keydown.enter="searchMatch()" class="search-1" placeholder="Maç ara...">
        </div>
        <div>
          <select v-model="timeBox" @change="filterAsTime()" class="select-1">
            <option value="all">Hepsi</option>
            <option value="Saat" disabled>Saat</option>
            <option :value="moment().format('YYYY-MM-DD HH')">1 Saat İçinde</option>
            <option :value="moment().add(1,'hours').format('YYYY-MM-DD HH')">2 Saat İçinde</option>
            <option :value="moment().add(2,'hours').format('YYYY-MM-DD HH')">3 Saat İçinde</option>
            <option :value="moment().add(3,'hours').format('YYYY-MM-DD HH')">4 Saat İçinde</option>
          </select>
        </div>
        <div>
          <select v-model="dateBox" @change="filterAsDay()" class="select-1 mr10">
            <option disabled>Gün</option>
            <option value="all">Hepsi</option>
            <option value="0">Bügün</option>
            <option value="1">Yarın</option>
            <option value="2">3.Gün</option>
            <option value="3">4.Gün</option>
          </select>
        </div>
      </div>
      <div  v-if="isLoader" class="loader-container">
        <LoaderComponent />
      </div>
      <div class="fixture-con">
        <details :open="isLeagueOpen" v-for="item in leagues" :key="item[0].Id">
          <summary class="fixture-title title-5">
            <div><img :src="getFlagsMix(item[0].RegionName)" onerror="this.src='../../../img/Unknown.png'" alt=""></div>
            <div>{{ item[0].RegionName }} {{ item[0].LeagueName }}</div>
            <div>1</div>
            <div>X</div>
            <div>2</div>
            <div>Alt</div>
            <div>Üst</div>
            <div>Var</div>
            <div>Yok</div>
            <div>+</div>
          </summary>
          <template  v-for="subitem in item" :key="subitem.FixtureId">
            <div class="fixture-list">
              <!-- <div><span class="league-code code-soccer">{{ String(subitem.FixtureId).slice(-3) }}</span></div> -->
              <div class="fixture-date-con">
                <span class="fixture-date">{{ moment(subitem.Date).format('MM-DD')}}</span>
                <span>{{ moment(subitem.Date).format('HH:mm')}}</span>
              </div>
              <div @click="getOdds(subitem.FixtureId)" class="teams-con">
                <div>{{ subitem.HomeTeam }}</div>
                <div>{{ subitem.AwayTeam }}</div>
              </div>
             
              <!-- extra -->
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, subitem.HomeTeam, subitem, 'Maç Bahsi')" v-if="subitem.MatchResult[0]">{{ subitem.MatchResult[0].options[0].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, 'X', subitem, 'Maç Bahsi')" v-if="subitem.MatchResult[0]">{{ subitem.MatchResult[0].options[1].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, subitem.AwayTeam, subitem, 'Maç Bahsi')" v-if="subitem.MatchResult[0]">{{ subitem.MatchResult[0].options[2].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, 'Alt 2.5', subitem, 'Toplam Gol Alt/Üst 2.5')" v-if="subitem.TotalGoals[0]">{{ subitem.TotalGoals[0].options[1].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, 'Üst 2.5', subitem, 'Toplam Gol Alt/Üst 2.5')" v-if="subitem.TotalGoals[0]">{{subitem.TotalGoals[0].options[0].price.odds}}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, 'Var', subitem, 'Karşılıklı Gol')" v-if="subitem.BothTeamsToScore[0]">{{ subitem.BothTeamsToScore[0].options[0].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="rate" :data-id="subitem.FixtureId"  @click="addSlip($event, 'Yok', subitem, 'Karşılıklı Gol')" v-if="subitem.BothTeamsToScore[0]">{{ subitem.BothTeamsToScore[0].options[1].price.odds }}</div>
              <div class="rate" v-else >&#128274;</div>
              <div class="cp" @click="getOdds(subitem.FixtureId)"><img src="@/assets/img/details.webp" width="32px" alt=""></div>
            </div>
          </template>
        </details>
        <PageEndComponent :length="leaguesLength" />
      </div>
    </aside>
    <aside class="slip-side">
        <SlipComponent />
    </aside>
    <div v-if="isSubOptions" class="suboptions-model">
      <div class="suboptions" :class="{suboptionFull: maxWindow}">
        <header class="menu suboptions-menu">
          <div class="suboptions-menu-tools">
            <img src="@/assets/img/switch.webp" class="menu-icons mr10 cp" alt="" @click="isMarketOpen =! isMarketOpen"  title="Hepsi">
            <img src="@/assets/img/all.webp" class="menu-icons cp mr10" alt="" @click="resetGame()"  title="Hepsi">
            <img src="@/assets/img/max.webp" class="menu-icons cp" alt="" @click="toggleMaxWindow()">
            <div class="cl-y ml10">({{oddsLength}})</div>
          </div>
            <div class="suboptions-menu-teamname">{{teamName}}</div>
            <img src="@/assets/img/close.webp" alt="" title="Kapat" @click="closeSub()" class="close">
        </header>
        <div class="suboptions-header">
          <input type="text" class="search-5 mr10" v-model="searchInputGame" @keydown.enter="searchGame()" placeholder="Bahis ara...">
          <ul class="live-option-filter">
            <li class="fjsbac">
              <a 
              class="live-option-filter-items bg-g" 
              @click.prevent="setActive('all'), marketFilter()" 
              :class="{ activeLiveFilter: isActive('all') }" 
              href="#all">Hepsi
            </a>
            <a 
              class="live-option-filter-items bg-g" 
              @click.prevent="setActive('result'), marketFilter('Maç Sonucu')"
              :class="{ activeLiveFilter: isActive('result') }" 
              href="#result">Maç Sonu
            </a>
              <a 
                class="live-option-filter-items bg-g" 
                @click.prevent="setActive('firsthalf'), marketFilter('Devre 1')" 
                :class="{ activeLiveFilter: isActive('firsthalf') }" 
                href="#firsthalf">D-1
              </a>
              <a 
                class="live-option-filter-items bg-g" 
                @click.prevent="setActive('secondhalf'), marketFilter('Devre 2')" 
                :class="{ activeLiveFilter: isActive('secondhalf') }" 
                href="#secondhalf">D-2
              </a>
              <a 
                class="live-option-filter-items bg-g" 
                @click.prevent="setActive('totals'), marketFilter('Toplam Gol')" 
                :class="{ activeLiveFilter: isActive('totals') }" 
                href="#totals">Goller
              </a>
              <a 
                class="live-option-filter-items bg-g" 
                @click.prevent="setActive('hometeam'), marketFilter(this.teams[0])" 
                :class="{ activeLiveFilter: isActive('hometeam') }" 
                href="#hometeam">Ev
              </a>
              <a 
                class="live-option-filter-items bg-g" 
                @click.prevent="setActive('awayteam'), marketFilter(this.teams[1])" 
                :class="{ activeLiveFilter: isActive('awayteam') }"
                href="#awayteam">Dep
              </a>
            </li>
          </ul>
        </div>
        <div class="suboptions-con">
          <div  v-if="isOddsLoader" class="loader-container">
            <LoaderComponent />
          </div>
          <details :open="isMarketOpen" v-for="item in subOdds" :key="item">
            <summary class="sublist-header">
              <span>{{item.name.value}} <span class="cl-y ml10">{{ item.attr }}</span></span>
            </summary>
            <div class="subodds-list">
              <template v-for="subitem in item.options" :key="subitem">
                <div class="subodds-wrapper prebwinfixture" >
                  <span class="odds">{{subitem.name.value}}</span>
                  <span class="oddsrate ml5 cl-r" @click="addSlip($event, subitem.name.value, '', item.name.value)">{{subitem.price.odds}}</span>
                </div>
              </template>
            </div>
          </details>
          <PageEndComponent :length="oddsLength" />
        </div>
      </div> 
    </div>
  </div>
</template>
<script>
import axios from "axios"
import mixins from '@/mixins/index.js'
import SlipComponent from "@/components/slip-component.vue";
import PageEndComponent from "@/components/page-end-component.vue";
import LoaderComponent from "@/components/loader-component.vue";

export default {
  name: 'SoccerPage',
  mixins: [mixins],
  inject:['moment'],
  components: {
    SlipComponent,
    PageEndComponent,
    LoaderComponent
  },
  data() {
    return {
      leagues: {},
      subOdds: {},
      leaguesLength: 0,
      countries: {},
      oddsLength: 0,
      searchMatches:{},
      searchGames:{},
      searchInputMatch: '',
      searchInputGame:'',
      slips: {},
      timeBox: 'Saat',
      dateBox: 'Gün',
      isSubOptions: false,
      betSlip: false,
      teamName: '',
      gameCode: '',
      isLeagueOpen: true,
      isMarketOpen: true,
      intervalLeagueList: '',
      isLoader: false,
      isOddsLoader: false,
      subTime: 0,
      maxWindow: false,
      activeItem: 'all',
      teams: []
    }
  },
  mounted() {
    this.getLeaguesFunction()
    this.$refs.search.focus()
  },
  methods: {
    async getLeagues() {
      this.isLoader = true
      await axios.get('/api/games/soccer').then((result) => {
        const final = result.data.result
        this.transCountriesMix(final)
        this.leagues = this.setGroupMix(final, 'LeagueId')
        this.isLoader = false
      
        this.leaguesLength = final.length
        this.searchMatches = result.data.result
        this.dateBox = 'Gün'
        this.timeBox = 'Saat'
        this.countries = this.setGroupMix(final, 'RegionId')
      })
    },
    async getOdds(id) {
      this.isOddsLoader = true
      let avoidMarkets = []
      this.subOdds = {}
      this.teamName = ''
      this.oddsLength = 0
      this.isSubOptions = true
      this.searchGames = null

      if(localStorage.getItem('set')){
        avoidMarkets = JSON.parse(localStorage.getItem('set')).map(item => {
          if(item.type == 'soccer-market') return item.marketId
        })
      }
      await axios.get('/api/games/odds/'+ id).then((result) => {
        this.teams.push(result.data[0].HomeTeam, result.data[0].AwayTeam)
        if(avoidMarkets.length > 0){
          this.subOdds = result.data[0].optionMarkets.filter(item1 => {return !avoidMarkets.some(item2 => (item1.name.value.includes(item2)))})
        } else {
          this.subOdds = result.data[0].optionMarkets
        }
        this.subOdds.sort((a, b) => a.name.value > b.name.value ? 1 : -1)
        this.oddsLength = this.subOdds.length
        this.isOddsLoader = false

        this.teamName = result.data[0].HomeTeam + ' - ' + result.data[0].AwayTeam
        this.gameCode = id
        this.subTime = result.data[0].Date
        this.searchGames = this.subOdds
        this.transMarketsMix(this.subOdds)
        this.transOddsMix(this.subOdds)
        this.activeItem = 'all'
      })
    },
    getCountries(id) {
      const temp = this.searchMatches.filter(item => item.RegionId === id)
      this.leagues = this.setGroupMix(temp, 'LeagueId')
      this.leaguesLength = temp.length
      window.scrollTo(0, 0)
    },
    closeSub() {
      this.isSubOptions = false
    },
    async filterAsDay() {
      let start = ''
      let end = ''
      if(this.dateBox == 'all'){
        start = this.moment().format('YYYY MM DD 00:00:00')
        end = this.moment().add(4,'days').format('YYYY MM DD 24:00:00')
      } else {
        start = this.moment().add(this.dateBox,'days').format('YYYY MM DD 00:00:00')
        end = this.moment().add(this.dateBox,'days').format('YYYY MM DD 24:00:00')
      }
      await axios.get(`/api/games/soccer-date-filter/${start}/${end}`).then (result => {
        this.transCountriesMix(result.data.result)
        this.leagues = this.setGroupMix(result.data.result, 'LeagueId')
        this.searchMatches = result.data.result
        this.leaguesLength = result.data.result.length
        this.countries = this.setGroupMix(result.data.result, 'RegionId')
      })
    },
    filterAsTime() {
      if (this.timeBox == 'all') {
        const temp = this.searchMatches.filter(item => this.moment(item.Date).format('YYYY MM DD') == this.moment().format('YYYY MM DD'))
        this.leagues = this.setGroupMix(temp, 'LeagueId')
        this.leaguesLength = temp.length
        this.timeBox = 'all'
        return false
      }
      const temp = this.searchMatches.filter(item => this.moment(item.Date).format('YYYY-MM-DD HH') == this.timeBox)
      this.leagues = this.setGroupMix(temp, 'LeagueId')
      this.leaguesLength = temp.length
    },
    async searchMatch() {
      if(this.searchInputMatch){
        await axios.get('/api/games/soccer-search/'+ this.searchInputMatch).then((result) => {
          this.leagues = this.setGroupMix(result.data.result, 'LeagueId')
          this.transCountriesMix(result.data.result)
          this.leaguesLength = result.data.result.length
          this.searchInputMatch = ''
        })
      } else {
        this.getLeagues()
      }
    },
    searchGame() {
      const temp = this.searchGames.filter(item => item.name.value.toLowerCase().includes(this.searchInputGame.toLowerCase()))
      this.subOdds = temp
      this.oddsLength = temp.length
      this.searchInputGame = ''
    },
    resetGame() {
      const temp = this.searchGames
      this.subOdds = temp
      this.oddsLength = temp.length
      this.searchInputGame = ''
    },
    addSlip(event, option, subitem, game) {
      const rateclass = event.target.className
      const parent = event.target.parentElement
      event.target.classList.toggle('bg-lg')
      parent.querySelectorAll('.bg-lg').forEach(item => {
        item.classList.remove('bg-lg')
        if(subitem != ''){
          event.target.classList.add('bg-lg')
        }
      })
      this.selectedId = true
      let gameCode = ''
      let match = this.teamName
      let eventTime = ''
      if (subitem == '') {
        match = this.teamName
        gameCode = this.gameCode
      } else {
        match = subitem.HomeTeam + ' - ' + subitem.AwayTeam
        gameCode = subitem.FixtureId
      }
      const finishedSlip = () => {
        if (event !== '-') {
          this.slips = {
            betid: gameCode,
            user: this.$store.state.auth.user,
            admin: this.$store.state.auth.admin,
            superadmin: this.$store.state.auth.superadmin,
            matches: match,
            games: game,
            options: option,
            rate: event.target.innerText,
            stream: 'Bülten',
            state: 'Aktif',
            eventtime: eventTime,
            score: '-:-',
            branch:'soccerStyle'
          }
          if (!this.$store.state.betslip) {
            this.$store.commit('setBetSlip', true)
          }
          if (this.$store.state.slips.length > 0) {
            let indexHolder = 0
            const findSlip = this.$store.state.slips.find((item, index) => {
              indexHolder = index
              return item.betid == gameCode
            })
            if (findSlip == undefined) {
              this.$store.commit('setSlips', this.slips)
            } else {
              if (rateclass == 'rate bg-lg') {
                this.$store.commit('removeSlipItem', indexHolder)
                if (this.$store.state.slips < 1) {
                  this.$store.commit('setBetSlip', false)
                }
              } else {
                this.$store.commit('removeSlipItem', indexHolder)
                setTimeout(() => {
                  this.$store.commit('setSlips', this.slips)
                }, 100)
              }
            }
          } else {
            this.$store.commit('setSlips', this.slips)
          }
        }
      }
      if (subitem) {
        eventTime = this.moment(subitem.Date).format('YYYY-MM-DD HH:mm')
        // eventTime = moment(subitem.Date).tz('Europe/Istanbul').format('YYYY-MM-DD HH:mm')
        finishedSlip()
        return false
      }
      eventTime = this.moment(this.subTime).format('YYYY-MM-DD HH:mm')
      // eventTime = moment(this.subTime).tz('Europe/Istanbul').format('YYYY-MM-DD HH:mm')
      finishedSlip()
      this.isSubOptions = false
    },
    getLeaguesFunction() {
      this.getLeagues()
      this.intervalLeagueList = setInterval(() => {
        this.getLeagues()
      }, 905 * 1000)
    },
    toggleMaxWindow(){
      this.maxWindow =! this.maxWindow
    },
    isActive (menuItem) {
      return this.activeItem === menuItem
    },
    setActive (menuItem) {
      this.activeItem = menuItem
    },
    marketFilter(marketname){
      if(marketname == undefined){
        this.subOdds = this.searchGames
        this.oddsLength = this.subOdds.length
      } else {
        this.subOdds = this.searchGames.filter(item => item.name.value.includes(marketname))
        this.oddsLength = this.subOdds.length
      }
    }
  },
  beforeUnmount: function () {
    clearInterval(this.intervalLeagueList)
  }
}
</script>
