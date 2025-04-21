import express from 'express'
const router = express.Router()
import fs from 'fs'
import multer from 'multer'
import tryCatch from '../../middleware/try-catch-middleware.js'
import Users from '../schemas/users-schema.js'
import Messages from '../schemas/messages-schema.js'

const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'dist/uploads')
    // cb(null, 'dist/uploads')
  },
  filename: function (req, file, cb) {
    cb(null, file.originalname)
  },
});
const fileFilter = function(req, file, cb){
  const types = ['image/jpeg','image/jpg','image/png','image/gif','image/webp','image/avif']
  if(!types.includes(file.mimetype)){
    return cb(new Error('Wrong file type'), false)
  }
  cb(null, true)
}
const upload = multer({
  storage,
  fileFilter
})
const uploadAudio = multer({
  storage
})
router.get("/", tryCatch(async (req, res) => {
  const chatuser = await Users.find({ user: req.session.auth.admin }, 'user logincheck')
  const usersarray = chatuser.map(item => item.user)
  const chatcount = await Messages.aggregate([
    { $match: { sender: { $in: usersarray }, receiver: req.session.auth.user, readed: 'no' } },
    { $group: { _id: "$user", count: { $sum: 1 } } }
  ])
  if (chatcount == '') {
    res.json({ chatuser: chatuser })
  } else {
    const final = chatuser.map(item => {
      return {
        user: item.user,
        logincheck: item.logincheck,
        count: chatcount.filter(item2 => {
          if (item2._id === item.user) {
            return item2.count
          } else {
            return 0
          }
        })
      }
    })
    res.status(200).json({ chatuser: final })
  }
}))
router.get("/get-chat-msg/:receiver/:sender", tryCatch(async (req, res) => {
  const sender = req.params.sender + "-" + req.params.receiver
  const receiver = req.params.receiver + "-" + req.params.sender
  const getmsg = await Messages.find({ $or: [{ betweenmsg: sender }, { betweenmsg: receiver }] }, 'msg date sender receiver readed type')
  res.status(200).json({ getmsg: getmsg })
}))
router.post("/msg-delete-all", tryCatch(async (req, res) => {
  const sender = req.body.sender + "-" + req.body.receiver
  const receiver = req.body.receiver + "-" + req.body.sender
  const query = { $or: [{ betweenmsg: sender }, { betweenmsg: receiver }] }
  const selectFiles = await Messages.find(query)
  for (const item of selectFiles) {
    const path = 'dist/uploads/' + item.msg
    if (fs.existsSync(path)) {
      fs.unlinkSync(path)
    }
  }
  await Messages.deleteMany(query)
  res.status(200).json({ message: "Mesajlar başarıyla silindi" })
}))
router.post("/msg-delete", tryCatch(async (req, res) => {
  const result = await Messages.deleteOne({_id: req.body.data._id})
  if(result){
    const path = 'dist/uploads/' + req.body.data.msg
    if (fs.existsSync(path)) {
      fs.unlinkSync(path)
    }
    res.status(200).json('Deleted')
  }
}))
router.put("/msg-update", tryCatch(async (req, res) => {
  await Messages.updateMany({ sender: req.body.sender, receiver: req.session.auth.user}, { $set: { readed: "yes" } })
  res.status(204).send()
}))
router.get("/msg-count", tryCatch(async (req, res) => {
  const result = await Messages.aggregate([
    { $match: { receiver: req.session.auth.user, readed: 'no' } },
    { $group: { _id: null, count: { $sum: 1 } } }
  ])
  if (result.length > 0) {
    res.status(200).json({ message: result[0].count })
    return false
  }
  res.status(200).json({ message: '' })
}))
router.post("/add-chat-image", upload.single('file'), tryCatch(async(req, res) => {
  res.status(200).json({message:'success'})
}))
router.post("/add-chat-audio", uploadAudio.single('file'),tryCatch(async(req, res) => {
  res.status(200).json({message:'success'})
}))
export default router