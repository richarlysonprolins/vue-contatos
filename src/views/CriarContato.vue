<template>
    
    <v-container fluid class="fill-height d-flex align-center justify-center">
        <v-card width="400" class="pa-6">
            <v-form @submit.prevent="cadastro">
                <v-text-field label="Nome"></v-text-field>
                <v-text-field label="E-mail"></v-text-field>
                <v-text-field label="Telefone"></v-text-field>
                <v-text-field label="CEP"></v-text-field>
                <v-text-field label="Logradouro"></v-text-field>
                <v-text-field label="Número"></v-text-field>
                <v-text-field label="Bairro"></v-text-field>
                <v-text-field label="Cidade"></v-text-field>
                <v-text-field label="Estado"></v-text-field>
                <v-btn type="submit" color="success">Confirmar</v-btn>
            </v-form>
        </v-card>
    </v-container>
</template>


<script setup>
import { ref } from 'vue' 
import { useRouter } from 'vue-router' 

const nome = ref('')
const cep = ref('')
const router = useRouter()

function cadastro(){
    if(nome.value && cep.value){
        router.push('/sucesso')
    } else {
        alert('Preencha todos os campos!')
    }
}
</script>
