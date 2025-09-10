    <template>
        <v-container fluid class="d-flex align-center justify-center">
            <v-card>
                <v-dialog>
                  <template v-slot:activator="{ props: activatorProps }">
                    <v-btn
                      v-bind="activatorProps"
                      color="primary"
                      variant="flat"
                    ><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-dialog
                          v-model="dialog"
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

                              <v-btn @click="dialog = false">
                                Disagree
                              </v-btn>

                              <v-btn @click="dialog = false">
                                Agree
                              </v-btn>
                            </template>
                          </v-card>
                        </v-dialog>
          

                  </template>

                   <template v-slot:default="{ isActive }">
                    <v-card title="Editar Contato">
                      <v-card-text>
                        <v-row dense>
                          <v-col v-for="(field,i) in formFields" :key="i" cols="12" md="4" sm="6">
                             <v-text-field v-model="field.model" :label="field.label" :type="field.type" :required="field.required || false"> </v-text-field> 
                          </v-col>
                        </v-row>
                        <small class="text-caption text-red123 text-medium-emphasis">*Indica campo obrigatório</small>
                      </v-card-text>

                      <v-divider></v-divider>

                      <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                          color="red"
                          text="Cancelar"
                          @click="dialog = false"
                        ></v-btn>

                        <v-btn
                          color="primary"
                          text="Salvar"
                          type="submit"
                          @click="dialog = false"
                        ></v-btn>
                      </v-card-actions>
                    </v-card>
                  </template>
                </v-dialog>  
            </v-card>
        </v-container>
    </template>

    <script setup>
    import { ref } from 'vue' 
    import { useRouter } from 'vue-router' 

    const formFields = ref([
      { label: "Nome", type:"text", model: ref(""), required: true},
      { label: "E-mail", type:"text", model: ref(""), required: true},
      { label: "Telefone", type:"text", model: ref(""), required: true},
      { label: "CEP", type:"text", model: ref(""), required: true},
      { label: "Logradouro", type:"text", model: ref(""), required: true},
      { label: "Número", type:"number", model: ref(""), required: true},
      { label: "Bairro", type:"text", model: ref(""), required: true},
      { label: "Cidade", type:"text", model: ref(""), required: true},
      { label: "Estado", type:"text", model: ref(""), required: true}
    ])

    const headers = ([
      { title: "Nome", key:"nome"},
      { title: "E-mail", key:"email"},
      { title: "Telefone", key:"telefone"},
      { title: "CEP", key:"cep"},
      { title: "Logradouro", key:"logradouro"},
      { title: "Número", key:"numero"},
      { title: "Bairro", key:"bairro"},
      { title: "Cidade", key:"cidade"},
      { title: "Estado", key:"estado"},
      { title: "Ações", key:"acoes"},
    ])

    const contatos = ([
      { nome: "Chambelo", email:"vinicius13@prolins.com.br", telefone:"(85) 94002-8922", cep:"60821-075", logradouro:"Av. Rogaciano Leite", numero:"2285", bairro:"Luciano Cavalcante", cidade:"Fortaleza", estado:"Ceará", acoes:""},
      { nome: "Nome", email:"nome", telefone:"bdjajksa", cep:"bdjajksa", logradouro:"bdjajksa", numero:"bdjajksa", bairro:"bdjajksa", cidade:"bdjajksa", estado:"bdjajksa", acoes:"bdjajksa"},
      { nome: "Nome", email:"nome", telefone:"bdjajksa", cep:"bdjajksa", logradouro:"bdjajksa", numero:"bdjajksa", bairro:"bdjajksa", cidade:"bdjajksa", estado:"bdjajksa", acoes:"bdjajksa"}
    ])

    const nome = ref('')
    const cep = ref('')
    const router = useRouter()



    const dialog = ref(false)

    function cadastro(){
        if(nome.value && cep.value){
            router.push('/sucesso')
        } else {
            alert('Preencha todos os campos!')
        }
    }
    </script>

    <style scoped>
    .text-red123 {
        color: red !important;
    }
    </style>


