<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from "primevue/useconfirm";
import { useFuncaoStore } from '@/store/funcao';
import { useToast } from "primevue/usetoast";
import funcaoForm from './form.vue';

const props = defineProps<{ funcoes: object[], funcao?: object | null }>();
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const funcaoStore = useFuncaoStore();
const confirm = useConfirm();
const toast = useToast();

const getFuncao = (event: any) => {
    router.reload({ only: ['funcao'], data: { id: event?.data?.id ?? null }, preserveUrl: true });
};

const newFuncao = () => {
    funcaoStore.newFuncao();
}

const confirmarExcluir = (id: Number) => {
    confirm.require({
        message: 'Confirma excluir a função?',
        header: 'Excluir função?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Excluir',
            severity: 'danger'
        },
        accept: () => {
            router.delete(route('funcoes.destroy', { id }), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Success', detail: 'Status atualizado', life: 3000 });
                },
                onError: () => {
                    toast.add({ severity: 'error', summary: 'Error', detail: 'Erro ao atualizar status', life: 3000 });
                }
            });
        },
    });
};

watch(() => props.funcao, async (newFuncao) => {
    if (!funcaoStore.funcao && newFuncao) {
        funcaoStore.setFuncao(newFuncao);
    }
})

</script>

<template>

    <Head title="Funções" />
    <DataTable v-model:filters="filters" :value="funcoes" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id" :globalFilterFields="['descricao', 'abreviatura']" :paginator="true"
        :rows="20" :rowsPerPageOptions="[5, 10, 20, 50, 100]" @rowSelect="getFuncao">
        <template #header>
            <div class="flex flex-wrap gap-2 items-center justify-start">
                <h4 class="text-2xl font-bold">Funções</h4>
                <IconField class="mx-auto">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" />
                </IconField>
                <Button label="Nova função" icon="pi pi-plus" size="small" @click="newFuncao" raised />
            </div>
        </template>
        <Column field="id" header="Id"></Column>
        <Column field="descricao" header="Descrição" sortable></Column>
        <Column class="w-auto flex justify-end gap-2">
            <template #body="slotProps">
                <Button icon="pi pi-trash" severity="danger" v-tooltip.top="'Excluir'"
                    @click="confirmarExcluir(slotProps.data.id)" rounded />
            </template>
        </Column>
    </DataTable>
    <funcao-form />
</template>
