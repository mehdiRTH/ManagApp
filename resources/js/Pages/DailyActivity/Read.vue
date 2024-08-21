<script lang="ts" setup>
import { QrcodeStream} from 'vue-qrcode-reader'
import MainLayout from '@/Layouts/MainLayout.vue';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { faQrcode } from '@fortawesome/free-solid-svg-icons';
import { ref, Ref } from 'vue';
import MainInputError from '@/Components/MainInputError.vue';
import axios from 'axios';
import { UserInterface } from '@/types/User/UsersInterface';
import { UserData } from '@/types/User/UserData';
const props=defineProps<{
    breadcrumbs:BreadcrumbsInterface[]
}>()

const qrCodeValue : Ref<{user:UserData, error:string, status:string} | null> = ref(null)
const error : Ref<string> = ref('')
const isDone : Ref<boolean> =ref(false)

function onDetect (detectedCodes: any) {
    qrCodeValue.value=detectedCodes[0].rawValue
    axios.get(route('daily_activities.check_qr',detectedCodes[0].rawValue))
    .then((response)=>{
        qrCodeValue.value=response.data
        isDone.value=true
    })
}

function paintBoundingBox(detectedCodes: any, ctx: { lineWidth: number; strokeStyle: string; strokeRect: (arg0: any, arg1: any, arg2: any, arg3: any) => void; }) {
    for (const detectedCode of detectedCodes) {
      const {
        boundingBox: { x, y, width, height }
      } = detectedCode

      ctx.lineWidth = 2
      ctx.strokeStyle = '#007bff'
      ctx.strokeRect(x, y, width, height)
    }
  }

  function onError(err: { name: string; message: string; }) {
    error.value = `[${err.name}]: `

    if (err.name === 'NotAllowedError') {
      error.value += 'you need to grant camera access permission'
    } else if (err.name === 'NotFoundError') {
      error.value += 'no camera on this device'
    } else if (err.name === 'NotSupportedError') {
      error.value += 'secure context required (HTTPS, localhost)'
    } else if (err.name === 'NotReadableError') {
      error.value += 'is the camera already in use?'
    } else if (err.name === 'OverconstrainedError') {
      error.value += 'installed cameras are not suitable'
    } else if (err.name === 'StreamApiNotSupportedError') {
      error.value += 'Stream API is not supported in this browser'
    } else if (err.name === 'InsecureContextError') {
      error.value += 'Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.'
    } else {
      error.value += err.message
    }
  }
</script>
<template>
    <MainLayout head="Read QrCode" :breadcrumbs="breadcrumbs">
        <div v-if="!isDone">
            <h1 class="text-center font-bold text-xl">Scan Your QrCode <faIcon :icon="faQrcode" /></h1>
            <div class="flex items-center justify-center mt-4">
                <div class="w-6/12">
                    <qrcode-stream :track="paintBoundingBox" @detect="onDetect" @error="onError"></qrcode-stream>
                </div>
                <MainInputError :error="error" />
            </div>
        </div>
        <div v-else class="flex items-center justify-center mt-10">
            <div class="bg-indigo-600 text-white rounded shadow-xl py-5 px-5 w-full lg:w-10/12 xl:w-3/4">
                <div class="flex flex-wrap -mx-3 items-center">
                    <div class="w-full">
                        <div class="p-5 text-center">
                            <h3 class="text-2xl">{{qrCodeValue?.status.includes('in') ? 'See you Soon !' : 'Welcome !'}} {{qrCodeValue?.user.name}}</h3>
                            <div>
                                <button @click="isDone=!isDone" class="mt-6 py-2 px-4 rounded text-white bg-indigo-900 hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <MainInputError :error="qrCodeValue?.error" />
            </div>
        </div>
    </MainLayout>
</template>
