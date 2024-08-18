import express from "express";
import helmet from "helmet";
import mongoSanitize from 'express-mongo-sanitize'
import path from 'path'
import 'dotenv/config'
import './models/db.js'
import usersRouter from './routers/usersRouter.js'
import cartsRouter from './routers/cartsRouter.js'
import ordersRouter from './routers/ordersRouter.js'
import productsRouter from './routers/productsRouter.js'
const app = express()

app.use(helmet())
app.use(mongoSanitize())
app.use(express.json())
app.use(express.static('public'))


app.use('/api/auth', usersRouter)
app.use('/api/carts', cartsRouter)
app.use('/api/orders', ordersRouter)
app.use('/api/products', productsRouter)

if(process.env.NODE_ENV == 'production'){
  app.use(express.static('dist'))
  app.get('*', (req, res) => {
    res.sendFile(path.resolve('disr/index.html'))
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

app.listen(process.env.PORT || 4000, () => console.log('Server is running on port' +' '+ process.env.PORT))
