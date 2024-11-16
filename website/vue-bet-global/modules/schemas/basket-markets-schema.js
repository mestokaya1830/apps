import mongoose from 'mongoose'

const basketmarketsSC = new mongoose.Schema({
  marketId:{type: String, required: true},
  marketName:{type: String, required: true}
}, {strict: false})

export default mongoose.model('basketmarkets', basketmarketsSC)