<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import { router } from '@inertiajs/vue3';
import FormOficio from './form.vue';
import Tooltip from 'primevue/tooltip';
import { useOficioStore } from '@/store/oficio';

const props = defineProps({
    oficios: Array,
    oficio: Object || null,
    openID: String || null,
});

const vTooltip = Tooltip;
const oficioStore = useOficioStore();

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const getOficio = (event) => {
    router.reload({ only: ['oficio'], data: { id: event?.data?.id ?? null }, preserveUrl: true });
};

const newOficio = () => {
    oficioStore.newOficio();
}

const clonarOficio = (event) => {
    router.reload({ only: ['oficio'], data: { id: event?.id ?? null, clonar: true }, preserveUrl: true });
};

watch(() => props.oficio, async (newOficio) => {
    if (!oficioStore.oficio && newOficio) {
        oficioStore.setOficio(newOficio);
    }
})

watch(() => props.openID, async (newID) => {
    if (newID && newID !== '0') {
        setTimeout(() => {
            window.open(route('oficios.show', { id: newID }), '_blank');
        }, 1000);
    }
})

</script>
<template>

    <Head title="Ofícios" />
    <DataTable v-model:filters="filters" :value="oficios" size="normal" stripedRows class="p-datatable-sm"
        selectionMode="single" dataKey="id" :globalFilterFields="['data', 'numero', 'destinatario', 'assunto', 'autor']"
        :paginator="true" :rows="20" :rowsPerPageOptions="[5, 10, 20, 50, 100]" @rowSelect="getOficio">
        <template #header>
            <div class="flex flex-wrap gap-4 items-center justify-start">
                <h4 class="text-2xl font-bold">Ofícios</h4>
                <InputGroup class="sm:w-md! mx-auto">
                    <InputGroupAddon>
                        <i class="pi pi-search" />
                    </InputGroupAddon>
                    <InputText v-model="filters['global'].value" placeholder="Busca..." class="w-100" showClear />
                    <InputGroupAddon>
                        <Button icon="pi pi-times" severity="secondary" @click="filters['global'].value = null" />
                    </InputGroupAddon>
                </InputGroup>
                <Button label="Novo ofício" icon="pi pi-plus" size="small" @click="newOficio" raised />
            </div>
        </template>
        <Column field="numeroCompleto" header="Número">
        </Column>
        <Column field="dataExtenso" header="Data">
        </Column>
        <Column field="destinatario" header="Destinatário"></Column>
        <Column field="assunto" header="Assunto"></Column>
        <Column field="autor" header="Autor"></Column>
        <Column class="w-auto flex justify-end gap-2">
            <template #body="slotProps">
                <Button icon="pi pi-copy" severity="secondary" v-tooltip.top="'Clonar'" rounded
                    @click="clonarOficio(slotProps.data)" />
                <Button as="a" icon="pi pi-file-pdf" severity="danger" v-tooltip.top="'Abrir PDF'"
                    :href="route('oficios.show', { id: slotProps.data.id })" target="_blank" rounded></Button>
            </template>
        </Column>
    </DataTable>
    <FormOficio />
</template>
