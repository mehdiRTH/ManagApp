<script lang="ts" setup>
import { onMounted, Ref, ref } from 'vue';
import { FileInterface } from '@/types/FileInterface'
import { faUpload } from '@fortawesome/free-solid-svg-icons';
import { useForm } from '@inertiajs/vue3';
import { ElMessageBox } from 'element-plus';

const props=defineProps<{
    filesSrc:Array<string>
}>()

const imagesSrc = ref([])
const files : Ref<Array<FileInterface | string>> =ref(props.filesSrc)
const form=useForm({});
const emits=defineEmits(['change'])

const onFileChange = ((event : any) => {

const file = event.target.files[0]

if (!file) {
    return false
}

let url : string =URL.createObjectURL(file)

imagesSrc.value.push((file.type.includes('image') ? url : '') as never)

const fileReader = new FileReader()
fileReader.onload = async (e) => {
    //Push the file into array of files
    files.value.push(file as never);

    //This Emit is responsible of exchanging files to the main page
    emits('change',files.value)

    //Clear input file value
    event.target.value=""
}

fileReader.readAsDataURL(file)
})

const removeFile=((idx:number)=>{
    ElMessageBox.confirm(
        'File will permanently deleted. Continue?',
        'Warning',
        {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
        }
            )
        .then(() => {
            files.value.splice(idx,1)
            imagesSrc.value.splice(idx,1)
            emits('change',files.value)
    })

})

const checkTypeImage =((item : string)=>{
    const imageType=['JPEG','JPG','PNG']

    return imageType.some(ty => (item.substring(item.lastIndexOf('.') + 1).includes(ty)))
})

onMounted(()=>{
    files.value.map((item,idx)=>{
        if(typeof item === 'string') imagesSrc.value.push('' as never)
        else emits('change',files.value.splice(idx,1))
    })

})
</script>
<template>
    <label class="container w-full mx-auto h-full flex flex-col justify-center items-center">
        <div id="images-container"></div>
            <div class="flex w-full justify-center">
                <div id="multi-upload-button"
                    class="inline-flex w-full items-center justify-center px-4 py-2 bg-white border border-white  rounded-l font-semibold cursor-pointer text-sm text-primary tracking-widest hover:bg-gray-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ">
                    <faIcon :icon="faUpload" class="mx-2" /> Upload Your Justifications
                </div>
        </div>
        <input type="file" @change="onFileChange" class="hidden" />
    </label>


    <!-- using two similar templates for simplicity in js code -->
    <div class="bg-gray-50 p-2 mt-2 rounded" v-if="files.length>=1">
        <div v-for="(item,idx) in files" class="inline-flex p-1 w-1/3 h-24">
            <article v-if="item.name && item.type" tabindex="0" class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-400 cursor-pointer relative shadow-sm">
                <img v-if="item.type.includes('image')" :src="imagesSrc[idx]" alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

                <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                <h1 class="flex-1 group-hover:text-blue-800 text-gray-50">{{$helpers.truncateString(item.name,40)}}</h1>
                <div class="flex">
                    <button type="button" @click="removeFile(idx)" class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-50">
                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                        </svg>
                    </button>
                </div>
                </section>
            </article>
            <article v-else-if="typeof item === 'string'" tabindex="0" class="group w-full h-full rounded-md focus:outline-none focus:shadow-outline elative bg-gray-400 cursor-pointer relative shadow-sm">
                <img v-if="checkTypeImage(item)" :src="item" alt="upload preview" class="img-preview w-full h-full sticky object-cover rounded-md bg-fixed" />

                <section class="flex flex-col rounded-md text-xs break-words w-full h-full z-20 absolute top-0 py-2 px-3">
                <h1 class="flex-1 group-hover:text-blue-800 text-gray-50">uploaded-File-{{ idx+1 }}.{{ item.substring(item.lastIndexOf('.') + 1) }}</h1>
                <div class="flex">
                    <button type="button" @click="removeFile(idx)" class="delete ml-auto focus:outline-none hover:bg-gray-300 p-1 rounded-md text-gray-50">
                        <svg class="pointer-events-none fill-current w-4 h-4 ml-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path class="pointer-events-none" d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z" />
                        </svg>
                    </button>
                </div>
                </section>
            </article>
        </div>
    </div>
</template>
