import { UserData } from "../User/UserData";

export interface SectionData{
    id:string;
    name:string;
    responsible:UserData;
    responsible_id:string;
    employees_affected:number;
}
