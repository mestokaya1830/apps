import express from 'express'
const app = express()
import cors from 'cors'
import helmet from 'helmet'
import Db from './modules/db.js'
import Messages from './modules/schemas/messages-schema.js'
import authRouters from './modules/routers/auth-routers.js'
import userRouters from './modules/routers/users-routers.js'
import apiRouters from './modules/routers/api-routers.js'
import betRouters from './modules/routers/bet-routers.js'
import marketsRouters from './modules/routers/markets-routers.js'
import chatRouters from './modules/routers/chat-routers.js'
import bossRouters from './modules/routers/boss-routers.js'
import dotenv from 'dotenv'
import path from 'path'
import auth from './middleware/auth.js'
import session from 'express-session'
import MongoStore from 'connect-mongo'
import http from 'http'
import { Server } from "socket.io"
import Bets from './modules/schemas/bets-schema.js'
import Betsummaries from './modules/schemas/bet-summaries-schema.js'

const server = http.createServer(app)
const io = new Server(server)

dotenv.config({ debug: true })
app.use(helmet())
app.use(cors({credentials: true}))
app.use(express.json())
app.use(express.urlencoded({ extended: true, limit: '3mb' }))
app.use(express.static('public'))

app.use(session({
  name:'secret_name',
  secret: 'secret_key',
  resave: false,
  saveUninitialized: false,
  // cookie: { maxAge: 6 * 3600000},//6 hour
  httpOnly: true,
  secure: true,
  rolling: true,
  store: MongoStore.create({
    mongoUrl: 'mongodb://mesto:MK1972mk11130113@localhost:27017/bet?authSource=bet',
    autoRemove: 'native'
  })
}))

app.use('/api', authRouters)
app.use('/api/chat', auth, chatRouters)
app.use('/api/games', auth, apiRouters)
app.use('/api/admin', auth, userRouters)
app.use('/api/admin', auth, betRouters)
app.use('/api/admin', auth, marketsRouters)
app.use('/api/admin', auth, bossRouters)

let readState = ''
let activeusers = {}
let openedusers = []

io.on('connection', (socket) => {
  socket.on('activeusers', (data) => {
    socket.user = data
    activeusers[socket.user] = socket
    if(openedusers.indexOf(data) === -1) {
      openedusers.push(data)
    }
  })
  socket.on('selectedusers', (data) => {
    selectedusers = data
  })
  let selectedusers = ''
  socket.on('send message', async(data) => {
    if (selectedusers in activeusers) {
      if (openedusers.includes(selectedusers)) {
        activeusers[socket.user].emit('new message', {data: data, onlinestate: true})
        activeusers[selectedusers].emit('new message', {data: data})
        readState = 'yes'
      }else{
        if(selectedusers.length > 0){
          activeusers[socket.user].emit('new message', {data: data, onlinestate: false})
          activeusers[selectedusers].emit('msgcount')
          readState = 'no'
        }
      }
    } else {
      activeusers[socket.user].emit('new message', {data: data, onlinestate: false})
      readState = 'no'
    }
    const newMessage = new Messages({
      user: data.user,
      betweenmsg: data.sender +'-'+ data.receiver,
      sender: data.sender,
      receiver: data.receiver,
      msg: data.message,
      type: data.type,
      readed: readState,
    })

    await newMessage.save()
  })
  socket.on('settyping', (data) => {
    if (selectedusers in activeusers) {
      if (openedusers.includes(selectedusers)) {
        activeusers[selectedusers].emit('gettyping', {data:data})
      }
    }
  })
  socket.on('closedusers', (data) => {
    let index = openedusers.indexOf(data)
    openedusers.splice(index, 1)
  })
  socket.on('disconnect', () => {
    if(!socket.user) return
    delete activeusers[socket.user]
  })

  socket.on('Finished', (data) => {
    const runQuery = async (id, sumid, state) => {
      await Bets.updateOne({ _id: id, state:'Aktif' }, { $set: { state: state } })
      if(state == 'Kaybetti'){
        await Betsummaries.updateOne({ sumid: sumid }, { $inc: { betscountremain: + 1, lostcount: + 1 }, state:'Kaybetti' })
        return false
      }
    }
    const setBetResult = async () => {
      try {
        let fullTimeBets = await Bets.find({state: 'Aktif', games: 'Maç Sonucu'})
        if(fullTimeBets.length > 0){
          fullTimeBets.forEach(item1 => {
            if (data.Id == item1.betid && data.HomeTeam == item1.options) {
              if (Number(data.Scoreboard.score.charAt(0)) <= Number(data.Scoreboard.score.charAt(2))) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'X') {
              if (data.Scoreboard.score.charAt(0) != data.Scoreboard.score.charAt(2)) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && data.AwayTeam == item1.options) {
              if (Number(data.Scoreboard.score.charAt(0)) >= Number(data.Scoreboard.score.charAt(2))) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          })
        }
        let fullTimeBothTeamToScore = await Bets.find({state: 'Aktif', games: 'Her İki Takım Gol Atarmı'})
        if(fullTimeBothTeamToScore.length > 0){
          fullTimeBothTeamToScore.forEach(item1 => {
            if (data.Id == item1.betid && item1.options.trim() == 'Evet') {
              if (Number(item1.Scoreboard.score.charAt(0)) < 1 || Number(item1.Scoreboard.score.charAt(2)) < 1){
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Hayır') {
              if (Number(item1.Scoreboard.score.charAt(0)) > 0 && Number(item1.Scoreboard.score.charAt(2)) > 0) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          })
        }
      //totoalGoal over-under
        let totoalGoal = await Bets.find({state: 'Aktif', games: 'Toplam Gol'})
        if (totoalGoal.length > 0) {
          totoalGoal.forEach(item1 => {
          //over-under 0.5
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 0,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 0) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 0,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 1) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          //over-under 1.5
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 1,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 1) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 1,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 2) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          //over-under 2.5
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 2,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 2) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 2,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 3) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          //over-under 3.5
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 3,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 3) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 3,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 4) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 4,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 4) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 4,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 5) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 5,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 5) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 5,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 6) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Alt 6,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) > 6) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
            if (data.Id == item1.betid && item1.options.trim() == 'Üst 6,5') {
              if ((Number(data.Scoreboard.score.charAt(0)) + Number(data.Scoreboard.score.charAt(2))) < 7) {
                runQuery(item1._id, item1.sumid, 'Kaybetti')
              }
            }
          })
        }
      } catch (error) {console.log(error)}
    }
    setBetResult()
  })
})

if(process.env.NODE_ENV == 'production'){
  app.use(express.static('dist'))
  app.get('*', (req, res) => res.sendFile(path.resolve('dist/index.html')))
}

app.use((error, req, res, next) => {
  console.log(error)
})

app.use((req, res)=>{
  res.status(404).send('page not found')
})

server.listen(3000, () => {
  console.log(`Server is running... ${3000}`)
})
