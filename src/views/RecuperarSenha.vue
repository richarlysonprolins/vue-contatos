<template>
  <v-container fluid class="fill-height d-flex align-center justify-center">
    <v-card color="black" width="400" class="pa-6">
      <div class="d-flex flex-column align-center mb-4">
        <img alt="Vue logo" class="logo" src="@/assets/NewLogoProlins.png" width="100%" height="100%" />
        <h2 class="text-h6">Insira seu email</h2>
      </div>

      <v-form @submit.prevent="login">
        <v-text-field
          v-model="email"
          label="E-mail"
          type="user"
          required
        />
        <v-btn type="submit" color="primary" block>Confirmar</v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const router = useRouter()

function login() {
  if (email.value) {
    router.push('/token')
  } else {
    alert('Preencha todos os campos!')
  }
}
</script>

<style scuped>
.forgot-password {
  color: rgb(0, 42, 255); 
  display: flex;
  margin-bottom: 20px;
}
</style>
