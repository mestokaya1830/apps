<template>
  <main>
    <div class="container">
      <img src="@/assets/logo.webp" alt="" class="logo">
      <h1 class="title">Mesfor Image Convertor</h1>
      <p class="text-format">Convert your JPEG, PNG, AVIF, WEBP and GIF images without compromising on image quality.</p>
      <form @submit.prevent="sendFile()" enctype="multipart/form-data" class="form">
        <div class="dimentions">
         TO: 
          <select v-model="format">
            <option value="png" selected>Png</option>
            <option value="jpeg">Jpeg</option>
            <option value="jpg">Jpg</option>
            <option value="avif">Avif</option>
            <option value="webp">Webp</option>
            <option value="gif">Gif</option>
          </select>
        </div>
        <div class="dropzone">
           <input type="file" class="input-field" multiple accept="image/*" ref="file" id="files" @change="sendFile()">
          <!-- <input type="file" class="input-field" multiple accept="image/png, image/gif, image/jpeg" ref="file" id="files" @change="sendFile()"> -->
          <div v-if="!uploading" class="img-container">
            <img src="@/assets/upload.png" alt="" width="70px">
            <p class="drag-text">Click here to upload files...</p>
            <span class="warning-text">Supports: Jpeg, Jpg, Png, Avif, Webp, Gif</span>
            <span class="warning-text">Max File: 20 -> Max Size: Total 50 MB</span>
            <span class="warning-text">Each file must be less then 10 MB</span>
          </div>
        </div>
        <ul class="progress-side">
          <div class="progress-center-bottom" v-if="uploading">
            <progress  class="progress is-link" :value="progress" max="100"></progress>
          </div>
          <div v-if="isLoader && !uploading" class="loader-con">
            <Loader />
          </div>
          <template v-for="file in uploadedFile[0]" :key="file.filename">
            <li class="progress-con" ref="list">
              <div class="progress-left"><img :src="`/uploads/${this.imagePath}/${file.filename}`" alt="" width="40px" class="images"></div>
              <div class="progress-center">
                <div class="progress-center-top">
                  <span class="file-name">{{file.filename}}</span>
                  <span class="file-status">Progress</span>
                </div>
                <div class="progress-center-bottom">
                  <progress  class="progress is-link" :value="progress" max="100"></progress>
                </div>
              </div>
              <div class="progress-right">
                <a :href="`/uploads/${this.imagePath}/${file.filename}`" download><img src="@/assets/download.png" alt="" class="cp" width="30px"></a>
              </div>
            </li>
          </template>
        </ul>
      </form>
      <div class="footer" v-if="uploadedFile[0]">
        <button id="clear-all" class="clear-all" @click="clearForm()">Clear All <img src="@/assets/clear.png" alt="" class="clear-btn-img"/></button>
        <form :action="`/api/download/${imagePath}`" method="post" class="download-btn-con ">
          <input type="submit" id="download-all" value="Download All" class="download-all">
          <img src="@/assets/download.png" alt="" class="download-btn-img"/>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios'
import Loader from '@/components/loader-component.vue'
export default {
  name:'ImageCompressor',
  components:{Loader},
  data () {
    return {
      uploading: false,
      uploadedFile: [],
      progress: 0,
      isLoader: false,
      imagePath: 0,
      format: 'png'
    }
  },
  methods:{
    async sendFile(){
      const formData = new FormData()
      let files = this.$refs.file.files
      const imageSize = Array.from(files).reduce((a, b) => a + b.size, 0)
      try {
        if(files.length > 20){
          alert('File length must be 20')
        } else if(imageSize > 5e+7){
          alert('Toatal File size must be less 50 MB')
        } else {
          for (const item of files) {
            if (!item.name.match(/\.(jpg|jpeg|png|webp|avif|gif)$/i)){
              alert('Some file is not image type!');
              return false
            } else {
              formData.append('files', item)
            }
          }
          this.uploading = true
          this.imagePath = Math.floor(Math.random() * 123456789)
          const res = await axios.post(`/api/convert/${this.format}/${this.imagePath}` , formData, {
            onUploadProgress: e => {
              this.progress = Math.round(e.loaded * 100 / e.total)
              if(this.progress == 100){
                this.uploading = false
                this.isLoader = true
              }
            }
          })
          if(res.data.files){
            this.uploadedFile.push(res.data.files)
          } else {
            alert(res.data.error)
          }
          files = null
          this.$refs.file.value = null
          this.isLoader = false
        }
      } catch (error) {
        console.error(error)
        this.uploading = false
      }
    },
    clearForm(){
      this.uploadedFile = []
      document.querySelectorAll('.dimentions-input').forEach(item => {
        item.value = ''
      })
      this.removeImages()
    },
    async removeImages(){
      await axios.post('/api/remove-images', {imagepath: this.imagePath}).then((result) => {
        console.log(result.data)
      })
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
  .dropzone {
    display: flex;
    justify-content: center;
    align-items: center;
    min-width: 100%;
    min-height: 240px;
    padding: 10px;
    position: relative;
    cursor: pointer;
    border: 2px dashed rgb(194, 184, 224);
    border-radius: 20px;
  }
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

  .dropzone .drag-text{
    color: #545454;
    font-size: 17px;
    font-weight: 700;
    margin-top: 20px;
  }
  .progress-side{
    width: 100%;
    margin-top: 30px;
  }
  .progress-con{
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 60px;
    width:100%;
    border-radius: 10px;
    border: 1px solid rgb(58,90,64);
    margin: 7px 0;
  }
  .dimentions{
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 46px;
    width:100%;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin: 40px auto;
  }
  select{
    appearance: none;
    outline: 0;
    width: 85%;
    padding: 0 10px;
    background: url('@/assets/select-arrow.webp') no-repeat right 10px center / 16px,
    linear-gradient(to left, #ddd 36px, #f1f1f1 36px);
    color: black;
    height: 30px;
    border: 1px solid #ccc;
    border-radius: 3px;
    cursor: pointer;
    font-size: calc(16px + 0.1vw);
  }
  .progress-right, .progress-left{
    padding: 10px;
  }
  .progress-left{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
  }
  .progress-center{
    width: 100%;
  }
  .progress-center-top{
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
  }
  .file-name, .file-status{
    font-size: 12px;
    color: rgb(58,90,64);
  }
  .file-status{margin-right: 10px;}
  .progress{
    width: 100%;
  }
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
    padding: 20px 0;
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
    align-items: center;
    width: 100%;
  }
  @media screen and (max-width: 1080px){
    .container{ 
      width: 100vw;
      padding: 10px;
    }

  }
</style>
