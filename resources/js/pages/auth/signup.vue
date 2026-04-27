<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <div class="form-container">
        <div>
            <h1>Signup</h1>
            <p>Enter your details below to create your account</p>
        </div>

        <div>
            <Form route="new_account.store" #default="{ processing, errors }">
                <div>
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" :data-invalid="errors.name ? 'true' : undefined" />
                    <div v-if="errors.name">{{ errors.name }}</div>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="email"
                        :data-invalid="errors.email ? 'true' : undefined" />
                    <div v-if="errors.email">{{ errors.email }}</div>
                </div>

                <div>
                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" autocomplete="cpf"
                        :data-invalid="errors.cpf ? 'true' : undefined" />
                    <div v-if="errors.cpf">{{ errors.cpf }}</div>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="new-password"
                        :data-invalid="errors.password ? 'true' : undefined" />
                    <div v-if="errors.password">{{ errors.password }}</div>
                </div>

                <div>
                    <label for="passwordConfirmation">Confirm password</label>
                    <input type="password" name="passwordConfirmation" id="passwordConfirmation"
                        autocomplete="new-password" :data-invalid="errors.passwordConfirmation ? 'true' : undefined" />
                    <div v-if="errors.passwordConfirmation">{{ errors.passwordConfirmation }}</div>
                </div>

                <div>
                    <button type="submit" class="button" :disabled="processing">Sign up</button>
                </div>
            </Form>
        </div>
    </div>
</template>
