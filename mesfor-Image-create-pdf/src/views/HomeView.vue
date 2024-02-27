<template>
  <main>
    <div class="container">
      <img src="@/assets/logo.webp" alt="" class="logo">
      <h1 class="title">Mesfor Generate Pdf</h1>
      <p class="text-format">Generate Pdf with your JPEG, PNG, Avif, WebP, Tif and Gif images without compromising on image quality.</p>
      <form @submit.prevent="sendFile()" enctype="multipart/form-data" class="form">
        <div class="dimentions">
         Format: 
          <select v-model="pdfFormat">
            <option value="Portrait">Portrait</option>
            <option value="Landscape">Landscape</option>
          </select>
        </div>
        <div class="dropzone">
           <input type="file" class="input-field" multiple accept="image/*" ref="file" id="files" @change="sendFile()">
          <!-- <input type="file" class="input-field" multiple accept="image/png, image/gif, image/jpeg" ref="file" id="files" @change="sendFile()"> -->
          <div v-if="!uploading" class="img-container">
            <img src="@/assets/upload.png" alt="" width="70px">
            <p class="drag-text">Click here to upload files...</p>
            <span class="warning-text">Supports: Jpeg, Jpg, Png, Avif, Webp, Tif, Gif</span>
            <span class="warning-text">Max File: 50 -> Max Size: Total 100 MB</span>
            <span class="warning-text">Each file size must be less then 10 MB</span>
          </div>
        </div>
        <ul class="progress-side">
          <div class="progress-center-bottom" v-if="uploading">
            <progress  class="progress is-link" :value="progress" max="100"></progress>
          </div>
          <div v-if="isLoader && !uploading" class="loader-con">
            <Loader />
          </div>
        </ul>
      </form>
    </div>
  </main>
</template>

<script>
import axios from 'axios'
import Loader from '@/components/loader-component.vue'
import jsPDF from "jspdf";

export default {
  name:'ImageCompressor',
  components:{Loader},
  data () {
    return {
      uploading: false,
      progress: 0,
      isLoader: false,
      imagePath: 0,
      pdfFormat: 'Portrait'
    }
  },
  methods:{
    async sendFile(){
      const formData = new FormData()
      let files = this.$refs.file.files
      const imageSize = Array.from(files).reduce((a, b) => a + b.size, 0)
      try {
        if(files.length > 50){
          alert('File length must be 50')
        } else if(imageSize > 1e+8){
          alert('Toatal file size must be less 100 MB')
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
          const res = await axios.post(`/api/upload/${this.imagePath}/${this.pdfFormat}` , formData, {
            onUploadProgress: e => {
              this.progress = Math.round(e.loaded * 100 / e.total)
              if(this.progress == 100){
                this.uploading = false
                this.isLoader = true
              }
            }
          })
          if(res.data.files){
            this.savePdf(res.data.files)
            this.removeImages()
          } else {
            alert(res.data.error)
          }
          this.isLoader = false
          files = null
          this.$refs.file.value = null
        }
      } catch (error) {
        console.error(error)
        this.uploading = false
      }
    },
    async removeImages(){
      await axios.post('/api/remove-images', {imagepath: this.imagePath}).then(() => {
        return false
      })
    },
    async generatePdf(imageUrls) {
      const doc = new jsPDF(this.pdfFormat);
      for (const [i, url] of imageUrls.entries()) {
        doc.addImage(url, "png", 0, 0, 0, 0);
        if (i !== imageUrls.length - 1) {
          doc.addPage();
        }
      }
      return doc;
    },
    async savePdf(imageUrls) {
      const multiPng = await this.generatePdf(imageUrls);
      multiPng.output("save", "mesfor.pdf");
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
  .dimentions{
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 46px;
    width:100%;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin: 40px auto;
    padding-left: 10px;
  }
  select{
    appearance: none;
    outline: 0;
    width: 80%;
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

  .dropzone .drag-text{
    color: #545454;
    font-size: 17px;
    font-weight: 700;
    margin-top: 20px;
  }
  .input-field{
    width: 100%;
    height: 200px;
    padding: 10px;
    position: absolute;
    opacity: 0;
    cursor: pointer;
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

  .file-name, .file-status{
    font-size: 12px;
    color: rgb(58,90,64);
  }
  .file-status{margin-right: 10px;}
  .progress{
    width: 100%;
  }
  .download-btn-con{
    display: flex;
    justify-content: space-between;
    width: fit-content;
    background-color: rgb(58,90,64);
    padding: 5px 10px;
    border-radius: 4px;
  }
  .loader-con{
    display: flex;
    justify-content: center;
    width: 100%;
  }
  @media screen and (max-width: 1080px){
    .container{ 
      width: 100vw;
      padding: 10px;
    }

  }
</style>
