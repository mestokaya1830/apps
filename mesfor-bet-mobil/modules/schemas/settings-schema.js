import mongoose from 'mongoose'

const settingsSC = new mongoose.Schema({
  user:{type: String, lovercase: true},
  admin:{type: String, lovercase: true},
  type:{type: String, lovercase: true},
  marketId:{type: String},
  state:{type: Boolean}
})

export default mongoose.model('settings', settingsSC)