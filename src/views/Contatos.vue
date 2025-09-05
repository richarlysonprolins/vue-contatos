    <template>
        <v-container fluid class="fill-height d-flex align-center justify-center">
        <v-card width="425" class="pa-6">
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
                </v-list>
                
                <v-btn color="primary">Criar Contato</v-btn>
                <v-table>
    <thead>
      <tr>
        <th class="text-left">
          Nome
        </th>
        <th class="text-left">
          E-mail
        </th>
        <th class="text-left">
          Telefone
        </th>
        <th class="text-left">
          CEP
        </th>
        <th class="text-left">
          Logradouro
        </th>
        <th class="text-left">
          Número    
        </th>
        <th class="text-left">
          Bairro
        </th>
        <th class="text-left">
          Cidade
        </th>
        <th class="text-left">
          Estado
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="item in desserts"
        :key="item.name"
      >
        <td>{{ item.name }}</td>
        <td>{{ item.calories }}</td>
      </tr>
    </tbody>
  </v-table>
            </v-card>
        </v-container>
    </template>

    <script setup>
    import { ref } from 'vue' 
    import { useRouter } from 'vue-router' 

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


