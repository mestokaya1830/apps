<template>
  <div class="f">
    <div v-if="message.state == 'success'" class="btn success">{{ message.result }}</div>
    <div v-else class="btn error">{{ message.result }}</div>
  </div>
</template>

<script>
  export default {
    name: 'alert-component',
    props: {
      message: {
        type: Object,
        required: true
      } 
    }
  }
</script>

<style>
.btn {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: calc(38px + 1vh);
  margin: 15px auto;
  border: none;
  color: #fff;
  letter-spacing: 1px;
  border-radius: var(--radius);
  cursor: pointer;
  font-size: calc(20px + 0.2vw);
}
.success {
  background-color: var(--lightgreen);
  color: #fff;
}
.error {
  background-color: var(--red);
  color: #fff;
}
.btn:hover{
  filter: brightness(120%);
}
</style>