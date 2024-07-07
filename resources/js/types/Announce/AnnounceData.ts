import { UserData } from "../User/UserData";

export interface AnnounceData{
    is_active: boolean;
    id:string;
    label:string;
    message:string;
    type:string;
    receiver?:UserData,
    end_date?:Date,
    status:string
}
