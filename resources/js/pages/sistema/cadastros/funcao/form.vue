<script setup lang="ts">
import { Form, router } from '@inertiajs/vue3';
import { reactive, ref, watch, inject } from 'vue';
import { useFuncaoStore } from '@/store/funcao';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';

const toast = useToast();
const auth = inject('auth');
const funcaoStore = useFuncaoStore();
const _dialog = reactive({
    show: false,
    title: undefined,
})

const _funcao = ref<any>(null);

const closeDialog = () => {
    funcaoStore.setFuncao(null);
    router.reload();
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Função salva com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

watch(() => funcaoStore.funcao, (newFuncao) => {
    if (newFuncao) {
        _funcao.value = newFuncao;
        _dialog.title = funcaoStore.funcao?.id ? funcaoStore.funcao?.descricao : 'Nova função'
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
            <Form :action="_funcao?.id ? route('funcoes.update', { id: _funcao?.id }) : route('funcoes.store')"
                #default="{ errors }" :method="_funcao?.id ? 'PUT' : 'POST'" @success="handleSuccess"
                @error="handleError">

                <div class="grid grid-cols-1 mb-4">
                    <cInputUI :errors="errors" field="descricao">
                        <FloatLabel variant="on">
                            <InputText id="iDescricao" name="descricao" v-model="_funcao.descricao" fluid
                                variant="filled" :invalid="('descricao' in errors)" />
                            <label for="iDescricao">Descrição</label>
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
