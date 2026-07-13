<script setup lang="ts">
import { Form, router } from '@inertiajs/vue3';
import { reactive, ref, watch, inject } from 'vue';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';
import { useRelatorioServicoStore } from '@/store/relatorio_servico';

const toast = useToast();
const auth = inject('auth');
const relatorioServicoStore = useRelatorioServicoStore();
const _dialog = reactive({
    show: true,
    title: '',
})

const closeDialog = () => {
    router.reload();
}

const _relatorio = ref({
    dataInicio: null,
    dataFim: null,
    substituto: 'ST PM Mat 000000-1 Fulano',
    assinatura: null,
});

watch(() => relatorioServicoStore.preModel, (preModel) => {
    if (preModel) {
        _relatorio.value = preModel;
        _dialog.title = relatorioServicoStore.model?.id ? 'editando' : 'novo'
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})

</script>

<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="'Novo relatório de Serviço'" :class="'w-4/6'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">
        <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
            <Form method="post" :action="route('relatorio-servico.store')" class="p-fluid" #default="{ errors }">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="dataInicio">
                        <FloatLabel variant="on">
                            <DatePicker v-model="_relatorio.dataInicio" inputId="iDatainicio" showIcon
                                iconDisplay="input" fluid variant="filled" :invalid="('dataInicio' in errors)"
                                dateFormat="dd 'de' MM 'de' yy" showButtonBar />
                            <label for="iDatainicio">Data inicial</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="dataFim">
                        <FloatLabel variant="on">
                            <DatePicker v-model="_relatorio.dataFim" inputId="iDatafim" showIcon iconDisplay="input"
                                fluid variant="filled" :invalid="('dataFim' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                showButtonBar />
                            <label for="iDatafim">Data final</label>
                        </FloatLabel>
                    </cInputUI>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <cInputUI :errors="errors" field="substituto">
                        <FloatLabel variant="on">
                            <InputText v-model="_relatorio.substituto" inputId="iSubstituto" fluid variant="filled"
                                :invalid="('substituto' in errors)" />
                            <label for="iSubstituto">Substituto</label>
                        </FloatLabel>
                    </cInputUI>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <cInputUI :errors="errors" field="assinatura">
                        <FloatLabel variant="on">
                            <Textarea v-model="_relatorio.assinatura" inputId="iAssinatura" autoResize rows="3" fluid
                                variant="filled" :invalid="('assinatura' in errors)" />
                            <label for="iAssinatura">Assinatura</label>
                        </FloatLabel>
                    </cInputUI>
                </div>
                <Button type="submit" label="Salvar" />
            </Form>
        </Panel>
    </Dialog>
</template>
