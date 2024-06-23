<script lang="ts" setup>
import { UserInterface } from '@/types/User/UsersInterface';
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainTable from '@/Components/Table/MainTable.vue';
import Tdtable from '@/Components/Table/TdTable.vue';
import Thtable from '@/Components/Table/ThTable.vue';
import StatusComponent from '@/Components/StatusComponent.vue';
import { ElMessageBox } from 'element-plus'
import { UserData } from '@/types/User/UserData';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import IconButton from '@/Components/IconButton.vue'

defineProps<{
    users:UserInterface,
    breadcrumbs:BreadcrumbsInterface[]
}>()

const form=useForm({})

const deleteUser = (user:UserData) => {
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
        form.delete(route('users.destroy',{'user':user}), {
        preserveScroll: true,
        onSuccess:()=>{
            toast.success('User deleted successfully')
        }
        })
    })
}
</script>
<template>
    <MainLayout :breadcrumbs="breadcrumbs" head="All Users">

        <MainTable label="Users" :meta="users.meta" :create_route="route('users.create')">
            <template #ThTable>
                <Thtable>Name</Thtable>
                <Thtable>Email</Thtable>
                <Thtable>Section</Thtable>
                <Thtable>Role</Thtable>
                <Thtable></Thtable>
            </template>
            <template #TdTable>
                <tr v-for="user in users.data">
                    <Tdtable>{{ user.name }}</Tdtable>
                    <Tdtable>{{ user.email }}</Tdtable>
                    <Tdtable>
                        <StatusComponent :type="user.section ? 'success' : 'refused' " v-if="!(user.role.includes('admin') || user.role.includes('super admin'))">{{user.section?.name ?? 'Not Affected Yet'}}</StatusComponent>
                        <StatusComponent type="default" v-else>{{ user.role[0]+' should not affected' }}</StatusComponent>
                    </Tdtable>
                    <Tdtable>
                        <StatusComponent v-for="role in user.role" :type="role" >{{ role }} </StatusComponent>
                    </Tdtable>
                    <Tdtable>
                        <div>
                            <IconButton :url="route('users.edit',{'user':user})" type="edit" />
                            <IconButton @click="deleteUser(user)" type="delete" />
                        </div>
                    </Tdtable>
                </tr>
            </template>
        </MainTable>
    </MainLayout>
</template>
