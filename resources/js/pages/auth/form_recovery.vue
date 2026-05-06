<script setup>
import { Form } from "@inertiajs/vue3";
import cInputUI from '@/components/ui/cInputUI.vue';
import { inject, ref } from "vue";
import { useToast } from 'primevue/usetoast';

const dialogRef = inject('dialogRef');
const toast = useToast();
const loading = ref(false);

const handleSuccess = () => {
    dialogRef.value.close();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Link de recuperação enviado para o email cadastrado.', life: 5000 });
}
const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Não foi possível enviar o link de recuperação.', life: 5000 });
    loading.value = false;
}

</script>
<template>
    <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
        <Form :action="route('password.email')" #default="{ errors }" :method="'POST'" @success="handleSuccess"
            @before="loading = true" @error="handleError">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <cInputUI :errors="errors" field="cpf">
                    <FloatLabel variant="on">
                        <InputText id="iCpf" name="cpf" fluid variant="filled" :invalid="('cpf' in errors)" />
                        <label for="iCpf">CPF</label>
                    </FloatLabel>
                </cInputUI>
            </div>
            <div class="grid grid-cols-1 gap-4 mb-4">
                <cInputUI :errors="errors" field="email">
                    <FloatLabel variant="on">
                        <InputText id="iEmail" name="email" fluid variant="filled" :invalid="('email' in errors)" />
                        <label for="iEmail">E-mail</label>
                    </FloatLabel>
                </cInputUI>
            </div>
            <Message class="my-2" v-show="('fields' in errors)" severity="error" variant="simple" size="small">{{
                errors['fields'] }}
            </Message>
            <Button label="Enviar link de recuperação" type="submit" class="w-full" :loading="loading" />
        </Form>
    </Panel>
</template>
