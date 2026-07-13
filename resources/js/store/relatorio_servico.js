import { defineStore } from 'pinia'

class RelatorioSv {
  id = 0
  numero = ''
  data_pre = ''
  data_pos = ''
  visto = 'Cristofer Tiemann - Major PM\nCoordenador de Segurança da CM'
  escalas = '1.1 - Sem alteração.\n\n' +
            '(UTILIZE OS MODELOS ABAIXO OU REMOVA O CONTEÚDO CASO NÃO SEJA UTILIZADO)\n\n' +
            '1.x (alterar a numeração) - O Cb PM 900000-2 Fulano trabalhou das 20h30 às 04h em reforço ao policiamento.\n\n' +
            '1.x (alterar a numeração) - O Cb PM 900000-2 Fulano trabalhou das 20h30 às 07h em em substituição ao Sgt PM 900000-1 Beltrano, autorizado pelo Coordenador de Segurança.'
  alteracoes = '2.1 - Sem alteração.\n\n' +
               '(UTILIZE OS MODELOS ABAIXO OU REMOVA O CONTEÚDO CASO NÃO SEJA UTILIZADO)\n\n' +
               '2.x (alterar a numeração) - No dia 09 de Julho de 2026 por volta de 20h30 ocorreu uma alteração no bloco I do Centro Administrativo, onde o Sr. Fulano de Tal, RG, CPF, telefone (tentar pegar o máximo de informações sobre o indíviduo), (explicar detalhadamente a situação). Foi feito contato com o Coordenador de Segurança e chamada a Gu PM da área para condução e demais procedimentos cabíveis.'
  equipamentos = '3.1. - Armeiro - Cb PM 900000-0 Fulano das 07h às 20h30/3°Sgt PM 300000-8 Beltrano das 20h30 às 07h.\n\n' +
                 '(UTILIZE OS MODELOS ABAIXO OU REMOVA O CONTEÚDO CASO NÃO SEJA UTILIZADO)\n\n' +
                 '3.x (alterar a numeração) - O Cb PM 920000-3 Fulano, da Coordenadoria de Transportes, retirou a pistola PT 100/940/640/24/7 n. SKX 42000 com xx munições no dia 09 de Julho de 2026 às 15h, conforme autorização do Coordenador de Segurança da CM.\n\n' +
                 '3.x (alterar a numeração) - O Cb PM 920000-3 Fulano, da Coordenadoria de Transportes, devolveu a pistola PT 100/940/640/24/7 n. SKX 42000 no 09 de Julho de 2026 às 15h.'
  instalacoes = '4.1 - Sem alteração.\n\n' +
                '(UTILIZE OS MODELOS ABAIXO OU REMOVA O CONTEÚDO CASO NÃO SEJA UTILIZADO)\n\n' +
                '4.x (alterar a numeração) - No dia 09 de Julho de 2026 por volta de 20h30 ocorreu uma queda de energia no bloco I, danificando equipamentos...\n\n' +
                '4.x (alterar a numeração) - No dia 09 de Julho de 2026 por volta de 15h a câmera X parou de funcionar. Foi realizado contato com a empresa Coringa, através do Sr. Fulano (colocar contato), que realizou manutenção no equipamento conforme ordem de serviço anexa/que virá no dia seguinte para realizar a manutenção do equipamento.'
  substituto = 'ST PM Mat 000000-1 Fulano'
  local_data = ''
  assinatura = ''
}

export const useRelatorioServicoStore = defineStore('relatorioServico', {
  state: () => ({
    preModel: null,
    model: null,
    errors: null
  }),
  getters: {
    getPreModel: (state) => state.preModel,
    getModel: (state) => state.model,
    getErrors: (state) => state.errors,
  },
  actions: {
    setPreModel(data) {
      this.preModel = data
    },
    setModel(data) {
      this.model = data
    },
    setErrors(data) {
      this.errors = data
    },
    newModel() {
      this.model = new RelatorioSv()
    },
  },
})
