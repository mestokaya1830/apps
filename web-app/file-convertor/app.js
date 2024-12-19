import express from 'express'
const app = express()
import helmet from 'helmet'
import multer from 'multer'
import fs from 'fs'
import dotenv from 'dotenv'
import path from 'path'
import csvToJson from 'csvtojson'
import { json2csv } from 'csv42'

dotenv.config()
app.use(helmet())

app.use(express.json())
app.use(express.urlencoded({ extended: true, limit: '3mb' }))
app.use(express.static('dist'))

if(process.env.NODE_ENV == 'production'){
  app.use(express.static('dist'))
  app.get('*', (req, res) => res.sendFile(path.resolve('dist/index.html')))
}

const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'dist/')
  },
  filename: function (req, file, cb) {
    cb(null, file.originalname)
  },
})
const fileFilter = function (req, file, cb) {
  const types = ['text/csv','application/json']
  if(!types.includes(file.mimetype)){
    const error = new Error('Wrong file type')
    error.code = 'LIMIT_FILE_TYPES'
    return cb(error, false)
  }
  cb(null, true)
}
const target = multer({
  storage,
  fileFilter,
  limits:{
    fileSize: 1e+7 //10 mb
    // fileSize: 5e+6 //5 mb
  }
})

app.post('/api/convert/csv-json/:imagepath', target.array('files'), async (req, res, ) => {
  fs.mkdir(path.resolve('./dist/uploads/', req.params.imagepath), { recursive: true }, () => {
    return false
  })
  const targetName = req.files[0].filename.split('.')[0]
  try {
    const result = await csvToJson().fromFile(`./dist/${req.files[0].filename}`)
    fs.writeFileSync(`./dist/uploads/${req.params.imagepath}/${targetName}.json`, JSON.stringify(result), 'utf-8', (err) => {
      if(err){
        console.log(err)
        return false
      }
    })
  } catch (error) {
    console.log(error)
  }
  res.json({code: 200, filename: `${targetName}.json`})
})

app.post('/api/convert/json-csv/:imagepath', target.array('files'), async (req, res, ) => {
  fs.mkdir(path.resolve('./dist/uploads/', req.params.imagepath), { recursive: true }, () => {
    return false
  })
  try {
    const targetName = req.files[0].filename.split('.')[0]
    const data = JSON.parse(fs.readFileSync(`./dist/${req.files[0].filename}`))
    const final = json2csv(data, { flatten: true })
    fs.writeFileSync(`./dist/uploads/${req.params.imagepath}/${targetName}.csv`, final, 'utf-8', (err) => {
      if(err){
        console.log(err)
        return false
      }
    })
    res.json({code: 200, filename: `${targetName}.csv`})
  } catch (error) {
    console.log(error)
  }
})

app.post('/api/remove-images', async (req, res) => {
  const imagePath = './dist/uploads/'+req.body.imagepath
  if (fs.existsSync(imagePath)){
    fs.rmSync(imagePath, { recursive: true }, () => {
      res.json({code:200})
    })
    return false
  }
  res.json({code: 400, message:'Sorry no images to remove!'})
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
