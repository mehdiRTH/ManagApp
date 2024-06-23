<script lang="ts" setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ComputedRef, computed } from 'vue';
import { IconDefinition, faCalendar, faPerson, faClose } from '@fortawesome/free-solid-svg-icons';
import { NotificationData } from '@/types/Notification/NotificationData';

const props=defineProps<{
    notification:NotificationData
}>()

const form=useForm({})

const iconType : ComputedRef<{icon:IconDefinition,color:string}> =computed(()=>{
    if(props.notification.type=='Meeting') return {icon:faCalendar,color:'text-primary'};
    else return {icon:faPerson,color:'text-secondary'}

})

const close=(()=>{
    form.delete(route('delete.notification', { notification: props.notification }),{
        preserveState:true
    })
})
</script>
<template>
    <Link v-if="notification.data.route" :href="notification.data.route" class="w-full p-3 mt-4 bg-white rounded shadow flex flex-shrink-0">
    <div tabindex="0" aria-label="group icon" role="img"
        class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
        <faIcon :icon="iconType.icon" :class="iconType.color" />
    </div>
    <div class="pl-3 w-full">
        <div class="flex items-center justify-between w-full">
            <p tabindex="0" class="focus:outline-none text-sm leading-none">{{ notification.data.message }}</p>
            <button @click="close" tabindex="0" aria-label="close icon" role="button" class="focus:outline-none cursor-pointer">
                <div tabindex="0" aria-label="close icon" role="button" class="focus:outline-none cursor-pointer">
                    <faIcon :icon="faClose" class="text-gray-500 text-xs" />
                </div>
            </button>
        </div>
        <p tabindex="0" class="focus:outline-none text-xs leading-3 pt-1 text-gray-500">{{ notification.date }}</p>
    </div>
    </Link>
    <div v-else class="w-full p-3 mt-4 bg-white rounded shadow flex flex-shrink-0">
        <div tabindex="0" aria-label="group icon" role="img"
            class="focus:outline-none w-8 h-8 border rounded-full border-gray-200 flex flex-shrink-0 items-center justify-center">
            <faIcon :icon="iconType.icon" :class="iconType.color" />
        </div>
        <div class="pl-3 w-full">
            <div class="flex items-center justify-between w-full">
                <p tabindex="0" class="focus:outline-none text-sm leading-none">{{ notification.data.message }}</p>
                <button @click="close" tabindex="0" aria-label="close icon" role="button" class="focus:outline-none cursor-pointer">
                    <div tabindex="0" aria-label="close icon" role="button" class="focus:outline-none cursor-pointer">
                        <faIcon :icon="faClose" class="text-gray-500 text-xs" />
                    </div>
                </button>
            </div>
            <p tabindex="0" class="focus:outline-none text-xs leading-3 pt-1 text-gray-500">{{ notification.date }}</p>
        </div>
    </div>
</template>
