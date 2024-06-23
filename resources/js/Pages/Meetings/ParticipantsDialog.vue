<script setup lang="ts">
import { ref, Ref } from 'vue'
import { ElButton, ElDialog } from 'element-plus'
import { CircleCloseFilled } from '@element-plus/icons-vue'
import StatusComponent from '@/Components/StatusComponent.vue';
import { MeetingData } from '@/types/Meeting/MeetingData';

const props=defineProps<{
    isOpen:boolean,
    meeting:MeetingData
}>()

const isOpened:Ref<boolean>=ref(props.isOpen)
defineEmits(['close'])
</script>
<template>
    <el-dialog v-model="isOpened" :show-close="false" width="500" @close="$emit('close')">
        <template #header="{ close, titleId, titleClass }">
            <div class="my-header">
                <h4 :id="titleId" :class="titleClass">The Participants of the meeting!</h4>
                <el-button type="danger" @click="close">
                    <el-icon class="el-icon--left">
                        <CircleCloseFilled />
                    </el-icon>
                    Close
                </el-button>
            </div>
        </template>
        <div class="grid grid-cols-1">
            <StatusComponent v-for="part in meeting.participants" type="success" class="m-2">
                    {{ part.name }}
            </StatusComponent>
        </div>
    </el-dialog>
</template>
<style scoped>
.my-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  gap: 16px;
}
</style>
