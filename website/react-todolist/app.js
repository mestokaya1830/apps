import express from 'express'
import cors from 'cors'
import session from 'express-session'
import path from 'path'
import 'dotenv/config'
import MongoStore from 'connect-mongo'
const app = express()

app.use(cors())
app.use(express.json())
app.use(express.static('public'))

app.use(session({
  secret:'secret',
  saveUninitialized:true,
  rolling: true,
  resave: true,
  cookie:{
    maxAge: 3600000,
    httpOnly: true,
    secure: false
  },
  store: MongoStore.create({
    mongoUrl: process.env.MONGO,
    autoRemove: 'native'
  })
}))

app.get('/', (req, res) => {
  req.session.auth = 'Mustafa'
  res.status(200).json({auth: req.session.auth})
})

app.get('/about', (req, res) => {
  res.status(200).json({auth: req.session.auth})
})

if(process.env.NODE_ENV === 'production'){
  app.use(express.static('dist'))
  app.get('*', (req, res) => {
    res.sendFile(path.resolve('dist/index.html'))
  })
}

app.use((req, res) => {
  res.status(201).send('Page Not Found!')
})

app.use((err, req, res, next) => {
  console.log(err)
  res.status(201).json(err)
  next()
})

app.listen(process.env.PORT, () => console.log('Server is running...'))