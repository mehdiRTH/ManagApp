import { UserData } from "../User/UserData";

export interface DailyActivityData{
    id:string;
    user:UserData,
    in_out:JSON
}
