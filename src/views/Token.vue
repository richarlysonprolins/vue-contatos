<template>
  <v-container class="container123 d-flex align-center justify-center">
    <v-card color="black" width="400" class="pa-6">
      <div class="d-flex flex-column align-center mb-4">
        <img alt="Vue logo" class="logo" src="@/assets/NewLogoProlins.png" width="100%" height="100%" />
        <h2 class="text-h6">Recuperação de Senha</h2>
        <p class="text-caption text-center">Insira o código de 6 dígitos enviado para seu email</p>
      </div>

      <v-form @submit.prevent="validarCodigo">
        <v-otp-input
          v-model="codigo"
          length="6"
          type="number"
          :loading="loading"
        ></v-otp-input>

        <v-btn 
          type="submit" 
          color="primary" 
          block 
          class="mt-4"
          :loading="loading"
        >
          Verificar Código
        </v-btn>

        <div class="text-center mt-4">
          <router-link to="/" class="forgot-password">Voltar para login</router-link>
        </div>
      </v-form>

      <!-- Mensagens de feedback -->
      <v-alert
        v-if="mensagemSucesso"
        type="success"
        class="mt-3"
      >
        {{ mensagemSucesso }}
      </v-alert>

      <v-alert
        v-if="mensagemErro"
        type="error"
        class="mt-3"
      >
        {{ mensagemErro }}
      </v-alert>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const codigo = ref('')
const loading = ref(false)
const mensagemSucesso = ref('')
const mensagemErro = ref('')
const router = useRouter()

function validarCodigo() {
  // Limpa mensagens anteriores
  mensagemSucesso.value = ''
  mensagemErro.value = ''
  loading.value = true

  // Simula uma requisição assíncrona
  setTimeout(() => {
    // Verifica se o código tem 6 dígitos (qualquer número)
    if (codigo.value.length === 6 && /^\d+$/.test(codigo.value)) {
      mensagemSucesso.value = 'Código verificado com sucesso! Sua senha foi redefinida para "123456".'
      
      // Limpa o código após sucesso
      codigo.value = ''
      
      // Opcional: Redireciona após alguns segundos
      setTimeout(() => {
        router.push('/')
      }, 3000)
    } else {
      mensagemErro.value = 'Por favor, insira um código de 6 dígitos válido.'
    }
    
    loading.value = false
  }, 1500) // Simula delay de rede
}
</script>

<style scoped>
.forgot-password {
  color: rgb(0, 42, 255); 
  text-decoration: none;
  font-size: 0.875rem;
}

.container123{
  width: 100vw;
  height: 100vh;
}

/* Estilo para o OTP input */
:deep(.v-otp-input) {
  justify-content: center;
}

:deep(.v-otp-input__field) {
  width: 45px;
  height: 45px;
  font-size: 18px;
  margin: 0 5px;
}
</style>