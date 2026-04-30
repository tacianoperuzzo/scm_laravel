<script setup>
import cMenuBar from '@/components/ui/cMenuBar.vue';
import scmLogo from '@/assets/images/scm-logo-sc-negative.png';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const userMenu = ref();
const menuItems = ref([
    {
        label: 'Home',
        icon: 'pi pi-fw pi-home',
        items: [
            {
                label: 'Dashboard',
                icon: 'pi pi-fw pi-home',
                route: 'dashboard'
            },
            {
                label: 'Ofícios',
                icon: 'pi pi-fw pi-user-edit',
                route: 'oficios.index'
            }
        ]
    },
    {
        label: 'CoAdm',
        icon: 'pi pi-fw pi-table',
        items: [
            {
                label: 'Efetivo',
                icon: 'pi pi-fw pi-user-plus',
                route: 'efetivo'
            },
        ]
    },
    {
        label: 'CoSeg',
        icon: 'pi pi-fw pi-shopping-cart',
        items: [
            {
                label: 'Relatório de Serviços',
                icon: 'pi pi-fw pi-list'
            },
        ]
    },
    {
        label: 'CoCer',
        icon: 'pi pi-fw pi-envelope',
        items: [
            {
                label: 'Whatsapp Services',
                icon: 'pi pi-fw pi-compass'
            },
        ]
    },
    {
        label: 'CoTTe',
        icon: 'pi pi-fw pi-calendar',
        items: [
            {
                label: 'Relatório de Logística',
                icon: 'pi pi-fw pi-list'
            },
        ]
    },
    {
        label: 'Sistema',
        icon: 'pi pi-fw pi-user',
        items: [
            {
                label: 'Cadastros básicos',
                icon: 'pi pi-fw pi-cog',
                items: [
                    {
                        label: 'Setores',
                        icon: 'pi pi-fw pi-cog',
                        route: 'setores.index'
                    },
                    {
                        label: 'Funções',
                        icon: 'pi pi-fw pi-cog',
                        route: 'funcoes.index'
                    },
                ]
            },
            {
                label: 'Usuários',
                icon: 'pi pi-fw pi-file',
                route: 'users.index'
            }
        ]
    }
]);
const userMenuItems = ref([
    {
        label: 'Profile',
        items: [
            {
                label: 'Profile',
                icon: 'pi pi-fw pi-user',
                command: () => {
                    router.get(route('profile.show'));
                }
            },
            {
                label: 'Settings',
                icon: 'pi pi-fw pi-cog',
                command: () => {
                    router.get(route('settings'));
                }
            },
            {
                label: 'Logout',
                icon: 'pi pi-fw pi-sign-out',
                command: () => {
                    router.post(route('logout'));
                }
            }
        ]
    }
]);
const toggle = (event) => {
    userMenu.value.toggle(event);
};
</script>
<template>
    <nav class="bg-green-800/95 p-4 fixed w-full z-10 top-0">
        <div class="container mx-auto flex justify-start items-center">
            <!-- Logo/Brand Name -->
            <a href="/">
                <img :src="scmLogo" alt="SCM Logo" class="h-10" />
            </a>
            <!-- Menu Links Container -->
            <div class="flex justify-between items-center space-x-4 ml-2 mr-2 grow">
                <cMenuBar :menuItems="menuItems" />
                <Button icon="pi pi-user" variant="outlined" severity="secondary" rounded aria-label="User"
                    class="text-gray-300!" @click="toggle" />
                <Menu ref="userMenu" id="overlay_menu" :model="userMenuItems" :popup="true" />
            </div>
        </div>
    </nav>
</template>
