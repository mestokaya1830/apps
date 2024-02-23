<template>
  <div>
    <div class="admin-con">
      <MarketsComponent
        :title="'Basketbol Canlı Bahis Ayarları'"
        :market="'basketlivemarkets'"
        :table="'basketlivemarkets'"
        :type="'basket-live-market'"
      />
    </div>
  </div>
</template>

<script setup>
  import MarketsComponent from "@/components/markets-component.vue";
</script>