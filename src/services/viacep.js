import axios from 'axios'

export async function fetchAddressByCep(cep) {
    const digits = (cep || '').replace(/\D/g, '')
        if (digits.lenght !== 8) return null
        const { data } = await axios.get(`https://viacep.com.br/ws/${digits}/json/`)
        if(data.erro) return null
        return {
            logradouro: data.logradouro || '',
            bairro: data.bairro || '',
            cidade: data.cidade || '',
            estado: data.uf || ''
        }
}