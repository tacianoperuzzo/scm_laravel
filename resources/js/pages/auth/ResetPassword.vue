<script setup>
import AppLogin from '@/layout/AppLogin.vue';
import { Form } from '@inertiajs/vue3';
import cInputUI from '@/components/ui/cInputUI.vue';

defineOptions({
    name: 'LoginPage',
    layout: AppLogin,
});

defineProps({
    token: String,
    email: String,
})

</script>
<template>
    <div class="mb-6">
        <p class="text-3xl font-extrabold text-surface-900 dark:text-surface-0 m-0">
            Recuperação de senha
        </p>
        <span class="text-surface-500 dark:text-surface-400 mt-2 font-medium">
            Redefina sua senha.
        </span>
    </div>
    <Form :action="route('password.store')" method="post" v-slot="{ errors }" class="flex flex-col gap-5">
        <input type="hidden" name="email" :value="email" />
        <input type="hidden" name="token" :value="token" />
        <cInputUI :errors="errors" field="cpf">
            <FloatLabel variant="on">
                <InputText id="iCPF" name="cpf" fluid variant="filled" :invalid="('cpf' in errors)" toggleMask />
                <label for="iCPF">CPF</label>
            </FloatLabel>
        </cInputUI>
        <cInputUI :errors="errors" field="password">
            <FloatLabel variant="on">
                <Password id="iPassword" name="password" fluid variant="filled" :invalid="('password' in errors)"
                    toggleMask />
                <label for="iPassword">Nova senha</label>
            </FloatLabel>
        </cInputUI>
        <cInputUI :errors="errors" field="passwordConfirmation">
            <FloatLabel variant="on">
                <Password id="iPasswordConfirmation" name="password_confirmation" fluid variant="filled"
                    :invalid="('passwordConfirmation' in errors)" toggleMask />
                <label for="iPasswordConfirmation">Confirmação da nova senha</label>
            </FloatLabel>
        </cInputUI>
        <Message class="my-2" v-show="('token' in errors)" severity="error" variant="simple" size="small">{{
            errors['token'] }}
        </Message>
        <Button label="Redefinir senha" type="submit" class="w-full" />
        <a href="/login" class="text-sm text-center text-surface-600 dark:text-surface-400 mt-3">Voltar para o login</a>
    </Form>
</template>
