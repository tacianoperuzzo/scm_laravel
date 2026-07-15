<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue';

interface Shortcut {
    title: string;
    icon: string;
    color: string;
    route: string;
}

// Array atualizado com 6 funcionalidades
const shortcuts = ref<Shortcut[]>([
    { title: 'Gerenciar Usuários', icon: 'pi pi-users', color: '#3B82F6', route: 'users.index' },       // Azul
    { title: 'Ofícios', icon: 'pi pi-file', color: '#EF4444', route: 'oficios.index' },                   // Vermelho
    { title: 'Relatório de Serviço', icon: 'pi pi-clipboard', color: '#14B8A6', route: 'dashboard' },  // Verde-azulado (Teal)
    { title: 'Relatórios Financeiros', icon: 'pi pi-chart-bar', color: '#10B981', route: 'dashboard' }, // Verde
    { title: 'Caixa de Mensagens', icon: 'pi pi-envelope', color: '#F59E0B', route: 'dashboard' },    // Laranja
    { title: 'Configurações', icon: 'pi pi-cog', color: '#8B5CF6', route: 'settings' },              // Roxo
]);

const acessarFuncionalidade = (rota: string): void => {
    router.get(route(rota));
};

</script>
<template>

    <Head title="Funções" />
    <div class="p-2 md:p-4">

        <!-- Grid ajustado para 6 itens:
         - Mobile (padrão): 1 coluna
         - sm (tablets pequenos): 2 colunas
         - lg (desktops): 3 colunas (cria duas linhas perfeitas de 3 itens) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 max-w-7xl mx-auto">

            <Card v-for="(item, index) in shortcuts" :key="index"
                class="cursor-pointer transition-all duration-200 text-center rounded-xl hover:-translate-y-1 hover:shadow-lg"
                @click="acessarFuncionalidade(item.route)">
                <template #content>
                    <div class="flex flex-col items-center justify-center p-4 sm:p-6">
                        <i :class="[item.icon, 'mb-3 sm:mb-4 text-5xl md:text-6xl']"
                            :style="{ color: item.color, fontSize: '3.5rem' }"></i>
                        <h3 class="m-0 text-slate-600 font-semibold text-base sm:text-lg">
                            {{ item.title }}
                        </h3>
                    </div>
                </template>
            </Card>

        </div>
    </div>
</template>
