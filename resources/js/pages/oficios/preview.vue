<script setup>
import { useOficioStore } from '@/store/oficio';
import { onBeforeUnmount, onMounted, ref } from 'vue';

const oficioStore = useOficioStore();

const urlPDF = ref('');

onMounted(() => {
    if (oficioStore.oficio) {
        oficioStore.getPreviewUrl(oficioStore.oficio).then((res) => {
            urlPDF.value = res.data.url;
        }).catch((err) => {
            console.log(err)
        }).finally(() => {
        });
    }
});

onBeforeUnmount(() => {
    if (urlPDF.value) {
        oficioStore.deletePreview(urlPDF.value);
    }
})

</script>
<template>
    <Panel v-if="urlPDF"
        :pt="{ root: 'pt-4', header: 'hidden!', contentContainer: 'min-h-100 h-full', content: 'min-h-100 h-full' }"
        class="min-h-100 h-full">
        <embed :src="urlPDF + '#toolbar=0'" type="application/pdf" class="w-full h-full" frameborder="0"></embed>
    </Panel>
    <Card v-else>
        <template #content>
            <Message severity="info" icon="pi pi-spin pi-spinner" variant="simple">Carregando pré-visualização...
            </Message>
        </template>
    </Card>
</template>
