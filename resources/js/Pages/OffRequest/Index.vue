<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainTable from '@/Components/Table/MainTable.vue';
import TdTable from '@/Components/Table/TdTable.vue';
import ThTable from '@/Components/Table/ThTable.vue';
import { DayOffInterface } from '@/types/DayOffRequest/DayOffInterface';
import StatusComponent from '@/Components/StatusComponent.vue';
import IconButton from '@/Components/IconButton.vue';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    off_requests:DayOffInterface
}>()



const typeStatus =((status: string)=>{
    let type='proccess';

    if(status=='Pending') type='proccess'
    else if(status=='Accepted') type='success'
    else return type='refused'

    return type;
})
</script>
<template>
<MainLayout head="Day Off Request" :breadcrumbs="breadcrumbs">
    <MainTable label="All Day Off Requests" :create_route="route('off_requests.create')" :meta="off_requests.meta">
            <template #ThTable>
                <ThTable>Employee</ThTable>
                <ThTable>Label</ThTable>
                <ThTable>Description</ThTable>
                <ThTable>Duration</ThTable>
                <ThTable>Status</ThTable>
                <ThTable></ThTable>
            </template>
            <template #TdTable>
                <tr v-for="req in off_requests.data">
                    <TdTable > {{ req.user.name }}</TdTable>
                    <TdTable > {{ req.label }}</TdTable>
                    <TdTable > {{ $helpers.truncateString(req.description) }}</TdTable>
                    <TdTable > {{ req.duration }} </TdTable>
                    <TdTable >
                        <StatusComponent :type="typeStatus(req.status)">{{$helpers.capitalizeFirstLetter(req.status)}}</StatusComponent>
                    </TdTable>
                    <TdTable >
                        <IconButton type="show" :url="route('off_requests.show',{ off_request:req })" />
                        <IconButton v-if="req.user.id==($page.props.auth.user.id as unknown as string) && req.status=='Pending'" type="edit" :url="route('off_requests.edit',{ off_request:req })" />
                        <IconButton v-if="req.user.id==($page.props.auth.user.id  as unknown as string) && req.status=='Pending'" type="delete" @click="$helpers.destroyModal({off_request:req},'off_requests')" />
                    </TdTable>
                </tr>
            </template>
    </MainTable>

</MainLayout>
</template>
