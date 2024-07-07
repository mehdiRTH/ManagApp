<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { MeetingResourceInterface } from '@/types/Meeting/MeetingResourceInterface';
import { ref } from 'vue'
import ParticipantsDialog from './ParticipantsDialog.vue'
import { faCalendar } from '@fortawesome/free-solid-svg-icons';


const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    meeting:MeetingResourceInterface
}>()

const isDialogOpen=ref(false)

const toggleDialog = (() => {
    isDialogOpen.value=!isDialogOpen.value
})
</script>
<template>
    <MainLayout :head="'Meeting Information'" :breadcrumbs="breadcrumbs">
        <div v-if="meeting.data.id!=null" class="flex flex-col justify-center items-center mt-10">
            <div
                class="relative flex flex-col items-center rounded-[20px] w-full max-w-[95%] mx-auto bg-primary bg-opacity-5 bg-clip-border shadow-3xl shadow-shadow-500 p-3">
                <div class="mt-2 mb-8 w-full">
                    <h4 class="px-2 text-xl font-bold text-navy-700 dark:text-white">
                        Meeting Information
                    </h4>
                    <p class="mt-2 px-2 text-base text-gray-600">
                        {{ meeting.data.description }}
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                    <div
                        class="flex flex-col col-span-2 items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600">Start Date</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            {{ meeting.data.start_date }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600">End Date</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            {{ meeting.data.end_date }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            {{ meeting.data.diff.h }} hour<span v-if="meeting.data.diff.h > 1">s</span>
                            <span v-if="meeting.data.diff.m > 0">and {{ meeting.data.diff.m }} minutes</span>
                        </p>
                    </div>

                    <div
                        class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600">Responisble</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            {{ meeting.data.responsible.name }}
                        </p>
                    </div>

                    <div
                        class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                        <p class="text-sm text-gray-600">Participants</p>
                        <p class="text-base font-medium text-navy-700 dark:text-white">
                            <button class="inline-flex text-blue-400" @click="toggleDialog()">
                                <span class="hover:underline">{{ meeting.data.participants[0].name }}</span>
                                <div v-if="meeting.data.participants.length>1"
                                    class="bg-gray-100 items-center p-1 mx-1 rounded text-xs">+{{
                                    meeting.data.participants.length-1 }}</div>
                            </button>
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div v-else
            class="grid place-items-center mt-20 h-[50vh] rounded-[20px]  max-w-[95%] w-full bg-primary bg-opacity-5 bg-clip-border shadow-3xl shadow-shadow-500 p-3 ">
            <p class="text-primary text-4xl text-center flex items-center">
                <faIcon :icon="faCalendar" class="mr-2" />Meeting has been Canceled
            </p>
        </div>

        <ParticipantsDialog :isOpen="isDialogOpen" :meeting="meeting.data" :key="isDialogOpen" @close="toggleDialog">
        </ParticipantsDialog>
    </MainLayout>
</template>
