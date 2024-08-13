import express from "express";
import Cryptr from "cryptr";
import Wrap from '../middleware/wrap.js'
import Users from '../models/schema/usersSc.js'

const cryptr = new Cryptr('secret')
const router = express.Router()


router.post('/signup', Wrap(async(req, res) => {
  const { username, email, password } = req.body
  
  const newUser = new Users({
    username: '',
    email: email,
    password: cryptr.encrypt(password)
  })
  await newUser.save()
  res.status(200).json('Signup successfull')
}))


router.post('/signin', Wrap(async(req, res) => {
  res.status(200).json('signin')
}))

export default router