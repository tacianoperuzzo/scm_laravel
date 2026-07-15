import { defineStore } from 'pinia'
import Pessoa from './pessoa'
import api from '@/services/api'

class Efetivo {
  id = 0
  pessoaId = 0
  matricula = ''
  postogradId = 0
  setorId = 0
  pasta = ''
  dataEntrada = null
  dataSaida = null
  pessoa = null
}

export const useEfetivoStore = defineStore('efetivo', {
  state: () => ({
    efetivo: null
  }),
  getters: {
    getEfetivo: (state) => state.efetivo,
  },
  actions: {
    setEfetivo(data) {
      this.efetivo = data
    },
    newEfetivo() {
      this.efetivo = new Efetivo()
      this.efetivo.pessoa = new Pessoa()
    },
    async findPessoaByCpf(cpf) {
      return new Promise((response, reject)=>{
        api.get(route('pessoa.findByCpf', cpf)).then(res=>response(res.data)).catch(err=>reject(err))
      })
    }
  },
})
