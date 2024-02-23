<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fac">
        <span class="title-2">Sistem Limit Ayarları</span>
      </header>
      <ul>
        <li class="fix-li-warning">
          <span class="sec-icon">&#9907;</span>
          <span class="sec-text cl-g">
            Sayın üyeler bu alandaki degişikliklerden sonra sisteme yeniden Giriş yapılmalıdır!
          </span>
        </li>
        <div class="main-set-list">
          <div class="set-li">
            <select class="select-2" v-model="userBox" @change="getUserSettings()">
              <option disabled selected>Üyeler</option>
              <option v-for="list in userList" :value="list.user" :key="list.id">{{ list.user }}</option>
            </select>
          </div>
          <section v-if="betLimitSettings !== null" class="users-container">
            <li class="set-li">
              <label for="allUsers" class="toggle-settings">
                <input type="checkbox" v-model="allUsers" id="allUsers" class="toggle-checkbox">
                <span class="toggle-switch"></span>
              </label>
              <h3>Tüm Bayiler İçin Uygula</h3>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Minimum Maç Sayısı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.minms" type="number" min="0" class="search-2" :input="betLimitSettings.minms">
                <LoaderComponent v-if="isLoader == 'minms'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('minms', betLimitSettings.minms)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Maximum Maç Sayısı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.maxms" type="number" min="0" class="search-2" :input="betLimitSettings.maxms">
                <LoaderComponent v-if="isLoader == 'maxms'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('maxms', betLimitSettings.maxms)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Minimum Kupon Miktarı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.minkm" type="number" min="0" class="search-2" :input="betLimitSettings.minkm">
                <LoaderComponent v-if="isLoader == 'minkm'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('minkm', betLimitSettings.minkm)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Maximum Kupon Miktarı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.maxkm" type="number" min="0" class="search-2" :input="betLimitSettings.maxkm">
                <LoaderComponent v-if="isLoader == 'maxkm'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('maxkm', betLimitSettings.maxkm)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Maximum Oran</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.maxrate" type="number" min="0" class="search-2"
                  :input="betLimitSettings.maxrate">
                  <LoaderComponent v-if="isLoader == 'maxrate'"/>
                  <span>
                    <img src="@/assets/img/save.webp" @click="updateUserSettings('naxrate', betLimitSettings.naxrate)" class="menu-icons ml10 cl-g cp"/>
                  </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Maximum Kazanç</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.maxearn" type="number" min="0" class="search-2"
                  :input="betLimitSettings.maxearn">
                  <LoaderComponent v-if="isLoader == 'maxearn'"/>
                  <span>
                    <img src="@/assets/img/save.webp" @click="updateUserSettings('maxearn', betLimitSettings.maxearn)" class="menu-icons ml10 cl-g cp"/>
                  </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Maximum Oran</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cmaxrate" type="number" min="0" class="search-2"
                  :input="betLimitSettings.cmaxrate">
                  <LoaderComponent v-if="isLoader == 'cmaxrate'"/>
                  <span>
                    <img src="@/assets/img/save.webp" @click="updateUserSettings('cmaxrate', betLimitSettings.cmaxrate)" class="menu-icons ml10 cl-g cp"/>
                  </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Minimum Maç Sayısı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cminms" type="number" min="0" class="search-2" :input="betLimitSettings.cminms">
                <LoaderComponent v-if="isLoader == 'cminms'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('cminms', betLimitSettings.cminms)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Maximum Maç Sayısı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cmaxms" type="number" min="0" class="search-2" :input="betLimitSettings.cmaxms">
                <LoaderComponent v-if="isLoader == 'cmaxms'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('cmaxms', betLimitSettings.cmaxms)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Minimum Kupon Miktarı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cminkm" type="number" min="0" class="search-2" :input="betLimitSettings.cminkm">
                <LoaderComponent v-if="isLoader == 'cminkm'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('cminkm', betLimitSettings.cminkm)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Maximum Kupon Miktarı</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cmaxkm" type="number" min="0" class="search-2" :input="betLimitSettings.cmaxkm">
                <LoaderComponent v-if="isLoader == 'cmaxkm'"/>
                <span>
                  <img src="@/assets/img/save.webp" @click="updateUserSettings('cmaxkm', betLimitSettings.cmaxkm)" class="menu-icons ml10 cl-g cp"/>
                </span>
              </div>
            </li>
            <li class="set-li">
              <div class="fac">
                <span class="logo-2 mr10 cl-g">&#9881;</span>
                <span class="set-li-text">Canlı Maximum Kazanç</span>
              </div>
              <div class="fix-li-2-sub">
                <input v-model="betLimitSettings.cmaxearn" type="number" min="0" class="search-2"
                  :input="betLimitSettings.cmaxearn">
                  <LoaderComponent v-if="isLoader == 'cmaxearn'"/>
                  <span>
                    <img src="@/assets/img/save.webp" @click="updateUserSettings('cmaxearn', betLimitSettings.cmaxearn)" class="menu-icons ml10 cl-g cp"/>
                  </span>
              </div>
            </li>
          </section>
        </div>
      </ul>
    </div>
  </div>
</template>
<script>
import axios from "axios"
import LoaderComponent from "@/components/loader-component.vue";
export default {
  name: 'betLimitSettings',
  components:{
    LoaderComponent
  },
  data() {
    return {
      betLimitSettings: null,
      userList: '',
      userBox: 'Üyeler',
      isLoader: '',
      allUsers: false
    }
  },
  mounted() {
    this.getUserList()
  },
  methods: {
    async getUserList () {
      await axios.get('/api/admin/user-list').then((result) => {
        if(result.data.result){
          this.userList = result.data.result
        }
      })
    },
    async getUserSettings() {
      await axios.get(`/api/admin/user-settings/${this.userBox}`).then((result) => {
        if (result.data.result[0].settings) {
          this.betLimitSettings = result.data.result[0].settings
        }
      })
    },
    async updateUserSettings(column, value) {
      if (value) {
        if(this.allUsers){
          this.userBox = 'Hepsi'
        }
        this.isLoader = column
        await axios.put('/api/admin/user-settings-update', { column: column, value: value, userbox: this.userBox}).then((result) => {
          if (result.data.code === 200) {
            this.isLoader = ''
          }
        })
        return false
      }
      alert('Bu alan sadece pozitif sayı olabilir')
    }
  }
}
</script>

