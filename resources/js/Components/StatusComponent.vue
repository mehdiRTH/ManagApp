<script lang="ts" setup>
import { faCheck,faClock,faClose,faRefresh, faUser,faBuildingUser } from '@fortawesome/free-solid-svg-icons'
import { computed, ref } from 'vue';

const props=defineProps<{
    type:string,
    isIcon?:boolean
}>()

const status =ref([
    {class:'text-emerald-500 bg-emerald-100/60', type:'success', icon:faCheck},
    {class:'text-red-500 bg-red-100/60', icon:faClose, type:'refused'},
    {class:'text-orange-500 bg-orange-100/60', icon:faClock,type:'proccess'},
    {class:'text-purple-500 bg-purple-100/60', icon:faUser,type:'super admin'},
    {class:'text-cyan-500 bg-cyan-100/60', icon:faUser,type:'admin'},
    {class:'text-rose-500 bg-rose-100/60', icon:faUser,type:'responsible'},
    {class: 'text-slate-500 bg-slate-100/60', icon: faUser, type: 'employee' },
    {class:'text-lime-500 bg-lime-100/60', icon:faUser,type:'HR'},
    {class:'text-blue-500 bg-blue-100/60', icon:faBuildingUser,type:'section'},
    {class:'text-gray-500 bg-gray-100/60', icon:faRefresh,type:'default'},

])

const statu = computed(() => {
    return status.value.find(item => item.type === props.type) || status.value[status.value.length - 1];
});

</script>
<template>
    <!-- {{ statu }} -->
    <div
        :class="'inline-flex items-center px-3 py-1 rounded-full gap-x-2 '+statu.class">

        <faIcon v-if="!isIcon" :icon="statu.icon" class="bg-transparent" />

        <h2 class="text-sm font-normal bg-transparent">
            <slot />
        </h2>
    </div>
</template>
