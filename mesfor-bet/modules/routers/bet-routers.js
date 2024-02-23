import express from 'express'
const router = express.Router()
import moment from 'moment-timezone'
import tryCatch from '../../middleware/try-catch-middleware.js'
import Users from '../schemas/users-schema.js'
import Bets from '../schemas/bets-schema.js'
import Betsummaries from '../schemas/bet-summaries-schema.js'
import Gamelogs from '../schemas/game-logs-schema.js'
import Ides from '../schemas/ides-schema.js'

router.get('/ides', tryCatch(async(req, res) => {
  const ides = await Ides.findOne({})
  res.json({ides: ides})
}))
router.post('/add-bet', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const newSummary = req.body.slipSummary
    let totalRate = 1
    let newBets = []
    new Bets(req.body.slips.map(item => {
      newBets.push({
        sumid: newSummary.sumid,
        ...item
      })
    }))
    for (const key in newBets) {
      totalRate *= newBets[key].rate
    }
    if (totalRate && totalRate > req.body.maxrate) {
      totalRate = req.body.maxrate
    }
    let earn = newSummary.amount * totalRate
    if (earn && earn > req.body.maxearn) {
      earn = req.body.maxearn
    }
    const betSummary = new Betsummaries({
      sumid: newSummary.sumid,
      user: newSummary.user,
      admin: newSummary.admin,
      superadmin: newSummary.superadmin,
      date: Date.now(),
      betscount: req.body.sliplength,
      betscountremain: 0,
      amount: newSummary.amount,
      rate: totalRate,
      earn,
      baseearn: earn,
      owner: newSummary.owner,
      state: 'Aktif',
      stream: newSummary.stream,
      role: req.session.auth.role
    })
    const checkcredit = await Users.findOne({ user: req.session.auth.user }, 'credit creditremain')
    if (newSummary.amount > checkcredit.creditremain) {
      return res.json({ error: 'Yetersiz Bakiye' })
    } else {
      await Bets.insertMany(newBets)
      await betSummary.save()
      await Users.updateOne({ user: req.session.auth.user }, { $inc: { creditremain: - newSummary.amount } })
      await Ides.updateOne({}, { $inc: { sumid: + 1 }})

      const result = await Users.findOne({ user: req.session.auth.user }, 'user admin superadmin creditremain')
      const gamelog = new Gamelogs({
        gameid: newSummary.sumid,
        user: result.user,
        admin: result.admin,
        superadmin: result.superadmin,
        date: new Date(),
        amount: newSummary.amount,
        creditremain: result.creditremain,
        ope: 'Eksilen',
        des: 'Kupon'
      })
      await gamelog.save()
      res.json({ message: 'Kupon basarıyla eklendi', credit: result.credit, creditremain: result.creditremain })
    }
  }
}))
router.post('/cancel-bet', tryCatch(async (req, res) => {
  await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $set: { state: 'iptal' } })
  await Bets.updateMany({ sumid: req.body.betsum.sumid }, { $set: { state: 'iptal' } })
  await Users.updateOne({ user: req.body.betsum.user }, { $inc: { creditremain: + req.body.betsum.amount } })
  const getusers = await Users.findOne({ user: req.body.betsum.user }, 'creditremain')
  const gamelog = new Gamelogs({
    gameid: req.body.betsum.sumid,
    user: req.body.betsum.user,
    admin: req.body.betsum.admin,
    superadmin: req.body.betsum.superadmin,
    date: new Date(),
    amount: req.body.betsum.amount,
    creditremain: getusers.creditremain,
    ope: 'Eklendi',
    des: 'iptal'
  })
  await gamelog.save()
  res.json({ code: 200, message: 'Kupon iptal edildi' })
}))
router.put('/return-bet', tryCatch(async (req, res) => {
  const ccr = await Users.findOne({ user: req.body.betsum.user }, 'creditremain')
  if (req.body.betsum.amount > ccr.creditremain) {
    res.json({ code: 401 })
  } else {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $set: { state: 'Aktif' } })
    await Bets.updateMany({ _id: req.body.betsum.betid }, { $set: { state: 'Aktif' } })
    await Users.updateOne({ user: req.body.betsum.user }, { $inc: { creditremain: - req.body.betsum.amount } })
    const lcr = await Users.findOne({ user: req.body.betsum.user }, 'creditremain')
    const gamelog = new Gamelogs({
      gameid: req.body.betsum.sumid,
      user: req.body.betsum.user,
      admin: req.body.betsum.admin,
      superadmin: req.body.betsum.superadmin,
      date: new Date(),
      amount: req.body.betsum.amount,
      creditremain: lcr.creditremain,
      ope: 'Eksilen',
      des: 'iptal-Aktif'
    })
    await gamelog.save()
    res.json({ code: 200 })
  }
}))
router.get('/last-coupon/', tryCatch(async (req, res) => {
  const lastSumId = await Betsummaries.findOne({ $and: [{ user: req.session.auth.user }, { stream: 'Bülten' }, { state: 'Aktif' }] }).sort({ _id: -1 }).limit(1)
  if (lastSumId) {
    const result = await Bets.find({ sumid: lastSumId.sumid }, 'code matches games options rate betid eventtime branch')
    res.json(result)
  } else {
    res.json({ status: 401 })
  }
}))
router.get('/bet-summary/:userbox/:statebox', tryCatch(async (req, res) => {
  const start = moment().format('YYYY-MM-DD 00:00:00')
  const end = moment().format('YYYY-MM-DD 24:00:00')
  if (req.session.auth.role == 'Member') {
    if (req.params.statebox == 'Aktif') {
      const betsummary = await Betsummaries.find({ user: req.session.auth.user, state: 'Aktif' }).sort({ _id: -1 })
      res.json({ betsummary })
    } else {
      if (req.params.statebox == 'Hepsi') {
        const betsummary = await Betsummaries.find({ user: req.session.auth.user, date: { $gte: start, $lt: end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
        res.json({ betsummary })
      } else {
        const betsummary = await Betsummaries.find({ user: req.session.auth.user, date: { $gte: start, $lt: end }, state: req.params.statebox }).sort({ _id: -1 })
        res.json({ betsummary })
      }
    }
  } else if (req.session.auth.role == 'Admin') {
    if (req.params.userbox == 'Hepsi') {
      if (req.params.statebox == 'Aktif') {
        const betsummary = await Betsummaries.find({ admin: req.session.auth.user, state: 'Aktif'}).sort({ _id: -1 })
        res.json({ betsummary })
      } else {
        if (req.params.statebox == 'Hepsi') {
          const betsummary = await Betsummaries.find({ admin: req.session.auth.user, date: { $gte: start, $lt: end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
          res.json({ betsummary })
        } else {
          const betsummary = await Betsummaries.find({ admin: req.session.auth.user, date: { $gte: start, $lt: end }, state: req.params.statebox }).sort({ _id: -1 })
          res.json({ betsummary })
        }
      }
    } else {
      if (req.params.statebox == 'Aktif') {
        const betsummary = await Betsummaries.find({ user: req.params.userbox, state: 'Aktif' }).sort({ _id: -1 })
        res.json({ betsummary })
      } else {
        if (req.params.statebox == 'Hepsi') {
          const betsummary = await Betsummaries.find({ user: req.params.userbox, date: { $gte: start, $lt: end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
          res.json({ betsummary })
        } else {
          const betsummary = await Betsummaries.find({ user: req.params.userbox, state: req.params.statebox }).sort({ _id: -1 })
          res.json({ betsummary })
        }
      }
    }
  } else if(req.session.auth.role == 'Boss') {
    if (req.params.userbox == 'Hepsi') {
      const betsummary = await Betsummaries.find({ state: 'Aktif' }).sort({ _id: -1 })
      res.json({ betsummary })
    } else {
      const betsummary = await Betsummaries.find({ superadmin: req.params.userbox, state: 'Aktif' }).sort({ _id: -1 })
      res.json({ betsummary })
    }
  } else {
    return false
  }
}))
router.get('/bet-summary/:id', tryCatch(async (req, res) => {
  const bets = await Bets.find({ sumid: req.params.id })
  res.json({ bets: bets })
}))
router.get('/bet-summary/date-filter/:userbox/:statebox/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    if (req.params.statebox == 'Hepsi') {
      const datefilter = await Betsummaries.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
      res.json({ code: 200, datefilter: datefilter })
    } else {
      const datefilter = await Betsummaries.find({ user: req.session.auth.user, state: req.params.statebox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
      res.json({ code: 200, datefilter: datefilter })
    }
  } else if(req.session.auth.role == 'Admin') {
    if (req.params.userbox == 'Hepsi') {
      if (req.params.statebox == 'Hepsi') {
        const datefilter = await Betsummaries.find({ admin: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
        res.json({ code: 200, datefilter: datefilter })
      } else {
        const datefilter = await Betsummaries.find({ admin: req.session.auth.user, state: req.params.statebox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, datefilter: datefilter })
      }
    } else {
      if (req.params.statebox == 'Hepsi') {
        const datefilter = await Betsummaries.find({ user: req.params.userbox, state: { $ne: 'iptal' }, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, datefilter: datefilter })
      } else {
        const datefilter = await Betsummaries.find({ user: req.params.userbox, state: req.params.statebox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, datefilter: datefilter })
      }
    }
  } else {
    return false
  }
}))
router.get('/bet-summary/day-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const dayfilter = await Betsummaries.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
    res.json({ code: 200, dayfilter: dayfilter })
  } else if(req.session.auth.role == 'Admin') {
    if (req.params.userbox == 'Hepsi') {
      const dayfilter = await Betsummaries.find({ admin: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
      res.json({ code: 200, dayfilter: dayfilter })
    } else {
      const dayfilter = await Betsummaries.find({ user: req.params.userbox, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
      res.json({ code: 200, dayfilter: dayfilter })
    }
  } else {
    return false
  }
}))
router.get('/bet-summary/week-filter/:userbox/:weekdate/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    if (req.params.weekdate == 'Hepsi') {
      const weekfilter = await Betsummaries.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
      res.json({ code: 200, weekfilter: weekfilter })
    } else {
      const weekfilter = await Betsummaries.find({ user: req.session.auth.user, state: req.params.weekdate, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
      res.json({ code: 200, weekfilter: weekfilter })
    }
  } else if(req.session.auth.role == 'Admin') {
    if (req.params.userbox == 'Hepsi') {
      if (req.params.weekdate == 'Hepsi') {
        const weekfilter = await Betsummaries.find({ admin: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end }, state: { $ne: 'iptal' } }).sort({ _id: -1 })
        res.json({ code: 200, weekfilter: weekfilter })
      } else {
        const weekfilter = await Betsummaries.find({ admin: req.session.auth.user, state: req.params.weekdate, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, weekfilter: weekfilter })
      }
    } else {
      if (req.params.weekdate == 'Hepsi') {
        const weekfilter = await Betsummaries.find({ user: req.params.userbox, state: { $ne: 'iptal' }, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, weekfilter: weekfilter })
      } else {
        const weekfilter = await Betsummaries.find({ user: req.params.userbox, state: req.params.weekdate, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
        res.json({ code: 200, weekfilter: weekfilter })
      }
    }
  } else {
    return false
  }
}))
router.get('/bet-summary-single/:userbox/:statebox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    let betsummary = await Betsummaries.find({ user: req.session.auth.user, state: 'Aktif' }).sort({ _id: -1 })
    if (betsummary) {
      betsummary = betsummary.filter((item) => {
        if ((item.betscount - item.betscountremain) == 1) {
          return true
        }
      })
    }
    res.json({ betsummary })
  } else if (req.session.auth.role == 'Admin') {
    if (req.params.userbox == 'Hepsi') {
      let betsummary = await Betsummaries.find({ admin: req.session.auth.user, state: 'Aktif' }).sort({ _id: -1 })
      if (betsummary) {
        betsummary = betsummary.filter((item) => {
          if ((item.betscount - item.betscountremain) == 1) {
            return true
          }
        })
      }
      res.json({ betsummary })
    } else {
      let betsummary = await Betsummaries.find({ user: req.params.userbox, state: 'Aktif' }).sort({ _id: -1 })
      if (betsummary) {
        betsummary = betsummary.filter((item) => {
          if ((item.betscount - item.betscountremain) == 1) {
            return true
          }
        })
      }
      res.json({ betsummary })
    }
  } else if(req.session.auth.role == 'Boss') {
    let betsummary = await Betsummaries.find({ state: 'Aktif' }).sort({ _id: -1 })
    if (betsummary) {
      betsummary = betsummary.filter((item) => {
        if ((item.betscount - item.betscountremain) == 1) {
          return true
        }
      })
    }
    res.json({ betsummary })
  } else {
    return false
  }
}))
router.get('/bet-summary-search/:sumid', tryCatch(async (req, res) => {
  if(req.session.auth.role == 'Member'){
    const betsummary = await Betsummaries.find({ user: req.session.auth.user, sumid: req.params.sumid })
    res.json({ betsummary })
  } else if(req.session.auth.role == 'Admin'){
    const betsummary = await Betsummaries.find({admin: req.session.auth.user, sumid: req.params.sumid })
    res.json({ betsummary })
  } else {
    return false
  }
}))
router.put('/bet-state-update', tryCatch(async (req, res) => {
  let rbb = req.body.betdetail
  const result = await Bets.findOne({ _id: rbb._id })
  await Bets.updateOne({ _id: rbb._id }, { $set: { state: rbb.state } })
  if (result.state == 'Aktif' && rbb.state == 'Kaybetti') {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { betscountremain: + 1, lostcount: + 1 } })
    res.json({ code: 200 })
  } else if ((result.state == 'Aktif' && rbb.state == 'Kazandi') || (result.state == 'Aktif' && rbb.state == 'iade')) {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { betscountremain: + 1, woncount: + 1 } })
    res.json({ code: 200 })
  } else if (result.state == 'Kaybetti' && rbb.state == 'Aktif') {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { betscountremain: - 1, lostcount: - 1 } })
    res.json({ code: 200 })
  } else if ((result.state == 'Kazandi' && rbb.state == 'Aktif') || (result.state == 'iade' && rbb.state == 'Aktif')) {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { betscountremain: - 1, woncount: - 1 } })
    res.json({ code: 200 })
  } else if (result.state == 'Kaybetti' && rbb.state == 'Kazandi') {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { lostcount: - 1, woncount: + 1 } })
    res.json({ code: 200 })
  } else if ((result.state == 'Kazandi' && rbb.state == 'Kaybetti') || (result.state == 'iade' && rbb.state == 'Kaybetti')) {
    await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $inc: { lostcount: + 1, woncount: - 1 } })
    res.json({ code: 200 })
  } else if (result.state == 'iade' && rbb.state == 'Kazandi') {
    await Betsummaries.updateOne({ sumid: rbb._id, state: 'iade' })
    res.json({ code: 200 })
  } else {
    res.json({ code: 200 })
  }
}))
router.put('/bet-summary-state-update', tryCatch(async (req, res) => {
  const betsum = req.body.betsum
  const betstate = req.body.betstate
  let ope = ''
  let des = ''
  const cbss = await Betsummaries.findOne({ sumid: betsum.sumid }, 'sumid user admin state role adminpay')
  const finduser = await Users.findOne({ $or: [{ user: betsum.admin }, { user: betsum.superadmin }] }, 'user admin autopay')
  await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { state: betstate } })

  if (cbss.state == 'Aktif' && betstate == 'Kaybetti') {
    res.json({ message: 'Kaybetti' })
  } else if (cbss.state == 'Aktif' && betstate == 'iade') {
    await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: + betsum.amount } })
    await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { rate: 1, earn: betsum.amount } })
    ope = 'Eklendi'
    des = 'iade'
    insertGameLog(betsum.user, finduser.user, finduser.admin, betsum.amount, ope, des)
  } else if (cbss.state == 'Kaybetti' && betstate == 'Aktif') {
    res.json({ code: 200 })
  } else if ((cbss.state == 'iade' && betstate == 'Aktif') || (cbss.state == 'iade' && betstate == 'Kaybetti')) {
    await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: - betsum.amount } })
    ope = 'Eksilen'
    des = 'Düzeltme'
    insertGameLog(betsum.user, finduser.user, finduser.admin, betsum.amount, ope, des)
  } else if (betstate == 'Kazandi') {
    const drawBet = await Bets.find({ sumid: betsum.sumid, state: 'iade' })
    if (drawBet) {
      let newRate = 0
      let newEarn = 0
      await Bets.updateMany({sumid: betsum.sumid, state: 'iade' }, {$set:{rate: 1}})
      const allRate = await Bets.find({sumid: betsum.sumid }, 'rate')
      newRate = allRate.reduce((acc, item) => {
        return acc * item.rate
      }, 1)
      newEarn = (newRate * betsum.amount).toFixed(2)
      await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { rate: newRate, earn: newEarn } })
      
      if(finduser.autopay == 1){
        await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { adminpay: 'yes' } })
        await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: + newEarn } })
        ope = 'Eklendi'
        des = 'Kazandi'
        insertGameLog(betsum.user, finduser.user, finduser.admin, newEarn, ope, des)
        return false
      }
      res.json({code: 200})
    } else {
        if(finduser.autopay == 1){
          await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { adminpay: 'yes' } })
          await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: + betsum.earn } })
          ope = 'Eklendi'
          des = 'Kazandi'
          insertGameLog(betsum.user, finduser.user, finduser.admin, betsum.earn, ope, des)
        }
      }
  } else if ((cbss.state == 'Kazandi' && betstate == 'Aktif') || (cbss.state == 'Kazandi' && betstate == 'Kaybetti')) {
    await Betsummaries.updateOne({ sumid: betsum.sumid }, { $set: { adminpay: 'no', userpay: 'no' } })
    const oldearn = await Betsummaries.findOne({ sumid: betsum.sumid }, 'earn')
    if (req.session.auth.autopay == 1) {
      await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: - oldearn.earn } })
      ope = 'Eksilen'
      des = 'Düzeltme'
      insertGameLog(betsum.user, cbss.admin, finduser.admin, oldearn.earn, ope, des)
    } else {
      if (cbss.adminpay == 'yes') {
        await Users.updateOne({ user: betsum.user }, { $inc: { creditremain: - oldearn.earn } })
        ope = 'Eksilen'
        des = 'Düzeltme'
        insertGameLog(betsum.user, finduser.user, finduser.admin, oldearn.earn, ope, des)
      } else {
        res.json({ code: 200 })
      }
    }
  } else {
    res.json({ message: 'active' })
  }
  async function insertGameLog(user, admin, superadmin, earn, ope, des) {
    const users = await Users.findOne({ user: betsum.user }, 'creditremain')
    const gamelog = new Gamelogs({
      gameid: betsum.sumid,
      user,
      admin,
      superadmin,
      date: new Date(),
      amount: earn,
      creditremain: users.creditremain,
      ope,
      des
    })
    await gamelog.save()
    res.json({ code: 200 })
  }
}))
router.put('/bet-payment', tryCatch(async (req, res) => {
  await Betsummaries.updateOne({ sumid: req.body.betsum.sumid }, { $set: { adminpay: 'yes' } })
  await Users.updateOne({ user: req.body.betsum.user }, { $inc: { creditremain: + req.body.betsum.earn } })
  const users = await Users.findOne({ user: req.body.betsum.user }, 'creditremain')
  const gamelog = new Gamelogs({
    gameid: req.body.betsum.sumid,
    user: req.body.betsum.user,
    admin:req.session.auth.user,
    superadmin:req.session.auth.admin,
    date: new Date(),
    amount: req.body.betsum.earn,
    creditremain: users.creditremain,
    ope: 'Eklendi',
    des: 'Kazandi'
  })
  await gamelog.save()
  res.json({code: 200})
}))
router.get('/active-info/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const activeinfo = await Betsummaries.aggregate([
      { $match: { user: req.session.auth.user, state: 'Aktif' } },
      { $group: { _id: null, activeamount: { $sum: '$amount' }, activeearn: { $sum: '$earn' }, activecount: { $sum: 1 } } }])
    res.json({ activeinfo: activeinfo[0] })
  } else {
    if (req.params.userbox == 'Hepsi') {
      const activeinfo = await Betsummaries.aggregate([
        { $match: { admin: req.session.auth.user, state: 'Aktif'} },
        { $group: { _id: null, activeamount: { $sum: '$amount' }, activeearn: { $sum: '$earn' }, activecount: { $sum: 1 } } }])
      res.json({ activeinfo: activeinfo[0] })
    } else {
      const activeinfo = await Betsummaries.aggregate([
        { $match: { user: req.params.userbox, state: 'Aktif' } },
        { $group: { _id: null, activeamount: { $sum: '$amount' }, activeearn: { $sum: '$earn' }, activecount: { $sum: 1 } } }])
      res.json({ activeinfo: activeinfo[0] })
    }
  }
}))
router.get('/won-info/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const woninfo = await Betsummaries.aggregate([
      { $match: { user: req.session.auth.user, state: 'Kazandi' } },
      { $group: { _id: null, wonamount: { $sum: '$amount' }, wonearn: { $sum: '$earn' }, woncount: { $sum: 1 } } }])
    res.json({ woninfo: woninfo[0] })
  } else {
    if (req.params.userbox == 'Hepsi') {
      const woninfo = await Betsummaries.aggregate([
        { $match: { admin: req.session.auth.user, state: 'Kazandi'} },
        { $group: { _id: null, wonamount: { $sum: '$amount' }, wonearn: { $sum: '$earn' }, woncount: { $sum: 1 } } }])
      res.json({ woninfo: woninfo[0] })
    } else {
      const woninfo = await Betsummaries.aggregate([
        { $match: { user: req.params.userbox, state: 'Kazandi' } },
        { $group: { _id: null, wonamount: { $sum: '$amount' }, wonearn: { $sum: '$earn' }, woncount: { $sum: 1 } } }])
      res.json({ woninfo: woninfo[0] })
    }
  }
}))
router.get('/lost-info/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const lostinfo = await Betsummaries.aggregate([
      { $match: { user: req.session.auth.user, state: 'Kaybetti' } },
      { $group: { _id: null, lostamount: { $sum: '$amount' }, lostearn: { $sum: '$earn' }, lostcount: { $sum: 1 } } }])
    res.json({ lostinfo: lostinfo[0] })
  } else {
    if (req.params.userbox == 'Hepsi') {
      const lostinfo = await Betsummaries.aggregate([
        { $match: { admin: req.session.auth.user, state: 'Kaybetti' } },
        { $group: { _id: null, lostamount: { $sum: '$amount' }, lostearn: { $sum: '$earn' }, lostcount: { $sum: 1 } } }])
      res.json({ lostinfo: lostinfo[0] })
    } else {
      const lostinfo = await Betsummaries.aggregate([
        { $match: { user: req.params.userbox, state: 'Kaybetti' } },
        { $group: { _id: null, lostamount: { $sum: '$amount' }, lostearn: { $sum: '$earn' }, lostcount: { $sum: 1 } } }])
      res.json({ lostinfo: lostinfo[0] })
    }
  }
}))
router.get('/total-info/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const totalinfo = await Betsummaries.aggregate([
      { $match: { user: req.session.auth.user, $or:[{state: 'Aktif'}, {state:'Kazandi'}, {state:'Kaybetti'}] }},
      { $group: { _id: null, totalamount: { $sum: '$amount' }, totalearn: { $sum: '$earn' }, totalcount: { $sum: 1 } } }])
    res.json({ totalinfo: totalinfo[0] })
  } else {
    if (req.params.userbox == 'Hepsi') {
      const totalinfo = await Betsummaries.aggregate([
        { $match: { admin: req.session.auth.user, $or:[{state: 'Aktif'}, {state:'Kazandi'}, {state:'Kaybetti'}] }},
        { $group: { _id: null, totalamount: { $sum: '$amount' }, totalearn: { $sum: '$earn' }, totalcount: { $sum: 1 } } }])
      res.json({ totalinfo: totalinfo[0] })
    } else {
      const totalinfo = await Betsummaries.aggregate([
        { $match: { user: req.params.userbox, $or:[{state: 'Aktif'}, {state:'Kazandi'}, {state:'Kaybetti'}] }},
        { $group: { _id: null, totalamount: { $sum: '$amount' }, totalearn: { $sum: '$earn' }, totalcount: { $sum: 1 } } }])
      res.json({ totalinfo: totalinfo[0] })
    }
  }
}))
router.get('/game-logs/:userbox', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const gamelog = await Gamelogs.find({ user: req.session.auth.user }).sort({ _id: -1 })
    res.json({ gamelog: gamelog })
  } else if(req.session.auth.role == 'Admin') {
    const gamelog = await Gamelogs.find({ user: req.params.userbox }).sort({ _id: -1 })
    res.json({ gamelog: gamelog })
  } else {
    return false
  }
}))
router.get('/game-logs-search/:gameid', tryCatch(async (req, res) => {
  if(req.session.auth.role == 'Admin' || req.session.auth.role == 'Member'){
    const gamelog = await Gamelogs.find({ gameid: req.params.gameid })
    res.json({ gamelog: gamelog })
  }
}))
router.get('/game-logs-date-filter/:userbox/:start/:end', tryCatch(async (req, res) => {
  if (req.session.auth.role == 'Member') {
    const datefilter = await Gamelogs.find({ user: req.session.auth.user, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
    res.json({ datefilter: datefilter })
  } else if(req.session.auth.role == 'Admin') {
    const datefilter = await Gamelogs.find({ user: req.params.userbox, date: { $gte: req.params.start, $lte: req.params.end } }).sort({ _id: -1 })
    res.json({ datefilter: datefilter })
  } else {
    return false
  }
}))

export default router