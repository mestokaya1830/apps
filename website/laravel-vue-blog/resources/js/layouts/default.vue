<script setup>
  import Navbar from '../components/navbar.vue'
</script>
<template>
  <div>
    <Navbar />
    <div class="router">
      <router-view />
    </div>
  </div>
</template>