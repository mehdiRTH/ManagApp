<script lang="ts" setup>
import { ref } from 'vue'
import { HolidayData } from '@/types/Holidays/HolidayData';
import { toast } from 'vue3-toastify';
import { useForm } from '@inertiajs/vue3';
import { ElMessageBox } from 'element-plus';

const props=defineProps<{
    isOpen:boolean,
    event: HolidayData
}>()

const isDialogOpen=ref(props.isOpen)
const form=useForm({})
const emit=defineEmits(['close','select'])
const deleteEvent=(()=>{
    ElMessageBox.confirm(
    'Are you sure you will want to delete this Holiday. Continue?',
    'Warning',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        form.delete(route('holidays.destroy',{'holiday':props.event.id}), {
        preserveScroll: true,
            onSuccess: () => {
            toast.success('Holiday deleted successfully')
            emit('close')
        }
        })
    })
})
</script>
<template>
    <el-dialog v-model="isDialogOpen" title="Warning" width="500" center @close="$emit('close')">
        <span class="flex items-center justify-center my-5">
            Are you want to delete or Edit Your Holiday ?
        </span>
        <template #footer>
            <div class="dialog-footer">
                <el-button type="danger" @click="deleteEvent">
                    Delete
                </el-button>
                <el-button type="primary" @click="$emit('select','edit')">Edit</el-button>
            </div>
        </template>
    </el-dialog>
</template>
