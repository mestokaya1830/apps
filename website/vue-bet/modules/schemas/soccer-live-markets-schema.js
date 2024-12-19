import mongoose from 'mongoose'

const soccerlivemarketsSC = new mongoose.Schema({
  marketId:{type: String, required: true},
  marketName:{type: String, required: true}
}, {strict: false})

export default mongoose.model('soccerlivemarkets', soccerlivemarketsSC)