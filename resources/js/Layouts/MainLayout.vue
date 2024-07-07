<script setup lang="ts">
import { ComponentInternalInstance, Ref, onMounted, ref } from 'vue';
import { MenuItemInterface } from '@/types/MenuItemInterface';
import { faCalendar, faHome, faPerson, faVideoCamera, faBullhorn } from '@fortawesome/free-solid-svg-icons';
import { faScreenpal } from '@fortawesome/free-brands-svg-icons';
import Header from './Header.vue'
import MobileSideBar from './Mobile/MobileSidebar.vue'
import SideBar from './Sidebar.vue'
import Notification from './Notifications/Notifications.vue'
import { BreadcrumbsInterface } from '@/types/BreadcrumbsInterface';
import { Head } from '@inertiajs/vue3';
import { getCurrentInstance } from 'vue';

const showingNotification : Ref<boolean> = ref(false);

let sideBar : (HTMLElement | null);
let openSidebar : (HTMLElement | null) ;
let closeSidebar : (HTMLElement | null) ;
const { proxy } : any = getCurrentInstance();

//Data of Menu
const menuItemsData : Ref<MenuItemInterface[]>=ref([
    { label: 'Dashboard', icon: faHome,route:route('dashboard'), count: null, isShowed:true },
    {label:'Users',icon:faPerson,route:route('users.index') ,count:null, isShowed:proxy.$helpers.hasRole('admin')},
    {label:'Meeting',icon:faVideoCamera,route:route('meetings.index') ,count:null, isShowed:true},
    {label:'Sections',icon:faScreenpal,route:route('sections.index') ,count:null, isShowed:proxy.$helpers.hasRole('admin')},
    {label:'Holidays',icon:faCalendar,route:route('holidays.index'),count:null, isShowed:true},
    {label:'Announces',icon:faBullhorn,route:route('announces.index'),count:null, isShowed:proxy.$helpers.hasRoles(['admin','responsible'])},
])

const props=defineProps<{
    breadcrumbs?:BreadcrumbsInterface[],
    head:string
}>()

function sidebarHandler(flag:boolean) {
    if (flag) {
        sideBar ? sideBar.style.transform = "translateX(0px)" :null;
        openSidebar ? openSidebar.classList.add("hidden") : null;
        closeSidebar ? closeSidebar.classList.remove("hidden") : null;
    } else {
        sideBar ? sideBar.style.transform = "translateX(-260px)" : null;
        closeSidebar ? closeSidebar.classList.add("hidden") : null;
        openSidebar ? openSidebar.classList.remove("hidden") : null;
    }
}

function toggleNotifications()
{
    showingNotification.value=!showingNotification.value
}

onMounted(()=>{

sideBar = document.getElementById("mobile-nav");
openSidebar  = document.getElementById("openSideBar");
closeSidebar  = document.getElementById("closeSideBar");

 sideBar ? sideBar.style.transform = "translateX(-260px)" : null;
})
</script>

<template>
    <Head :title="head" />
    <div class="flex flex-no-wrap">
        <!-- Sidebar starts -->
        <!-- Remove class [ hidden ] and replace [ sm:flex ] with [ flex ] -->
        <Notification :toggle="showingNotification" @toggle-notification="toggleNotifications"  />
        <SideBar :menu-items-data="menuItemsData" />
        <MobileSideBar :menu-items-data="menuItemsData" @toggle="sidebarHandler" />
        <!-- Sidebar ends -->
        <div class="container mx-auto py-10 h-64 md:w-4/5 w-11/12 px-6">
            <Header :breadcrumbs="breadcrumbs" @notificationToggle="toggleNotifications" />
            <!-- Remove class [ border-dashed border-2 border-gray-300 ] to remove dotted border -->
            <div class="w-full h-full rounded">
                <!-- Place your content here -->
                <main>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
