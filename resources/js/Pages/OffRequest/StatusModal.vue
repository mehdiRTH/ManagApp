<script lang="ts" setup>
import Modal from '@/Components/Modal.vue'
import { DayOffResourceInterface } from '@/types/DayOffRequest/DayOffResourceInterface';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props=defineProps<{
    isOpen:boolean,
    off_request:DayOffResourceInterface
}>()
const form=useForm({
    status:props.off_request.data.status,
    status_answer:props.off_request.data.status_answer,
    isInModal:true
})

const isShowed=computed(()=>props.isOpen)

const updateStatus=(()=>{
    form.put(route('off_requests.update',{off_request:props.off_request.data}))
})
</script>
<template>
<el-dialog v-model="isShowed" title="Change Status" width="600">
    <el-form :model="form">
      <el-form-item label="Status" label-width="140px">
        <el-select v-model="form.status" placeholder="Please select a zone">
          <el-option v-for="item in ['Refused','Accepted']" :label="$helpers.capitalizeFirstLetter(item)" :value="item" />
        </el-select>
      </el-form-item>
      <el-form-item label="Message" label-width="140px">
        <el-input
            v-model="form.status_answer"
            :autosize="{ minRows: 2, maxRows: 4 }"
            type="textarea"
            placeholder="Write Message"
        />
      </el-form-item>

    </el-form>
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="$emit('close')">Cancel</el-button>
        <el-button type="primary" @click="updateStatus">
          Confirm
        </el-button>
      </div>
    </template>
  </el-dialog>
</template>
