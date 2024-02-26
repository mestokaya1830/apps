import express from 'express'
const app = express()
import cors from 'cors'
import helmet from 'helmet'
import multer from 'multer'
import sharp from 'sharp'
import fs from 'fs'
import dotenv from 'dotenv'
import path from 'path'
import zip from 'express-zip'

dotenv.config({ debug: true })
app.use(helmet())
// app.use(cors({
//   origin: 'http://localhost:5173'
// }))
app.use(express.json())
app.use(express.urlencoded({ extended: true, limit: '3mb' }))
app.use(express.static('public'))

if(process.env.NODE_ENV == 'production'){
  app.use(express.static('public'))
  app.get('*', (req, res) => res.sendFile(path.resolve('public/index.html')))
}

const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'public/')
  },
  filename: function (req, file, cb) {
    cb(null, file.originalname)
  },
})
const fileFilter = function (req, file, cb) {
  const types = ['image/jpeg','image/jpg','image/png','image/gif', 'image/webp', 'image/avif', 'image/tiff']
  if(!types.includes(file.mimetype)){
    const error = new Error('Wrong file type')
    error.code = 'LIMIT_FILE_TYPES'
    return cb(error, false)
  }
  cb(null, true)
}

const resize = multer({
  storage,
  fileFilter,
  limits:{
    fileSize: 1e+7 //10 mb
  }
})

app.post('/api/upload/:imagepath/:pdfformat', resize.array('files', 30), async (req, res, ) => {
  try {
    let width = 794
    let height = 1122
    if(req.params.pdfformat == 'Landscape'){
      width = 1122
      height = 794
    }
    fs.mkdir(path.resolve('./public/uploads/', req.params.imagepath), { recursive: true }, () => {
      return false
    })
    const originalName = []
    for (const item of req.files) {
      await sharp(item.path)
      .resize(width, height, {fit: 'fill'})
      .toFile('./public/uploads/'+ req.params.imagepath +'/'+ item.originalname)
      fs.unlink(item.path, () => {
        originalName.push(item.originalname)
      })
    }
    const files = req.files.map(item => './public/uploads/'+ req.params.imagepath +'/'+ item.originalname)
    res.status(200).json({files})
  } catch (error) {
    console.log(error)
  }
})

app.post('/api/remove-images', async (req, res) => {
  const imagePath = './public/uploads/'+req.body.imagepath
  if (fs.existsSync(imagePath)){
    fs.rmSync(imagePath, { recursive: true }, () => {
      res.json({code:200})
    })
  } else {
    res.json({code: 400, message:'Sorry no images to remove!'})
  }
})
app.use((error, req, res, next) => {
  if(error.code == 'LIMIT_FILE_TYPES'){
    res.json({error:'Wrong file type!'})
    next()
  }
  if(error.code == 'LIMIT_FILE_SIZE'){
    res.json({error:'File to large! Each file must be less then 10 MB'})
    next()
  }
})

app.listen(3000, () => {
  console.log('Server is running...')
})
