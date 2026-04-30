import { defineStore } from 'pinia'
import api from '@/services/api'

class Oficio {
  id = null
  numero = null
  ano = (new Date()).getFullYear()
  data = new Date()
  destinatario = ""
  assunto = ""
  tratamento = ""
  cargo = ""
  municipio = ""
  conteudo = ""
}

export const useOficioStore = defineStore('oficio', {
  state: () => ({
    oficio: null
  }),
  getters: {
    getOficio: (state) => state.oficio,

  },
  actions: {
    setOficio(data) {
      if (data) {
        data.data = data.data ? new Date(data.data) : null
      }
      this.oficio = data
    },
    newOficio() {
      this.oficio = new Oficio()
    },
    async getPreviewUrl(obj) {
      return new Promise((response, reject)=>{
        api.post(route('oficio.preview', {id: obj.id}), obj).then(res=>response(res)).catch(err=>reject(err))
      })
    },
    async deletePreview(file) {
      api.post(route('oficio.delete-preview'), {pdfFile: file}).then(()=>{})
    }
  },
})
