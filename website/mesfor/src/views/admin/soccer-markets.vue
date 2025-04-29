<template>
  <div>
    <div class="admin-con">
      <MarketsComponent
        :title="'Futbol Bahis Ayarları'"
        :market="'soccermarkets'"
        :table="'soccermarkets'"
        :type="'soccer-market'"
      />
    </div>
  </div>
</template>

<script setup>
  import MarketsComponent from "@/components/markets-component.vue";
</script>