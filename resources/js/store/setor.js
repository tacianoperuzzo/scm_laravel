import { defineStore } from 'pinia'

class Setor {
  id = 0
  descricao = null
  sigla = null
}

export const useSetorStore = defineStore('setor', {
  state: () => ({
    setor: null
  }),
  getters: {
    getEfetivo: (state) => state.setor,
  },
  actions: {
    setSetor(data) {
      this.setor = data
    },
    newSetor() {
      this.setor = new Setor()
    }
  },
})
