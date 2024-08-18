<template>
  <div>
    <div class="admin-con">
      <MarketsComponent
        :title="'Basketbol Bahis Ayarları'"
        :market="'basketmarkets'"
        :table="'basketmarkets'"
        :type="'basket-market'"
      />
    </div>
  </div>
</template>

<script setup>
  import MarketsComponent from "@/components/markets-component.vue";
</script>