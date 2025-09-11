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

      <v-alert v-if="errorMessage" type="error" class="mt-3">
        {{ errorMessage }}
      </v-alert>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const loading = ref(false)
const errorMessage = ref('')
const email = ref('')
const password = ref('')
const router = useRouter()

async function login() {
  if (!email.value || !password.value) {
    errorMessage.value = 'Preencha todos os campos!'
    return
  }

  loading.value = true
  errorMessage.value = ''

  try {
    // Use URL relativa para evitar CORS
    const response = await fetch('/api/valida_login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    console.log('Status da resposta:', response.status)
    
    if (!response.ok) {
      throw new Error(`Erro do servidor: ${response.status}`)
    }

    const data = await response.json()
    console.log('Dados recebidos:', data)

    if (data.success) {
      if (data.token) {
        localStorage.setItem('authToken', data.token)
      }
      if (data.user) {
        localStorage.setItem('user', JSON.stringify(data.user))
      }
      router.push('/contatos')
    } else {
      errorMessage.value = data.message || 'Erro ao fazer login'
    }
  } catch (error) {
    console.error('Erro completo:', error)
    errorMessage.value = 'Erro de conexão. Verifique se o servidor PHP está rodando.'
  } finally {
    loading.value = false
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
