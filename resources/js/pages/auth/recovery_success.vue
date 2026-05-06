<script setup>
import AppLogin from '@/layout/AppLogin.vue';
import { router } from '@inertiajs/vue3';

defineOptions({
    name: 'LoginPage',
    layout: AppLogin,
});

</script>
<template>
    <div class="mb-6">
        <p class="text-3xl font-extrabold text-surface-900 dark:text-surface-0 m-0 mb-4">
            Recuperação de senha
        </p>
        <span class="text-surface-500 dark:text-surface-400 font-medium">
            Senha alterada com sucesso. <br>
            Você já pode fazer login com sua nova senha.
        </span>
        <div class="mt-6">
            <Button as="a" label="Fazer login" :href="route('login')" class="w-full" />
        </div>
    </div>
</template>
