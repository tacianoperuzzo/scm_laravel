<script setup lang="ts">
import scmLogo from '@/assets/images/scm-logo-sc-negative.png';
</script>
<template>
    <div class="min-h-screen w-full flex bg-surface-50 dark:bg-surface-950">

        <div class="hidden md:flex flex-1 items-center justify-center bg-green-800/95 p-12 text-white">
            <div class="max-w-md text-center">
                <div class="mb-8 flex justify-center">
                    <img :src="scmLogo" alt="SCM Logo" class="h-24" />
                </div>
                <h1 class="text-4xl font-bold mb-4 tracking-tight">Bem-vindo!</h1>

            </div>
        </div>

        <main class="flex-1 flex flex-col justify-center items-center p-8 bg-white dark:bg-surface-900">
            <div class="w-full max-w-100 md:w-4/5 lg:w-2/3">
                <slot />

                <footer class="mt-8 text-center text-sm text-surface-500 dark:text-surface-400">
                    <p>© 2026 - Todos os direitos reservados.</p>
                </footer>
            </div>
        </main>

    </div>
</template>
