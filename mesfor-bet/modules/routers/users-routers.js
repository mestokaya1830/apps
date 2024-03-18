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
import Settings from '../schemas/settings-schema.js'
import Basketmarkets from '../schemas/basket-markets-schema.js'
import Basketlivemarkets from '../schemas/basket-live-markets-schema.js'
import Soccermarkets from '../schemas/soccer-markets-schema.js'
import Soccerlivemarkets from '../schemas/soccer-live-markets-schema.js'

router.post('/add-user', tryCatch(async (req, res) => {
  const newUser = req.body.newUser
  let setrole = null
  if (newUser.role === 'Boss') {
    setrole = 'Superadmin'
  } else if (newUser.role === 'Superadmin') {
    setrole = 'Admin'
  } else {
    setrole = 'Member'
  }
  const result = await Users.findOne({ user: req.session.auth.user }, 'admin userlimit usedlimit creditremain')
  if (result.usedlimit >= result.userlimit) {
    res.json({ code: 400, message: 'Limitiniz dolmuştur!' })
  } else {
    const users = await Users.find({ $or: [{ user: newUser.user }, { nick: newUser.nick }] }, 'user nick')
    if (users.length > 0) {
      if (users[0].user === newUser.user) {
        res.json({ message: 'Bu Add kullanilmaktadir' })
      } else {
        res.json({ message: 'Bu Nick kullanilmaktadir' })
      }
    } else {
      const newUsers = new Users({
        user: newUser.user,
        nick: newUser.nick,
        pass: cryptr.encrypt(newUser.pass),
        admin: newUser.admin,
        superadmin: result.admin,
        credit: newUser.credit,
        creditremain: newUser.credit,
        userlimit: newUser.userlimit,
        usedlimit: 0,
        customercomission: newUser.customercomission,
        usercancelbet: newUser.usercancelbet,
        role: setrole,
        payment: new Date(),
        settings:{}
      })
      if (newUser.role === 'Superadmin') {
        await Users.updateOne({ user: newUser.admin }, { $inc: { usedlimit: + 1 } })
        await Basketmarkets.updateMany({}, { $set: { [newUser.user]: true } })
        await Basketlivemarkets.updateMany({}, { $set: { [newUser.user]: true } })
        await Soccermarkets.updateMany({}, { $set: { [newUser.user]: true } })
        await Soccerlivemarkets.updateMany({}, { $set: { [newUser.user]: true } })
        await newUsers.save()
        res.json({ code: 201, message: 'Yeni kullanıcı eklendi' })
      } else if (req.session.auth.role === 'Boss') {
        await Users.updateOne({ user: newUser.admin }, { $inc: { usedlimit: + 1 } })
        await newUsers.save()
        res.json({ code: 201, message: 'Yeni kullanıcı eklendi' })
      } else {
        newUsers.settings = {
          minms: 1,
          maxms: 15,
          minkm: 5,
          maxkm: 1000,
          maxrate: 1000,
          maxearn: 10000,
          cminms: 1,
          cmaxms: 15,
          cminkm: 5,
          cmaxkm: 1000,
          cmaxrate: 1000,
          cmaxearn: 10000
        }
        let credit = ''
        newUser.credit ? credit = newUser.credit : credit = 0
        const creditlogs = new Creditlogs({
          user: newUser.user,
          admin: newUser.admin,
          superadmin: result.admin,
          date: new Date(),
          amount: credit,
          credit: credit,
          creditremain: credit,
          ope: 'Tanımlandı',
          des: 'Yeni Kayıt'
        })
        await newUsers.save()
        await creditlogs.save()
        await Users.updateOne({ user: newUser.admin }, { $inc: { usedlimit: + 1 } })
        res.json({ code: 201, message: 'Yeni kullanici eklendi' })
      }
    }
  }
}))
router.get('/user-list', tryCatch(async (req, res) => {
  const userlist = await Users.find({ admin: req.session.auth.user }, 'user')
  res.status(200).json({ result: userlist })
}))
router.get('/user-search/:user', tryCatch(async (req, res) => {
  const users = await Users.find({ user: req.params.user })
  res.status(200).json({ result: users })
}))
router.get('/users', tryCatch(async (req, res) => {
  const users = await Users.find({ admin: req.session.auth.user })
  res.status(200).json({ result: users })
}))
router.get('/user-settings/:userbox', tryCatch(async (req, res) => {
  const users = await Users.find({ user: req.params.userbox }, 'settings')
  res.status(200).json({ result: users })
}))
router.put('/user-settings-update', tryCatch(async (req, res) => {
  if(req.body.userbox == 'Hepsi'){
    await Users.updateMany({ admin: req.session.auth.user }, { $set: { ['settings.' + req.body.column]: req.body.value } })
    res.status(204).send()
  } else {
    await Users.updateOne({ user: req.body.userbox }, { $set: { ['settings.' + req.body.column]: req.body.value } })
    res.status(204).send()
  }
}))
router.get('/single-user', tryCatch(async (req, res) => {
  const user = await Users.find({ user: req.session.auth.user })
  res.status(200).json({ result: user })
}))
router.get('/users/:id', tryCatch(async (req, res) => {
  const users = await Users.findOne({ user: req.params.id })
  res.status(200).json({ result: users })
}))
router.get("/active-users", tryCatch(async (req, res) => {
  const activeusers = await Users.aggregate([
    { $match: { admin: req.session.auth.user, logincheck: 'active' } },
    { $group: { _id: null, count: { $sum: 1 } } }])
  res.status(200).json({ result: activeusers })
}))
router.get('/profile', tryCatch(async (req, res) => {
  const profile = await Users.findOne({ user: req.session.auth.user })
  res.status(200).json({ profile })
}))
router.patch('/profile-update', tryCatch(async (req, res) => {
  const result = await Users.findOne({ nick: req.body.nick }).limit(1)
  if (result) {
    res.status(200).json({ message: 'Bu nick kullanılmaktadır' })
  } else {
    await Users.updateOne({ user: req.session.auth.user }, { $set: { nick: req.body.nick } })
    res.status(204).send()
  }
}))
router.post('/delete/:id', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Admin') {
    const activecount = await Betsummaries.findOne({ user: req.params.id, state: "Aktif" })
    if (activecount != null) {
      res.status(200).json({ message: 'Aktif kuponunuz var!' })
    } else {
      await Users.updateOne({ user: req.session.auth.user }, { $inc: { usedlimit: - 1 } })
      await Users.deleteOne({ user: req.params.id })
      await Creditlogs.deleteMany({ user: req.params.id })
      await Gamelogs.deleteMany({ user: req.params.id })
      await Loginlogs.deleteMany({ user: req.params.id })
      await Bets.deleteMany({ user: req.params.id })
      await Betsummaries.deleteMany({ user: req.params.id })
      res.status(200).json({ message: 'Kullanıcı başarıyla silindi' })
    }
  } else if (req.session.auth.role === 'Superadmin') {
    const activecount = await Betsummaries.findOne({ admin: req.params.id, state: "Aktif" })
    if (activecount != null) {
      res.status(200).json({ message: 'Aktif kuponunuz var!' })
    } else {
      await Users.updateOne({ user: req.session.auth.user }, { $inc: { usedlimit: - 1 } })
      await Users.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Creditlogs.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Gamelogs.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Loginlogs.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Bets.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Betsummaries.deleteMany({ $or: [{ admin: req.params.id }, { user: req.params.id }] })
      await Basketmarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Basketlivemarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Soccermarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Soccerlivemarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Settings.deleteMany({ user: req.params.id })
      await Basketmarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Basketlivemarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Soccermarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })
      await Soccerlivemarkets.updateMany({}, { $unset: { [req.params.id]: 1 } })

      res.status(200).json({ message: 'Kullanıcı başarıyla silindi' })
    }
  } else if (req.session.auth.role === 'Boss') {
    const subUser = await Users.find({ superadmin: req.params.id })
    const sa = subUser.map(item => item.admin)
    const activecount = await Betsummaries.findOne({ superadmin: req.params.id, state: 'Aktif' })
    if (activecount != null) {
      res.json({ message: 'Aktif kuponunuz var!' })
    } else {
      await Users.deleteMany({ superadmin: { $in: sa } })
      await Creditlogs.deleteMany({ superadmin: { $in: sa } })
      await Gamelogs.deleteMany({ superadmin: { $in: sa } })
      await Loginlogs.deleteMany({ superadmin: { $in: sa } })
      await Bets.deleteMany({ superadmin: { $in: sa } })
      await Betsummaries.deleteMany({ superadmin: { $in: sa } })

      const result = await Users.find({ admin: req.params.id })
      await Users.updateOne({ user: req.session.auth.user }, { $inc: { usedlimit: - 1 } })
      await Users.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Creditlogs.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Gamelogs.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Loginlogs.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Bets.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Betsummaries.deleteMany({ $or: [{ superadmin: req.params.id }, { admin: req.params.id }, { user: req.params.id }] })
      await Settings.deleteMany({ admin: req.params.id })

      for (let item of result) { await Basketmarkets.updateMany({}, { $unset: { [item.user]: 1 } }) }
      for (let item of result) { await Basketlivemarkets.updateMany({}, { $unset: { [item.user]: 1 } }) }
      for (let item of result) { await Soccermarkets.updateMany({}, { $unset: { [item.user]: 1 } }) }
      for (let item of result) { await Soccerlivemarkets.updateMany({}, { $unset: { [item.user]: 1 } }) }
      res.status(200).json({ message: 'Kullanıcı başarıyla silindi' })
    }
  } else {
    return false
  }
}
))
router.patch('/login-count-update', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.session.auth.user }, { $set: { logincount: req.body.logincount } })
  res.status(204).send()
}))
router.patch('/customer-comission-update', tryCatch(async (req, res) => {
  await Users.updateMany({ $or: [{admin: req.session.auth.user }, {user: req.session.auth.user }]}, { $set: { customercomission: req.body.customercomission } })
  res.status(204).send()
}))
router.patch('/user-cancel-bet-update', tryCatch(async (req, res) => {
  await Users.updateMany({$or:[{admin: req.session.auth.user},{user: req.session.auth.user}]}, { $set: { usercancelbet: req.body.usercancelbet } })
  res.status(204).send()
}))
router.patch('/credit-remain-update/:id', tryCatch(async (req, res) => {
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
    admin: req.session.auth.user,
    superadmin: req.session.auth.admin,
    date: new Date(),
    amount: req.body.updateamount,
    credit: req.body.creditremain,
    creditremain: result[0].creditremain,
    ope,
    des
  })
  await creditlogs.save()
  res.status(204).send()
}))
router.patch('/state-update/:id', tryCatch(async (req, res) => {
  await Users.updateOne({ $or: [{ user: req.params.id }, { admin: req.params.id }, { superadmin: req.params.id }] }, { $set: { state: req.body.state } })
  res.status(204).send()
}))
router.patch('/users-limit-update/:id', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.params.id }, { $set: { userlimit: req.body.newlimit } })
  res.status(204).send()
}))
router.patch('/payment-update/:id', tryCatch(async (req, res) => {
  let currentDate = new Date()
  await Users.updateOne({ user: req.params.id }, { $set: { payment: currentDate } })
  res.status(204).send()
}))
router.patch('/autopay-update', tryCatch(async (req, res) => {
  await Users.updateOne({ user: req.session.auth.user }, { $set: { autopay: req.body.autopay } })
  res.status(204).send()
}))
router.get('/credit-info/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Member') {
    const creditinfo = await Users.findOne({ user: req.session.auth.user }, 'credit creditremain')
    res.status(200).json({ creditinfo })
  } else if(req.session.auth.role === 'Admin') {
    if (req.params.userbox === 'Üyeler') {
      const creditinfo = await Users.aggregate([
        { $match: { admin: req.session.auth.user } },
        { $group: { _id: null, credit: { $sum: '$credit' }, creditremain: { $sum: '$creditremain' } } }])
      res.status(200).json({ creditinfo: creditinfo[0] })
    } else {
      const creditinfo = await Users.find({ user: req.params.userbox }, 'credit creditremain')
      res.status(200).json({ creditinfo: creditinfo[0] })
    }
  } else {
    return false
  }
}))
router.get('/credit-logs/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Member') {
    const creditlog = await Creditlogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
    res.status(200).json({ creditlog })
  } else if(req.session.auth.role === 'Admin') {
    const creditlog = await Creditlogs.find({ user: req.params.userbox }).sort({ _id: -1 })
    res.status(200).json({ creditlog })
  } else {
    return false
  }
}))
router.get('/credit-logs/date-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Member') {
    const datefilter = await Creditlogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
    res.status(200).json({ datefilter })
  } else if(req.session.auth.role === 'Admin') {
    const datefilter = await Creditlogs.find({ user: req.params.userbox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
    res.status(200).json({ datefilter })
  } else {
    return false
  }
}))
router.get('/login-logs/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Member') {
    const loginlog = await Loginlogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
    res.status(200).json({ loginlog })
  } else {
    if(req.params.userbox == 'Sahip'){
      const loginlog = await Loginlogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
      res.status(200).json({ loginlog })
    } else {
      const loginlog = await Loginlogs.find({ user: req.params.userbox }).sort({ _id: -1 })
      res.status(200).json({ loginlog })
    }
  }
}))
router.get('/login-logs/date-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role === 'Member') {
    const datefilter = await Loginlogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
    res.status(200).json({ datefilter })
  } else {
    if(req.params.userbox == 'Sahip'){
      const datefilter = await Loginlogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
      res.status(200).json({ datefilter })
    } else {
      const datefilter = await Loginlogs.find({ user: req.params.userbox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
      res.status(200).json({ datefilter })
    }
  }
}))

export default router