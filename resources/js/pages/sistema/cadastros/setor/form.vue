<script setup lang="ts">
import { Form, router } from '@inertiajs/vue3';
import { reactive, ref, watch } from 'vue';
import { useSetorStore } from '@/store/setor';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';

const toast = useToast();
const setorStore = useSetorStore();
const _dialog = reactive({
    show: false,
    title: undefined,
})

const _setor = ref(null);

const closeDialog = () => {
    setorStore.setSetor(null);
    router.reload();
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Setor salvo com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

watch(() => setorStore.setor, (newSetor) => {
    if (newSetor) {
        _setor.value = newSetor;
        _dialog.title = setorStore.setor?.id ? setorStore.setor?.descricao : 'Novo setor'
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
            <Form :action="_setor.id ? route('setores.update', { id: _setor.id }) : route('setores.store')"
                #default="{ errors }" :method="_setor.id ? 'PUT' : 'POST'" @success="handleSuccess"
                @error="handleError">

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="descricao" class="col-span-2">
                        <FloatLabel variant="on">
                            <InputText id="iDescricao" name="descricao" v-model="_setor.descricao" fluid
                                variant="filled" :invalid="('descricao' in errors)" />
                            <label for="iDescricao">Descrição</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="sigla">
                        <FloatLabel variant="on">
                            <InputText id="iSigla" name="sigla" v-model="_setor.sigla" fluid variant="filled"
                                :invalid="('sigla' in errors)" />
                            <label for="iSigla">Sigla</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="flex items-center justify-end gap-4 w-full">
                    <Button type="button" label="Cancelar" icon="pi pi-times" severity="secondary"
                        @click="closeDialog" />
                    <Button type="submit" label="Salvar" icon="pi pi-check" severity="success" />
                </div>
            </Form>
        </Panel>
    </Dialog>
</template>
