import express from 'express'
const app = express()
import cors from 'cors'
import helmet from 'helmet'
import fs from 'fs'
import dotenv from 'dotenv'
import path from 'path'
import ytdl from 'ytdl-core'
import cookie  from 'cookie-parser'

dotenv.config({ debug: true })
app.use(helmet())
app.use(cors({credentials: true}))
app.use(express.json())
app.use(express.urlencoded({ extended: true, limit: '3mb' }))
app.use(express.static('public'))

if(process.env.NODE_ENV == 'production'){
  app.use(express.static('public'))
  app.get('*', (req, res) => res.sendFile(path.resolve('public/index.html')))
}

app.post('/api/download', async (req, res) => {
  let fileName = ''
  ytdl.getInfo(req.body.url).then((info) => {
    fileName = info.videoDetails.title
    res.header("Content-Disposition", `attachment; filename=${fileName}.${req.body.format}`)
    let range = req.headers.range
    if(!range){
      range = 'bytes=0-'
    }
    if(req.body.format == 'mp3'){
      ytdl.downloadFromInfo(info, { format: 'mp3', filter:'audioonly' }).pipe(res);
    } else {
      ytdl.downloadFromInfo(info, { format: 'mp4', quality: 18 }).pipe(res);
    }
    res.cookie('mesfor', Math.floor(Math.random() * 12345678), {
      secure: false
    })
  }).catch((error) => {
    res.json({code: 500, error:error})
  });
  
})

app.use((error, req, res, next) => {
  console.log(error)
  next()
})

app.listen(3000, () => {
  console.log('Server is running...')
})
