import mongoose from 'mongoose'

const adviseSC = new mongoose.Schema({
  user:{type: String, required: true},
  admin:{type: String, required: true},
  superadmin:{type: String, required: true},
  subject:{type: String, required: true},
  text:{type: String, required: true},
  date:{type: Date, required: true, default: Date.now()},
  expireAt: {type: Date, default: Date.now, index: { expires: '40d' }}
})
adviseSC.index({expireAt: 1},{expires: '40d'});
export default mongoose.model('advise', adviseSC)