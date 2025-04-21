import mongoose from 'mongoose'

const betsSC = new mongoose.Schema([{
    sumid:{type: Number, required: true, default: 0},
    betid:{type: String, required: true},
    user:{type: String, required: true},
    admin:{type: String, required: true},
    superadmin:{type: String, required: true},
    matches:{type: String, required: true},
    games:{type: String, required: true},
    options:{type: String, required: true},
    rate:{type: Number, required: true},
    state:{type: String, required: true},
    stream:{type: String, required: true},
    date:{type: Date, required: true, default: Date.now()},
    eventtime:{type: String, required: true},
    score:{type: String, default:'-:-'},
    branch:{type: String},
    expireAt: {type: Date, default: Date.now, index: { expires: '40d' }}
  }]
)
betsSC.index({expireAt: 1},{expires: '40d'});
export default mongoose.model('bets', betsSC)