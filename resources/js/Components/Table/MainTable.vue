<script lang="ts" setup>
import { MetaInterface } from '@/types/MetaInterface';
import MainButton from '../MainButton.vue';
import Paginate from "@/Components/Table/Paginate.vue"
import { faAdd } from '@fortawesome/free-solid-svg-icons';
defineProps<{
    label:string,
    create_route?:string | null,
    meta?:MetaInterface,
    isEmpty?:boolean
}>();

const emits=defineEmits(['click_create'])

</script>
<template>
    <div class="flex flex-col mt-8">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="flex justify-between items-center my-4">
                    <h1 class="ml-2 font-semibold text-slate-500">{{label}} Table</h1>
                    <div v-if="create_route" class="my-1">
                        <MainButton v-if="create_route" color="primary" :icon="faAdd" class="mr-4" :url="create_route">Create</MainButton>
                        <MainButton v-else color="primary" class="mr-4" :icon="faAdd" @click="emits('click_create')">Create</MainButton>
                    </div>
                </div>
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <slot name="ThTable" />
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <slot name="TdTable" />
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <Paginate v-if="meta" :metaData="meta" />
</template>
