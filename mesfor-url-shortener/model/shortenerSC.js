import mongoose from "mongoose";

const shortenerSC = new mongoose.Schema({
  full: {type: String, required: true},
  short: {type: String, required: true},
  created_at: {type: Date, default: Date.now()}
})

export default mongoose.model('shortener', shortenerSC)