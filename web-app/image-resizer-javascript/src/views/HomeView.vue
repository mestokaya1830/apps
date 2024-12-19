<template>
  <main>
    <div class="container">
      <img src="@/assets/logo.webp" alt="" class="logo">
      <h1 class="title">Mesfor Image Resizer</h1>
      <p class="text-format">Optimize your JPEG, PNG, Avif, WebP, Tif and Gif images without compromising on image quality.</p>
      <form @submit.prevent="sendFile()" enctype="multipart/form-data" class="form">
        <div class="dimentions">
          <input type="number" class="dimentions-input" id="imageWidth" placeholder="Width">
          <input type="number" class="dimentions-input" id="imageHeight" placeholder="Height">
        </div>
        <div class="dropzone">
           <input type="file" class="input-field" multiple accept="image/*" ref="file" id="files" @change="sendFile()">
          <!-- <input type="file" class="input-field" multiple accept="image/png, image/gif, image/jpeg" ref="file" id="files" @change="sendFile()"> -->
          <div v-if="!uploading" class="img-container">
            <img src="@/assets/upload.png" alt="" width="70px">
            <p class="drag-text">Click here to upload files...</p>
            <span class="warning-text">Supports: Jpeg, Jpg, Png, Avif, Webp, Tif, Gif</span>
            <span class="warning-text">Max File: 20 -> Max Size: Total 50 MB</span>
            <span class="warning-text">Each file size must be less then 10 MB</span>
          </div>
        </div>
        <ul class="progress-side">
          <div class="progress-center-bottom" v-if="uploading">
            <progress  class="progress is-link" :value="progress" max="100"></progress>
          </div>
          <div class="loader-con" v-if="isLoader && !uploading">
            <Loader />
          </div>
          <template v-for="file in uploadedFile[0]" :key="file.originalname">
            <li class="progress-con" ref="list">
              <div class="progress-left"><img :src="`/uploads/${this.imagePath}/${file.originalname}`" alt="" width="40px" class="images"></div>
              <div class="progress-center">
                <div class="progress-center-top">
                  <span class="file-name">{{file.originalname}}</span>
                  <span class="file-status">Progress</span>
                </div>
                <div class="progress-center-bottom">
                  <progress  class="progress is-link" :value="progress" max="100"></progress>
                </div>
              </div>
              <div class="progress-right">
                <a :href="`/uploads/${this.imagePath}/${file.originalname}`" download><img src="@/assets/download.png" alt="" class="cp" width="30px"></a>
              </div>
            </li>
          </template>
        </ul>
      </form>
      <div class="footer" v-if="uploadedFile[0]">
        <div class="download-btn-con">
          <button id="clear-all" class="clear-all" @click="clearAll()">Clear All <img src="@/assets/clear.png" alt="" class="clear-btn-img"/></button>
          <button id="download-all" class="download-all" @click="downloadAll()">Download All <img src="@/assets/download.png" alt="" class="download-btn-img"/></button>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios'
import JSZip from 'jszip';
import Loader from '@/components/loader-component.vue'
export default {
  name:'ImageCompressor',
  components:{Loader},
  data () {
    return {
      uploading: false,
      uploadedFile: [],
      progress: 0,
      imagePath: 0,
      isLoader: false
    }
  },
  methods:{
    async sendFile(){
      const formData = new FormData()
      let files = this.$refs.file.files
      const imageWidth = document.getElementById('imageWidth')
      const imageHeight = document.getElementById('imageHeight')
      if(imageWidth.value == '' || imageHeight.value == ''){
        alert('Please enter image width and heigth')
        return false
      }
      const imageSize = Array.from(files).reduce((a, b) => a + b, 0)
      try {
        if(files.length > 20){
          alert('File length must be 20')
        } else if(imageSize > 5e+7){
          alert('Toatal File size must be less 50 MB')
        } else {
          for (const item of files) {
            if (!item.name.match(/\.(jpg|jpeg|png|webp|avif|tif|gif)$/i)){
              alert('Some file is not image type!');
              return false
            } else {
              formData.append('files', item)
            }
          }
          this.uploading = true
          this.imagePath = Math.floor(Math.random() * 123456789)
          const res = await axios.post(`/api/resize/${imageWidth.value}/${imageHeight.value}/${this.imagePath}` , formData, {
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
          this.isLoader = false
          files = null
          this.$refs.file.value = null
        }
      } catch (error) {
        this.uploading = false
        files = null
        this.$refs.file.value = null
      }
    },
    async downloadAll() {
      //get all image url
      const urls = Array.from(document.querySelectorAll('.images')).map(item => item.src)

      //create blob from image urls
      const blobObject = urls.map(async (item) => {
        const result = await fetch(item)
        const final = await result.blob()
        return {
          name:item.split('/')[5],
          data: final
        }
      })

      const result = await Promise.all(blobObject)
      let zip = new JSZip()
      result.forEach(item => {
        zip.file(item.name, item.data)
      })
      const zipFile = await zip.generateAsync({type: 'blob'})
      //create download link
      const a = document.createElement('a')
      a.download = 'test.zip'
      const url = URL.createObjectURL(zipFile)
      a.href = url
      a.click()
      a.remove()
      document.body.appendChild(a)
      URL.revokeObjectURL(url)
      this.clearAll()
    },
    clearAll(){
      this.uploadedFile = []
      document.querySelectorAll('input').forEach(item => {
        item.value = ''
      })
      this.removeImages()
    },
    async removeImages(){
      await axios.post('/api/remove-images', {imagepath: this.imagePath}).then(() => {
        return false
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
  .dimentions-input{
    width: 50%;
    border-radius: 5px;
    height: 30px;
    padding-left: 10px;
    border: none;
    border: 1px solid #ddd;
    margin:  10px;
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
    min-width: 160px;
    height: 40px;
    border: none;
    width: fit-content;
    border-radius: 3px;
    font-size: 16px;
    padding: 0 10px;
    margin:  10px;
  }
  .download-all{
    color: #fff;
    background-color: rgb(58,90,64);
  }
  .clear-all{
    color: rgb(58,90,64);
    border: 1px solid rgb(58,90,64);
  }
  .download-all:hover, .clear-all:hover{
    filter: brightness(120%);
    cursor: pointer;
  }
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
