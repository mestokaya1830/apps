import { createStore } from 'vuex'
import VuexPersist from 'vuex-persist';


const vuexLocalStorage = new VuexPersist({
  key: 'vuex',
  storage: window.localStorage
})

export default createStore({
  state: {
    auth: '',
    userbox: 'Üyeler',
    msgcount: 0,
    betinfo: 0,
    openchat:'',
    slips: [],
    betslip: false,
    openslip: false,
    adminmenu: false,
  },
  mutations: {
    setAuth: (state, payload) => {
      state.auth = payload
    },
    setUserBox: (state,payload) => {
      state.userbox = payload
    },
    setMsgCount: (state,payload) => {
      state.msgcount = payload
    },
    setBetInfo : (state, payload) => {
      state.betinfo = payload
    },
    setOpenChat : (state, payload) => {
      state.openchat = payload
    },
    setBetSlip : (state, payload) => {
      state.betslip = payload
    },
    setSlips : (state, payload) => {
      state.slips.push(payload)
    },
    removeSlipItem: (state, payload) => {
      state.slips.splice(payload, 1)
    },
    removeSlips : (state, payload) => {
      state.slips.splice(payload)
    },
    setAdminMenu : (state, payload) => {
      state.adminmenu = payload
    },
    setOpenSlip : (state, payload) => {
      state.openslip = payload
    }
  },
  plugins: [vuexLocalStorage.plugin]
})