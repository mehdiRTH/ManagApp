<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { Roleinterface } from '@/types/RoleInterface';
import MainInput from '@/Components/MainInput.vue'
import MainLabel from '@/Components/Label.vue'
import { useForm } from '@inertiajs/vue3';
import MainButton from '@/Components/MainButton.vue'
import { toast } from 'vue3-toastify';
import { UserResourceInterface } from '@/types/User/UserResourceInterface';
import { SectionInterface } from '@/types/Section/SectionsInterface';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    user:UserResourceInterface,
    roles:Roleinterface[],
    sections:SectionInterface
}>()

const isEdit : boolean=(props.user.data.id ? true : false)

const form=useForm({
    name :isEdit ? props.user.data.name : '',
    email:isEdit ? props.user.data.email : '',
    password:'',
    password_confirmation:'',
    role: isEdit ? props.user.data.role[0] : '',
    section:isEdit ? props.user.data.section?.id : '',
    isEdit: isEdit
})

const submit=(()=>{
    if(isEdit)
    {
        form.put(route('users.update',{'user':props.user.data}), {
        preserveScroll: true,
        onSuccess:()=>{
            toast.success('User updated successfully')
        }
        })
    }
    else {
        form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess:()=>{
            toast.success('User created successfully')
        }
        })
    }

})

function isErrorsEmpty():boolean
{
    return Object.keys(form.errors).length==0
}

</script>
<template>
    <MainLayout :breadcrumbs="breadcrumbs" :head="'Create User'">
        <section :class="{'bg-primary':isErrorsEmpty(),'bg-tertiary':!isErrorsEmpty()}" class="max-w-6xl p-6 mx-auto bg-primary rounded-md shadow-md dark:bg-gray-800 my-10">
            <h1 class="text-xl font-bold text-white capitalize dark:text-white">Account settings</h1>
            <form @submit.prevent="submit()">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                    <!-- Input For Name-->
                    <MainInput v-model="form.name" label="Name" :error="form.errors.name"></MainInput>

                    <!-- Input For Email-->
                    <MainInput v-model="form.email" label="Email" :error="form.errors.email"></MainInput>

                    <!-- Input For Password-->
                    <MainInput v-model="form.password" label="Password" :error="form.errors.password" input-type="password"></MainInput>

                    <!-- Input For Password Confirmation-->
                    <MainInput v-model="form.password_confirmation" label="Password Confirmation" :error="form.errors.password_confirmation"
                        input-type="password"></MainInput>

                    <!-- Input For Roles-->
                    <MainLabel label="select" :error="form.errors.role">
                        <el-select v-model="form.role" placeholder="Select" size="large" class="w-full">
                            <el-option v-for="item in roles" :key="item.uuid" :label="item.name" :value="item.name" />
                        </el-select>
                    </MainLabel>

                    <!-- Input For Section-->
                    <MainLabel label="Select Section" :error="form.errors.section">
                        <el-select v-model="form.section" placeholder="Select" size="large" class="w-full">
                            <el-option v-for="item in sections.data" :key="item.id" :value="item.id" :label="item.name" >
                                <div class="flex justify-between">
                                    <p>{{ item.name }}</p>
                                    <p class="text-primary">{{ item.responsible.name }}</p>
                                </div>
                            </el-option>
                        </el-select>
                    </MainLabel>

                </div>

                <div class="flex justify-end mt-6">
                    <MainButton :color="'white'" :text-color="isErrorsEmpty() ? 'primary' : 'tertiary'" type="submit">{{props.user.data.id ? 'Edit' : 'Save'}}</MainButton>
                </div>
            </form>
        </section>
    </MainLayout>
</template>
