import { defineStore } from 'pinia'
import Pessoa from './pessoa'

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
    }
  },
})
