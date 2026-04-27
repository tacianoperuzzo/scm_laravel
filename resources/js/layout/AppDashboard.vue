<script setup lang="ts">
import appMenubar from './AppMenubar.vue';
import Loading from '@/components/ui/cLoading.vue';
import { provide } from 'vue'

const props = defineProps<{ auth?: object }>();

provide('auth', props.auth);

</script>

<template>
    <div class="">
        <appMenubar></appMenubar>
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="pt-20">
            <div class="p-4">
                <Panel>
                    <slot />
                </Panel>
            </div>
        </div>
    </div>
    <Loading />
</template>
