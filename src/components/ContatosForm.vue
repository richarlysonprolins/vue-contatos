    <template>
        <v-container fluid class="d-flex align-center justify-center">
            <v-card>
                <v-dialog v-model="dialogEditar" max-width="600">
                  <template v-slot:activator="{ props: activatorProps }">
                    <v-btn
                      v-bind="activatorProps"
                      color="primary"
                      variant="flat"
                      @click="editarContato(item)"
                    ><v-icon>mdi-pencil</v-icon></v-btn>
                  </template>

                   <template v-slot:default="{ isActive }">
                    <v-card title="Editar Contato">
                      <v-card-text>
                        <v-row dense>
                          <v-col v-for="(field,i) in formFields" :key="i" cols="12" md="4" sm="6">
                             <v-text-field v-model="field.model" :label="field.label" :type="field.type" :rules="field.rules || []" :required="field.required" @blur="field.key === 'cep' ? buscarCep() : null" />
                          </v-col>
                        </v-row>
                        <small class="text-caption text-red123 text-medium-emphasis">*Indica campo obrigatório</small>
                      </v-card-text>

                      <v-divider></v-divider>

                      <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                          color="red"
                          text
                          @click="dialogEditar = false"
                        >Cancelar</v-btn>

                        <v-btn
                          color="primary"
                          text
                          @click="salvarContato"
                        >Salvar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </template>
                </v-dialog>
                <v-dialog 
                          v-model="dialogDeletar"
                          max-width="400"
                          persistent
                        >
                          <template v-slot:activator="{ props: activatorProps }">
                            <v-btn color="red" v-bind="activatorProps" @click="abrirDialogDeletar">
                              <v-icon>mdi-delete</v-icon>
                            </v-btn>
                          </template>

                          <v-card>
                            <v-card-title class="d-flex align-center">
                                <v-icon icon="mdi-alert" color="error" class="mr-2"></v-icon>
                                Confirmar exclusão
                            </v-card-title>
                            
                            <v-card-text>
                                <p>Tem certeza que deseja excluir o contato <strong>{{ contatoParaExcluir?.nome }}</strong>?</p>
                                <p class="text-caption text-medium-emphasis mt-2">
                                    Ao clicar em confirmar, este contato será permanentemente removido.
                                </p>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn 
                                    color="grey" 
                                    variant="text" 
                                    @click="dialogDeletar = false"
                                >
                                    Cancelar
                                </v-btn>
                                <v-btn 
                                    color="error" 
                                    variant="flat" 
                                    @click="confirmarExclusao"
                                >
                                    Confirmar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-dialog>  
            </v-card>
        </v-container>
    </template>

    <script setup>
    import { ref, watch } from 'vue' 
    import { fetchAddressByCep } from "../services/viacep.js"
    const contatoParaExcluir = ref(null)
    
    const props = defineProps({
      contato: {
        type: Object,
        required: true
      }
    })

    const emit = defineEmits(["atualizado"])
    const dialog = ref(false)
    const dialogEditar = ref(false)
    const dialogDeletar = ref(false)
    const contatoSelecionado = ref(null)

    async function buscarCep() {
      const cepField = formFields.value.find(f => f.key === "cep")
      const cep = cepField.model 

      if (!cep || cep.replace(/\D/g, '').length !== 8) {
        alert('CEP inválido. Deve ter 8 dígitos.')
        return
      }
      
      const endereco = await fetchAddressByCep(cep)
      
      if (endereco) {
        formFields.value.find(f => f.key === "logradouro").model = endereco.logradouro
        formFields.value.find(f => f.key === "bairro").model = endereco.bairro
        formFields.value.find(f => f.key === "cidade").model = endereco.cidade
        formFields.value.find(f => f.key === "estado").model = endereco.estado
      } else {
        alert('CEP não encontrado ou erro na consulta')
      }
    }

    const validationRules = {
      required: value => {
        if (value && value.toString().trim()) return true
        return 'Este campo é obrigatório'
      },
      email: value => {
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        return pattern.test(value) || 'E-mail inválido'
      },
      cep: value => {
        const cleaned = value.replace(/\D/g, '')
        return cleaned.length === 8 || 'CEP deve ter 8 dígitos'
      }
    }

    // Atualize o formFields com regras específicas
    const formFields = ref([
      { label: "Nome", key:"nome", type:"text", model: "", required: true, rules: [validationRules.required] },
      { label: "E-mail", key:"email", type:"text", model: "", required: true, rules: [validationRules.required, validationRules.email] },
      { label: "Telefone", key:"telefone", type:"text", model: "", required: true, rules: [validationRules.required] },
      { label: "CEP", key:"cep", type:"text", model: "", required: true, rules: [validationRules.required, validationRules.cep] },
      { label: "Logradouro", key:"logradouro", type:"text", model: "", required: true, rules: [validationRules.required] },
      { label: "Número", key:"numero", type:"number", model: "", required: true, rules: [validationRules.required] },
      { label: "Bairro", key:"bairro", type:"text", model: "", required: true, rules: [validationRules.required] },
      { label: "Cidade", key:"cidade", type:"text", model: "", required: true, rules: [validationRules.required] },
      { label: "Estado", key:"estado", type:"text", model: "", required: true, rules: [validationRules.required] }
    ])

    watch(() => props.contato, (novo) => {
      if (novo) {
        formFields.value.forEach(field => {
          field.model = novo[field.key] || ""
        })
      }
    }, { immediate: true })

    async function salvarContato() {
      const camposInvalidos = formFields.value.filter(f => f.required && !f.model.trim())

      if (camposInvalidos.length > 0) {
        alert(`Preencha os campos obrigatórios: ${camposInvalidos.map(f => f.label).join(", ")}`)
        return
      }

      const payload = {}
      formFields.value.forEach(field => {
        payload[field.key] = field.model
      }) 
      payload.id = props.contato.id

      try {
        const res = await fetch("/api/editar_contato.php", {
          method: "POST", 
          headers: { "Content-Type" : "application/json" },
          body: JSON.stringify(payload)
        })
        const data = await res.json()
        if (data.status === "ok") {
          alert("Contato atualizado com sucesso!")
          dialogEditar.value = false
          emit("atualizado")
        } else {
          alert("Erro ao salvar: " + (data.mensagem || "desconhecido"))
        }
        } catch (e) {
          console.error("Erro ao editar:", e)
        }
      }

      async function confirmarExclusao() {
        if (!props.contato || !props.contato.id) {
        alert("Erro: Contato não selecionado para exclusão")
        dialogDeletar.value = false
        return
        }
        try {
          const res = await fetch("/api/excluir_contato.php", {
            method: "POST",
            headers: { "Content-Type" : "application/json" },
            body: JSON.stringify({ id: props.contato.id })
          })
          const data = await res.json()
          if (data.success) {
            alert(`Contato "${props.contato.nome}" deletado com sucesso!"`)
            dialogDeletar.value = false
            emit("atualizado")
          } else {
            alert("Erro ao deletar contato: " + (data.mensagem || "desconhecido"))
        }
        } catch (e) {
          console.log("Erro ao excluir:", e)
          alert("Erro ao excluir contato. Tente novamente.")
        }
        
      }
      
      function editarContato(item){
        contatoSelecionado.value = item
        formFields.value.forEach(field => {
          field.model = item[field.key] || ""
        })
        dialogEditar.value = true
      }

      function abrirDialogDeletar() {
        contatoParaExcluir.value = props.contato
        dialogDeletar.value = true
      }

    </script>

    <style scoped>
    .text-red123 {
        color: red !important;
    }
    </style>


