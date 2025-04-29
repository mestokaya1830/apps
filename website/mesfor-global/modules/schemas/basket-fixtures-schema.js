import mongoose from 'mongoose'

const basketfixturesSC = new mongoose.Schema({
  FixtureId:{type: Number, required: true},
  RegionId:{type: Number, required: true},
  RegionName:{type: String, required: true},
  Date:{type: Date, required: true},
  LeagueId:{type: Number, required: true},
  LeagueName:{type: String, required: true},
  HomeTeam:{type: String, required: true},
  AwayTeam:{type: String, required: true},
  MatchResult:{type:Array, required: true},
  Totals:{type: Array, required: true},
  Handicap:{type: Array}
})

export default mongoose.model('basketfixtures', basketfixturesSC)