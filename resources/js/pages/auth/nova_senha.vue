<script setup>
import AppLogin from '@/layout/AppLogin.vue';
import { Form } from '@inertiajs/vue3';
import cInputUI from '@/components/ui/cInputUI.vue';

defineOptions({
    name: 'LoginPage',
    layout: AppLogin,
});

defineProps({
    token_id: Number,
    usuario_id: Number,
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
    <Form route="user.reset-password" method="post" v-slot="{ errors }" class="flex flex-col gap-5">
        <input type="hidden" name="id" :value="usuario_id" />
        <input type="hidden" name="token_id" :value="token_id" />
        <cInputUI :errors="errors" field="password">
            <FloatLabel variant="on">
                <Password id="iPassword" name="password" fluid variant="filled" :invalid="('password' in errors)"
                    toggleMask />
                <label for="iPassword">Nova senha</label>
            </FloatLabel>
        </cInputUI>
        <cInputUI :errors="errors" field="passwordConfirmation">
            <FloatLabel variant="on">
                <Password id="iPasswordConfirmation" name="passwordConfirmation" fluid variant="filled"
                    :invalid="('passwordConfirmation' in errors)" toggleMask />
                <label for="iPasswordConfirmation">Confirmação da nova senha</label>
            </FloatLabel>
        </cInputUI>

        <Button label="Redefinir senha" type="submit" class="w-full" />

    </Form>
</template>
