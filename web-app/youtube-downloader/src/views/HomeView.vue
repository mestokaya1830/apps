<template>
  <main>
    <div class="container">
      <img src="@/assets/logo.webp" alt="" class="logo">
      <h1 class="title">Mesfor Youtube Downloader</h1>
      <p class="text-format">Download youtube video and audio.</p>
      <form action="/api/download" @submit="download($event)" method="post" class="form">
        <div class="dimentions">
          <select name="format">
            <option value="mp4">Video</option>
            <option value="mp3">Audio</option>
          </select>
          <input type="text" v-model="url" name="url" class="dimentions-input" id="imageHeight" placeholder="Enter url here...">
        </div>
        <div class="footer">
          <div class="download-btn-con" v-if="!isLoader">
            <input type="submit" id="download-all"  value="Send Request" class="download-all">
            <img src="@/assets/download.png" alt="" class="download-btn-img"/>
          </div>
          <Loader v-if="isLoader"/>
        </div>
      </form>
    </div>
  </main>
</template>

<script>
import Loader from '@/components/loader-component.vue'
export default {
  name:'ImageCompressor',
  components:{Loader},
  data () {
    return {
      state: false,
      isLoader: false,
      format:'mp4',
      url:'',
    }
  },
  methods:{
    async download(e){
      if(this.url == ''){
        e.preventDefault();
        alert('Please enter valid youtube url!')
        return false
      }
      this.isLoader = true
      setInterval(() => {
        let result = document.cookie.split('=')
        if(result[0] == 'mesfor'){
          document.cookie = "mesfor=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
          this.isLoader = false
          this.url = ''
        }
      }, 1000);
    }
  }
}
</script>

<style scoped>
.cp{cursor: pointer;}
  .container{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 30vw;
    margin: 0 auto;
  }
  .form{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
  }
  .title{
    font-size: 30px;
    color: #545454;
    margin-top: 30px;
  }
  .text-format{
    color: #666;
    font-size: 13px;
    margin: 20px 0;
  }
  .warning-text{
    font-size: 12px;
    color: #bababa;
    margin-top: 10px;
    margin-bottom: 5px;
  }
  .logo{margin-top: 50px;}
  .img-container{
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .input-field{
    width: 100%;
    height: 200px;
    padding: 10px;
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }
  .dimentions{
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: auto;
    width:100%;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin: 40px auto;
    margin-bottom: 0;
  }
  .dimentions-input{
    width: 70%;
    border-radius: 5px;
    height: 30px;
    padding-left: 10px;
    border: none;
    border: 1px solid #ddd;
    margin:  10px;
  }
  select{
    appearance: none;
    outline: 0;
    width: 25%;
    padding: 0 10px;
    background: url('@/assets/select-arrow.webp') no-repeat right 10px center / 16px,
    linear-gradient(to left, #ddd 36px, #f1f1f1 36px);
    color: black;
    height: 30px;
    border: 1px solid #ccc;
    border-radius: 3px;
    cursor: pointer;
    font-size: calc(16px + 0.1vw);
    margin-left: 10px;
  }
  .file-name, .file-status{
    font-size: 12px;
    color: rgb(58,90,64);
  }
  .file-status{margin-right: 10px;}

  ul{
    list-style: none;
  }
  .download-btn-con{
    display: flex;
    justify-content: space-between;
    width: fit-content;
    background-color: rgb(58,90,64);
    padding: 5px 10px;
    border-radius: 4px;
  }
  .footer{
    display: flex;
    justify-content: center;
    width: 100%;
    margin-top: 50px;
  }
  .download-all, .clear-all{
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    width: fit-content;
    font-size: 16px;
  }
  .download-all{
    color: #fff;
    background-color: rgb(58,90,64);
    margin-right: 10px;
  }
  .clear-all{
    min-width: 160px;
    color: rgb(58,90,64);
    border: 1px solid rgb(58,90,64);
    margin-right: 20px;
    border-radius: 4px;
  }
  .download-btn-con:hover, .clear-all:hover{
    filter: brightness(120%);
    cursor: pointer;
  }
  .download-all:hover{cursor: pointer;}
  .clear-btn-img{
    width: 32px;
    margin-left: 50px;
  }
  .download-btn-img{
    width: 32px;
    margin-left: 10px;
  }
  .loader-con{
    display: flex;
    justify-content: center;
    width: 100%;
  }
  .images{
    border-radius: 4px;
  }
  @media screen and (max-width: 1080px){
    .container{ 
      width: 100vw;
      padding: 10px;
    }

  }
</style>
