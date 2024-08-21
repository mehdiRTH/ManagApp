<script setup lang="ts">
import { ref, Ref } from 'vue'
import { ElButton, ElDialog } from 'element-plus'
import { CircleCloseFilled } from '@element-plus/icons-vue'
import moment from 'moment';

const props=defineProps<{
    isOpen:boolean,
    activity:any
}>()

const isOpened:Ref<boolean>=ref(props.isOpen)
defineEmits(['close'])

const compareActivityDate=((in_date: string,out_date: string)=>{
    var beginningTime = moment(in_date+'am', 'h:mma');
    var endTime = moment(out_date+'am', 'h:mma');

    return beginningTime.isSameOrBefore(endTime)
})

const itemlabel=((item:string,count:number)=>{
    let results=''
    if(count==0){
        results='Start Service'+(compareActivityDate(props.activity[item],'08:05') ? ' At Time' : ' (Late)')
    }
    else {
        if(count==Object.keys(props.activity).length-1)
        {
            results='End Service'+(compareActivityDate(props.activity[item],'18:00') ? ' At Time' : ' (Late)')
        }else{
            results=item.includes('in') ? 'Check In' : 'Check Out'
        }
    }

    return results
})

const calculateTime=(()=>{
    let countActivity=Object.keys(props.activity).length

    if(countActivity%2==0)
    {
        let totalMinutes=0;
            for(let i=1;i<=(countActivity/2);i++)
            {
                const date1=moment(props.activity['in_'+i], 'h:m');
                const date2=moment(props.activity['out_'+i], 'h:m');

                totalMinutes+=date2.diff(date1,'minutes');
            }
        return totalMinutes+' minutes';
    }else{
        return 'You Should Check Out'
    }
})

</script>
<template>
    <el-dialog v-model="isOpened" :show-close="false" width="500" @close="$emit('close')">
        <template #header="{ close, titleId, titleClass }">
            <div class="my-header">
                <h4 :id="titleId" :class="titleClass">Activities</h4>
                <el-button type="danger" @click="close">
                    <el-icon class="el-icon--left">
                        <CircleCloseFilled />
                    </el-icon>
                    Close
                </el-button>
            </div>
        </template>
            <div class="bg-white rounded-lg w-full p-4 shadow">
                    <div>
                        <span class="text-gray-900 relative inline-block date uppercase font-medium tracking-widest">Wednesday 8</span>
                        <div v-for="(item,count) in Object.keys(activity)" class="flex mb-2">
                            <div class="w-2/12">
                                <span class="text-sm text-gray-600 block">{{ activity[item] }}</span>
                            </div>
                            <div class="w-1/12">
                                <span :class="{'bg-primary':item.includes('in'),'bg-info':item.includes('out')}" class="h-2 w-2 rounded-full block mt-2"></span>
                            </div>
                            <div class="w-9/12">
                                <span class="text-sm font-semibold block">{{ itemlabel(item,count) }}</span>
                            </div>
                        </div>
                    </div>
                    <h1 class="text-gray-900 mt-2 relative inline-block font-bold tracking-widest">Total Working hours: {{ calculateTime() }} </h1>
                <div>
                </div>
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
