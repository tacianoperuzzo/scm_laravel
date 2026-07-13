import api from '@/services/api'
import { defineStore } from 'pinia'

class Usuario {
  id = 0
  cpf = ''
  ativo = 1
  nivel_permissao_id = 1
}

export const useUsuarioStore = defineStore('usuario', {
  state: () => ({
    usuario: null,
    errors: null
  }),
  getters: {
    getUsuario: (state) => state.usuario,
    getErrors: (state) => state.errors,
  },
  actions: {
    setUsuario(data) {
      this.usuario = data
    },
    setErrors(data) {
      this.errors = data
    },
    newUsuario() {
      this.usuario = new Usuario()
    },
    async enviaEmailRecuperacaoSenha(id) {
        return await api.post(route('user.enviaEmailRecuperacaoSenha', {id: id}))
        .then(res=>res.data)
        .catch(err=>err)
    }
  },
})
