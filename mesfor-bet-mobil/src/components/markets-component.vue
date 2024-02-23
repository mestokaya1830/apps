<template>
  <div v-if="$store.state.auth.role === 'Admin'">
    <header class="menu-1 fac">
      <span class="title-2">{{title}}</span>
      <span class="cl-y">({{marketsLength}})</span>
    </header>
    <ul>
      <li class="fix-li-warning">
        <span class="sec-icon">&#9907;</span>
        <span class="sec-text cl-g">
          Sayın üyeler bu alandaki degişikliklerden sonra sisteme yeniden Giriş yapılmalıdır!
        </span>
      </li>
      <div class="main-set-list">
        <div class="users-container market-container">
          <template v-for="list in markets" :key="list.marketId">
            <li class="fix-li">
              <div class="fix-1">
                <label :for="list.marketId" class="toggle-settings">
                  <input v-model="list[$store.state.auth.user]" :id="list.marketId" type="checkbox" checked class="toggle-checkbox"  @change="updateMarkets(list[$store.state.auth.user], list.marketId)" />
                  <div class="toggle-switch"></div>
                </label>
                <span class="market-name">{{list.marketName}}</span>
              </div>
            </li>
          </template>
        </div>
      </div>
    </ul>
  </div>
</template>
<script>
import axios from "axios"
export default {
  name: 'MarketSettings',
  props:{
    market:{
      type: String,
      required: true,
      default: '',
     },
    title:{
      type: String,
      required: true,
      default: ''
     },
    table:{
      type: String,
      required: true,
      default: ''
    },
    type:{
      type: String,
      required: true,
      default: ''
    }
  },
  data () {
    return {
      markets: {},
      marketsLength:0,
    }
  },
  mounted () {
    this.getMarkets()
  },
  methods: {
    async getMarkets () {
      await axios.get(`/api/admin/markets/${this.market}`).then((result) => {
        this.markets = result.data
        this.marketsLength = result.data.length
      })
    },
    async updateMarkets (state, marketId) {
      await axios.post('/api/admin/markets-update', {table:this.table, type:this.type, state, marketId})
    }
  }
}
</script>