<script lang="ts" setup>
import { IconDefinition } from '@fortawesome/fontawesome-svg-core';
import { faClock, faPen, faTrash } from '@fortawesome/free-solid-svg-icons';
import { Link } from '@inertiajs/vue3';
import { Ref, computed, ref } from 'vue';

const props=defineProps<{
    url?:string,
    icon?:IconDefinition,
    color?:string,
    type:string
}>()

defineEmits(['click'])

interface IconType{
    color:string;
    icon:IconDefinition;
    type:string;
}

const types : Ref<IconType[]>=ref([
    {color:'stroke', icon:faClock, type:'default'},
    {color:'info', icon:faPen, type:'edit'},
    {color:'danger', icon:faTrash, type:'delete'}
])

const typeSelected=computed(()=>{
    // let selectedType=types.value.find((item)=>item.type==props.type);

    return types.value.find((item)=>item.type==props.type) || types.value[0]

})

</script>
<template>
    <Link v-if="url" :href="url" :class="'text-white middle none center w-3 h-3 p-2 mx-2 rounded-md text-xs bg-' +(color!=null ? color : typeSelected?.color)">
        <faIcon v-if="icon" :icon="icon"  />
        <faIcon v-else :icon="typeSelected?.icon"  />
    </Link>
    <button v-else @click="$emit('click')" :class="'text-white middle none center p-2 mx-2 rounded-md text-xs bg-' +(color!=null ? color : typeSelected?.color)">
        <faIcon v-if="icon" :icon="icon" />
        <faIcon v-else :icon="typeSelected?.icon" />
    </button>
</template>
