import mongoose from 'mongoose'

const messagesSC = new mongoose.Schema({
  user:{type: String, required: true},
  betweenmsg:{type: String, required: true},
  sender:{type: String, required: true},
  receiver:{type: String, required: true},
  msg:{type: String, required: true},
  type:{type: String, required: true},
  date:{type: Date, required: true, default: Date.now()},
  readed:{type: String, required: true},
  expireAt: {type: Date, default: Date.now, index: { expires: '7d' }}
})

messagesSC.index({expireAt: 1},{expires: '7d'});
export default mongoose.model('messages', messagesSC)