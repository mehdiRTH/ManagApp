
interface NotifData{
    message:string;
    route?:string;
}

export interface NotificationData{
    id:string;
    type:string;
    date:string;
    data:NotifData;
}
