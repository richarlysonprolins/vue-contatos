<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <RouterView />
</template>

<style>
/* Se quiser fundo padrão para toda a aplicação */
html, body, #app {
  height: 100dvh !important;
  width: 100dvw !important;
  background-color: rgb(0, 129, 250);
}
#app {
  display: flex;
  place-items: center;
}
</style>
