<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import Form from '@/Components/Form.vue';
import MainInput from '@/Components/MainInput.vue';
import Label from '@/Components/Label.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { useForm } from '@inertiajs/vue3';
import { UserInterface } from '@/types/User/UsersInterface';
import { Ref ,ref } from 'vue';
import { MeetingResourceInterface } from '@/types/Meeting/MeetingResourceInterface';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    participantes:UserInterface,
    meeting:MeetingResourceInterface
}>()

const isEdit : Ref<boolean>=ref(props.meeting.data?.id ? true : false )

const form=useForm({
    participants_id:isEdit ? props.meeting.data.participants_id : [],
    responsible_id:isEdit ? props.meeting.data.responsible?.id : '' ,
    start_date:isEdit ? props.meeting.data.start_date : '' ,
    end_date:isEdit ? props.meeting.data.end_date : '' ,
    description: isEdit ? props.meeting.data.description : '' ,
})

function capitalizeFirstLetter(str:string) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

const submit=(()=>{
    if(isEdit.value) {
        form.put(route('meetings.update',{meeting:props.meeting.data}),{
        preserveState:true
    })
    }else
    form.post(route('meetings.store'),{
        preserveState:true
    })
})
</script>
<template>
    <MainLayout :head="isEdit ? 'Edit Meeting' : 'Create Meeting'" :breadcrumbs="breadcrumbs">
        <Form :label="isEdit ? 'Edit Meeting' : 'Create Meeting'" @submit="submit()" btn-label="Save" :errors="form.errors" class="max-w-4xl" >
            <Label label="Select responsible for the meeting" :error="form.errors.responsible_id" class="col-span-2">
                <el-select v-model="form.responsible_id" placeholder="Select responsible" class="w-full">
                    <el-option v-for="item in participantes.data" :key="item.id" :label="item.name" :value="item.id">
                        <div class="flex justify-between">
                            <span>{{ item.name }}</span>
                            <span
                                class="rounded-full mt-2 h-5 flex items-center text-white bg-green-400 py-1 px-3 text-xs font-bold mr-3">{{
                                capitalizeFirstLetter(item.role[0]) }}</span>
                        </div>
                    </el-option>
                </el-select>
            </Label>
            <Label label="Select Participantes" :error="form.errors.participants_id" class="col-span-2">
                <el-select v-model="form.participants_id" multiple collapse-tags placeholder="Select Participantes"
                    class="w-full">
                    <el-option v-for="item in participantes.data" :key="item.id" :label="item.name" :value="item.id">
                        <div class="flex justify-between">
                            <span>{{ item.name }}</span>
                            <span
                                class="rounded-full mt-2 h-5 flex items-center text-white bg-green-400 py-1 px-3 text-xs font-bold mr-3">{{
                                capitalizeFirstLetter(item.role[0]) }}</span>
                        </div>
                    </el-option>
                </el-select>
            </Label>
            <Label label="Start date" :error="form.errors.start_date">
                <el-date-picker v-model="form.start_date" type="datetime" value-format="YYYY-MM-DD HH:mm:ss" format="YYYY-MM-DD HH:mm" placeholder="Select Start date" class="w-full" />

            </Label>

            <Label label="End date" :error="form.errors.end_date">
                <div >
                    <el-date-picker v-model="form.end_date" type="datetime" value-format="YYYY-MM-DD HH:mm:ss" format="YYYY-MM-DD HH:mm" placeholder="Select End date" class="w-full" />
                </div>
            </Label>

            <MainInput v-model="form.description" label="Description" input-type="textarea" :error="form.errors.description" class="col-span-2" />
        </Form>
    </MainLayout>
</template>
