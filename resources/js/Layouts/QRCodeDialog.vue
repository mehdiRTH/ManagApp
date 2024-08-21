<script lang="ts" setup>
import MainButton from '@/Components/MainButton.vue';
import { faClose, faEye } from '@fortawesome/free-solid-svg-icons';
import { ref, Ref } from 'vue';

const props=defineProps<{
    openQrCode:boolean
}>()
const emit=defineEmits(['close'])
const isOpenQrCode : Ref<boolean> = ref(props.openQrCode)

const close=(()=>{
    isOpenQrCode.value=!isOpenQrCode.value
    emit('close')
})

</script>
<template>
    <el-dialog v-model="isOpenQrCode" :show-close="false" width="350" center @close="close">
        <template #header="{ close, titleId, titleClass }">
        <div class="my-header">
            <h4 :id="titleId" :class="titleClass">Entry QR Code</h4>
            <el-button type="danger" @click="close">
                <el-icon class="el-icon--left"><faIcon :icon="faClose" /></el-icon>
                Close
            </el-button>
        </div>
        </template>
        <div class="flex justify-center my-2">
            <div class="bg-gray-200 p-4 w-8/12 rounded-md">
                <h3 class="text-center mb-4 text-xl font-semibold">Scan Your QR Code</h3>
                <div class="flex items-center justify-center">
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='+$page.props.auth.qrCode" class="w-full" />
                </div>
            </div>
        </div>
        <div class="flex justify-center ml-4">
            <MainButton color="primary" :icon="faEye" :url="route('daily_activities.show',{user:$page.props.auth.user})" >
                Enter Your Activities
            </MainButton>
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
