<script setup>

const props = defineProps({
    oficio: Object,
    pdf: String
})
</script>

<template>
    <div class="h-[calc(100vh-100px)]">
        <iframe :src="pdf" style="width:100%; height:100%;" frameborder="0" v-if="pdf"></iframe>
    </div>
</template>

<style scoped></style>
