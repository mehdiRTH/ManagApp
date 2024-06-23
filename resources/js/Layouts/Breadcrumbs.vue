<script lang="ts" setup>
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { Link } from '@inertiajs/vue3';

defineProps<{
    data:BreadcrumbsInterface[]
}>()
</script>
<template>
    <div class="capitalize">
        <nav aria-label="breadcrumb" class="w-max">
            <ol class="flex flex-wrap items-center w-full bg-opacity-60 rounded-md bg-transparent p-0 transition-all">
                <li v-for="(item,idx) in data"
                    class="flex items-center text-blue-gray-900 antialiased font-sans text-sm font-normal leading-normal cursor-pointer transition-colors duration-300 hover:text-light-blue-500">
                    <Link v-if="!(idx+1==data.length)" :href="item.url">
                    <p
                        class="block antialiased font-sans text-sm leading-normal text-secondary mx-2 font-normal opacity-50 transition-all hover:text-blue-500 hover:opacity-100">
                        {{item.title}}
                    </p>
                    </Link>
                    <span v-if="!(idx+1==data.length)"
                        class="text-gray-500 text-sm antialiased font-sans font-normal leading-normal">/ &nbsp;</span>
                    <div v-if="idx+1==data.length"
                        class="flex items-center text-primary antialiased font-sans text-sm font-normal leading-normal cursor-pointer transition-colors duration-300 hover:text-blue-500">
                        <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                            {{ item.title }}
                        </p>
                    </div>
                </li>
            </ol>
        </nav>
        <h6 class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-primary">
            {{data[data.length-1].title}}</h6>
    </div>
</template>
