import express from 'express'
const router = express.Router()
import tryCatch from '../../middleware/try-catch-middleware.js'
import Soccermarkets from '../schemas/soccer-markets-schema.js'
import Basketmarkets from '../schemas/basket-markets-schema.js'
import Soccerlivemarkets from '../schemas/soccer-live-markets-schema.js'
import Basketlivemarkets from '../schemas/basket-live-markets-schema.js'
import Settings from '../schemas/settings-schema.js'

router.get('/markets/:id', tryCatch(async (req, res) => {
  let result = ''
  switch (req.params.id) {
    case 'soccermarkets':
      result = await Soccermarkets.find({}, `marketId marketName ${req.session.auth.user}`).sort({ marketName: 1 })
      res.json(result)
      break
    case 'basketmarkets':
      result = await Basketmarkets.find({}, `marketId marketName ${req.session.auth.user}`).sort({ marketName: 1 })
      res.json(result)
      break
    case 'soccerlivemarkets':
      result = await Soccerlivemarkets.find({}, `marketId marketName ${req.session.auth.user}`).sort({ marketName: 1 })
      res.json(result)
      break
    case 'basketlivemarkets':
      result = await Basketlivemarkets.find({}, `marketId marketName ${req.session.auth.user}`).sort({ marketName: 1 })
      res.json(result)
      break
    default:
      break
  }
}))
router.post('/markets-update', tryCatch(async (req, res) => {
    switch (req.body.table) {
      case 'soccermarkets':
      await Soccermarkets.updateOne({ marketId: req.body.marketId }, { $set: { [req.session.auth.user]: req.body.state } })
      break
    case 'basketmarkets':
      await Basketmarkets.updateOne({ marketId: req.body.marketId }, { $set: { [req.session.auth.user]: req.body.state } })
      break
    case 'soccerlivemarkets':
      await Soccerlivemarkets.updateOne({ marketId: req.body.marketId }, { $set: { [req.session.auth.user]: req.body.state } })
      break
    case 'basketlivemarkets':
      await Basketlivemarkets.updateOne({ marketId: req.body.marketId }, { $set: { [req.session.auth.user]: req.body.state } })
      break
    default:
      break
  }
  if (req.body.state == false) {
    const setting = new Settings({
      user: req.session.auth.user,
      admin: req.session.auth.admin,
      type: req.body.type,
      marketId: req.body.marketId
    })
    await setting.save()
    res.json({ message: 'done' })
  } else {
    await Settings.deleteOne({ user: req.session.auth.user, marketId: req.body.marketId, type: req.body.type })
    res.json({ message: 'done' })
  }
}))
router.get('/settings', tryCatch(async (req, res) => {
  let role = ''
  if (req.session.auth.role === 'Member') {
    role = req.session.auth.admin
  } else if (req.session.auth.role === 'Admin') {
    role = req.session.auth.user
  } else {
    return false
  }
  const result = await Settings.find({ user: role })
  res.json({ result })
}))
export default router