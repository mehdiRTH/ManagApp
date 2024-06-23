import { SectionData } from "../Section/SectionData";

export interface UserData{
    id:string;
    name:string;
    email:string;
    password:string;
    role: Array<string>;
    section:SectionData;
}
