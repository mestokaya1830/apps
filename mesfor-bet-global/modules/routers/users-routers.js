import express from 'express'
const router = express.Router()
import Cryptr from 'cryptr'
const cryptr = new Cryptr('myTotalySecretKey')
import tryCatch from '../../middleware/try-catch-middleware.js'
import Users from '../schemas/users-schema.js'
import Bets from '../schemas/bets-schema.js'
import Betsummaries from '../schemas/bet-summaries-schema.js'
import Loginlogs from '../schemas/login-logs-schema.js'
import Creditlogs from '../schemas/credit-logs-schema.js'
import Gamelogs from '../schemas/game-logs-schema.js'


router.get('/user-list', tryCatch(async (req, res) => {
  const userlist = await Users.find({}, 'user')
  res.json({ result: userlist })
}))
router.get('/user-search/:user', tryCatch(async (req, res) => {
  const users = await Users.find({ user: req.params.user })
  res.json({ result: users })
}))
router.get('/users', tryCatch(async (req, res) => {
  const users = await Users.find({})
  res.json({ result: users })
}))
router.get('/user-settings/:userbox', tryCatch(async (req, res) => {
  const users = await Users.find({ user: req.params.userbox }, 'settings')
  res.json({ result: users })
}))
router.put('/user-settings-update', tryCatch(async (req, res) => {
  if(req.body.userbox == 'Hepsi'){
    await Users.updateMany({ admin: req.session.auth.user }, { $set: { ['settings.' + req.body.column]: req.body.value } })
    res.json({ code: 200 })
  } else {
    await Users.updateOne({ user: req.body.userbox }, { $set: { ['settings.' + req.body.column]: req.body.value } })
    res.json({ code: 200 })
  }
}))
router.get('/single-user', tryCatch(async (req, res) => {
  const user = await Users.find({ user: req.session.auth.user })
  res.json({ result: user })
}))
router.get('/users/:id', tryCatch(async (req, res) => {
  const users = await Users.findOne({ user: req.params.id })
  res.json({ result: users })
}))
router.get("/active-users", tryCatch(async (req, res) => {
  const activeusers = await Users.aggregate([
    { $match: { logincheck: 'active' } },
    { $group: { _id: null, count: { $sum: 1 } } }])
  res.json({ code: 200, result: activeusers })
}))
router.get('/profile', tryCatch(async (req, res) => {
  const profile = await Users.findOne({ user: req.session.auth.user })
  res.json({ profile })
}))
router.put('/profile-update', tryCatch(async (req, res) => {
  const result = await Users.findOne({ email: req.body.email }).limit(1)
  if (result) {
    res.json({ message: 'Bu email kullanılmaktadır' })
  } else {
    await Users.updateOne({ user: req.session.auth.user }, { $set: { email: req.body.email } })
    res.json({ code: 200 })
  }
}))
router.post('/delete/:id', tryCatch(async (req, res) => {
  const activecount = await Betsummaries.findOne({ user: req.params.id, state: "Aktif" })
    if (activecount != null) {
      res.json({ message: 'Aktif kuponunuz var!' })
    } else {
      await Users.deleteOne({ user: req.params.id })
      await Creditlogs.deleteMany({ user: req.params.id })
      await Gamelogs.deleteMany({ user: req.params.id })
      await Loginlogs.deleteMany({ user: req.params.id })
      await Bets.deleteMany({ user: req.params.id })
      await Betsummaries.deleteMany({ user: req.params.id })
      res.json({ code: 200, message: 'Kullanıcı başarıyla silindi' })
    }
}
))
router.put('/login-count-update', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.session.auth.user }, { $set: { logincount: req.body.logincount } })
  res.json({ code: 200 })
}))
router.put('/customer-comission-update', tryCatch(async (req, res) => {
  await Users.updateMany({}, { $set: { customercomission: req.body.customercomission } })
  res.json({ code: 200 })
}))
router.put('/user-cancel-bet-update', tryCatch(async (req, res) => {
  await Users.updateMany({user: req.session.auth.user}, { $set: { usercancelbet: req.body.usercancelbet } })
  res.json({ code: 200 })
}))
router.put('/credit-remain-update/:id', tryCatch(async (req, res) => {
  let ope = ''
  let des = ''
  if (req.body.operate === 'plus') {
    await Users.updateOne({ user: req.params.id }, { $inc: { creditremain: + req.body.updateamount } })
    ope = 'Eklendi'
    des = 'Bakiye Ekleme'
  } else {
    await Users.updateOne({ user: req.params.id }, { $inc: { creditremain: - req.body.updateamount } })
    ope = 'Eksildi'
    des = 'Ödeme'
  }
  const result = await Users.find({ user: req.params.id }, 'creditremain').limit(1)
  const creditlogs = new Creditlogs({
    user: req.params.id,
    date: new Date(),
    amount: req.body.updateamount,
    credit: req.body.creditremain,
    creditremain: result[0].creditremain,
    ope,
    des
  })
  await creditlogs.save()
  res.json({ code: 200 })
}))
router.put('/state-update/:id', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.params.id}, { $set: { state: req.body.state } })
  res.json({ code: 200 })
}))

router.put('/payment-update/:id', tryCatch(async (req, res) => {
  let currentDate = new Date()
  await Users.updateOne({ user: req.params.id }, { $set: { payment: currentDate } })
  res.json({ code: 200 })
}))
router.put('/autopay-update', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.session.auth.user }, { $set: { autopay: req.body.autopay } })
  res.json({ code: 200 })
}))
router.get('/credit-info/:userbox', tryCatch(async (req, res) => {
  const creditinfo = await Users.findOne({ user: req.session.auth.user }, 'credit creditremain')
  res.json({ creditinfo })
}))
router.get('/credit-logs/:userbox', tryCatch(async (req, res) => {
  const creditlog = await Creditlogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
  res.json({ creditlog })
}))
router.get('/credit-logs/date-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  const datefilter = await Creditlogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
  res.json({ datefilter })
}))
router.get('/login-logs/:userbox', tryCatch(async (req, res) => {
  const loginlog = await Loginlogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
  res.json({ loginlog })
}))
router.get('/login-logs/date-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  const datefilter = await Loginlogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
  res.json({ datefilter })
}))

export default router