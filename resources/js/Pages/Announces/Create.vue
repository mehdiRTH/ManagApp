<script lang="ts" setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { AnnounceResourceInterface } from '@/types/Announce/AnnounceResourceInterface';
import { UserInterface } from '@/types/User/UsersInterface';
import { SectionInterface } from '@/types/Section/SectionsInterface';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import Form from '@/Components/Form.vue';
import Label from '@/Components/Label.vue';
import { useForm } from '@inertiajs/vue3';
import { Ref, inject, onMounted, ref } from 'vue';
import MainInput from '@/Components/MainInput.vue';
import { toast } from 'vue3-toastify';

const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[],
    announce:AnnounceResourceInterface,
    receivers: UserInterface,
    sections:SectionInterface
}>()

const isEdit : Ref<boolean> = ref(props.announce.data?.id ? true : false)

const isOnEdit=((column : any)=>{

    return isEdit.value ? column : ''

})


const form=useForm({
    label: isOnEdit(props.announce.data?.label) ,
    message: isOnEdit(props.announce.data?.message) ,
    type:isOnEdit(props.announce.data?.type),
    receiver:isOnEdit(props.announce.data?.receiver?.id),
    is_active:isEdit.value ? props.announce.data?.is_active : true,
    status:isOnEdit(props.announce.data?.status),
    end_date:isOnEdit(props.announce.data?.end_date),
})

const types : Array<string> =[
    'All',
    'Section',
    'Direct'
]

const status : Array<string> =[
    'success',
    'information',
    'danger'
]

const submit=(()=>{
    if(isEdit.value)
    {
        form.put(route('announces.update',{announce:props.announce.data}),{
            preserveState:true,
            onSuccess:(()=>{
                toast.success('Announce updated successfully')
            })
        })
    }else{
        form.post(route('announces.store'),{
            preserveState:true,
            onSuccess:(()=>{
                toast.success('Announce created successfully')
            })
        })
    }
})
</script>
<template>
    <MainLayout :head="isEdit ? 'Edit Announce' : 'Create Announce'" :breadcrumbs="breadcrumbs">
        <Form :label="isEdit ? 'Edit Announce' : 'Create Announce'" @submit="submit()" btn-label="Save"
            :errors="form.errors" class="max-w-4xl">

            <!--Input of announce type-->
            <Label label="Select the type of announce" :error="form.errors.type">
                <el-select v-model="form.type" collapse-tags placeholder="Select a type" class="w-full" @change="form.receiver=''">
                    <el-option v-for="item in types" :key="item" :label="item" :value="item">
                        {{item}}
                    </el-option>
                </el-select>
            </Label>

            <!--Input of active or deactivate-->
            <Label :label="'The announce '+(form.is_active ? 'is active' : 'is deactivated')" :error="form.errors.is_active" class="col-span-1">
                <el-switch v-model="form.is_active" class="mb-2 text-white"
                    style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949; --el-switch__label--right:#ffffff;" active-text="Active The Announce"
                    inactive-text="Deactivate The Announce" />
            </Label>

            <!--Input of Status-->
            <Label label="Select the status" :error="form.errors.status">
                <el-select v-model="form.status" collapse-tags placeholder="Select a receiver"  class="w-full " >
                    <el-option v-for="item in status" :key="item" :label="$helpers.capitalizeFirstLetter(item)  " :value="item" >
                             {{ $helpers.capitalizeFirstLetter(item) }}
                    </el-option>
                </el-select>
            </Label>

            <!--Input of End Date-->
            <Label label="Set an ending date" :error="form.errors.end_date">
                <el-date-picker v-model="form.end_date" type="datetime" value-format="YYYY-MM-DD" format="YYYY-MM-DD" placeholder="Select End date" class="w-full" />
            </Label>

            <!--Input of Label-->
            <MainInput v-model="form.label" label="Label" :error="form.errors.label"class="col-span-2"  />

            <!--Input of message-->
            <MainInput v-model="form.message" input-type="textarea" label="Message" :error="form.errors.message"
                class="col-span-2" />

            <!--Input of receiver-->
            <Label v-if="form.type=='Direct'" label="Select a receiver" :error="form.errors.receiver"
                class="col-span-2">
                <el-select v-model="form.receiver" collapse-tags placeholder="Select a receiver" class="w-full" >
                    <el-option v-for="item in receivers.data" :key="item.id" :label="item.name" :value="item.id">
                        <div class="flex justify-between">
                            <span>{{ item.name }}</span>
                            <span
                                class="rounded-full mt-2 h-5 flex items-center text-white bg-green-400 py-1 px-3 text-xs font-bold mr-3">
                                {{ $helpers.capitalizeFirstLetter(item.role[0]) }}</span>
                        </div>
                    </el-option>
                </el-select>
            </Label>
            <Label v-else-if="form.type=='Section'" label="Select a Section" :error="form.errors.receiver"
                class="col-span-2">
                <el-select v-model="form.receiver" collapse-tags placeholder="Select a Section" class="w-full">
                    <el-option v-for="item in sections.data" :key="item.id" :label="item.name" :value="item.id">
                        <div class="flex justify-between">
                            <span>{{ item.name }}</span>
                        </div>
                    </el-option>
                </el-select>
            </Label>
        </Form>
    </MainLayout>
</template>
<style>
.el-switch__label{
    color: #393838;
}

.el-switch__label.is-active{
    color:#ffffff;
}
</style>
