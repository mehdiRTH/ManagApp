<script lang="ts" setup>
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Form from '@/Components/Form.vue';
import MainInput from '@/Components/MainInput.vue';
import MainLabel from '@/Components/Label.vue';
import { UserInterface } from '@/types/User/UsersInterface';
import { toast } from 'vue3-toastify';
import { SectionResourceInterface } from '@/types/Section/SectionResourceInterface';
import { ref } from 'vue';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    responsibles:UserInterface,
    section:SectionResourceInterface
}>()

const isEdit=ref(props.section.data?.id)

const form=useForm({
    name:isEdit.value ? props.section.data.name : '',
    responsible_id:isEdit.value ? props.section.data.responsible?.id : ''
})

const submit=(()=>{
    if(isEdit.value)
    {
        form.put(route('sections.update', { 'section': props.section.data }), {
        preserveState:true,
        onSuccess:(()=>{
            toast.success('Sections Updated successfully')
        })
    })
    }
    else{
        form.post(route('sections.store'),{
        preserveState:true,
        onSuccess:(()=>{
            toast.success('Sections stored successfully')
        })
    })
    }

})
</script>
<template>
    <MainLayout :breadcrumbs="breadcrumbs" :head="isEdit ? 'Edit Section' : 'Create Section'">
        <Form label="Create Sections" :errors="form.errors" :btn-label="isEdit ? 'Edit' : 'Create'" @submit="submit()" class="max-w-4xl">
            <!-- Name -->
            <MainInput v-model="form.name" label="Name" :error="form.errors.name" class="col-span-2" />

            <!-- Select Responsible -->
            <MainLabel label="Select Responsible" :error="form.errors.responsible_id" class="col-span-2">
                <el-select v-model="form.responsible_id" placeholder="Select" size="large" class="w-full">
                    <el-option v-for="item in responsibles.data" :key="item.id" :label="item.name" :value="item.id" />
                </el-select>
            </MainLabel>
        </Form>
    </MainLayout>
</template>
