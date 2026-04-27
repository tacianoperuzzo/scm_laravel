<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Data } from '@/generated/data';
import { FilterMatchMode } from '@primevue/core/api';
import { ref, watch } from 'vue';
import { useEfetivoStore } from '@/store/efetivo';
import FormEfetivo from './form.vue';

const props = defineProps<{
    efetivos: Data.Efetivo[],
    efetivo?: Data.Efetivo | null,
    cargos: Data.Cargo[],
    errors?: any | null
}>()

const efetivoStore = useEfetivoStore();
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const novoEfetivo = () => {
    efetivoStore.newEfetivo();
}

watch(() => props.efetivo, (newEfetivo) => {
    if (newEfetivo) {
        efetivoStore.setEfetivo(newEfetivo);
    }
});

</script>
<template>

    <Head title="Efetivos" />
    <DataTable v-model:filters="filters" :value="efetivos" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id" :globalFilterFields="['name', 'cpf', 'email']" :paginator="true" :rows="20"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]">
        <template #header>
            <div class="flex flex-wrap gap-2 items-center justify-start">
                <h4 class="text-2xl font-bold">Efetivo</h4>
                <IconField class="mx-auto">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" />
                </IconField>
                <Button label="Novo efetivo" icon="pi pi-plus" size="small" @click="novoEfetivo" raised />
            </div>
        </template>
        <Column field="pessoa.nome" header="Nome" sortable></Column>
        <Column field="pessoa.email" header="Email" sortable></Column>
        <Column field="active" header="Ativo" sortable>
            <template #body="slotProps">
                <span v-if="slotProps.data.active" class="text-green-500 font-bold">Sim</span>
                <span v-else class="text-red-500 font-bold">Não</span>
            </template>
        </Column>
        <Column class="w-auto text-end!">
            <template #body="slotProps">
                <Button v-if="slotProps.data.active" icon="pi pi-times" class="mr-2" severity="secondary"
                    v-tooltip.top="'Desativar'" rounded @click="setStatus(slotProps.data.id, false)" />
                <Button v-else icon="pi pi-check" class="mr-2" severity="secondary" v-tooltip.top="'Ativar'" rounded
                    @click="setStatus(slotProps.data.id, true)" />
                <Button icon="pi pi-trash" severity="danger" v-tooltip.top="'Excluir'" rounded
                    @click="excluir(slotProps.data.id)" disabled />
            </template>
        </Column>
    </DataTable>
    <FormEfetivo :cargos="cargos" />
</template>
