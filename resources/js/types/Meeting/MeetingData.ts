import { UserData } from "../User/UserData";

export interface MeetingData{
    id:string;
    created_by:UserData,
    responsible:UserData,
    participants:Array<UserData>,
    start_date:string;
    end_date:string;
    participants_id:Array<string>;
    description:string;
}
