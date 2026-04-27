<script setup>
import { Form } from "@inertiajs/vue3";
import cInputUI from '@/components/ui/cInputUI.vue';

</script>
<template>
    <Panel :pt="{ root: 'pt-4', header: 'hidden!' }">
        <Form :action="route('user.recovery-password')" #default="{ errors }" :method="'POST'">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <cInputUI :errors="errors" field="cpf">
                    <FloatLabel variant="on">
                        <InputText id="iCpf" name="cpf" fluid variant="filled" :invalid="('cpf' in errors)" />
                        <label for="iCpf">CPF</label>
                    </FloatLabel>
                </cInputUI>
            </div>
            <div class="grid grid-cols-1 gap-4 mb-4">
                <cInputUI :errors="errors" field="email">
                    <FloatLabel variant="on">
                        <InputText id="iEmail" name="email" fluid variant="filled" :invalid="('email' in errors)" />
                        <label for="iEmail">E-mail</label>
                    </FloatLabel>
                </cInputUI>
            </div>
            <Button label="Enviar link de recuperação" type="submit" class="w-full" />
        </Form>
    </Panel>
</template>
