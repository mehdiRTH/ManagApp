<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { AnnounceInterface } from '@/types/Announce/AnnounceInterface';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainTable from '@/Components/Table/MainTable.vue';
import TdTable from '@/Components/Table/TdTable.vue';
import ThTable from '@/Components/Table/ThTable.vue';
import StatusComponent from '@/Components/StatusComponent.vue';
import IconButton from '@/Components/IconButton.vue'

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    announces:AnnounceInterface
}>()
</script>
<template>
<MainLayout head="Announces" :breadcrumbs="breadcrumbs">
    <MainTable label="All Announces" :create_route="route('announces.create')" :meta="announces.meta">
            <template #ThTable>
                <ThTable>Label</ThTable>
                <ThTable>Message</ThTable>
                <ThTable>Receiver</ThTable>
                <ThTable>Type</ThTable>
                <ThTable>Status</ThTable>
                <ThTable>Is Active</ThTable>
                <ThTable></ThTable>
            </template>
            <template #TdTable>
                <tr v-for="announce in announces.data" :key="announce.id">
                    <TdTable>{{ announce.label }}</TdTable>
                    <TdTable>{{ $helpers.truncateString(announce.message) }}</TdTable>
                    <TdTable>
                        <StatusComponent type="success" v-if="announce.type=='All'" >All Employees</StatusComponent>
                        <StatusComponent type="section" v-else-if="announce.type=='Section'" >{{ announce.receiver?.name }} Section</StatusComponent>
                        <StatusComponent type="admin" v-else >{{ announce.receiver?.name }} </StatusComponent>
                    </TdTable>
                    <TdTable>
                        <StatusComponent type="success" v-if="announce.type=='All'" >{{ announce.type }}</StatusComponent>
                        <StatusComponent type="employee" v-else-if="announce.type=='Direct'" >{{ announce.type }}</StatusComponent>
                        <StatusComponent type="admin" v-else >{{ announce.type }}</StatusComponent>
                    </TdTable>
                    <TdTable>
                        <StatusComponent :type="announce.status=='success' ? 'success' : (announce.status=='information' ? 'proccess' : 'refused')" >{{ $helpers.capitalizeFirstLetter(announce.status)}}</StatusComponent>
                    </TdTable>
                    <TdTable>
                        <StatusComponent isIcon :type="announce.is_active ? 'success' : 'refused'" >{{ announce.is_active ? 'Activated' : 'Not Activated' }}</StatusComponent>
                    </TdTable>
                    <TdTable>
                        <IconButton type="edit" :url="route('announces.edit',{announce:announce})" />
                        <IconButton type="delete" @click="$helpers.destroyModal({'announce':announce},'announces')" />

                    </TdTable>
                </tr>
            </template>
        </MainTable>
</MainLayout>
</template>
