import mongoose from 'mongoose'

const basketlivemarketsSC = new mongoose.Schema({
  marketId:{type: String, required: true},
  marketName:{type: String, required: true}
}, {strict: false})

export default mongoose.model('basketlivemarkets', basketlivemarketsSC)