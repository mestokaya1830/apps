<template>
  <div>
    <div class="admin-con">
      <MarketsComponent
        :title="'Futbol Canlı Bahis Ayarları'"
        :market="'soccerlivemarkets'"
        :table="'soccerlivemarkets'"
        :type="'soccer-live-market'"
      />
    </div>
  </div>
</template>

<script setup>
  import MarketsComponent from "@/components/markets-component.vue";
</script>