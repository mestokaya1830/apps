import mongoose from 'mongoose'

const soccerfixturesSC = new mongoose.Schema({
  FixtureId:{type: Number, required: true},
  RegionId:{type: Number, required: true},
  RegionName:{type: String, required: true},
  Date:{type: Date, required: true},
  LeagueId:{type: Number, required: true},
  LeagueName:{type: String, required: true},
  HomeTeam: {type: String, required: true},
  AwayTeam: {type: String, required: true},
  MatchResult:{type: Array},
  TotalGoals:{type: Array},
  BothTeamsToScore:{type: Array},
  ShortId:{type: Number},
})

export default mongoose.model('soccerfixtures', soccerfixturesSC)