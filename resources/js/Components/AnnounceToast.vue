<script lang="ts" setup>
import { AnnounceData } from '@/types/Announce/AnnounceData';
import { faClose, faExclamationCircle, faCircleCheck, faTriangleExclamation } from '@fortawesome/free-solid-svg-icons';
import { usePage } from '@inertiajs/vue3';
import {  Ref, computed, onMounted, ref } from 'vue';

const props=defineProps<{
    announce:AnnounceData
}>()

const isClosed : Ref<boolean> = ref(false)

const close=(()=>{
    localStorage.setItem('announce-'+props.announce.id+'-'+usePage().props.auth.user.id,props.announce.id);
    isClosed.value=!isClosed.value
})

const color=computed(()=>{
    if(props.announce.status=='success') return {bg:'success',label:'green',icon:faCircleCheck};
    else if(props.announce.status=='information') return {bg:'info',label:'orange',icon:faExclamationCircle};
    else return {bg:'danger',label:'red', icon:faTriangleExclamation};
})

onMounted(()=>{
    isClosed.value=localStorage.getItem('announce-'+props.announce.id+'-'+usePage().props.auth.user.id) ? true : false
})

</script>
<template>
    <div v-if="!isClosed" class="mt-6 w-full">
        <div :class="'text-sm text-white rounded-md shadow-lg mb-3 bg-'+color.bg" role="alert">
            <div class="flex p-2">
                <div class="block items-center">
                    <h1 :class="'font-bold text-'+color.label+'-800'">
                       <faIcon  :icon="color.icon" /> {{ $helpers.capitalizeFirstLetter(announce.label) }}
                    </h1>
                    <p class="mx-0.5">{{announce.message}}</p>
                </div>
            <div class="ml-auto items-center flex">
                <button @click="close" type="button" class="inline-flex flex-shrink-0 justify-center items-center h-4 w-4 rounded-md text-white/[.5] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-blue-500 transition-all text-sm dark:focus:ring-offset-blue-500 dark:focus:ring-blue-700">
                <span class="sr-only">Close</span>
                <faIcon :icon="faClose" />
                </button>
            </div>
            </div>
        </div>
    </div>
</template>
