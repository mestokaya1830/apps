import mongoose from 'mongoose'

const soccermarketsSC = new mongoose.Schema({
  marketId:{type: String, required: true},
  marketName:{type: String, required: true}
}, {strict: false})

export default mongoose.model('soccermarkets', soccermarketsSC)