import { defineStore } from 'pinia'

class Usuario {
  id = 0
  cpf = ''
  active = 1
  pessoa = {
    id: 0,
    nome: '',
    email: '',
  }
}

export const useUsuarioStore = defineStore('usuario', {
  state: () => ({
    usuario: null
  }),
  getters: {
    getUsuario: (state) => state.usuario,
  },
  actions: {
    setUsuario(data) {
      this.usuario = data
    },
    newUsuario() {
      this.usuario = new Usuario()
    }
  },
})
