import mongoose from 'mongoose'

const anonsSC = new mongoose.Schema({
  anons:{type: String, required: true}
},{timestamps: true})

export default mongoose.model('anons', anonsSC)
