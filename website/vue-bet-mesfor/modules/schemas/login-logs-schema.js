import mongoose from 'mongoose'

const loginlogSC = new mongoose.Schema({
  user:{type: String, required: true},
  admin:{type: String, required: true},
  superadmin:{type: String, required: true},
  date:{type: Date, required: true, default: Date.now()},
  proccess:{type: String, required: true},
  ip:{type: String, required: true},
  expireAt: {type: Date, default: Date.now, index: { expires: '40d' }}
})

loginlogSC.index({expireAt: 1},{expires: '40d'});
export default mongoose.model('loginlogs', loginlogSC)