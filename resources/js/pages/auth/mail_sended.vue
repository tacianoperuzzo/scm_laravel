<script setup>
import AppLogin from '@/layout/AppLogin.vue';

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
            Encaminhado link para o email cadastrado. Verifique sua caixa de entrada e siga as instruções para redefinir
            sua
            senha.
        </span>
    </div>
</template>
