<script setup>
import AppLogin from '@/layout/AppLogin.vue';
import { defineAsyncComponent, ref } from 'vue';
import { Form } from "@inertiajs/vue3";
import { useDialog } from 'primevue/usedialog';

const recoveryForm = defineAsyncComponent(() => import('./form_recovery.vue'));

defineOptions({
    name: 'LoginPage',
    layout: AppLogin,
});

defineProps({
    errors: Object,
    status: String,
});

const rememberMe = ref(false);
const loading = ref(false);
const dialogService = useDialog();

const openFormRecovery = () => {
    const dialogRef = dialogService.open(recoveryForm, {
        props: {
            header: 'Recuperação de senha',
            class: 'w-100 md:w-3/6',
            modal: true,
            maximizable: false,
            breakpoints: { '1199px': '90vw', '575px': '95vw' },
        },
        onClose: () => {
            // Lógica a ser executada quando o diálogo for fechado, se necessário
        }
    });
}

</script>

<template>
    <div class="mb-6">
        <p class="text-3xl font-extrabold text-surface-900 dark:text-surface-0 m-0">
            Login
        </p>
        <span class="text-surface-500 dark:text-surface-400 mt-2 font-medium">
            Acesse sua conta para continuar
        </span>
        <p class="my-3">
            <Message severity="error" v-if="flash?.error && flash.error != 'Unauthorized access'" :life="10000"
                closable>{{
                    flash?.error
                }}</Message>
        </p>
    </div>

    <Form :action="route('login')" method="post" #default="{ errors }" class="flex flex-col gap-5">

        <div class="flex flex-col gap-2 text-left">
            <label for="cpf" class="text-sm font-semibold text-surface-700 dark:text-surface-200">
                CPF
            </label>
            <InputText id="cpf" name="cpf" type="text" :data-invalid="errors.cpf ? 'true' : undefined" class="w-full"
                required />

        </div>

        <div class="flex flex-col gap-2 text-left">
            <div class="flex justify-between items-center">
                <label for="password" class="text-sm font-semibold text-surface-700 dark:text-surface-200">
                    Senha
                </label>
                <a href="#" class="text-xs font-bold text-primary-600 hover:text-primary-500 no-underline"
                    @click="openFormRecovery">
                    Esqueceu a senha?
                </a>
            </div>
            <Password id="password" name="password" autocomplete="current-password"
                :data-invalid="errors.password ? 'true' : undefined" :feedback="false" toggleMask fluid class="w-full"
                required />

        </div>

        <div class="flex items-center gap-2">
            <Checkbox v-model="rememberMe" :binary="true" inputId="remember" />
            <label for="remember" class="text-sm text-surface-600 dark:text-surface-400">Lembrar de mim</label>
        </div>

        <Message class="my-2" v-show="errors.cpf" severity="error" variant="simple" size="small">
            Erro: Nenhum usuário ativo com estas credenciais.
        </Message>
        <Button type="submit" label="Entrar" icon="pi pi-sign-in" class="w-full py-3 mt-2" :loading="loading" />

    </Form>
    <DynamicDialog />
</template>
