
interface NotifData{
    message:string;
    route?:{url:string,params:string};
}

export interface NotificationData{
    id:string;
    type:string;
    date:string;
    data:NotifData;
}
