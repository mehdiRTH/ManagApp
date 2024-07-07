import { useForm, usePage } from '@inertiajs/vue3';
import { ElMessageBox } from 'element-plus';
import { App, Ref, ref } from 'vue';
import { toast } from 'vue3-toastify';
import { RouteParams } from '../../vendor/tightenco/ziggy/src/js';

export default {
    install(app : App){
        app.config.globalProperties.$helpers={
            capitalizeFirstLetter,
            truncateString: function (str: string): string {
                if (str.length > 30) {
                  return str.slice(0, 30) + "...";
                } else {
                  return str;
                }
            },
            hasRole: function (role : string) : boolean
            {
                let userRole=usePage().props.auth.role;

                if(userRole.includes('super admin')) return true;

                return userRole.includes(role)

            },
            hasRoles: function(roles : Array<string>) : boolean
            {
                let role=usePage().props.auth.role;

                if(role.includes('super admin')) return true;

                return roles.some((item)=>role.includes(item))

            },
            destroyModal : function (modelObject : RouteParams<string>,routeName : string) : void
            {
                const form=useForm({});
                let label : string =Object.keys(modelObject)[0];

                ElMessageBox.confirm(
                    capitalizeFirstLetter(label)+' will permanently deleted. Continue?',
                    'Warning',
                    {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    }
                )
                    .then(() => {
                        form.delete(route(routeName + '.destroy', modelObject ), {
                        preserveScroll: true,
                        onSuccess:()=>{
                            toast.success(capitalizeFirstLetter(label)+' deleted successfully')
                        }
                        })
                    })
            }
        }
    }
}
function capitalizeFirstLetter(str:string) : string {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

