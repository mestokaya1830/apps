const mongoose = require('mongoose')
const db = mongoose.connect('mongodb://localhost:27017/blog')
.then(() => {console.log('Connected')})
.catch((err) => {console.error(err)})

module.exports = db