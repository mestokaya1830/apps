<template>
  <div id="printMe" class="bet-details-print">
    <ul class="slip-item-con only-print">
      <div class="print-title">
        <h3 class="slip-title">Bahislerim</h3>
        <li class="slip-order">
          <span class="slip-items">Kod: {{ betSum.sumid }}</span>
          <span>{{moment(new Date(), "YYYY-MM-DD H:mm").format("YYYY-MM-DD H:mm")}}</span>
        </li>
      </div>
      <li class="slip print-list" v-for="(item, index) in bets" :key="index">
        <div class="slip-order">
          <span class="slip-items slip-items-text">Maç kodu:</span>
          <span class="badge slip-code cl-b">{{item.code}}</span>
        </div>
        <div class="slip-order">
          <span class="slip-match">{{item.matches}}</span>
        </div>
        <div class="slip-order">
          <span class="slip-items slip-items-text">Bahis:</span>
          <span class="slip-items slip-items-break">{{item.games}}</span>
        </div>
        <div>
          <div class="slip-order">
            <span class="slip-items slip-items-text">Seçim:</span>
            <span class="slip-items slip-items-break">{{item.options}}</span>
          </div>
          <div class="slip-order">
            <span class="slip-items slip-items-text">Oran:</span>
            <strong class="slip-items">{{ (item.rate).toFixed(2) }}</strong>
          </div>
        </div>
      </li>
    </ul>
    <ul class="print-result only-print">
      <li class="info-con">
        <span>Toplam Bahis: </span>
        <span> {{ betSum.betscount }}</span>
      </li>
      <li class="info-con info-con-rate">
        <span>Toplam Oran:</span>
        <span> {{ (betSum.rate).toFixed(2)}}</span>
      </li>
      <li class="info-con info-con-rate">
        <span>Miktar:</span>
        <span> {{ betSum.amount }}</span>
      </li>
      <li class="info-con">
        <span>Toplam Kazanç:</span>
        <span>{{ getComission }}</span>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  name:'print-component',
  inject:['moment'],
  props:{
    bets: {
      type:Array,
      required: true
    },
    betSum: {
      type:Object,
      required: true
    },
  },
  data() {
    return {}
  },
  computed:{
    getComission() {
      let newEarn = (this.betSum.earn * this.$store.state.auth.customercomission) / 100
      return (this.betSum.earn - newEarn).toFixed(2)
    },
  }
}
</script>

<style>
@media print {
  .no-print {
    display: none;
  }
  .only-print {
    display: block;
    padding: 5px 10px;
    color: #111;
  }
  .bet-details-print{
    width: 100%;
  }
  .slip-title {
   text-align: center;
   min-height: 40px;
  }
  .slip-date {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 3px 5px;
    border-bottom: 1px solid #444;
  }
  .print-title{
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 60px;
    padding: 10px 0;
    border-bottom: 1px solid #444;
  }
  .print-list {
    border: none;
    margin: 0;
    padding: 2px;
    box-shadow: none;
    border-bottom: 1px solid #ccc;
  }
  .slip {
    height: auto;
    min-height: 70px;
  }
  .slip-order {
    display: flex;
    justify-content: space-between;
    box-shadow: none;
  }
  .slip-items {
    color: black;
  }
  .slip-match {
    padding-top: 5px;
  }
  .print-result {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-top: 5px;
    border-bottom: 1px solid #444;
    position: static;
  }
  .info-con {
    display: flex;
    justify-content: space-between;
    border: none;
    height: 20px;
  }
}
</style>