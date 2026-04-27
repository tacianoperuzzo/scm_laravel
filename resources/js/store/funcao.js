import { defineStore } from 'pinia'

class Funcao {
  id = 0
  descricao = null
}

export const useFuncaoStore = defineStore('funcao', {
  state: () => ({
    funcao: null
  }),
  getters: {
    getFuncao: (state) => state.funcao,
  },
  actions: {
    setFuncao(data) {
      this.funcao = data
    },
    newFuncao() {
      this.funcao = new Funcao()
    }
  },
})
