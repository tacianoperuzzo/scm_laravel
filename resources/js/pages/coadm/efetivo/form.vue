<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { useEfetivoStore } from '@/store/efetivo';
import { reactive, ref, watch } from 'vue';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';

const props = defineProps<{
    cargos: Data.Cargo[],
}>()

const efetivoStore = useEfetivoStore();
const toast = useToast();

const _efetivo = ref(null)
const _dialog = reactive({
    show: false,
    title: undefined,
})

const closeDialog = () => {
    efetivoStore.setEfetivo(null);
}
const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Efetivo salvo com sucesso.', life: 3000 });
}
const handleError = () => {
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

watch(() => efetivoStore.efetivo, (newEfetivo) => {
    if (newEfetivo) {
        _efetivo.value = newEfetivo;
        _dialog.title = efetivoStore.efetivo?.id ? efetivoStore.efetivo?.pessoa?.nome : 'Novo efetivo'
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})
</script>
<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="_dialog.title" :class="'w-5/6 h-auto'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">
        <Panel :pt="{ root: 'pt-2', header: 'hidden!' }" class="min-h-100 h-full">
            <Form :route="_efetivo.id ? 'efetivo.update' : 'efetivo.store'" :params="{ id: _efetivo.id }"
                #default="{ errors }" :method="_efetivo.id ? 'PUT' : 'POST'" @success="handleSuccess"
                @error="handleError">
                <Tabs value="0">
                    <TabList>
                        <Tab value="0">Dados pessoais</Tab>
                        <Tab value="1">Dados funcionais</Tab>
                        <Tab value="2">Login</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="0" class="pt-4">
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI :errors="errors" field="pessoa.cpf">
                                    <FloatLabel variant="on">
                                        <InputMask id="iCpf" name="cpf" v-model="_efetivo.cpf" mask="99999999999" fluid
                                            variant="filled" :invalid="('cpf' in errors)" />
                                        <label for="iCpf">CPF</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.nome">
                                    <FloatLabel variant="on">
                                        <InputText id="iNome" name="pessoa.nome" v-model="_efetivo.pessoa.nome" fluid
                                            variant="filled" :invalid="('pessoa.nome' in errors)" />
                                        <label for="iNome">Nome</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI :errors="errors" field="pessoa.nascimento">
                                    <FloatLabel variant="on">
                                        <InputMask id="iNascimento" name="pessoa.nascimento" mask="99/99/9999"
                                            v-model="_efetivo.pessoa.nascimento" fluid variant="filled"
                                            :invalid="('pessoa.nascimento' in errors)" />
                                        <label for="iNascimento">Data de nascimento</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.email">
                                    <FloatLabel variant="on">
                                        <InputText id="iEmail" name="pessoa.email" v-model="_efetivo.pessoa.email" fluid
                                            variant="filled" :invalid="('pessoa.email' in errors)" />
                                        <label for="iEmail">Email</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.telefone">
                                    <FloatLabel variant="on">
                                        <InputText id="iTelefone" name="pessoa.telefone"
                                            v-model="_efetivo.pessoa.telefone" fluid variant="filled"
                                            :invalid="('pessoa.telefone' in errors)" />
                                        <label for="iTelefone">Telefone</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <Divider />
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.endereco">
                                    <FloatLabel variant="on">
                                        <InputText id="iEndereco" name="pessoa.endereco"
                                            v-model="_efetivo.pessoa.endereco" fluid variant="filled"
                                            :invalid="('pessoa.endereco' in errors)" />
                                        <label for="iEndereco">Endereço</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.enderecoNumero">
                                    <FloatLabel variant="on">
                                        <InputText id="iEnderecoNumero" name="pessoa.enderecoNumero"
                                            v-model="_efetivo.pessoa.enderecoNumero" fluid variant="filled"
                                            :invalid="('pessoa.enderecoNumero' in errors)" />
                                        <label for="iEnderecoNumero">Número</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI :errors="errors" field="pessoa.enderecoComplemento">
                                    <FloatLabel variant="on">
                                        <InputText id="iEnderecoComplemento" name="pessoa.enderecoComplemento"
                                            v-model="_efetivo.pessoa.enderecoComplemento" fluid variant="filled"
                                            :invalid="('pessoa.enderecoComplemento' in errors)" />
                                        <label for="iEnderecoComplemento">Complemento</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.enderecoMunicipio">
                                    <FloatLabel variant="on">
                                        <InputText id="iMunicipio" name="pessoa.municipio"
                                            v-model="_efetivo.pessoa.municipio" fluid variant="filled"
                                            :invalid="('pessoa.municipio' in errors)" />
                                        <label for="iMunicipio">Município</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.enderecoCep">
                                    <FloatLabel variant="on">
                                        <InputText id="iCep" name="pessoa.cep" v-model="_efetivo.pessoa.cep" fluid
                                            variant="filled" :invalid="('pessoa.cep' in errors)" />
                                        <label for="iCep">CEP</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                        </TabPanel>
                        <TabPanel value="1">
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI :errors="errors" field="matricula">
                                    <FloatLabel variant="on">
                                        <InputText id="iMatricula" name="matricula" v-model="_efetivo.matricula" fluid
                                            variant="filled" :invalid="('matricula' in errors)" />
                                        <label for="iMatricula">Matrícula</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="postogradId">
                                    <FloatLabel variant="on">
                                        <Select v-model="_efetivo.postogradId" name="postograd_id" :options="cargos"
                                            optionLabel="descricao" placeholder="Selecione o posto/graduação" fluid />
                                        <label for="iPostograd">Posto/Graduação</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <cInputUI :errors="errors" field="matricula">
                                    <FloatLabel variant="on">
                                        <Select v-model="_efetivo.postogradId" name="postograd_id" :options="cargos"
                                            optionLabel="descricao" placeholder="Selecione o posto/graduação" fluid />
                                        <label for="iMatricula">Setor</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pasta">
                                    <FloatLabel variant="on">
                                        <InputText id="iPasta" name="pasta" v-model="_efetivo.pasta" fluid
                                            variant="filled" :invalid="('pasta' in errors)" />
                                        <label for="iPasta">Pasta</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                        </TabPanel>
                        <TabPanel value="2">
                            <p class="m-0">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                voluptatum
                                deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati
                                cupiditate non
                                provident, similique sunt in culpa
                                qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem
                                rerum facilis est
                                et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque
                                nihil impedit quo
                                minus.
                            </p>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </Form>
        </Panel>
    </Dialog>
</template>
