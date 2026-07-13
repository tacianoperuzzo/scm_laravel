<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { useConfirm } from "primevue/useconfirm";
import { useSetorStore } from '@/store/setor';
import { useToast } from "primevue/usetoast";
import setorForm from './form.vue';

const props = defineProps<{ setores: object[], setor?: object | null }>();
const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const setorStore = useSetorStore();
const confirm = useConfirm();
const toast = useToast();

const getSetor = (event: any) => {
    router.reload({ only: ['setor'], data: { id: event?.data?.id ?? null }, preserveUrl: true });
};

const newSetor = () => {
    setorStore.newSetor();
}

const confirmarExcluir = (id: Number) => {
    confirm.require({
        message: 'Confirma excluir o setor?',
        header: 'Excluir setor?',
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
            router.delete(route('setores.destroy', { id }), {
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

watch(() => props.setor, async (newSetor) => {
    if (!setorStore.setor && newSetor) {
        setorStore.setSetor(newSetor);
    }
})

</script>

<template>

    <Head title="Setores" />
    <DataTable v-model:filters="filters" :value="setores" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id" :globalFilterFields="['descricao', 'abreviatura']" :paginator="true"
        :rows="20" :rowsPerPageOptions="[5, 10, 20, 50, 100]" @rowSelect="getSetor">
        <template #header>
            <div class="flex flex-wrap gap-2 items-center justify-start">
                <h4 class="text-2xl font-bold">Setores</h4>
                <IconField class="mx-auto">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" />
                </IconField>
                <Button label="Novo setor" icon="pi pi-plus" size="small" @click="newSetor" raised />
            </div>
        </template>
        <Column field="id" header="Id"></Column>
        <Column field="descricao" header="Descrição" sortable></Column>
        <Column field="abreviatura" header="Abreviatura" sortable></Column>
        <Column class="w-auto flex justify-end gap-2">
            <template #body="slotProps">
                <Button icon="pi pi-trash" severity="danger" v-tooltip.top="'Excluir'"
                    @click="confirmarExcluir(slotProps.data.id)" rounded />
            </template>
        </Column>
    </DataTable>
    <setor-form />
</template>
