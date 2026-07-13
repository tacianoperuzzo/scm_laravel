<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { useUsuarioStore } from '@/store/usuario';
import { usePessoaStore } from '@/store/pessoa';
import { computed, reactive, ref, watch } from 'vue';
import { useToast } from 'primevue/usetoast';
import cInputUI from '@/components/ui/cInputUI.vue';

const props = defineProps<{
    cargos: [],
    setores: [],
    funcoes: [],
    niveis: [],
}>()

const usuarioStore = useUsuarioStore();
const pessoaStore = usePessoaStore();
const toast = useToast();

const _pessoa = ref(null)
const _usuario = ref(null)
const _dialog = reactive({
    show: false,
    title: undefined,
})

const fileUploadRef = ref(null);

const panel0Errors = computed(() => {
    return usuarioStore.errors ? Object.keys(usuarioStore.errors).some(chave => ['pessoa.foto'].includes(chave)) : false;
})
const panel1Errors = computed(() => {
    return usuarioStore.errors ? Object.keys(usuarioStore.errors).some(chave => ['cpf', 'pessoa.nascimento', 'pessoa.telefone', 'pessoa.nome', 'pessoa.email'].includes(chave)) : false;
})
const panel2Errors = computed(() => {
    return usuarioStore.errors ? Object.keys(usuarioStore.errors).some(chave => ['pessoa.matricula', 'pessoa.postograd_id', 'pessoa.nome_guerra', 'pessoa.setor_id', 'pessoa.funcao_id', 'pessoa.pasta', 'pessoa.data_entrada', 'pessoa.data_saida', 'pessoa.observacao'].includes(chave)) : false;
})
const panel3Errors = computed(() => {
    return usuarioStore.errors ? Object.keys(usuarioStore.errors).some(chave => ['nivel_permissao_id'].includes(chave)) : false;
})

const closeDialog = () => {
    usuarioStore.setUsuario(null);
    usuarioStore.setErrors(null);
    pessoaStore.setPessoa(null);
}
const handleTransform = (data) => {
    data.ativo = _usuario.value.ativo == 1 || _usuario.value.ativo == 'true' ? 1 : 0
    data.pessoa.postograd_id = _pessoa.value.postograd_id
    data.pessoa.setor_id = _pessoa.value.setor_id
    data.pessoa.funcao_id = _pessoa.value.funcao_id
    data.pessoa.foto_url = _pessoa.value.foto_url
    return data
}
const handleSuccess = () => {
    closeDialog();
    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Efetivo salvo com sucesso.', life: 3000 });
}
const handleError = (errors) => {
    usuarioStore.setErrors(errors);
    toast.add({ severity: 'error', summary: 'Erro', detail: 'Verifique os dados informados.', life: 3000 });
}

const findPessoa = async () => {
    if (_pessoa.value.cpf?.length === 11) {
        let data = await pessoaStore.findPessoaByCpf(_pessoa.value.cpf);
        if (data?.id) {
            toast.add({ severity: 'error', summary: 'CPF encontrado', detail: 'Este CPF já está em uso, verifique.', life: 3000 });
        }
    }
}

const onSelectFile = async (event) => {
    const file = event.files[0];
    const reader = new FileReader();
    fileUploadRef.value.clear();
    reader.onload = (e) => {
        _pessoa.value.foto = e.target.result;
    };
    reader.readAsDataURL(file);
    try {
        const response = await pessoaStore.uploadFoto(file);
        _pessoa.value.foto_url = response.url;
        toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Foto enviada com sucesso.', life: 3000 });
    } catch (error) {
        toast.add({ severity: 'error', summary: 'Erro', detail: 'Falha ao enviar a foto.', life: 3000 });
    }
}

const onClearFile = () => {
    _pessoa.value.foto = null;
    _pessoa.value.foto_url = null;
}

watch(() => pessoaStore.pessoa, (newPessoa) => {
    if (newPessoa) {
        _pessoa.value = newPessoa;
        _dialog.title = pessoaStore.pessoa?.id ? pessoaStore.pessoa?.nome : 'Novo registro'
        _dialog.show = true;
    } else {
        _dialog.show = false;
    }
})
watch(() => usuarioStore.usuario, (usuario) => {
    if (usuario) {
        _usuario.value = usuario;
    }
})

</script>
<template>
    <Dialog v-model:visible="_dialog.show" maximizable modal :header="_dialog.title" :class="'w-5/6 h-auto'"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" @after-hide="closeDialog">
        <Panel :pt="{ root: 'p-0', header: 'hidden!', content: 'p-0!' }" class="min-h-100 h-full">
            <Form :action="_usuario.id ? route('users.update', { id: _usuario.id }) : route('users.store')"
                #default="{ errors }" :method="_usuario.id ? 'PUT' : 'POST'" :transform="handleTransform"
                @success="handleSuccess" @error="handleError">
                <input type="hidden" v-model="_usuario.id" name="id">
                <input type="hidden" v-model="_pessoa.cpf" name="cpf">
                <input type="hidden" v-model="_usuario.ativo" name="ativo">
                <input type="hidden" v-model="_usuario.nivel_permissao_id" name="nivel_permissao_id">
                <Accordion value="0">
                    <AccordionPanel value="0">
                        <AccordionHeader :pt="{ root: 'bg-slate-100!' }">
                            <span class="flex items-center justify-between w-full pr-4">
                                <span class="font-bold whitespace-nowrap">Foto</span>
                                <i class="pi pi-exclamation-triangle text-red-600" v-if="panel0Errors"></i>
                            </span>
                        </AccordionHeader>
                        <AccordionContent>
                            <div class="flex items-end gap-4 mb-4 mt-4">
                                <div
                                    class="w-50 h-50 p-1 border-2 border-dotted border-gray-300 rounded-lg flex items-center justify-center">
                                    <div class="w-full h-full rounded-lg overflow-hidden">
                                        <img v-if="_pessoa.foto" :src="_pessoa.foto" alt="Foto do efetivo"
                                            class="w-full h-full object-cover" />
                                    </div>
                                </div>
                                <FileUpload ref="fileUploadRef" name="pessoa.foto_url" accept="image/*"
                                    :maxFileSize="2000000" auto customUpload @uploader="onSelectFile"
                                    @clear="onClearFile" mode="advanced"
                                    :pt="{ root: { class: 'border-0!' }, content: { class: 'hidden!' } }">
                                    <template #header="{ chooseCallback, clearCallback }">
                                        <div class="flex flex-col items-center gap-2">
                                            <Button type="button" severity="danger"
                                                :disabled="!(_pessoa.foto || _pessoa.foto_url)" variant="outlined"
                                                size="small" @click="clearCallback()">
                                                <i class="pi pi-trash"></i>
                                                Remover foto
                                            </Button>
                                            <Button type="button" size="small" @click="chooseCallback()">
                                                <i class="pi pi-plus"></i>
                                                Carregar foto
                                            </Button>
                                        </div>
                                    </template>
                                </FileUpload>
                            </div>
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel value="1">
                        <AccordionHeader :pt="{ root: 'bg-slate-100!' }">
                            <span class="flex items-center justify-between w-full pr-4">
                                <span class="font-bold whitespace-nowrap">Dados Pessoais</span>
                                <i class="pi pi-exclamation-triangle text-red-600" v-if="panel1Errors"></i>
                            </span>
                        </AccordionHeader>
                        <AccordionContent>
                            <div class="grid grid-cols-3 gap-4 mb-4 mt-4">
                                <cInputUI :errors="errors" field="cpf">
                                    <FloatLabel variant="on">
                                        <InputMask id="iCpf" name="pessoa.cpf" v-model="_pessoa.cpf"
                                            mask="999.999.999-99" :unmask="true" fluid variant="filled"
                                            :invalid="('cpf' in errors)" @blur="findPessoa"
                                            :disabled="_usuario.id > 0" />
                                        <label for="iCpf">CPF</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.nome">
                                    <FloatLabel variant="on">
                                        <InputText id="iNome" name="pessoa.nome" v-model="_pessoa.nome" fluid
                                            variant="filled" :invalid="('pessoa.nome' in errors)" />
                                        <label for="iNome">Nome</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-5 gap-4 mb-4 mt-4">
                                <cInputUI :errors="errors" field="pessoa.nascimento">
                                    <FloatLabel variant="on">
                                        <InputMask id="iNascimento" name="pessoa.nascimento" mask="99/99/9999"
                                            v-model="_pessoa.nascimento" fluid variant="filled"
                                            :invalid="('pessoa.nascimento' in errors)" />
                                        <label for="iNascimento">Data de nascimento</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.telefone">
                                    <FloatLabel variant="on">
                                        <InputMask id="iTelefone" name="pessoa.telefone" mask="(99) 99999-9999"
                                            v-model="_pessoa.telefone" fluid variant="filled"
                                            :invalid="('pessoa.telefone' in errors)" />
                                        <label for="iTelefone">Telefone</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI class="col-span-2" :errors="errors" field="email">
                                    <FloatLabel variant="on">
                                        <InputText id="iEmail" name="pessoa.email" v-model="_pessoa.email" fluid
                                            variant="filled" :invalid="('email' in errors)" />
                                        <label for="iEmail">Email</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-5 gap-4 mb-4">
                                <cInputUI class="col-span-4" :errors="errors" field="pessoa.endereco">
                                    <FloatLabel variant="on">
                                        <InputText id="iEndereco" name="pessoa.endereco" v-model="_pessoa.endereco"
                                            fluid variant="filled" :invalid="('pessoa.endereco' in errors)" />
                                        <label for="iEndereco">Endereço</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.endereco_numero">
                                    <FloatLabel variant="on">
                                        <InputText id="iEnderecoNumero" name="pessoa.endereco_numero"
                                            v-model="_pessoa.endereco_numero" fluid variant="filled"
                                            :invalid="('pessoa.endereco_numero' in errors)" />
                                        <label for="iEnderecoNumero">Número</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-5 gap-4 mb-4">
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.endereco_complemento">
                                    <FloatLabel variant="on">
                                        <InputText id="iEnderecoComplemento" name="pessoa.endereco_complemento"
                                            v-model="_pessoa.endereco_complemento" fluid variant="filled"
                                            :invalid="('pessoa.endereco_complemento' in errors)" />
                                        <label for="iEnderecoComplemento">Complemento</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.endereco_municipio">
                                    <FloatLabel variant="on">
                                        <InputText id="iMunicipio" name="pessoa.endereco_municipio"
                                            v-model="_pessoa.endereco_municipio" fluid variant="filled"
                                            :invalid="('pessoa.endereco_municipio' in errors)" />
                                        <label for="iMunicipio">Município</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.endereco_cep">
                                    <FloatLabel variant="on">
                                        <InputMask id="iCep" name="pessoa.endereco_cep" v-model="_pessoa.endereco_cep"
                                            mask="99999-999" fluid variant="filled"
                                            :invalid="('pessoa.endereco_cep' in errors)" />
                                        <label for="iCep">CEP</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel value="2">
                        <AccordionHeader :pt="{ root: 'bg-slate-100!' }">
                            <span class="flex items-center justify-between w-full pr-4">
                                <span class="font-bold whitespace-nowrap">Dados Funcionais</span>
                                <i class="pi pi-exclamation-triangle text-red-600" v-if="panel2Errors"></i>
                            </span>
                        </AccordionHeader>
                        <AccordionContent>
                            <div class="grid grid-cols-4 gap-4 mb-4 mt-4">
                                <cInputUI :errors="errors" field="pessoa.matricula">
                                    <FloatLabel variant="on">
                                        <InputMask id="iMatricula" name="pessoa.matricula" v-model="_pessoa.matricula"
                                            mask="999999-9" fluid variant="filled"
                                            :invalid="('pessoa.matricula' in errors)" />
                                        <label for="iMatricula">Matrícula</label>
                                    </FloatLabel>
                                </cInputUI>
                                <div class="col-span-3 grid grid-cols-2 gap-4">
                                    <cInputUI :errors="errors" field="pessoa.postograd_id">
                                        <FloatLabel variant="on">
                                            <Select v-model="_pessoa.postograd_id" name="pessoa.postograd_id"
                                                :options="cargos" optionLabel="descricao" optionValue="id" fluid />
                                            <label for="iPostograd">Posto/Graduação</label>
                                        </FloatLabel>
                                    </cInputUI>
                                    <cInputUI :errors="errors" field="pessoa.nome_guerra">
                                        <FloatLabel variant="on">
                                            <InputText id="iNomeGerra" name="pessoa.nome_guerra"
                                                v-model="_pessoa.nome_guerra" fluid variant="filled"
                                                :invalid="('pessoa.nome_guerra' in errors)" />
                                            <label for="iNomeGerra">Nome de Guerra</label>
                                        </FloatLabel>
                                    </cInputUI>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <cInputUI :errors="errors" field="pessoa.setor_id">
                                    <FloatLabel variant="on">
                                        <Select v-model="_pessoa.setor_id" name="pessoa.setor_id" :options="setores"
                                            optionLabel="descricao" optionValue="id" fluid />
                                        <label for="iSetor">Setor</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.funcao_id">
                                    <FloatLabel variant="on">
                                        <Select v-model="_pessoa.funcao_id" name="pessoa.funcao_id" :options="funcoes"
                                            optionLabel="descricao" optionValue="id" fluid />
                                        <label for="iFuncao">Função</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mb-4">
                                <cInputUI class="col-span-2" :errors="errors" field="pessoa.pasta">
                                    <FloatLabel variant="on">
                                        <InputText id="iPasta" name="pessoa.pasta" v-model="_pessoa.pasta" fluid
                                            variant="filled" :invalid="('pessoa.pasta' in errors)" />
                                        <label for="iPasta">Pasta</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.data_entrada">
                                    <FloatLabel variant="on">
                                        <InputMask id="iDataEntrada" name="pessoa.data_entrada" mask="99/99/9999"
                                            v-model="_pessoa.data_entrada" fluid variant="filled"
                                            :invalid="('pessoa.data_entrada' in errors)" />
                                        <label for="iDataEntrada">Data de entrada</label>
                                    </FloatLabel>
                                </cInputUI>
                                <cInputUI :errors="errors" field="pessoa.data_saida">
                                    <FloatLabel variant="on">
                                        <InputMask id="iDataSaida" name="pessoa.data_saida" mask="99/99/9999"
                                            v-model="_pessoa.data_saida" fluid variant="filled"
                                            :invalid="('pessoa.data_saida' in errors)" />
                                        <label for="iDataSaida">Data de saída</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <cInputUI :errors="errors" field="pessoa.observacao">
                                    <FloatLabel variant="on">
                                        <Textarea id="iObservacao" name="pessoa.observacao" v-model="_pessoa.observacao"
                                            fluid rows="5" variant="filled"
                                            :invalid="('pessoa.observacao' in errors)" />
                                        <label for="iObservacao">Observação</label>
                                    </FloatLabel>
                                </cInputUI>
                            </div>
                        </AccordionContent>
                    </AccordionPanel>
                    <AccordionPanel value="3">
                        <AccordionHeader :pt="{ root: 'bg-slate-100!' }">
                            <span class="flex items-center justify-between w-full pr-4">
                                <span class="font-bold whitespace-nowrap">Login</span>
                                <i class="pi pi-exclamation-triangle text-red-600" v-if="panel3Errors"></i>
                            </span>
                        </AccordionHeader>
                        <AccordionContent>
                            <div class="grid grid-cols-3 gap-4 mb-4 mt-4">
                                <cInputUI :errors="errors" field="nivel_permissao_id">
                                    <FloatLabel variant="on">
                                        <Select v-model="_usuario.nivel_permissao_id" name="nivel_permissao_id"
                                            :options="niveis" optionLabel="descricao" optionValue="id" fluid />
                                        <label for="iNivel">Nivel</label>
                                    </FloatLabel>
                                </cInputUI>
                                <ToggleButton v-model="_usuario.ativo" name="ativo" onIcon="pi pi-check" onLabel="Ativo"
                                    offIcon="pi pi-times" size="small" offLabel="Inativo" class="w-full sm:w-40"
                                    aria-label="Confirmation" />
                            </div>
                        </AccordionContent>
                    </AccordionPanel>
                </Accordion>
                <div class="flex items-center justify-end gap-4 w-full my-4">
                    <Button type="button" label="Cancelar" icon="pi pi-times" severity="secondary"
                        @click="closeDialog" />
                    <Button type="submit" label="Salvar" icon="pi pi-check" severity="success" />
                </div>
            </Form>
        </Panel>
    </Dialog>
</template>
