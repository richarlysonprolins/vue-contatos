<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <RouterView />
</template>

<style>
/* Se quiser fundo padrão para toda a aplicação */
html, body, #app {
  height: 100%;
  margin: 0 50% 0 30%;
  background-color: rgb(0, 129, 250);
}
</style>
