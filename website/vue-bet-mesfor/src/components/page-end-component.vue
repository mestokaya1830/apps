<template>
  <div class="page-end">
    <span v-if="length > 0">&#9875;</span>
    <div class="page-end" v-else>Veri yoktur</div>
  </div>
</template>
<script>
export default {
  name:'PageEnd',
  props:{
    length:{
      type:Number,
      required: true,
      default: 0
    }
  }
}
</script>
<style>
  .page-end{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 3px 0;
    min-height: 40px;
    color: #999;
    border-bottom-left-radius: var(--radius);
    border-bottom-right-radius: var(--radius);
    background-color: var(--black);
  }
</style>