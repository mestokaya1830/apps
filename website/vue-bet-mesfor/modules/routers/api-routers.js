import express from 'express'
const router = express.Router()
import cron from "node-cron"
import cacheMiddleware from '../../middleware/cache-middleware.js'
import tryCatch from '../../middleware/try-catch-middleware.js'
import SoccerFixtures from '../schemas/soccer-fixtures-schema.js'
import BasketFixtures from '../schemas/basket-fixtures-schema.js'
import Bets from '../schemas/bets-schema.js'
import Betsummaries from '../schemas/bet-summaries-schema.js'
import moment from 'moment-timezone'
import request from 'sync-request'
import fetch from 'node-fetch'


cron.schedule("*/5 * * * *", async () => {
  const runQuery = async (id, sumid, state) => {
    await Bets.updateOne({ _id: id, state:'Aktif' }, { $set: { state: state } })
    if(state == 'Kaybetti'){
      await Betsummaries.updateOne({ sumid: sumid }, { $inc: { betscountremain: + 1, lostcount: + 1 }, state:'Kaybetti' })
    }
  }
  try {
    //halftime----------------
    let halfTimeBets = await Bets.find({state: 'Aktif', games: 'Devre 1 Sonucu'})
    if (halfTimeBets.length > 0) {
      let result1 = request('GET', `https://api.betsapi.com/v1/bwin/inplay?token=${process.env.API_KEY}&sport_id[]=4`,{json: {results: 'results'}})
      let halfTimeApi = JSON.parse(result1.getBody('utf8')).results.filter(item => item.Scoreboard.period == 'Halftime' && halfTimeBets.some(item1 => (item.Id == item1.betid)))
      if(halfTimeApi.length > 0){
        halfTimeApi.forEach(item1 => {
          halfTimeBets.forEach(item2 => {
            if (item1.Id == item2.betid && item1.HomeTeam == item2.options) {
              if (Number(item1.Scoreboard.score.charAt(0)) <= Number(item1.Scoreboard.score.charAt(2))) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'X') {
              if (item1.Scoreboard.score.charAt(0) != item1.Scoreboard.score.charAt(2)) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item1.AwayTeam == item2.options) {
              if (Number(item1.Scoreboard.score.charAt(0)) >= Number(item1.Scoreboard.score.charAt(2))) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          })
        })
      }
    }
    //halftime both team to score----------------
    let halfTimeBetsBothTeamtoScore = await Bets.find({state: 'Aktif', games: 'Her İki Takım Gol Atarmı Devre 1'})
    if (halfTimeBetsBothTeamtoScore.length > 0) {
      let result1 = request('GET', `https://api.betsapi.com/v1/bwin/inplay?token=${process.env.API_KEY}&sport_id[]=4`,{json: {results: 'results'}})
      let halfTimeApi = JSON.parse(result1.getBody('utf8')).results.filter(item => item.Scoreboard.period == 'Halftime' && halfTimeBetsBothTeamtoScore.some(item1 => (item.Id == item1.betid)))
      if(halfTimeApi.length > 0){
        halfTimeApi.forEach(item1 => {
          halfTimeBetsBothTeamtoScore.forEach(item2 => {
            if (item1.Id == item2.betid && item2.options.trim() == 'Evet') {
              if (Number(item1.Scoreboard.score.charAt(0)) < 1 || Number(item1.Scoreboard.score.charAt(2)) < 1) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Hayır') {
              if (Number(item1.Scoreboard.score.charAt(0)) > 0 && Number(item1.Scoreboard.score.charAt(2)) > 0) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          })
        })
      }
    }
    //halftime over-under
    let htou = await Bets.find({state: 'Aktif', games: 'Devre 1 - Toplam Gol'})
    if(htou.length > 0){
      let result2 = request('GET', `https://api.betsapi.com/v1/bwin/inplay?token=${process.env.API_KEY}&sport_id[]=4`,{json: {results: 'results'}})
      let overUnderApi = JSON.parse(result2.getBody('utf8')).results.filter(item => item.Scoreboard.period == 'Halftime' && htou.some(item1 => (item.Id == item1.betid)))
      if (overUnderApi.length > 0) {
        overUnderApi.forEach(item1 => {
          htou.forEach(item2 => {
          //halftime over-under 0.5
            if (item1.Id == item2.betid && item2.options.trim() == 'Alt 0,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) > 0) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Üst 0,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) < 1) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          //halftime over-under 1.5
            if (item1.Id == item2.betid && item2.options.trim() == 'Alt 1,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) > 1) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Üst 1,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) < 2) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          //halftime over-under 2.5
            if (item1.Id == item2.betid && item2.options.trim() == 'Alt 2,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) > 2) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Üst 2,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) < 3) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          //halftime over-under 3.5
            if (item1.Id == item2.betid && item2.options.trim() == 'Alt 3,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) > 3) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Üst 3,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) < 4) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          //halftime over-under 4.5
            if (item1.Id == item2.betid && item2.options.trim() == 'Üst 4,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) > 4) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
            if (item1.Id == item2.betid && item2.options.trim() == 'Alt 4,5') {
              if ((Number(item1.Scoreboard.score.charAt(0)) + Number(item1.Scoreboard.score.charAt(2))) < 5) {
                runQuery(item2._id, item2.sumid, 'Kaybetti')
              }
            }
          })
        })
      }
    }
  } catch (error) {console.log(error)}
})
// cron.schedule("*/1 * * * *", () => {
cron.schedule("*/15 * * * *", () => {
  const t = new Date()
  const basket = () => {
    try {
      let start = moment().format('YYYY-MM-DD HH:mm')
      let end = moment().add(4,'days').format('YYYY-MM-DD HH:mm')

      const final = request('GET', `https://api.betsapi.com/v1/bwin/prematch?token=${process.env.API_KEY}&sport_id=7&page=1`,{json: {results: 'results'}})
      const pages = JSON.parse(final.getBody('utf8'))
      let pagenumber = Math.ceil(pages.pager.total/pages.pager.per_page)
      const urls = []
      for (let i = 1; i <= pagenumber; i++) {
        urls.push(`https://api.betsapi.com/v1/bwin/prematch?token=${process.env.API_KEY}&sport_id=7&page=${i}`)
      }
      const fetchData = () => {
        const allRequests = urls.map(async url => {
          return await fetch(url).then(response => response.json())
        })
        return Promise.all(allRequests)
      }
      fetchData().then(arrayOfResponses => {
        let newarraybasket = []
        for (const key in arrayOfResponses) {
          newarraybasket.push(arrayOfResponses[key].results)
        }
        if (newarraybasket.length > 0) {
          let storearray = []
          newarraybasket.forEach(item => {
            item.forEach(item2 => {
              storearray.push(item2)
            })
          })
          if(storearray.length > 0){
            let filterupdate = storearray.filter(item => {return moment(new Date(item.updated_at * 1000)).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD') && moment(item.Date).format('YYYY-MM-DD HH:mm') > start && moment(item.Date).format('YYYY-MM-DD HH:mm') < end})
            let final = filterupdate.filter(item => {return !item.LeagueName.includes('eSoccer') && !item.LeagueName.includes('Price Boost') && !item.LeagueName.includes('Enhanced Accas')})
            const saveAll = async() => {
              let newFixtur = []
              if(final.length > 0){
                new SoccerFixtures(final.map(item => {
                  if(item.HomeTeam && item.AwayTeam){
                    newFixtur.push({
                      FixtureId: item.Id,
                      RegionId: item.RegionId,
                      RegionName: item.RegionName,
                      Date: item.Date,
                      LeagueId: item.LeagueId,
                      LeagueName: item.LeagueName,
                      HomeTeam: item.HomeTeam,
                      AwayTeam: item.AwayTeam,
                      MatchResult: item.Markets.filter(item => item.name.value == 'Money Line'),
                      Handicap: item.Markets.filter(item => item.name.value == 'Handicap'),
                      Totals: item.Markets.filter(item => item.name.value == 'Totals')
                    })
                  }
                }))
                await BasketFixtures.collection.drop()
                await BasketFixtures.insertMany(newFixtur)
              }
            }
            saveAll()
          }
        }
      })
    } catch (error) {
      console.log(error)
    }
  }
  const soccer  = () => {
    try {
      let start = moment().format('YYYY-MM-DD HH:mm')
      let end = moment().add(4,'days').format('YYYY-MM-DD HH:mm')
      
      const final = request('GET', `https://api.betsapi.com/v1/bwin/prematch?token=${process.env.API_KEY}&sport_id=4&page=1`,{json: {results: 'results'}})
      const pages = JSON.parse(final.getBody('utf8'))
      let pagenumber = Math.ceil(pages.pager.total/pages.pager.per_page)
      const urls = []
      for (let i = 1; i <= pagenumber; i++) {
        urls.push(`https://api.betsapi.com/v1/bwin/prematch?token=${process.env.API_KEY}&sport_id=4&page=${i}`)
      }
      const fetchData = () => {
        const allRequests = urls.map(async url => {
          return await fetch(url).then(response => response.json())
        })
        return Promise.all(allRequests)
      }
      fetchData().then(data => {
        let newarray = []
        for (const key in data) {
          newarray.push(data[key].results)
        }
        if (newarray.length > 0) {
          let storearray = []
          newarray.forEach(item => {
            item.forEach(item2 => {
              storearray.push(item2)
            })
          })
          if(storearray.length > 0){
            let filterupdate = storearray.filter(item => {return moment(new Date(item.updated_at * 1000)).format('YYYY-MM-DD') === moment().format('YYYY-MM-DD') && moment(item.Date).format('YYYY-MM-DD HH:mm') > start && moment(item.Date).format('YYYY-MM-DD HH:mm') < end})
            let final = filterupdate.filter(item => {return !item.LeagueName.includes('eSoccer') && !item.LeagueName.includes('Price Boost') && !item.LeagueName.includes('Enhanced Accas')})      
            const saveAll = async() => {
              let newFixtur = []
              if(final.length > 0){
                new SoccerFixtures(final.map(item => {
                  if(item.HomeTeam && item.AwayTeam){
                    newFixtur.push({
                      FixtureId: item.Id,
                      RegionId: item.RegionId,
                      RegionName: item.RegionName,
                      Date: item.Date,
                      LeagueId: item.LeagueId,
                      LeagueName: item.LeagueName,
                      HomeTeam: item.HomeTeam,
                      AwayTeam: item.AwayTeam,
                      MatchResult: item.optionMarkets.filter(item => item.name.value == "Match Result"),
                      TotalGoals: item.optionMarkets.filter(item => item.name.value == "Total Goals" && item.attr == "2,5"),
                      BothTeamsToScore: item.optionMarkets.filter(item => item.name.value == "Both Teams To Score"),
                      ShortId: String(item.Id).slice(-3),
                    })
                  }
                }))
                await SoccerFixtures.collection.drop()
                await SoccerFixtures.insertMany(newFixtur)
              }
            }
            saveAll()
          }
        }
      })
    } catch (error) {
      console.log(error)
    }
  }
  soccer()
  setTimeout(() => {
    basket()
  }, 60000)
})
router.get("/soccer", tryCatch(async (req, res) => {
  const result = await SoccerFixtures.find({ Date: { $gt: moment(), $lt: moment().format('YYYY-MM-DD 24:00:00')}})
  res.status(200).json({result})
}))
router.get("/soccer-date-filter/:start/:end",  tryCatch(async (req, res) => {
  const result = await SoccerFixtures.find({ Date: { $gt: req.params.start, $lt: req.params.end}})
  res.status(200).json({result})
}))
router.get("/soccer-search/:id", cacheMiddleware(960) ,tryCatch(async (req, res) => {
  const result = await SoccerFixtures.find({
    $or:[
      {HomeTeam: new RegExp(req.params.id, 'i')},
      {AwayTeam: new RegExp(req.params.id, 'i')}
    ]
  })
  res.status(200).json({result})
}))
router.get("/basket-search/:id", cacheMiddleware(960) ,tryCatch(async (req, res) => {
  const result = await BasketFixtures.find({
    $or:[
      {HomeTeam: new RegExp(req.params.id, 'i')},
      {AwayTeam: new RegExp(req.params.id, 'i')}
    ]
  })
  res.status(200).json({result})
}))
router.get("/basket", cacheMiddleware(960), tryCatch(async (req, res) => {
  const result = await BasketFixtures.find({ Date: { $gt: moment(), $lt: moment().format('YYYY-MM-DD 24:00:00')}})
  res.status(200).json({result})
}))
router.get("/basket-date-filter/:start/:end", cacheMiddleware(960), tryCatch(async (req, res) => {
  const result = await BasketFixtures.find({ Date: { $gt: req.params.start, $lt: req.params.end}})
  res.status(200).json({result})
}))
router.get("/odds/:id", cacheMiddleware(960), (req, res) => {
  try {
    const result = request('GET', `https://api.betsapi.com/v1/bwin/event?token=${process.env.API_KEY}&event_id=${req.params.id}`, { json: { results: 'results' } })
    const final = JSON.parse(result.getBody('utf8')).results
    res.status(200).json(final)
  } catch (error) {
    console.log(error)
  }
})
router.get("/soccer-live", cacheMiddleware(60), (req, res) => {
  try {
    const result = request('GET', `https://api.betsapi.com/v1/bwin/inplay?token=${process.env.API_KEY}&sport_id[]=4`, { json: { results: 'results' } })
    // const final =  JSON.parse(result.getBody('utf8')).results.filter(item => item.Scoreboard.started == true && item.Scoreboard.period !== 'Reg. Time Over')
    console.log(result.statusCode)
    res.status(200).json(final)
  } catch (error) {
    if(error){
      res.status(204).send()
    }
  }
  
})
router.get("/basket-live", cacheMiddleware(30), (req, res) => {
  try {
    const result = request('GET', `https://api.betsapi.com/v1/bwin/inplay?token=${process.env.API_KEY}&sport_id[]=7`, { json: { results: 'results' } })
    const final =  JSON.parse(result.getBody('utf8')).results.filter(item => item.Scoreboard.started == true && item.Scoreboard.period !== 'Reg. Time Over')
    res.status(200).json(final)
  } catch (error) {
    if(error){
      res.status(204).send()
    }
  }
})
router.get("/live-odds/:id", cacheMiddleware(10), (req, res) => {
  try {
    const result = request('GET', `https://api.betsapi.com/v1/bwin/event?token=${process.env.API_KEY}&event_id=${req.params.id}`, { json: { results: 'results' } })
    const final = JSON.parse(result.getBody('utf8')).results
    res.status(200).json(final)
  } catch (error) {
    console.log(error)
  }
})
router.get(`/scores/:id`, cacheMiddleware(300), async(req, res) => {
  try {
    const result = request('GET', `https://api.betsapi.com/v1/bwin/result?token=${process.env.API_KEY}&event_id=${req.params.id}`, { json: { results: 'results' } })
    const final = JSON.parse(result.getBody('utf8')).results
    if(final[0].ss != null){
      await Bets.updateMany({betid: req.params.id}, {$set:{score:final[0].ss}})
      res.status(200).json(final)
      return false
    }
    res.status(400).send()
  } catch (error) {
    console.log(error)
  }
})
export default router