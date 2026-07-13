<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { FilterMatchMode } from '@primevue/core/api';
import { ref, watch } from 'vue';
import FormRelatorioServico from 'pages/coseg/relatorio_servico/form.vue';
import NovoRelatorioServico from 'pages/coseg/relatorio_servico/novo.vue';
import { useRelatorioServicoStore } from '@/store/relatorio_servico';

const props = defineProps<{
    listagem: object[],
    model?: object | null,
    errors?: any | null
}>()

const relatorioServicoStore = useRelatorioServicoStore();
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const novoRelatorio = () => {
    relatorioServicoStore.newModel();
};

const getRelatorioServico = (event: any) => {
    relatorioServicoStore.setModel(event?.data ?? null);
};

watch(() => props.model, async (newModel) => {
    if (!relatorioServicoStore.model && newModel) {
        relatorioServicoStore.setModel(newModel);
    }
})

</script>

<template>

    <Head title="Relatório de Serviço" />
    <DataTable v-model:filters="filters" :value="listagem" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id"
        :globalFilterFields="['data', 'numero', 'remetente', 'substituto', 'escalas', 'alteracoes', 'equipamentos', 'instalacoes']"
        :paginator="true" :rows="20" :rowsPerPageOptions="[5, 10, 20, 50, 100]" @rowSelect="getRelatorioServico">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-start">
                <h4 class="text-2xl font-bold">Relatórios de Serviço</h4>
                <InputGroup class="sm:w-md! mx-auto">
                    <InputGroupAddon>
                        <i class="pi pi-search" />
                    </InputGroupAddon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" showClear />
                    <InputGroupAddon>
                        <Button icon="pi pi-times" severity="secondary" @click="filters['global'].value = null" />
                    </InputGroupAddon>
                </InputGroup>
                <Button label="Novo relatório" icon="pi pi-plus" size="small" @click="novoRelatorio" raised />
            </div>
        </template>
        <Column field="numero" header="Número" sortable></Column>
        <Column header="Data">
            <template #body="slotProps">
                {{ slotProps.data.data_pre }} para {{ slotProps.data.data_pos }}
            </template>
        </Column>
        <Column field="remetente" header="Remetente" sortable></Column>
        <Column field="substituto" header="Substituto" sortable></Column>
        <Column class="w-auto flex justify-end gap-2">
            <template #body="slotProps">
                <Button as="a" icon="pi pi-file-pdf" severity="danger" v-tooltip.top="'Abrir PDF'"
                    :href="route('oficios.show', { id: slotProps.data.id })" target="_blank" rounded></Button>
            </template>
        </Column>
    </DataTable>
    <NovoRelatorioServico :errors="props.errors" />
    <FormRelatorioServico :errors="props.errors" />
</template>
