import mongoose from 'mongoose'

const idesSC = new mongoose.Schema({
  sumid:{type: Number, required: true, default: 0}
},{timestamps: true})

export default mongoose.model('ides', idesSC)
