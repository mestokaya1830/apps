<template>
  <div>
    <div class="admin-con">
      <header class="menu-1 fac">
        <span class="title-2">Şikayet ve Öneriler</span>
      </header>
      <template v-for="item in adviseList" :key="item._id">
        <div class="advise-con-list">
          <span class="cl-g">{{ adviseList[0].date }}</span>
          <h2 class="advise-subject">{{ item.subject }}</h2>
          <div class="advise-text">{{ item.text }}</div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import LoaderComponent from '@/components/loader-component.vue'
export default {
  name: 'Advise',
  components: {
    LoaderComponent
  },
  data() {
    return {
      adviseList: {},
      isLoader: false
    }
  },
  mounted() {
    this.getAdvise()
  },
  methods: {
    async getAdvise() {
      this.isLoader = true
      await axios.get('/api/admin/boss/advise-list').then(result => {
        if (result.data) {
          this.isLoader = false
          this.adviseList = result.data
        }
      })
    }
  }
}
</script>