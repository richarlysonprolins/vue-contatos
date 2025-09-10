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
                             <v-text-field v-model="field.model" :label="field.label" :type="field.type" :required="field.required || false" @blur="field.key === 'cep' ? buscarCep() : null" />
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
                            <v-btn color="red" v-bind="activatorProps">
                              <v-icon>mdi-delete</v-icon>
                            </v-btn>
                          </template>

                          <v-card
                            prepend-icon="mdi-map-marker"
                            text="Ao clicar em confirmar, você deleta o usuário"
                            title="Tem certeza que quer deletar usuário?"
                          >
                            <template v-slot:actions>
                              <v-spacer></v-spacer>

                              <v-btn @click="dialogDeletar = false">
                                Cancelar
                              </v-btn>

                              <v-btn @click="confirmarExclusao">
                                Confirmar
                              </v-btn>
                            </template>
                          </v-card>
                        </v-dialog>  
            </v-card>
        </v-container>
    </template>

    <script setup>
    import { ref } from 'vue' 
    import { fetchAddressByCep } from "../services/viacep.js"
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

    const formFields = ref([
      { label: "Nome", key:"nome", type:"text", model: ref(""), required: true},
      { label: "E-mail", key:"email", type:"text", model: ref(""), required: true},
      { label: "Telefone", key:"telefone", type:"text", model: ref(""), required: true},
      { label: "CEP", key:"cep", type:"text", model: ref(""), required: true},
      { label: "Logradouro", key:"logradouro", type:"text", model: ref(""), required: true},
      { label: "Número", key:"numero", type:"number", model: ref(""), required: true},
      { label: "Bairro", key:"bairro", type:"text", model: ref(""), required: true},
      { label: "Cidade", key:"cidade", type:"text", model: ref(""), required: true},
      { label: "Estado", key:"estado", type:"text", model: ref(""), required: true}
    ])

    const dialog = ref(false)
    const dialogEditar = ref(false)
    const dialogDeletar = ref(false)

    async function salvarContato() {
      const payload = {}
      formFields.value.forEach(field => {
        payload[field.key] = field.model
      }) 
      payload.id = contatoSelecionado.value.id

      try {
        const res = await fetch("/api/editar_contato.php", {
          method: "POST", 
          headers: { "Content-Type" : "application/json" },
          body: JSON.stringify(payload)
        })
        const data = await res.json()
        if (data.success) {
          alert("Contato atualizado com sucesso!")
          dialogEditar.value = false
          carregarContatos()
        }
        } catch (e) {
          console.error("Erro ao editar:", e)
        }
      }

      async function confirmarExclusao() {
        try {
          const res = await fetch("/api/excluir_contato.php", {
            method: "POST",
            headers: { "Content-Type" : "application/json" },
            body: JSON.stringify({ id: contatoSelecionado.value.id })
          })
          const data = await res.json()
          if (data.success) {
            alert("Contato deletado com sucesso!")
            dialogDeletar.value = false
            carregarContatos()
          }
        } catch (e) {
          console.log("Erro ao editar:", e)
        }
        
      }
      
      function editarContato(item){
        contatoSelecionado.value = item
        formFields.value.forEach(field => {
          field.model = item[field.key] || ""
        })
        dialogEditar.value = true
      }

    </script>

    <style scoped>
    .text-red123 {
        color: red !important;
    }
    </style>


