<script lang="ts" setup>
import { MenuItemInterface } from '@/types/MenuItemInterface';
import { IconDefinition } from '@fortawesome/fontawesome-svg-core';
import { Link } from '@inertiajs/vue3';


const props=defineProps<{
    menus:MenuItemInterface[]
}>()
</script>
<template>

<div v-for="menu in menus">
    <li v-if="menu.isShowed" class="flex w-full justify-between text-primary hover:text-blue-200 cursor-pointer items-center mb-6">
            <Link  :href="menu.route" class="flex items-center focus:outline-none focus:ring-2 focus:ring-white">
                <faIcon :icon="menu.icon" class="icon icon-tabler icon-tabler-puzzle" />
                <span class="font-semibold ml-2">{{menu.label}}</span>
            </Link>
            <div v-if="menu.count" class="py-1 px-3 bg-secondary rounded text-white font-semibold flex items-center justify-center text-xs">{{menu.count}}</div>
    </li>
</div>
</template>
