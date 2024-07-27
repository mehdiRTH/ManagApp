import { UserData } from "../User/UserData";

export interface DayOffData{
    id:string;
    user:UserData;
    label:string;
    description:string;
    justification:string;
    status:string;
    type:string;
    status_answer: string;
    created_at: Date;
    start_date:Date;
    end_date:Date;
    duration:string;
}
