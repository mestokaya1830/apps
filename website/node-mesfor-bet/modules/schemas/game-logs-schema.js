import mongoose from 'mongoose'

const gamelogsSC = new mongoose.Schema({
  gameid:{type: Number, required: true},
  user:{type: String, required: true},
  admin:{type: String, required: true},
  superadmin:{type: String, required: true},
  date:{type: Date, required: true, default: Date.now()},
  amount:{type: Number, required: true},
  creditremain:{type: Number, required: true},
  ope:{type: String, required: true},
  des:{type: String, required: true},
  expireAt: {type: Date, default: Date.now, index: { expires: '40d' }}
})

gamelogsSC.index({expireAt: 1},{expires: '40d'});
export default mongoose.model('gamelogs', gamelogsSC)