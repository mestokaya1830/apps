@extends('backend.master')
@section('content')
<div class="admin-container">
  <div class="upload-image-container">
    <div class="wrapper upload-wrapper">
      <form id="form" action='' method="post", enctype='multipart/form-data'>
          @csrf
          <select style="margin-bottom:50px;" name="maincategory" id="main-category" onchange="getSubCategory()" class="upload-image1">
              <option value="projects" selected="projects">Projeler</option>
              <option value="activities">Etkinlikler</option>
          </select>

          <select name="subcategory" onchange="getImages(this)" id="sub-category" class="upload-image2">

          </select>

          <input id="file" type='file', name='file'/>
          <i class="fa fa-cloud-upload"></i>
          <h3>Dosya Seçiniz</h3>
          <h5>Yada Sürükleyip Bırakınız</h5>
        </form>
        <ul id="area"></ul>
        <ul class="uploaded-area"></ul>
    </div>
  </div>
  <div id="imageContainer"></div>
</div>

<script>
  
  const getSubCategory = async () => {
    const result = await fetch('/admin/getsubcategory', {
        method:'POST',
        credentials: 'include',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':'{{csrf_token()}}',
        },
        body:JSON.stringify({
          type:document.getElementById('main-category').value
        })
    })

    const final = await result.json()
    document.getElementById('sub-category').innerHTML = ''
    for(const item of final.result){
      document.getElementById('sub-category').innerHTML += `
      <option value="${item.title}">${item.title}</option>
      `
    }
    await getImages()
  }
  getSubCategory()


  const fileIcons = (param) => {
    if(param.match(/\.jp?g|png|gif|webp/)){
      return 'png'
    } else if(param.match(/\.zip|rar/)){
      return 'zip'
    } else if(param.match(/\.mp4/)){
      return 'mp4'
    } else {
      return 'doc'
    }
  }

  const form = document.getElementById('form')
  const file = document.getElementById('file')
  let uploadedArea = document.querySelector('.uploaded-area')

  file.addEventListener('change', (e) => {
    if(e.target.files[0]){
      let fileName = e.target.files[0].name
      if(fileName.length >= 12){
        let splitName = fileName.split('.')
        fileName = splitName[0].substring(0, 12) +'... .'+ splitName[1]
      }
      uploadFile(fileName)
      e.target.value = null
    }
  })

  const uploadFile = (param) => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/uploadimage');
    xhr.onload =  function(){
      if(this.status === 200 && this.responseText == '401'){
        alert('Bu resim sistemde kayıtlıdır')
      }
      xhr.upload.addEventListener('progress', function({loaded, total}){
        let fileLoaded = Math.floor((loaded / total) * 100)
        let fileTotal = Math.floor(total / 1000)
        let fileSize
        (fileTotal < 1024) ? fileSize = fileTotal + 'KB' : fileSize = (loaded / (1024 * 1024)).toFixed(2) + "MB"
        document.getElementById('area').innerHTML = `
          <li class="row">
            <div class="details">
              <i class="fa fa-file-alt"></i>
              <div>${param}</div>
              <div>${fileLoaded} %</div>
            </div>
            <div class="bar">
              <div class="prog" style="width:${fileLoaded}%"></div>
            </div>
          </li>
        `
        if(loaded == total){
            document.getElementById('area').innerHTML = ''
            let uploadedHTML = `
              <li class="upload-end">
                <span class="name">
                  <img src="{{asset('/images/icons/${fileIcons(param)}.png')}}" style="margin-right:10px;"/>
                  ${param}
                </span>
                <span class="size">${fileSize}</span>
                <i class="fa fa-check" style="color:#6990f2"></i>
              </li>
            `
            uploadedArea.insertAdjacentHTML('afterbegin', uploadedHTML)
            document.getElementById('sub-category')
          }
        })
        getImages()
    }
    xhr.send(new FormData(form))
  }

  async function getImages(){
    const result = await fetch('/admin/getimages', {
        method:'Post',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':'{{csrf_token()}}',
        },
        body:JSON.stringify({
          maincategory:document.getElementById('main-category').value,
          subcategory:document.getElementById('sub-category').value
        })
    })
    const final = await result.json()
    document.getElementById('imageContainer').innerHTML = ''
    final.forEach(item => {
      document.getElementById('imageContainer').innerHTML += `
      <div class="upload-img">
        <i class="fa fa-trash fa-2x img-trash" onclick="deleteImages(this)"></i>
        <i class="fa fa-picture-o img-bgi" onclick="changeCover(this)"></i>
        <img src="{{asset('${item.imgname}')}}" id="${item.imgname}" style="height:100%;">
      </div>
        `
    })
  }

  const deleteImages  = async(param) => {
    const check = confirm('Bu resim silinsinmi?')
    if(check){
      const result = await fetch('/admin/deleteimage', {
          method:'Post',
          headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN':'{{csrf_token()}}',
          },
          body:JSON.stringify({
            imgname:param.nextElementSibling.nextSibling.nextSibling.getAttribute('id')
          })
      })
      const final = await result.json()
      if(final.msg = '200'){
        getImages()
      }
    }
  }

  const changeCover  = async(param) => {
    let img = param.nextElementSibling.getAttribute('id').split('/')
    const result = await fetch('/admin/changecover', {
        method:'Post',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':'{{csrf_token()}}',
        },
        body:JSON.stringify({
          table:img[1],
          title:img[2],
          img:img[3]
        })
    })
    if(result){
      alert('Bu resim kapak resmi olarak atandı')
    }
  }

</script>
@stop