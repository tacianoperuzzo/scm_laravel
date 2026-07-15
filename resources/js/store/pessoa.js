import api from '@/services/api'
import { defineStore } from 'pinia'

class Pessoa {
  id = 0
  cpf = ''
  nome = ''
  email = ''
  telefone = ''
  nascimento = null
  endereco = ''
  endereco_numero = ''
  endereco_complemento = ''
  endereco_municipio = ''
  endereco_cep = ''
  foto = ''
  foto_url = ''
  matricula = ''
  postograd_id = null
  corporacao = null
  setor_id = null
  funcao_id = null
  pasta = ''
  data_entrada = null
  data_saida = null
}

export const usePessoaStore = defineStore('pessoa', {
  state: () => ({
    pessoa: null
  }),
  getters: {
    getPessoa: (state) => state.pessoa,
  },
  actions: {
    setPessoa(data) {
      this.pessoa = data
    },
    newPessoa() {
      this.pessoa = new Pessoa()
    },
    async findPessoaByCpf(cpf) {
      return new Promise((response, reject)=>{
        api.get(route('pessoa.findByCpf', cpf)).then(res=>response(res.data)).catch(err=>reject(err))
      })
    },
    async uploadFoto(file) {
        return await
            api.post(route('pessoa.uploadFoto'), {file: file}, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
        .then(res=>res.data)
        .catch(err=>err)
    }
  },
})
