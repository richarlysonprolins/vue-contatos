<template>
  <v-container class="container123 d-flex align-center justify-center">
    <v-card color="black" width="400" class="pa-6">
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
        <router-link to="/recuperar-senha" class="forgot-password">Esqueci minha senha</router-link>
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

<style scoped>
.forgot-password {
  color: rgb(0, 42, 255); 
  display: flex;
  margin-bottom: 20px;
}
.container123{
  width: 100vw;
  height: 100vh;
}
</style>
