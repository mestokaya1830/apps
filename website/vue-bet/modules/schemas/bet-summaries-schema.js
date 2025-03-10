import mongoose from 'mongoose'

const betsummariesSC = new mongoose.Schema({
  sumid:{type: Number, required: true, default: 0},
  user:{type: String, required: true},
  admin:{type: String, required: true},
  superadmin:{type: String, required: true},
  date:{type: Date, required: true},
  betscount:{type: Number, required: true},
  betscountremain:{type: Number, required: true},
  amount:{type: Number, required: true},
  rate:{type: Number, required: true},
  earn:{type: Number, required: true},
  baseearn:{type: Number, required: true},
  owner:{type: String, required: true},
  state:{type: String, required: true},
  userpay:{type: String, required: true, default:'no'},
  adminpay:{type: String, required: true, default: 'no'},
  stream:{type: String, required: true},
  role:{type: String, required: true},
  woncount:{type: Number, required: true, default: 0},
  lostcount:{type: Number, required: true, default: 0},
  expireAt: {type: Date, default: Date.now, index: { expires: '40d' }}
})

betsummariesSC.index({expireAt: 1},{expires: '40d'});
export default mongoose.model('betsummaries', betsummariesSC)
