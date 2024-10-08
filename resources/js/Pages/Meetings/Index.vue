<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import MainTable from '@/Components/Table/MainTable.vue';
import TdTable from '@/Components/Table/TdTable.vue';
import ThTable from '@/Components/Table/ThTable.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { MeetingInterface } from '@/types/Meeting/MeetingInterface';
import { UserInterface } from '@/types/User/UsersInterface';
import ParticipantsDialog from './ParticipantsDialog.vue'
import { Ref, ref } from 'vue';
import { MeetingData } from '@/types/Meeting/MeetingData';
import IconButton from '@/Components/IconButton.vue';
import { useForm } from '@inertiajs/vue3';
import { getCurrentInstance } from 'vue';
const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    meetings:MeetingInterface

}>()

const {proxy} : any =getCurrentInstance();

const isAdmin =ref(proxy.$helpers.hasRoles(['admin','responsible']))
const isDialogOpen : Ref<boolean> =ref(false)
const selectedMeeting : Ref<MeetingData> =ref(props.meetings.data[0])

const toggleDialog = ((meeting: MeetingData) => {
    if(meeting) selectedMeeting.value=meeting
    isDialogOpen.value=!isDialogOpen.value
})

</script>
<template>
    <MainLayout head="All Meetings" :breadcrumbs="breadcrumbs">
        <MainTable label="All Meetings" :create_route="isAdmin ? route('meetings.create') : null" :meta="meetings.meta">
            <template #ThTable>
                <ThTable>Responsible</ThTable>
                <ThTable>Participants</ThTable>
                <ThTable>Created By</ThTable>
                <ThTable>Start Date</ThTable>
                <ThTable>End Date</ThTable>
                <ThTable></ThTable>
            </template>
            <template #TdTable>
                <tr v-for="meeting in meetings.data" :key="meeting.id">
                    <TdTable>{{ meeting.responsible.name }}</TdTable>
                    <TdTable>
                        <button class="inline-flex text-blue-400" @click="toggleDialog(meeting)">
                            <span class="hover:underline">{{ meeting.participants[0].name }}</span>
                            <div v-if="meeting.participants.length>1" class="bg-gray-100 items-center p-1 mx-1 rounded text-xs">+{{ meeting.participants.length-1 }}</div>
                        </button>
                    </TdTable>
                    <TdTable>{{ meeting.created_by.name }}</TdTable>
                    <TdTable>{{ meeting.start_date }}</TdTable>
                    <TdTable>{{ meeting.end_date }}</TdTable>
                    <TdTable v-if="isAdmin">
                        <IconButton type="show" :url="route('meetings.show',{meeting:meeting})" />
                        <IconButton type="edit" :url="route('meetings.edit',{meeting:meeting})" />
                        <IconButton type="delete" @click="$helpers.destroyModal({meeting:meeting},'meetings')" />
                    </TdTable>
                    <TdTable v-else>
                        <IconButton type="show" :url="route('meetings.show',{meeting:meeting})" />
                    </TdTable>
                </tr>
            </template>
        </MainTable>
        <ParticipantsDialog :isOpen="isDialogOpen" :meeting="selectedMeeting" :key="isDialogOpen.toString()" @close="toggleDialog"></ParticipantsDialog>
    </MainLayout>
</template>
