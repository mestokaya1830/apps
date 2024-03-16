import mongoose from 'mongoose'

const db = mongoose.connect(process.env.MONGO_URL)
.then(() => {
  console.log('Connected')
}).catch(() => {
  console.log("error")
})

export default db
