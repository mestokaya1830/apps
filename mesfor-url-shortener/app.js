  import express from 'express'
  const app = express();
  import 'dotenv/config'
  import db from './model/db.js'
  import helmet from 'helmet'
  import Shortener from './model/shortenerSC.js'
  import path from 'path'
  
  app.use(helmet())
  app.use(express.json())
  app.use(express.static('dist'));


  app.get('/api/get-urls', async (req, res) => {
      const result = await Shortener.find();
      res.status(200).json(result);
  });
  app.post('/api/addurl', async (req, res) => {
      const fullUrl = req.body.fullUrl
      const newUrl = new Shortener({
        full: fullUrl
      })
      await newUrl.save()
      res.status(200).json(newUrl);
  });

  app.get('/:shortUrl', async (req, res) => {
    const shortUrl = await Shortener.findOne({ short: req.params.shortUrl })
    console.log(req.params.shortUrl)
    console.log(shortUrl)
    if (shortUrl == null) return res.sendStatus(404)
  
    shortUrl.clicks++
    shortUrl.save()
  
    res.redirect(shortUrl.full)
  })

  if(process.env.NODE_ENV == 'production'){
    app.use(express.static('dist'))
    app.get('*', (req, res) => {
      res.sendFile(path.resolve('dist/index.html'))
    })
  }
  app.use((req, res) => {
    res.json('<h1>Page Not Found</h1>')
  })

  app.use((error, req, res, next) => {
    console.log(error)
    res.json({error: error})
    next()
  })
  app.listen(process.env.PORT, () => {
    console.log('Server is running...')
  });