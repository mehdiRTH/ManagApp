import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { RouteParams, route as ziggyRoute } from 'ziggy-js';
import { PageProps as AppPageProps } from './';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: typeof ziggyRoute;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
        $helpers:{
            capitalizeFirstLetter(str:string) : string,
            truncateString(str : string,numb?:number) : string,
            destroyModal(objectModal : RouteParams<string>, routeName : string) : void,
            hasRole(role : string) : boolean,
            hasRoles(role : Array<string>) : boolean,
            checkTypeImage(item : string) : boolean
        }
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
