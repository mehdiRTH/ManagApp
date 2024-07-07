<script lang="ts" setup>
import { HolidayData } from '@/types/Holidays/HolidayData';
import { useForm } from '@inertiajs/vue3';
import {  ref, Ref } from 'vue'
import { toast } from 'vue3-toastify';

const props=defineProps<{
    isDialogOpen:boolean,
    range: HolidayData ,
    name?:string
}>()

const isOpen : Ref<boolean> =ref(props.isDialogOpen)
const formLabelWidth = '140px'

const form=useForm({
    start:props.range.start,
    end:props.range.end,
    name:props.range.title ?? ''
})

const emits=defineEmits(['close'])

const submit=(()=>{
    if(props.range?.id){
        form.put(route('holidays.update', { holiday: props.range?.id }), {
        preserveState: true,
        onSuccess:()=>{
            toast.success('Holiday updated successfully')
            emits('close')
        }
    })
    }else{
        form.post(route('holidays.store'),{
        preserveState: true,
        onSuccess:()=>{
            toast.success('Holiday created successfully')
            emits('close')
        }
    })
    }

})
</script>
<template>
    <el-dialog v-model="isOpen" title="Holiday Information" width="500" @close="$emit('close')">
        <el-form :model="form">
            <el-form-item label="Name Of Holiday" :label-width="formLabelWidth">
                <el-input v-model="form.name" autocomplete="off" />
            </el-form-item>
            <el-form-item label="Start Of Holiday" :label-width="formLabelWidth">
                <el-input v-model="form.start" autocomplete="off" type="date" />
            </el-form-item>
            <el-form-item label="Start Of work" :label-width="formLabelWidth">
                <el-input v-model="form.end" autocomplete="off" type="date" />
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="$emit('close')">Cancel</el-button>
                <el-button type="primary" @click="submit">
                    Confirm
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>
