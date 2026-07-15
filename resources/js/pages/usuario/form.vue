<script setup lang="ts">
import { Form, router } from '@inertiajs/vue3';
import { reactive, ref, watch, inject } from 'vue';
import { useUsuarioStore } from '@/store/usuario';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';

const toast = useToast();
const auth = inject('auth');
const usuarioStore = useUsuarioStore();
const _dialog = reactive({
    show: false,
    title: undefined,
})

const _usuario = ref(null);

const closeDialog = () => {
    usuarioStore.setUsuario(null);
    router.reload();
}

const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Usuário salvo com sucesso.', life: 3000 });
}

const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

watch(() => usuarioStore.usuario, (newUsuario) => {
    if (newUsuario) {
        _usuario.value = newUsuario;
        _dialog.title = usuarioStore.usuario?.id ? usuarioStore.usuario?.pessoa?.nome : 'Novo usuário'
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
            <Form :action="_usuario.id ? route('users.update', { id: _usuario.id }) : route('users.store')"
                #default="{ errors }" :method="_usuario.id ? 'PUT' : 'POST'" @success="handleSuccess"
                @error="handleError">
                <input type="hidden" name="pessoa.id" v-model="_usuario.pessoa.id" />
                <input type="hidden" name="active" :value="_usuario.active ? 1 : 0" />

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <cInputUI :errors="errors" field="cpf">
                        <FloatLabel variant="on">
                            <InputText id="iCpf" name="cpf" v-model="_usuario.cpf" fluid variant="filled"
                                :invalid="('cpf' in errors)" />
                            <label for="iCpf">CPF</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <cInputUI :errors="errors" field="pessoa.nome">
                        <FloatLabel variant="on">
                            <InputText id="iNome" name="pessoa.nome" v-model="_usuario.pessoa.nome" fluid
                                variant="filled" :invalid="('pessoa.nome' in errors)" />
                            <label for="iNome">Nome</label>
                        </FloatLabel>
                    </cInputUI>
                    <cInputUI :errors="errors" field="email">
                        <FloatLabel variant="on">
                            <InputText id="iEmail" name="email" v-model="_usuario.email" fluid variant="filled"
                                :invalid="('email' in errors)" />
                            <label for="iEmail">E-mail</label>
                        </FloatLabel>
                    </cInputUI>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <ToggleButton v-model="_usuario.active" onIcon="pi pi-check" onLabel="Ativo" offIcon="pi pi-times"
                        size="small" offLabel="Inativo" class="w-full sm:w-40" aria-label="Confirmation" />
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
