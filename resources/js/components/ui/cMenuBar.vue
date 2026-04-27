<script setup lang="ts">
import Menubar from 'primevue/menubar';
import type { MenuItem } from 'primevue/menuitem';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
    menuItems: {
        type: Array as () => MenuItem[],
        required: true
    }
});
const currentRoute = ref(route())
</script>

<template>
    <Menubar :model="props.menuItems"
        :pt="{ root: 'bg-green-100/0! border-0!', itemContent: 'menubar-root', submenu: 'menubar-submenu' }">
        <template #item="{ item, props, hasSubmenu }">
            <!-- If it's a regular link, use Inertia Link -->
            <Link v-if="item.route" :href="route(item.route)" class="p-menubar-item-link" :method="item.method ?? 'get'"
                :class="{ 'active-class': currentRoute.current(item.route) }">
                <span :class="item.icon" class="p-menuitem-icon" />
                <span class="p-menuitem-text">{{ item.label }}</span>
            </Link>

            <!-- Default behavior for submenus/non-link items -->
            <a v-else :href="item.url" v-bind="props.action">
                <span :class="item.icon" class="p-menuitem-icon" />
                <span class="p-menuitem-text">{{ item.label }}</span>
                <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down p-submenu-icon" />
            </a>
        </template>
    </Menubar>
</template>
