<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import Form from '@/Components/Form.vue';
import MainInput from '@/Components/MainInput.vue';
import Label from '@/Components/Label.vue';
import { InertiaForm, router, useForm } from '@inertiajs/vue3';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { DayOffResourceInterface } from '@/types/DayOffRequest/DayOffResourceInterface';
import ImageUploader from '@/Components/ImageUploader.vue'
import { computed, onMounted, Ref,ref } from 'vue';
import { DayOffData } from '@/types/DayOffRequest/DayOffData';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    offRequest:DayOffResourceInterface
}>()

const isEdit: Ref<boolean>=ref(!!props.offRequest.data?.id)
const date  = ref([])

const isOnEdit=((column : any, output? : any)=>{
    return isEdit.value ? column : (output ?? '')
})

const form =useForm({
    label:isOnEdit(props.offRequest.data?.label),
    description:isOnEdit(props.offRequest.data?.description),
    type:isOnEdit(props.offRequest.data?.type,'Textual'),
    justification: isOnEdit(props.offRequest.data?.justification,[]),
    user_id:isOnEdit(props.offRequest.data?.user?.id),
    status:isOnEdit(props.offRequest.data?.status),
    status_answer:'',
    start_date:isOnEdit(props.offRequest.data?.start_date,''),
    end_date:isOnEdit(props.offRequest.data?.end_date,''),
    isInModal:false,
    _method:isEdit.value ? "PUT" : "POST"
})


const submit=(()=>{
    if(isEdit.value){
        form.post(route('off_requests.update',{off_request:props.offRequest.data}))
    }
    else form.post(route('off_requests.store'));
})

const changeFiles=((files : FileList,fileUrl: string)=>{

    form.justification=Array.from(files)
})

const chnageDate=(()=>{
        form.start_date=date.value[0]
        form.end_date=date.value[1]
})

onMounted(()=>{
    if(isEdit.value) date.value=[(form.start_date as never),(form.start_date as never)]
})

</script>
<template>
<MainLayout head="Create Day Off Request" :breadcrumbs="breadcrumbs">
    <Form label="Create Day off request" @submit="submit()" btn-label="Save" :errors="form.errors" >
        <!-- Label -->
        <MainInput v-model="form.label" label="Label" :error="form.errors.label" />

        <!-- type -->
        <Label label="Type Justification" :error="form.errors.type" >
            <el-select v-model="form.type" placeholder="Select type" class="w-full" @change="form.justification=[]">
                <el-option v-for="item in ['Files','Textual']" :key="item" :label="item" :value="item">
                        {{ item }}
                </el-option>
            </el-select>
        </Label>

        <!-- Description -->
        <MainInput v-model="form.description" input-type="textarea" label="Description" :error="form.errors.description" class="col-span-2" />

        <!-- type -->
        <Label v-if="form.type=='Files'" label="Justification" :error="form.errors.justification" class="col-span-2">
            <ImageUploader :files-src="form.type=='Files' ? form.justification : []" @change="changeFiles" />
         </Label>

         <!-- justification -->
        <MainInput v-else v-model="form.justification" input-type="textarea" label="Justifications Textual" :error="form.errors.justification" class="col-span-2" />


        <!-- type Duration-->
        <Label label="Duration" :error="form.errors.start_date || form.errors.end_date" class="cols-span-2 w-full">
            <el-date-picker
                v-model="date"
                type="datetimerange"
                range-separator="To"
                start-placeholder="Start date"
                end-placeholder="End date"
                format="YYYY/MM/DD hh:mm:ss"
                value-format="YYYY/MM/DD hh:mm:ss"
                @change="chnageDate"
            />
        </Label>

    </Form>
</MainLayout>
</template>
