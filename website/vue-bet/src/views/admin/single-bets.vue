<template>
  <div>
    <BetsComponent route="bet-summary" title="Tek Maça Kalanlar" />
  </div>
</template>

<script>
  import BetsComponent from "@/components/bets-component.vue";

  export default {
    name:'Bets',
    components:{
      BetsComponent
    }
  }
</script>
