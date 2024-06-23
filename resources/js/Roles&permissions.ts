import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { UserData } from "./types/User/UserData";

const auth : Object=ref(usePage().props?.auth)

export function hasRole(role : string) : boolean
{
    if(auth.value.role.includes('super admin')) return true;

    return auth.value.role.includes(role)

}

export function hasRoles(roles : Array<string>) : boolean
{
    if(auth.value.role.includes('super admin')) return true;

    return roles.some((role)=>auth.value.role.includes(role))

}

