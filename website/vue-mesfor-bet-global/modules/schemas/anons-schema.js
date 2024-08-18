import mongoose from 'mongoose'

const anonsSC = new mongoose.Schema({
  anons:{type: String, required: true}
})

export default mongoose.model('anons', anonsSC)