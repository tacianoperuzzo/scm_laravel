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
    show: false,
    title: '',
})

const form = ref(null);

const closeDialog = () => {
    relatorioServicoStore.setModel(null);
    router.reload();
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Relatório salvo com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

watch(() => relatorioServicoStore.model, (newRelatorio) => {
    if (newRelatorio) {
        form.value = newRelatorio;
        _dialog.title = relatorioServicoStore.model?.id ? 'editando' : 'novo'
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})

</script>
<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="'Relatório de Serviço'" :class="'w-5/6'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">

        <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
            <Form
                :action="form.id ? route('relatorio-servico.update', { id: form.id }) : route('relatorio-servico.store')"
                #default="{ errors }" :method="form.id ? 'PUT' : 'POST'" @success="handleSuccess" @error="handleError">
                <input type="hidden" name="id" v-model="form.id" />
                <div class="border border-gray-300 bg-white">
                    <!-- CABEÇALHO -->
                    <div class="flex flex-col md:flex-row border-b border-gray-300">
                        <div
                            class="w-full md:w-1/3 p-3 border-b md:border-b-0 md:border-r border-gray-300 flex flex-col items-center">
                            <span class="text-xs text-gray-600 mb-2 uppercase">Visto</span>
                            <Textarea v-model="form.visto" rows="3" readonly
                                class="w-full bg-gray-100 text-sm resize-none p-2 border border-gray-300 rounded focus:outline-none" />
                        </div>

                        <div class="w-full md:w-2/3 p-4 flex flex-col items-center justify-center text-center">
                            <div class="text-sm font-bold mb-3 leading-tight">
                                LIVRO DE PARTE 8 Nº 187 /CO 8EG/8CM/2026<br />
                                Casa D'Agronômica
                            </div>
                            <div class="flex items-center gap-2 mb-3 text-sm">
                                <span>Do dia</span>
                                <DatePicker v-model="form.data_pre" inputId="iDatainicio" showIcon iconDisplay="input"
                                    variant="filled" :invalid="('dataInicio' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                    showButtonBar />
                                <span>para</span>
                                <DatePicker v-model="form.data_pos" inputId="iDatafim" showIcon iconDisplay="input"
                                    variant="filled" :invalid="('dataFim' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                    showButtonBar />
                            </div>
                            <div class="text-xs text-gray-600">
                                Do Cmt da Guarda da Casa D'Agronômica ao Coordenador de Segurança da CM.
                            </div>
                        </div>
                    </div>

                    <!-- SEÇÕES DE TEXTO (Substituindo o Editor) -->
                    <div class="p-4 border-b border-gray-300 bg-gray-50">
                        <label class="block font-bold text-xs mb-2 uppercase">1. Escalas Extras:</label>
                        <Textarea v-model="form.escalas" rows="6"
                            class="w-full p-2 border border-gray-300 rounded text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div class="p-4 border-b border-gray-300 bg-gray-50">
                        <label class="block font-bold text-xs mb-2 uppercase">2. Alterações: (Ordens de Serviço,
                            Ocorrências e Substituição etc)</label>
                        <Textarea v-model="form.alteracoes" rows="6"
                            class="w-full p-2 border border-gray-300 rounded text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div class="p-4 border-b border-gray-300 bg-gray-50">
                        <label class="block font-bold text-xs mb-2 uppercase">3. Armas, Munições e Equipamentos:</label>
                        <Textarea v-model="form.equipamentos" rows="6"
                            class="w-full p-2 border border-gray-300 rounded text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div class="p-4 border-b border-gray-300 bg-gray-50">
                        <label class="block font-bold text-xs mb-2 uppercase">4. Instalações Físicas:</label>
                        <Textarea v-model="form.instalacoes" rows="6"
                            class="w-full p-2 border border-gray-300 rounded text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <!-- RODAPÉ E ASSINATURA -->
                    <div class="p-6">
                        <div class="text-sm leading-relaxed mb-4">
                            PASSAGEM DE SERVIÇO: Fiz ao meu substituto,
                            <InputText v-model="form.substituto"
                                class="w-full md:w-[400px] p-1 text-sm border border-gray-300 rounded mx-1 inline-block focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                            ,
                            ao qual transmiti todas as ordens em vigor, bem como fiz a entrega de todo o material que se
                            encontrava sob a minha responsabilidade. Florianópolis,
                            <InputText v-model="form.dataPassagem"
                                class="w-48 p-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                        <div class="flex justify-end mt-2">
                            <Textarea v-model="form.assinatura" rows="3"
                                class="w-full md:w-[400px] bg-gray-100 text-sm resize-none p-3 text-center border border-gray-300 rounded focus:outline-none" />
                        </div>
                    </div>
                </div>

                <!-- BOTÃO DE AÇÃO -->
                <div class="flex justify-center mt-6 mb-10">
                    <Button label="CADASTRAR"
                        class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-10 rounded border-none transition-colors duration-200"
                        @click="submitForm" />
                </div>
            </Form>
        </Panel>
    </Dialog>
</template>
