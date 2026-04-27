<script setup>
import { loading } from '@/store/loading';
</script>

<template>
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-10000 flex justify-center items-center"
        v-show="loading.showing()">
        <div class="w-16 h-16 border-4 border-solid border-primary rounded-full border-t-transparent animate-spin">
        </div>
    </div>
</template>

<style scoped></style>
