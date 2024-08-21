<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainTable from '@/Components/Table/MainTable.vue';
import TdTable from '@/Components/Table/TdTable.vue';
import ThTable from '@/Components/Table/ThTable.vue';
import { DailyActivityInterface } from '@/types/DailyActivity/DailyActivityInterface';
import StatusComponent from '@/Components/StatusComponent.vue';
import IconButton from '@/Components/IconButton.vue';
const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    daily_activities:DailyActivityInterface
}>()

</script>
<template>
<MainLayout :breadcrumbs="breadcrumbs" :head="'Daily Activities'">
    <MainTable label="Employees Activities" :meta="daily_activities.meta">
        <template #ThTable>
            <ThTable>Employee</ThTable>
            <ThTable>Activities</ThTable>
        </template>
        <template #TdTable>
            <tr v-for="activity in daily_activities.data" :key="activity.id">
                <TdTable>{{ activity.user.name }}</TdTable>
                <TdTable>
                    <div v-if="Object.keys(activity.in_out).length==0">
                        <StatusComponent type="proccess" class="m-2">
                                No Activities Founded
                        </StatusComponent>
                    </div>
                    <div v-else>
                        <IconButton label="Enter For More infromation" type="show" :url="route('daily_activities.show',{user:activity.user})" />
                    </div>
                </TdTable>
            </tr>
        </template>
    </MainTable>
</MainLayout>
</template>
