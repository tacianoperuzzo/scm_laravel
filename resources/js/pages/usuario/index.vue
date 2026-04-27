<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { FilterMatchMode } from '@primevue/core/api';
import { ref, watch } from 'vue';
import FormUsuario from './form.vue';
import { router } from '@inertiajs/vue3';
import { useUsuarioStore } from '@/store/usuario';
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";

const props = defineProps<{ usuarios: object[], usuario?: object | null, errors?: any | null }>()

const usuarioStore = useUsuarioStore();
const confirm = useConfirm();
const toast = useToast();

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const getUsuario = (event: any) => {
    router.reload({ only: ['usuario'], data: { id: event?.data?.id ?? null }, preserveUrl: true });
};

const newUsuario = () => {
    usuarioStore.newUsuario();
}

const setStatus = (id: number, ativar: boolean) => {
    confirm.require({
        message: 'Confirmar alteração de status do usuário?',
        header: ativar ? 'Ativar usuário?' : 'Desativar usuário?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: ativar ? 'Ativar' : 'Desativar',
            severity: ativar ? 'success' : 'danger'
        },
        accept: () => {
            router.put(route('user.status', { id }), { active: ativar ? 1 : 0 }, {
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

const excluir = (id: number) => {
    confirm.require({
        message: 'Confirmar exclusão do login do usuário?',
        header: 'Excluir usuário?',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancelar',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Excluir',
            severity: 'danger'
        },
        accept: () => {
            toast.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
};

watch(() => props.usuario, async (newUsuario) => {
    if (!usuarioStore.usuario && newUsuario) {
        usuarioStore.setUsuario(newUsuario);
    }
})

</script>
<template>

    <Head title="Usuários" />
    <DataTable v-model:filters="filters" :value="usuarios" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id" :globalFilterFields="['name', 'cpf', 'email']" :paginator="true" :rows="20"
        :rowsPerPageOptions="[5, 10, 20, 50, 100]" @rowSelect="getUsuario">
        <template #header>
            <div class="flex flex-wrap gap-2 items-center justify-start">
                <h4 class="text-2xl font-bold">Usuários</h4>
                <IconField class="mx-auto">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" />
                </IconField>
                <Button label="Novo usuário" icon="pi pi-plus" size="small" @click="newUsuario" raised />
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
        <Column class="w-auto flex justify-end gap-2">
            <template #body="slotProps">
                <Button v-if="slotProps.data.active" icon="pi pi-times" severity="secondary" v-tooltip.top="'Desativar'"
                    rounded @click="setStatus(slotProps.data.id, false)" />
                <Button v-else icon="pi pi-check" severity="secondary" v-tooltip.top="'Ativar'" rounded
                    @click="setStatus(slotProps.data.id, true)" />
                <Button icon="pi pi-trash" severity="danger" v-tooltip.top="'Excluir'" rounded
                    @click="excluir(slotProps.data.id)" disabled />
            </template>
        </Column>
    </DataTable>
    <FormUsuario />
</template>
