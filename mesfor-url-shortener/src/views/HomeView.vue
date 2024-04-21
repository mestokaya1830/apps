<template>
  <div>
    <div class="container">
      <img src="@/assets/logo.webp" alt="" class="logo">
      <h1 class="title">Mesfor Url Shortener</h1>
      <div class="wrapper">
        <input type="text" id="url" class="inputs" placeholder="URL..."/>
        <button @click="createShortUrl()" class="input-btn">Create Short Url</button>
      </div>
      <table class="list">
        <thead>
          <tr>
            <td>Full Url</td>
            <td>Short Url</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in urlList" :key="item.id">
            <td>{{ item.full }}</td>
            <td><RouterLink :to="item.short" target="_blank">{{ item.short }}</RouterLink></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import Loader from '@/components/loader-component.vue'
export default {
  name:'UrlShortener',
  components:{Loader},
  data () {
    return {
      urlList: {}
    }
  },
  mounted(){
    this.getUrls()
  },
  methods:{
    async getUrls(){
      const result = await fetch('http://localhost:3000/api/get-urls')
      const final = await result.json()
      this.urlList = final
    },
    async createShortUrl () {
      const url = document.getElementById('url')
      const result = await fetch('http://localhost:3000/api/addurl', {
          method: 'POST',
          headers: {'Content-type': "application/json; charset=UTF-8"},
          body: JSON.stringify({
              fullUrl: url.value
          })
      })
      const returnData = await result.json()
    }
  }
}
</script>

<style scoped>
  .container{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 40vw;
    margin: 0 auto;
    padding: 2px;
  }
  .wrapper{
    display: flex;
    margin-top: 50px;
  }
  .title{
    font-size: 30px;
    color: #545454;
    margin-top: 30px;
  }
.logo{margin-top: 50px;}
.inputs{
  height: 34px;
  padding-left: 7px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
  font-size: 16px;
  width: 500px;
}
.input-btn{
  padding: 7px 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 17px;
}
table, td, th {
  border: 1px solid #ccc;
  height: auto;
  padding: 10px;
  color: #545454;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
  @media screen and (max-width: 1080px){
    .container{ 
      width: 100vw;
      padding: 10px;
    }

  }
</style>
