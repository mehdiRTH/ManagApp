<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import { Ref, computed, ref } from 'vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { HolidayInterface } from '@/types/Holidays/HolidayInterface';
import CreateDialog from './CreateDialog.vue'
import { HolidayData } from '@/types/Holidays/HolidayData';
import ChoiceSelectDialog from './ChoiceSelectDialog.vue'
import { getCurrentInstance } from 'vue';

const { proxy } : any =getCurrentInstance()

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    holidays:HolidayInterface
}>()

//Interface
interface EventInterface{
    startStr: string;
    endStr: string;
    id?:string;
    title?:string
}

//Variables
const isDialogOpen: Ref<boolean> = ref(false)
const isSelectDialogOpen: Ref<boolean> = ref(false)
const isHr: Ref<boolean> = ref(proxy.$helpers.hasRole('HR'))
const selectedEvent : Ref<HolidayData> = ref({'start':'', 'end':''})

//Functions
const handleClick = ((range: EventInterface) => {
if(isHr.value){
    isDialogOpen.value = !isDialogOpen.value
    selectedEvent.value = {'start':range.startStr, 'end':range.endStr}
}
})

const handleEvent=((range: { event : EventInterface })=>{
    if(isHr.value){
        isSelectDialogOpen.value = !isSelectDialogOpen.value
        selectedEvent.value = {'start':range.event.startStr, 'end':range.event.endStr,'id':range.event.id,'title':range.event.title}
    }
})


const selectedChoice=((choice:string)=>{
    if(choice=='edit'){
        isDialogOpen.value = !isDialogOpen.value
        isSelectDialogOpen.value = false
    }
})

const calendarOptions=computed(()=>{
return {
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    events: props.holidays.data,
    height:600,
    selectable:true,
    select:handleClick,
    eventClick:handleEvent
    }
})

</script>
<template>
    <MainLayout head="Holidays" :breadcrumbs="breadcrumbs">
        <div class="mt-4">
            <FullCalendar :options="calendarOptions" />
        </div>
        <CreateDialog :isDialogOpen="isDialogOpen" :key="isDialogOpen.toString()" :range="selectedEvent" @close="isDialogOpen=!isDialogOpen" />
        <ChoiceSelectDialog :isOpen="isSelectDialogOpen" :key="isSelectDialogOpen.toString()" :event="selectedEvent" @close="isSelectDialogOpen=!isSelectDialogOpen" @select="selectedChoice"/>
    </MainLayout>
</template>
