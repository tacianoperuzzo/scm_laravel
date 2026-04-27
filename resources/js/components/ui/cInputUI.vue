<script setup>
const { errors, field } = defineProps({
  errors: Object,
  field: String
})
</script>

<template>
  <div class="flex flex-col">
    <slot />
    <Message v-show="(`${field}` in errors)" severity="error" variant="simple" size="small">{{ errors[field] }}
    </Message>
  </div>
</template>
