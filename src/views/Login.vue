<template>
  <v-container fluid class="fill-height d-flex align-center justify-center">
    <v-card width="400" class="pa-6">
      <div class="d-flex flex-column align-center mb-4">
        <img alt="Vue logo" class="logo" src="@/assets/NewLogoProlins.png" width="100%" height="100%" />
        <h2 class="text-h6">Bem-vindo(a)</h2>
      </div>

      <v-form @submit.prevent="login">
        <v-text-field
          v-model="email"
          label="E-mail"
          type="email"
          required
        />
        <v-text-field
          v-model="password"
          label="Senha"
          type="password"
          required
        />
        <v-btn type="submit" color="primary" block>Entrar</v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const router = useRouter()

function login() {
  if (email.value && password.value) {
    router.push('/contatos')
  } else {
    alert('Preencha todos os campos!')
  }
}
</script>
