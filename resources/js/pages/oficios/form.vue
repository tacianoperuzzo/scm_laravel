<script setup>
import { Form } from '@inertiajs/vue3';
import Editor from '@tinymce/tinymce-vue';
import { useToast } from 'primevue/usetoast';
import { defineAsyncComponent, reactive, ref, watch, computed } from 'vue';
import OficioService from '@/services/OficioService';
import { useOficioStore } from '@/store/oficio';
import { useDialog } from 'primevue/usedialog';
import cInputUI from '@/components/ui/cInputUI.vue';

const previewDialog = defineAsyncComponent(() => import('./preview.vue'));

const oficioStore = useOficioStore();
const dialogService = useDialog();
const _dialog = reactive({
    show: false,
    title: undefined,
});
const _oficio = ref(null);

const toast = useToast();
const previewPDF = ref(false);
const urlPDF = ref('');
const openPDF = ref(0);

const closeDialog = () => {
    oficioStore.setOficio(null);
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Ofício salvo com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

const canPreview = computed(() => {
    return _oficio.value?.data && _oficio.value?.destinatario && _oficio.value?.municipio && _oficio.value?.conteudo;
});

const openPreview = () => {
    const dialogRef = dialogService.open(previewDialog, {
        props: {
            header: 'Pré-visualização do ofício',
            style: { width: '75%' },
            modal: true,
            maximizable: true,
            breakpoints: { '1199px': '90vw', '575px': '95vw' },
        },
        onClose: () => {
            if (urlPDF.value) OficioService.deletePreview(urlPDF.value);
            urlPDF.value = '';
            previewPDF.value = false;
        }
    });
}

const formatData = (data) => {
    return {
        ...data,
        numero: _oficio.value?.numero ?? null,
        ano: (new Date(_oficio.value?.data)).getFullYear() ?? null,
        conteudo: _oficio.value?.conteudo ?? null,
        data: _oficio.value?.data ?? null
    }
}

watch(() => oficioStore.oficio, (newOficio) => {
    if (newOficio) {
        _dialog.title = oficioStore.oficio?.id ? `Ofício ${oficioStore.oficio?.numeroCompleto}` : 'Novo ofício'
        newOficio.data = new Date(newOficio.data)
        newOficio.data.setHours(newOficio.data.getHours() + 3);
        _oficio.value = newOficio;
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})

</script>
<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="_dialog.title" :class="'w-5/6'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">
        <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
            <Form :action="_oficio.id ? route('oficios.update', { id: _oficio.id }) : route('oficios.store')"
                #default="{ errors }" :method="_oficio.id ? 'PUT' : 'POST'" @success="handleSuccess"
                @error="handleError" :transform="formatData">
                <input type="hidden" name="openPDF" v-model="openPDF" />

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="data">
                        <FloatLabel variant="on">
                            <DatePicker v-model="_oficio.data" inputId="iData" showIcon iconDisplay="input" fluid
                                variant="filled" :invalid="('data' in errors)" dateFormat="dd 'de' MM 'de' yy"
                                showButtonBar />
                            <label for="iData">Data</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="tratamento">
                        <FloatLabel variant="on">
                            <InputText v-model="_oficio.tratamento" name="tratamento" fluid variant="filled"
                                :invalid="('tratamento' in errors)" />
                            <label for="iTratamento">Tratamento</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="destinatario">
                        <FloatLabel variant="on">
                            <InputText v-model="_oficio.destinatario" name="destinatario" fluid variant="filled"
                                :invalid="('destinatario' in errors)" />
                            <label for="iDestinatario">Destinatário</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="cargo">
                        <FloatLabel variant="on">
                            <InputText v-model="_oficio.cargo" name="cargo" fluid variant="filled"
                                :invalid="('cargo' in errors)" />
                            <label for="iCargo">Cargo</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <cInputUI :errors="errors" field="assunto">
                        <FloatLabel variant="on">
                            <InputText v-model="_oficio.assunto" name="assunto" fluid variant="filled"
                                :invalid="('assunto' in errors)" />
                            <label for="iAssunto">Assunto</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="municipio">
                        <FloatLabel variant="on">
                            <InputText v-model="_oficio.municipio" name="municipio" fluid variant="filled"
                                :invalid="('municipio' in errors)" />
                            <label for="iMunicipio">Município</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="mb-4" :class="{ 'p-invalid': ('conteudo' in errors) }">
                    <Editor v-model="_oficio.conteudo" name="conteudo" licenseKey="gpl"
                        tinymce-script-src="/libs/tinymce-7.7.2/tinymce.min.js" :init="{
                            height: 365,
                            menubar: false,
                            plugins: 'table lists image',
                            toolbar: [
                                'undo redo | bold italic underline strikethrough | identTextButton | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | table image | removeformat',
                            ],
                            statusbar: false,
                            promotion: false,
                            contextmenu: false,
                            language: 'pt_BR',
                            skin: 'oxide',
                            content_style: 'body { font-family:Arial,Helvetica,sans-serif; font-size:14px }',
                            formats: {
                                ident_block: { block: 'div', styles: { 'text-indent': '40px' }, wrapper: true }
                            },
                            setup: function (editor) {
                                editor.ui.registry.addButton('identTextButton', {
                                    icon: 'ltr',
                                    tooltip: 'Identar parágrafo',
                                    onAction: function () {
                                        editor.formatter.toggle('ident_block');
                                    }
                                });
                            }
                        }">
                    </Editor>
                </div>

                <div class="flex items-center justify-end gap-4 w-full">
                    <Button label="Pré-visualizar" icon="pi pi-eye" severity="info" @click="openPreview"
                        :disabled="!canPreview" />
                    <Button type="submit" label="Salvar" icon="pi pi-check" severity="success" @click="openPDF = 0" />
                    <Button type="submit" label="Salvar e abrir PDF" icon="pi pi-file-pdf" @click="openPDF = 1" />
                </div>
            </Form>
        </Panel>
    </Dialog>
    <DynamicDialog />
</template>

<style>
.p-invalid > .tox.tox-tinymce {
  border-width: 1px !important;
  border-color: #f87171 !important;
}

</style>
