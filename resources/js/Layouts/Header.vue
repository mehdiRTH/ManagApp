<script lang="ts" setup>
import { Ref, ref, watch } from 'vue';
import Breadcrumbs from './Breadcrumbs.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { SettingsMenu } from '@/types/SettingsMenu';
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import AnnounceToast from '@/Components/AnnounceToast.vue'
import { faQrcode, faClose } from '@fortawesome/free-solid-svg-icons';
import QRCodeDialog from './QRCodeDialog.vue';
defineProps<{
    breadcrumbs?:BreadcrumbsInterface[]
}>()

defineEmits(['notificationToggle'])

const isOpen : Ref<boolean> =ref(false)
const dropdownOpen : Ref<boolean> =ref(false)
const openQrCode: Ref<boolean> =ref(false)

const itemsSettingsMenu : Ref<SettingsMenu[]> =ref([
    {label:'Profile',type:'get',route:'profile.edit'},
    {label:'Logout',type:'post',route:'logout'}
])


</script>
<template>
    <nav class="block w-full max-w-full bg-transparent text-white shadow-none rounded-xl transition-all px-0 py-1">
        <div class="flex flex-col-reverse justify-between gap-6 md:flex-row md:items-center">

            <Breadcrumbs v-if="breadcrumbs" :data="breadcrumbs" />
            <div v-else></div>

            <div class="flex items-center">
                <a href="#">
                    <button
                        class="middle none font-sans font-bold center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 rounded-lg text-secondary hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30 hidden items-center gap-1 px-4 xl:flex"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="h-5 w-5 text-secondary">
                            <path fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                clip-rule="evenodd"></path>
                        </svg>{{ $page.props.auth.user.name }} </button>
                    <button
                        class="relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-secondary hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30 grid xl:hidden"
                        type="button">
                        <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5 text-blue-gray-500">
                                <path fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </button>
                </a>
                <!--Qr Code Section-->
                <button @click="openQrCode=!openQrCode"
                    class="relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-secondary hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    type="button"
                    >
                    <faIcon :icon="faQrcode" class="h-5 w-5 text-secondary" />
                </button>
                <QRCodeDialog :openQrCode="openQrCode" :key="openQrCode.toString()" @close="openQrCode=!openQrCode" />

                <!--Notification Section-->
                <button @click="$emit('notificationToggle',isOpen=!isOpen)" aria-haspopup="menu" id=":r2:"
                    class="relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-secondary hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                    type="button">
                    <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true" class="h-5 w-5 text-blue-gray-500">
                            <path fill-rule="evenodd"
                                d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </button>
                <div class="relative">
                    <button @click="dropdownOpen = ! dropdownOpen"
                        class="relative middle none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-secondary hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30">
                        <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="h-5 w-5 text-blue-gray-500">
                                <path fill-rule="evenodd"
                                    d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </button>

                    <div v-if="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"
                        style="display: none;"></div>

                    <div v-if="dropdownOpen"
                        class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
                        <span v-for="item in itemsSettingsMenu">
                            <ResponsiveNavLink v-if="item.type == 'get'" :href="route(item.route)"> {{ item.label }}
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-else :href="route(item.route)" method="post" as="button">
                                {{ item.label }}
                            </ResponsiveNavLink>
                        </span>
                    </div>
                </div>
                </div>
            </div>
    </nav>
    <AnnounceToast v-for="announce in $page.props.auth.announces.data" :announce="announce"  />

</template>

