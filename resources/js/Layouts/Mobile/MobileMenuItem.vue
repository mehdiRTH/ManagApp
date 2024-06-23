<script lang="ts" setup>
import { MenuItemInterface } from '@/types/MenuItemInterface';
import { IconDefinition } from '@fortawesome/fontawesome-svg-core';
import { Link } from '@inertiajs/vue3';

const props=defineProps<{
    menus:MenuItemInterface[]
}>()
</script>
<template>

    <li v-for="menu in menus" class="flex w-full justify-between text-primary hover:text-blue-200 cursor-pointer items-center mb-6">
        <Link :href="menu.route" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
            <faIcon :icon="menu.icon" class="icon icon-tabler icon-tabler-grid" />
            <span class="text-sm ml-2">{{menu.label}}</span>
        </Link>
        <div v-if="menu.count" class="py-1 px-3 bg-secondary rounded text-gray-300 flex items-center justify-center text-xs">{{menu.count}}</div>
    </li>
</template>
