<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainTable from '@/Components/Table/MainTable.vue';
import ThTable from '@/Components/Table/ThTable.vue';
import TdTable from '@/Components/Table/TdTable.vue';
import { SectionInterface } from '@/types/Section/SectionsInterface';
import MainButton from '@/Components/MainButton.vue';
import { faPen, faTrash } from '@fortawesome/free-solid-svg-icons';
import StatusComponent from '@/Components/StatusComponent.vue';
import { SectionData } from '@/types/Section/SectionData';
import { ElMessageBox } from 'element-plus'
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import IconButton from '@/Components/IconButton.vue'

defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    sections:SectionInterface
}>()

const form=useForm({})

const deleteSection = (section : SectionData) => {
  ElMessageBox.confirm(
    'User will permanently delete the file. Continue?',
    'Warning',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        form.delete(route('sections.destroy', { 'section': section }), {
        preserveScroll: true,
        onSuccess:()=>{
            toast.success('User deleted successfully')
        }
        })
    })
}
</script>
<template>
<MainLayout head="All Sections" :breadcrumbs="breadcrumbs">
    <MainTable label="Sections table" :create_route="route('sections.create')" :meta="sections.meta">
        <template #ThTable>
            <ThTable>Name</ThTable>
            <ThTable>Responsible</ThTable>
            <ThTable>Employee Affected</ThTable>
            <ThTable></ThTable>
        </template>
        <template #TdTable>
            <tr v-for="section in sections.data" :key="section.id">
                <TdTable>{{ section.name }}</TdTable>
                <TdTable>{{ section.responsible.name }}</TdTable>
                <TdTable><StatusComponent type="employee">{{ section.employees_affected }} Employees</StatusComponent>
                    </TdTable>
                <TdTable>
                    <div>
                        <IconButton type="edit" :url="route('sections.edit',{'section':section})" />
                        <IconButton type="delete" :icon="faTrash" @click="deleteSection(section)" />
                    </div>
                </TdTable>
            </tr>
        </template>
    </MainTable>
</MainLayout>
</template>
