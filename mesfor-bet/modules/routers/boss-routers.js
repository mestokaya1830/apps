import express from "express"
const router = express.Router()
import tryCatch from "../../middleware/try-catch-middleware.js"
import Users from "../schemas/users-schema.js"
import Bets from "../schemas/bets-schema.js"
import Betsummaries from "../schemas/bet-summaries-schema.js"
import Loginlogs from "../schemas/login-logs-schema.js"
import Creditlogs from "../schemas/credit-logs-schema.js"
import Gamelogs from "../schemas/game-logs-schema.js"
import Messages from "../schemas/messages-schema.js"
import Anons from "../schemas/anons-schema.js"
import Advise from "../schemas/advise-schema.js"
import moment from "moment"
import fs from "fs"
import cp from "child_process"

router.post("/boss-backup-database",tryCatch(async (req, res) => {
  const d = new Date()
  const path = `~/dump/${d.getMonth() + 1}-${d.getDate()}`
  const setBackup = () => {
    cp.exec(`mongodump --db=bet --out ${path}  --authenticationDatabase admin --username 'Boss' --password 'MK1972mk11130113'`,function(error, stdout, stderr) {
      if (!error) {
        res.json("Backedup")
        return false
      }
      console.log(error)
    })
  }
  if (fs.existsSync('~/dump')) {
    fs.rmSync('~/dump/', { recursive: true })
    setBackup()
    return false
  }
  setBackup()
}))
router.post("/boss-restore-database",tryCatch(async (req, res) => {
  cp.exec('ls ~/dump/',function(error, stdout, stderr) {
    if (!error) {
      let path = stdout.substring(0, stdout.length-1)
      cp.exec(`mongorestore -d bet ~/dump/${path}/bet --drop --authenticationDatabase admin --username 'Boss' --password 'MK1972mk11130113'`,function(error) {
        if (!error) {
          res.json("Restored")
          return false
        }
        console.log(error)
      })
    }
  })
}))
router.post("/boss-set-anons",tryCatch(async (req, res) => {
  const newAnons = new Anons({ anons: req.body.anons })
  await newAnons.save()
  res.send('Published')
}))
router.get("/boss-get-anons",tryCatch(async (req, res) => {
  const result = await Anons.findOne()
  res.json({ result })
}))
router.post("/boss-delete-anons",tryCatch(async (req, res) => {
  await Anons.deleteOne()
  res.send('Deleted')
}))
router.get("/boss-active-users",tryCatch(async (req, res) => {
  if (req.session.auth.role === "Boss") {
    const users = await Users.find({ logincheck: "active" }, "user admin")
    res.json({ result: users })
  }
}))
router.get("/boss-get-old-data",tryCatch(async (req, res) => {
  const start = moment().add(-1, "days").format("YYYY-MM-DD")
  if (req.session.auth.role === "Boss") {
    const result = await Betsummaries.find({ date: { $lte: start } })
    if(result.length > 0){
      const betSummaries = await Betsummaries.countDocuments({ date: { $lte: start } })
      const bets = await Bets.countDocuments({ date: { $lte: start } })
      const gameLogs = await Gamelogs.countDocuments({ date: { $lte: start } })
      const creditLogs = await Creditlogs.countDocuments({ date: { $lte: start } })
      const loginLogs = await Loginlogs.countDocuments({ date: { $lte: start } })
      Promise.all([betSummaries, bets, gameLogs, creditLogs, loginLogs]).then((result) => {
        res.json(result)
      })
    }
  }
}))
router.post("/boss-delete-old-data",tryCatch(async (req, res) => {
  const start = moment().add(-1, "days").format("YYYY-MM-DD")
  if (req.session.auth.role === "Boss") {
    const result = await Betsummaries.find({ date: { $lte: start } })
    if(result.length > 0){
      const betSummaries = await Betsummaries.deleteMany({ date: { $lte: start } })
      const bets = await Bets.deleteMany({ date: { $lte: start } })
      const loginLogs = await Loginlogs.deleteMany({ date: { $lte: start } })
      const creditLogs = await Creditlogs.deleteMany({ date: { $lte: start } })
      const gameLogs = await Gamelogs.deleteMany({ date: { $lte: start } })
      Promise.all([betSummaries, bets, loginLogs, creditLogs, gameLogs]).then((result) => {
        res.json('Deleted')
      })
    } else {
      res.json('No Data')
    }
  }
}))
router.post("/boss-delete-old-messages",tryCatch(async (req, res) => {
  const start = moment().add(-1, "days").format("YYYY-MM-DD")
  if (req.session.auth.role === 'Boss') {
    const result = await Messages.find({ date: { $lte: start } })
    if(result.length > 0){
      await Messages.deleteMany({ date: { $lte: start } }).then(() => {
        for (const item of result) {
          const path = 'dist/uploads/' + item.msg
          if (fs.existsSync(path)) {
            fs.unlinkSync(path)
          }
        }
        res.json('Deleted')
      })
    } else {
      res.json('No Data')
    }
  }
}))
router.post("/boss/advise", tryCatch(async (req, res) => {
  const newAdvise = new Advise({ 
    user:req.session.auth.user,
    admin:req.session.auth.admin,
    superadmin:req.session.auth.superadmin,
    subject:req.body.advise.subject,
    text:req.body.advise.text
   })
  await newAdvise.save()
  res.json({code: 200})
}))
router.get("/boss/advise-list", tryCatch(async (req, res) => {
  const result = await Advise.find()
  if(result.length > 0) res.json(result)
  
}))
export default router
