      <template>
          <v-container fluid class="fill-height d-flex align-center justify-center">
              <v-card class="pa-6">
                      <!-- Lista de Contatos 
                
                      <v-list lines="two">
                      <v-list-subheader>Todos os seus contatos</v-list-subheader>

                      <v-list-item prepend-avatar="https://cdn.vuetifyjs.com/images/lists/1.jpg">
                          <template v-slot:title>
                              Bruno
                          </template>
                          <template v-slot:append>
                              <v-btn color="primary"><v-icon icon="mdi-pencil"></v-icon></v-btn>
                              <v-btn color="red"><v-icon icon="mdi-delete"></v-icon></v-btn>

                          </template>
                      </v-list-item>

                      <v-divider inset></v-divider>

                      <v-list-item prepend-avatar="https://cdn.vuetifyjs.com/images/lists/2.jpg">
                          <template v-slot:title>
                          Lucas   
                          </template>
                          <template v-slot:append>
                                  <v-btn color="primary"><v-icon icon="mdi-pencil"></v-icon></v-btn>
                                  <v-spacer></v-spacer>
                                  <v-btn color="red"><v-icon icon="mdi-delete"></v-icon></v-btn>
                          </template>
                          <template v-slot:subtitle>
                          </template>
                      </v-list-item>

                      <v-divider inset></v-divider>

                      <v-list-item prepend-avatar="https://cdn.vuetifyjs.com/images/lists/3.jpg" title="Renata">
                          <template v-slot:subtitle>
                          </template>
                          <template v-slot:append>
                              <v-btn color="primary"><v-icon icon="mdi-pencil"></v-icon></v-btn>
                              <v-btn color="red"><v-icon icon="mdi-delete"></v-icon></v-btn>
                          </template>
                      </v-list-item>
                      </v-list> -->
                  <v-dialog v-model="dialog" max-width="600">
                    <template v-slot:activator="{ props: activatorProps }">
                      <v-btn
                        v-bind="activatorProps"
                        color="primary"
                        text
                        variant="flat"
                      >Criar Contato</v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                      <v-card title="Criar Contato">
                        <v-card-text>
                          <v-row dense>
                            <v-col v-for="(field,i) in formFields" :key="i" cols="12" md="4" sm="6">
                              <v-text-field v-model="field.model" :label="field.label" :type="field.type" :required="field.required || false" @blur="field.key === 'cep' ? buscarCep() : null"> </v-text-field> 
                            </v-col>
                          </v-row>
                          <p class="text-caption-red text-red123 text-medium-emphasis">*Indica campo obrigatório</p>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                          <v-spacer></v-spacer>

                          <v-btn
                            color="red"
                            text
                            @click="dialog = false"
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
                <v-data-table v-slot:item.actions="{ item }" :headers="headers" :items="contatos" item-key="id">
                  
                  <ContatosForm
                      v-model="openModal"
                      :contato="contatoSelecionado"
                      @click="salvarContato"
                  />
                </v-data-table>
              </v-card>
          </v-container>
      </template>

      <script setup>
      import { onMounted, ref } from 'vue' 
      import ContatosForm from '../components/ContatosForm.vue'
      import { useRouter } from 'vue-router' 
      import { fetchAddressByCep } from "../services/viacep.js"
      const contatoSelecionado = ref(null)

      const formFields = ref([
        { label: "Nome", key: "nome", type:"text", model: ref(""), required: true},
        { label: "E-mail", key: "email", type:"text", model: ref(""), required: true},
        { label: "Telefone", key: "telefone", type:"text", model: ref(""), required: true},
        { label: "CEP", key: "cep", type:"text", model: ref(""), required: true},
        { label: "Logradouro", key: "logradouro", type:"text", model: ref(""), required: true},
        { label: "Número", key: "numero", type:"number", model: ref(""), required: true},
        { label: "Bairro", key: "bairro", type:"text", model: ref(""), required: true},
        { label: "Cidade", key: "cidade", type:"text", model: ref(""), required: true},
        { label: "Estado", key: "estado", type:"text", model: ref(""), required: true}
      ])

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

      const headers = ([
        { text: "Nome", value: "nome" },
        { text: "E-mail", value: "email" },
        { text: "Telefone", value: "telefone" },
        { text: "CEP", value: "cep" },
        { text: "Logradouro", value: "logradouro" },
        { text: "Número", value: "numero" },
        { text: "Bairro", value: "bairro" },
        { text: "Cidade", value: "cidade" },
        { text: "Estado", value: "estado" },
        { text: "Ações", value: "actions", sortable: false }
      ])

      const contatos = ref([])

      async function carregarContatos(){
        try {
          const resposta = await fetch("/api/listar_contatos.php")
          const dados = await resposta.json()
          contatos.value = dados
        } catch (e) {
          console.log("Deu ruim menó", e)
        }
      }

      onMounted(() => {
        carregarContatos()
      })

      const dialog = ref(false)

      async function salvarContato(){
         const novoContato = {}
            formFields.value.forEach(field => {
            novoContato[field.key.toLowerCase()] = field.model
          })
        try {
          const resposta = await fetch("/api/criar_contato.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            }, 
            body: JSON.stringify(novoContato)
          })
           const texto = await resposta.text()
          console.log("Resposta bruta do PHP:", texto)

          const resultado = JSON.parse(texto)
          console.log("JSON parseado:", resultado)

          if (resultado.status === "ok") {
            alert("Contato criado com sucesso! ID: " + resultado.id)
              formFields.value.forEach(field => {
              field.model.value = ''
          })
          dialog.value = false
        } else {
            alert("Erro ao salvar contato!")
          }
        } catch (e) {
          console.error("Erro na requisição:", e)
        }
      }
      

      </script>

      <style scoped>
      .text-red123 {
        color: red !important;
      }
      </style>


