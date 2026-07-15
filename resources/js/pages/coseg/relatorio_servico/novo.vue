<script setup>
import { Form, router } from '@inertiajs/vue3';
import { reactive, ref, watch, inject } from 'vue';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';
import { useRelatorioServicoStore } from '@/store/relatorio_servico';

const toast = useToast();
const auth = inject('auth');
const relatorioServicoStore = useRelatorioServicoStore();
const _dialog = reactive({
    show: false,
    title: 'Novo relatório de Serviço',
})

const closeDialog = () => {
    relatorioServicoStore.setPreModel(null);
    router.reload();
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Relatório de Serviço salvo com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

const _relatorio = ref(null);

const formatData = (data) => {
    data.data_pre = _relatorio.value.data_pre;
    data.data_pos = _relatorio.value.data_pos;
    return data;
}

watch(() => relatorioServicoStore.preModel, (preModel) => {
    if (preModel) {
        _relatorio.value = preModel;
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})

</script>

<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="_dialog.title" :class="'w-4/6'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">
        <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
            <Form method="post" :action="route('relatorio-servico.store')" class="p-fluid" #default="{ errors }"
                :transform="formatData" @success="handleSuccess" @error="handleError">
                <input type="hidden" name="numero" v-model="_relatorio.numero" />
                <input type="hidden" name="visto" v-model="_relatorio.visto" />
                <input type="hidden" name="escalas" v-model="_relatorio.escalas" />
                <input type="hidden" name="alteracoes" v-model="_relatorio.alteracoes" />
                <input type="hidden" name="equipamentos" v-model="_relatorio.equipamentos" />
                <input type="hidden" name="instalacoes" v-model="_relatorio.instalacoes" />
                <input type="hidden" name="remetente" v-model="_relatorio.remetente" />
                <input type="hidden" name="local_data" v-model="_relatorio.local_data" />

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="data_pre">
                        <FloatLabel variant="on">
                            <DatePicker v-model="_relatorio.data_pre" name="data_pre" showIcon iconDisplay="input" fluid
                                variant="filled" :invalid="('data_pre' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                showButtonBar />
                            <label>Data inicial</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="data_pos">
                        <FloatLabel variant="on">
                            <DatePicker v-model="_relatorio.data_pos" name="data_pos" showIcon iconDisplay="input" fluid
                                variant="filled" :invalid="('data_pos' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                showButtonBar />
                            <label>Data final</label>
                        </FloatLabel>
                    </cInputUI>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <cInputUI :errors="errors" field="substituto">
                        <FloatLabel variant="on">
                            <InputText v-model="_relatorio.substituto" name="substituto" fluid variant="filled"
                                :invalid="('substituto' in errors)" />
                            <label for="iSubstituto">Substituto</label>
                        </FloatLabel>
                    </cInputUI>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <cInputUI :errors="errors" field="assinatura">
                        <FloatLabel variant="on">
                            <Textarea v-model="_relatorio.assinatura" name="assinatura" autoResize rows="3" fluid
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
