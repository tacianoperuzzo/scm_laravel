import 'vue-sonner/style.css'
import 'primeicons/primeicons.css'
import 'quill/dist/quill.snow.css'
import './css/app.css'
import { client } from '~/client'
import Layout from '~/layout/AppDashboard.vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { TuyauProvider } from '@adonisjs/inertia/vue'
import { createApp, type DefineComponent, h } from 'vue'
import { resolvePageComponent } from '@adonisjs/inertia/helpers'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import ToastService from 'primevue/toastservice';
import DialogService from 'primevue/dialogservice';
import ConfirmationService from 'primevue/confirmationservice';

const appName = import.meta.env.VITE_APP_NAME || 'SCM'

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) => {
    return resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./pages/**/*.vue'),
      Layout
    )
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(TuyauProvider, { client }, { default: () => h(App, props) }) })
    const pinia = createPinia()
    app.use(plugin)
      .use(PrimeVue, {
          theme: {
            preset: Aura,
            options: {
              darkModeSelector: '.dark-mode',
            }
          },
          locale: {
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            today: 'Hoje',
            clear: 'Limpar',
          }
      })
      .use(ToastService)
      .use(DialogService)
      .use(ConfirmationService)
      .use(pinia)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
})
